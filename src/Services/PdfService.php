<?php

namespace App\Services;

use Spipu\Html2Pdf\Html2Pdf;



/* @class service curl http service */
class PdfService
{
    public function print(string $html, string $direction = "L", string $format = "A4", $directory = null)
    {
        $html2pdf = new HTML2PDF($direction, $format, 'fr');
        $html2pdf->writeHTML($html);
        $output = $html2pdf->Output($directory);
        file_put_contents($directory, $output);
    }
}