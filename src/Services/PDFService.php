<?php

namespace App\Services;

use Dompdf\Dompdf;
use Dompdf\Options;

class PDFService 
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
        // $this->domPdf->render();
        $this->domPdf->stream();
    }

}