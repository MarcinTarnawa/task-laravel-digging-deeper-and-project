<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Mail\ConsentRequestMail;
use App\Mail\InvoicePdfMail;
use App\Models\Customer;
use App\Models\CustomerData;
use App\Services\InvoiceService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;

class PdfController extends Controller
{
    protected $invoiceService;

    public function __construct(InvoiceService $service) {
        $this->invoiceService = $service;
    }
    
    // wyswietlanie
    public function index()
    {

        $userData = [
         'name' => env('COMPANY_NAME', 'Domyślna Nazwa')
        ]; // możliwość do zmiany

        $invoices = CustomerData::with('customer')->where('is_active', true)->latest()->get();

        return view('pdfCreator.index', ['userData' => $userData, 'customers' => Customer::all(), 'invoices' => $invoices]);
    }

    // dodawanie
    public function create()
    {
        $validated = request()->validate([
            'name' => ['required', 'string', 'min:3', 'max:255'],
            'customer_id' => ['required', 'exists:customers,id'],
            'date_sold' => ['required', 'date'],
            'date_delivered' => ['required', 'date'],
            'product_name' => ['required', 'string', 'min:3', 'max:255'],
            'price' => ['required', 'numeric'],
            'vat' => ['required', 'numeric'],
        ]);
        
        $priceInGrosze = (int) round($validated['price'] * 100);

        $validated['price'] = $priceInGrosze;
        $validated['user_id'] = auth()->id();
        $validated['invoice_uuid'] = (string) str()->uuid();
        $validated['version']      = 1;
        $validated['is_active']    = true;

        CustomerData::create($validated);
        
        return redirect('/pdf')->with('success', 'Dodano pomyślnie!');
    }

    // usunięcie
    public function destroy(CustomerData $customer_data)
    {
        $customer_data->delete();
        
        return redirect()->back()->with('success', 'Faktura została pomyślnie usunięta.');
    }

    // // pobieranie
    public function downloadPdf(Request $request, CustomerData $customer_data)
    {
        $pdf = $this->invoiceService->generatePdf($customer_data);
        
        if ($request->query('action') === 'download') {
            return $pdf->download("faktura_{$customer_data->id}.pdf");
        }

        return $pdf->stream();
    }
   
    // edycja
    public function editInvoice(CustomerData $customer_data)
    {
        $invoice = $customer_data;
        $customers = Customer::all(); // Potrzebne do listy wyboru nabywcy
        $userData = ['name' => 'Twoja Firma'];

        return view('pdfCreator.edit', compact('invoice', 'customers', 'userData'));
    }

    // Zapisanie zmian
    public function updateInvoice(Request $request, CustomerData $customer_data)
    {
        $validated = $request->validate([
            'customer_id'    => ['required','exists:customers,id'],
            'product_name'   => ['required','string','min:3', 'max:255'],
            'price'          => ['required','numeric'],
            'vat'            => ['required','integer'],
            'date_sold'      => ['required','date'],
            'date_delivered' => ['required','date'], 
        ]);
        $customer_data->update(['is_active' => false]);

        $newData = $validated;
        $newData['name'] = $customer_data->name;
        $newData['user_id']      = auth()->id();
        $newData['price']      = (int) round($validated['price'] * 100);
        $newData['invoice_uuid'] = $customer_data->invoice_uuid;
        $newData['version']      = $customer_data->version + 1;
        $newData['is_active']    = true;

        // $customer_data->update($validated); // old
        CustomerData::create($newData);
        
        return redirect('/pdf')->with('success', 'Faktura została zaktualizowana.');
    }

    //stare faktury
    public function history($uuid)
    {
        // Pobieramy wszystkie wersje danej faktury, od najnowszej do najstarszej
        $history = CustomerData::with('customer')
            ->where('invoice_uuid', $uuid)
            ->orderBy('version', 'desc')
            ->get();

        // Jeśli nic nie znaleziono, rzuć 404
        if ($history->isEmpty()) {
            abort(404);
        }

        return view('pdfCreator.history', compact('history'));
    }

    public function restore(CustomerData $customer_data)
    {
        // 1. Znajdź obecną aktywną wersję dla tego UUID i ją dezaktywuj
        CustomerData::where('invoice_uuid', $customer_data->invoice_uuid)
            ->where('is_active', true)
            ->update(['is_active' => false]);

        // 2. Znajdź najwyższy numer wersji w całej historii tego UUID
        $latestVersion = CustomerData::where('invoice_uuid', $customer_data->invoice_uuid)
            ->max('version');

        // 3. Stwórz nową wersję na podstawie tej, którą przywracamy
        $newVersion = $customer_data->replicate(); // Kopiuje model do nowej instancji
        $newVersion->version = $latestVersion + 1;
        $newVersion->is_active = true;
        $newVersion->save();

        return redirect()->route('pdf.history', $customer_data->invoice_uuid)
            ->with('success', "Przywrócono wersję v{$customer_data->version} jako nową wersję v{$newVersion->version}");
    }

   //wyslanie email
    public function sendEmail(CustomerData $customer_data) 
    {
        
        $customer = $customer_data->customer;

        // 1. Sprawdzamy czy klient wyraził zgodę
        if (!$customer->email_consent) {
            
            // 2. Ograniczamy spam (wysyłamy prośbę max raz na 24h)
            if ($customer->consent_sent_at && $customer->consent_sent_at->gt(now()->subDay())) {
                return redirect()->back()->with('error', 'Czekamy na akceptację. Prośba o zgodę została już wysłana w ciągu ostatnich 24h.');
            }

            // 3. Generujemy bezpieczny, podpisany link (Signed URL)
            $consentUrl = URL::signedRoute('customer.consent', ['customer' => $customer->id]);

            // 4. Wysyłamy maila z prośbą o zgodę (musisz stworzyć ten Mailable)
            Mail::to($customer->email)->send(new ConsentRequestMail($customer, $consentUrl));

            $customer->update(['consent_sent_at' => now()]);

            return redirect()->back()->with('info', 'Klient nie wyraził jeszcze zgody. Wysłano prośbę o potwierdzenie maila.');
        }

        $pdf = $this->invoiceService->generatePdf($customer_data);
        
        Mail::to($customer_data->customer->email)
            ->send(new InvoicePdfMail($customer_data, $pdf->output()));

        return redirect()->back()->with('success', 'Email wysłany!');
    }

    public function confirmConsent(Customer $customer) {
        $customer->update(['email_consent' => true]);
        return view('welcome'); // lub prosty komunikat
    }
}
