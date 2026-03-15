<?php
namespace App\Services;

use Barryvdh\DomPDF\Facade\Pdf;

class InvoiceService {
    public function generatePdf($customer_data) {
        $data = [
            'invoice'  => $customer_data,
            'userData' => ['name' => config('app.company_name', 'Twoja Firma')],
            'netto'    => $customer_data->netto,
            'vatValue' => $customer_data->vatValue,
            'brutto'   => $customer_data->brutto,
        ];

        return Pdf::loadView('pdfCreator.faktura', $data);
    }
}