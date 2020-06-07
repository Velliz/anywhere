<?php

namespace controller\api;

use Dompdf\Dompdf;
use Dompdf\Options;
use Exception;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpWord\Settings;
use plugins\DomPdfWriter;
use pukoframework\middleware\Service;

/**
 * #Template html false
 */
class convert extends Service
{

    /**
     * @var Dompdf
     */
    private $dompdf;

    private $head = "<!DOCTYPE html><html><body><style type='text/css'>@page{margin: 0px;}body{margin: 0px;}</style>";
    private $headNormal = "<!DOCTYPE html><html><body><style type='text/css'>body{font-family: 'Helvetica';}</style>";
    private $tail = "</body></html>";

    /**
     * convert constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $options = new Options();
        $options->set('isRemoteEnabled', true);
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isPhpEnabled', true);
        $this->dompdf = new Dompdf($options);
    }

    /**
     * @param string $from
     * @throws Exception
     */
    public function topdf($from = '')
    {
        if (!isset($_FILES['filedata'])) {
            throw new Exception('File must uploaded!');
        }

        $files = $_FILES['filedata'];
        $error = $files['error'];
        $name = $files['name'];

        if ($error !== 0) {
            throw new Exception("Failed! File protected or to large.");
        }

        $source = $_FILES['filedata']['tmp_name'];

        //pictures, word, excel
        switch ($from) {
            case 'jpeg':
            case 'jpg':
                $info = getimagesize($source);
                if ($info['mime'] === 'image/jpeg') {
                    $img = imagecreatefromjpeg($source);
                } else if ($info['mime'] === 'image/gif') {
                    $img = imagecreatefromgif($source);
                } else if ($info['mime'] === 'image/png') {
                    $img = imagecreatefrompng($source);
                } else {
                    throw new Exception('Unknown image file format!');
                }

                $width = imagesx($img);
                $height = imagesy($img);

                ob_start();
                imagejpeg($img, null, 80);
                $compress = ob_get_clean();
                $compress = base64_encode($compress);

                $imgTag = '<img src="data:' . $info['mime'] . ';base64,' . $compress . '" width="100%" alt="embedded images">';
                $htmlFactory = $this->head . $imgTag . $this->tail;

                $this->dompdf->setPaper([0, 0, $height, $width], 'landscape');
                $this->dompdf->loadHtml($htmlFactory);
                $this->dompdf->render();

                header("Cache-Control: no-cache");
                header("Pragma: no-cache");
                header("Author: Anywhere 0.1");
                header('Content-Type: application/pdf');

                $this->dompdf->stream("{$name}.pdf", [
                    "Attachment" => 0
                ]);
                exit();
                break;
            case 'spreadsheet':
                $objPHPExcel = IOFactory::load($source);
                IOFactory::registerWriter('VPDF', DomPdfWriter::class);
                $writer = IOFactory::createWriter($objPHPExcel, 'VPDF');
                $writer->writeAllSheets();

                header("Cache-Control: no-cache");
                header("Pragma: no-cache");
                header("Author: Anywhere 0.1");
                header(sprintf('Content-Disposition: attachment; filename="%s.pdf"', $name));
                header('Content-Type: application/pdf');

                $writer->save("php://output");
                exit();
                break;
            case 'word':
                Settings::setPdfRendererName(Settings::PDF_RENDERER_DOMPDF);
                Settings::setPdfRendererPath('.');
                $phpWord = \PhpOffice\PhpWord\IOFactory::load($source, 'Word2007');

                echo $phpWord->save("{$name}.pdf", 'PDF', true);

                exit();
                break;
            case 'text':
                $texts = file_get_contents($source);
                $texts = "<div style='white-space:pre-wrap;'>{$texts}</div>";
                $htmlFactory = $this->headNormal . $texts . $this->tail;

                $this->dompdf->setPaper('A4', 'portrait');
                $this->dompdf->loadHtml($htmlFactory);
                $this->dompdf->render();

                header("Cache-Control: no-cache");
                header("Pragma: no-cache");
                header("Author: Anywhere 0.1");
                header('Content-Type: application/pdf');

                $this->dompdf->stream("{$name}.pdf", [
                    "Attachment" => 0
                ]);
                exit();
                break;
            default:
                throw new Exception('file type not supported');
                break;
        }
    }
}