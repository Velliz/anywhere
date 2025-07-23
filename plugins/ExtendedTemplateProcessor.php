<?php

namespace plugins;

use PhpOffice\PhpWord\Element\AbstractContainer;
use PhpOffice\PhpWord\Element\Image;
use PhpOffice\PhpWord\Element\Link;
use PhpOffice\PhpWord\Exception\Exception;
use PhpOffice\PhpWord\Media;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\Settings;
use PhpOffice\PhpWord\Shared\XMLWriter;
use PhpOffice\PhpWord\Shared\ZipArchive;
use PhpOffice\PhpWord\TemplateProcessor;

/**
 * Extended TemplateProcessor to handle media relationships in Word documents.
 * This class extends the functionality of the original TemplateProcessor
 *
 * to manage media elements such as images and links, ensuring that
 * they are correctly added to the document package and
 * relationships are properly set up.
 */
class ExtendedTemplateProcessor extends TemplateProcessor
{

    /**
     * @var array
     */
    protected $rIdMediaMap = [];

    /**
     * @param PhpWord $phpWord
     *
     * @throws Exception
     */
    public function setupRelationships(PhpWord $phpWord): void
    {
        $originalRid = $this->getNextRelationsIndex($this->getMainPartName());
        $rid = $originalRid;

        $xmlWriter = new XMLWriter();

        $sections = $phpWord->getSections();
        foreach ($sections as $section) {
            $this->fixRelId($section->getElements(), $rid);
        }

        $sectionMedia = Media::getElements('section');
        if (!empty($sectionMedia)) {
            $this->addFilesToPackage($this->zip(), $sectionMedia);

            foreach ($sectionMedia as $element) {
                $rid = $this->rIdMediaMap[$element['source']] ?? null;

                if ($rid === null) {
                    $this->report('No rId for media!');

                    continue;
                }

                $this->writeMediaRel($xmlWriter, $rid, $element);
            }
        }

        $mediaXml = $xmlWriter->getData();

        // Add link as relationship in XML relationships.
        $mainPartName = $this->getMainPartName();
        $this->tempDocumentRelations[$mainPartName] = str_replace('</Relationships>', $mediaXml,
                $this->tempDocumentRelations[$mainPartName]) . '</Relationships>';
    }

    protected function fixRelId(array $elements, &$id): void
    {
        foreach ($elements as $element) {
            if (
                $element instanceof Link
                || $element instanceof Image
            ) {
                $rId = $this->rIdMediaMap[$element->getSource()] ?? null;

                if ($rId === null) {
                    $rId = $id++;
                    $this->rIdMediaMap[$element->getSource()] = $rId;
                }

                $element->setRelationId($rId - 6);
            }

            if ($element instanceof AbstractContainer) {
                $this->fixRelId($element->getElements(), $id);
            }
        }
    }

    /**
     * Write media relationships.
     *
     * @param XMLWriter $xmlWriter
     * @param int $relId
     * @param array $mediaRel
     *
     * @throws Exception
     */
    protected function writeMediaRel(XMLWriter $xmlWriter, int $relId, array $mediaRel): void
    {
        $typePrefix = 'officeDocument/2006/relationships/';
        $typeMapping = ['image' => 'image', 'object' => 'oleObject', 'link' => 'hyperlink'];
        $targetMapping = ['image' => 'media/', 'object' => 'embeddings/'];

        $mediaType = $mediaRel['type'];
        $type = $typeMapping[$mediaType] ?? $mediaType;
        $targetPrefix = $targetMapping[$mediaType] ?? '';
        $target = $mediaRel['target'];
        $targetMode = ($type == 'hyperlink') ? 'External' : '';

        $this->writeRel($xmlWriter, $relId, $typePrefix . $type, $targetPrefix . $target, $targetMode);
    }

    /**
     * Write individual rels entry.
     *
     * Format:
     * <Relationship Id="rId..." Type="http://..." Target="....xml" TargetMode="..." />
     *
     * @param int $relId Relationship ID
     * @param string $type Relationship type
     * @param string $target Relationship target
     * @param string $targetMode Relationship target mode
     *
     * @throws Exception
     */
    protected function writeRel(XMLWriter $xmlWriter, int $relId, string $type, string $target, string $targetMode = ''): void
    {
        if ($type != '' && $target != '') {
            if (strpos($relId, 'rId') === false) {
                $relId = 'rId' . $relId;
            }
            $xmlWriter->startElement('Relationship');
            $xmlWriter->writeAttribute('Id', $relId);
            $xmlWriter->writeAttribute('Type', 'http://schemas.openxmlformats.org/' . $type);
            $xmlWriter->writeAttribute('Target', $target);
            if ($targetMode != '') {
                $xmlWriter->writeAttribute('TargetMode', $targetMode);
            }
            $xmlWriter->endElement();
        } else {
            throw new Exception('Invalid parameters passed.');
        }
    }

    /**
     * Add files to package.
     *
     * @param ZipArchive $zip
     * @param mixed $elements
     *
     * @throws Exception
     */
    protected function addFilesToPackage(ZipArchive $zip, array $elements): void
    {
        $types = [];

        foreach ($elements as $element) {
            $type = $element['type']; // image|object|link

            if (!in_array($type, ['image', 'object'])) {
                continue;
            }

            $target = 'word/media/' . $element['target'];

            // Retrieve GD image content or get local media
            if (isset($element['isMemImage']) && $element['isMemImage']) {
                $imageContents = $element['imageString'];
                $zip->addFromString($target, $imageContents);
            } else {
                $this->addFileToPackage($zip, $element['source'], $target);
            }

            if ($type === 'image' && !str_contains($this->tempDocumentContentTypes, "Extension=\"{$element['imageExtension']}\"")) {
                $types[$element['imageExtension']] = $element['imageType'];
            }
        }

        $types = array_map(function ($value, $key) {
            return str_replace(['{ext}', '{type}'], [$key, $value], '<Default Extension="{ext}" ContentType="{type}"/>');
        }, $types, array_keys($types));

        $this->tempDocumentContentTypes = str_replace('</Types>', join("\n", $types), $this->tempDocumentContentTypes) . '</Types>';
    }

    /**
     * Add file to package.
     *
     * Get the actual source from an archive image.
     *
     * @param ZipArchive $zipPackage
     * @param string $source
     * @param string $target
     *
     * @throws Exception
     */
    protected function addFileToPackage(ZipArchive $zipPackage, string $source, string $target): void
    {
        $isArchive = str_contains($source, 'zip://');
        $actualSource = null;

        if ($isArchive) {
            $source = substr($source, 6);
            [$zipFilename, $imageFilename] = explode('#', $source);

            $zip = new ZipArchive();

            if ($zip->open($zipFilename) !== false) {
                if ($zip->locateName($imageFilename)) {
                    $zip->extractTo(Settings::getTempDir(), $imageFilename);
                    $actualSource = Settings::getTempDir() . DIRECTORY_SEPARATOR . $imageFilename;
                }
            }

            $zip->close();
        } else {
            $actualSource = $source;
        }

        if (null !== $actualSource) {
            $zipPackage->addFile($actualSource, $target);
        }
    }

    protected function report($message): void
    {
        // This method can be overridden to handle reporting/logging as needed.
        // For example, you could log the message or throw an exception.
        // throw new Exception($message);
        error_log($message);
    }

}
