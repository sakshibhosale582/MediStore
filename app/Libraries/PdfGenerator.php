<?php

namespace App\Libraries;

use Dompdf\Dompdf;
use Dompdf\Options;

class PdfGenerator
{
    public function generateInvoice(array $order, array $items): string
    {
        $html = view('pdf/invoice', ['order' => $order, 'items' => $items]);

        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        return $dompdf->output();
    }
}
