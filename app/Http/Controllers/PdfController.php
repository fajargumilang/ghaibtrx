<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class PdfController extends Controller
{
    public function downloadReceipt()
    {
        $data = []; // Ambil data yang diperlukan untuk struk di sini

        $pdf = Pdf::loadView('receipt', $data);
        return $pdf->download('receipt.pdf');
    }
}
