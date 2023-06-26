<?php

namespace App\Service;

use Dompdf\Dompdf;
use Dompdf\Options;

class PdfService
{
    private $domPdf;

    public function __construct()
    {
        $this->domPdf = new DomPdf();

        $pdfOptions = new Options();

        $pdfOptions->set('defaultFont', 'Arial');

        $this->domPdf->setOptions($pdfOptions);
    }

    public function showPdf($html)
    {

        $this->domPdf->loadHtml($html);
        $this->domPdf->render();
        $this->domPdf->stream("test.pdf", [
            'Attachement' => false
        ]);
    }
}
