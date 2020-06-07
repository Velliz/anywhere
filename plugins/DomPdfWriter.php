<?php

namespace plugins;

use Dompdf\Dompdf;
use Dompdf\Options;

/**
 * Class DomPdf Writer
 * @package plugins
 */
class DomPdfWriter extends \PhpOffice\PhpSpreadsheet\Writer\Pdf\Dompdf
{
    /**
     * @return Dompdf
     */
    protected function createExternalWriterInstance()
    {
        $options = new Options();
        $options->set('isRemoteEnabled', true);
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isPhpEnabled', true);

        $instance = new Dompdf($options);
        $instance->setPaper('A4', 'landscape');

        return $instance;
    }

    /**
     * @param string $pFilename
     */
    public function save($pFilename): void
    {
        $fileHandle = parent::prepareForSave($pFilename);

        $pdf = $this->createExternalWriterInstance();

        $pdf->loadHtml($this->generateHTMLAll());
        $pdf->render();

        fwrite($fileHandle, $pdf->output());

        parent::restoreStateAfterSave();
    }
}