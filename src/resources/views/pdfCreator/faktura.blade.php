<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="utf-8">
    <title>Faktura_{{ $invoice->id }}</title>
    <style>
        /* Emulator Tailwind dla DomPDF */
        @page { margin: 0; }
        body { font-family: 'DejaVu Sans', sans-serif; margin: 0; padding: 0; color: #1f2937; line-height: 1.5; }
        
        .w-full { width: 100%; }
        .p-10 { padding: 2.5rem; }
        .px-8 { padding-left: 2rem; padding-right: 2rem; }
        .py-12 { padding-top: 3rem; padding-bottom: 3rem; }
        .m-0 { margin: 0; }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .text-white { color: #ffffff; }
        .text-gray-500 { color: #6b7280; }
        .text-gray-900 { color: #111827; }
        .font-bold { font-weight: bold; }
        .text-sm { font-size: 0.875rem; }
        .text-xs { font-size: 0.75rem; }
        .text-2xl { font-size: 1.5rem; }
        .uppercase { text-transform: uppercase; }
        .tracking-widest { letter-spacing: 0.1em; }
        .border-b-2 { border-bottom-width: 2px; }
        .border-gray-200 { border-color: #e5e7eb; }
        .bg-gray-50 { background-color: #f9fafb; }
        
        /* Dynamiczny kolor marki */
        .brand-bg { background-color: {{ $invoice->user->brand_color ?? '#0d6efd' }}; }
        .brand-border { border-color: {{ $invoice->user->brand_color ?? '#0d6efd' }}; }
        .brand-text { color: {{ $invoice->user->brand_color ?? '#0d6efd' }}; }
    </style>
</head>
<body>
    <!-- Nagłówek (Header-Brand) -->
    <div class="brand-bg text-white py-12 px-8">
        <table class="w-full">
            <tr>
                <td style="vertical-align: middle;">
                    @if($invoice->user->logo_path)
                    <div style="background: white; padding: 8px; border-radius: 8px; display: inline-block;">
                        <img src="{{ public_path('storage/' . $invoice->user->logo_path) }}" 
                             style="max-width: 140px; max-height: 70px;">
                    </div>
                    @endif
                </td>
                <td class="text-right" style="vertical-align: middle;">
                    <h1 class="m-0 text-2xl font-bold uppercase tracking-widest">Faktura VAT</h1>
                    <div style="font-size: 18px; opacity: 0.8;">nr {{ $invoice->invoice_number ?? $invoice->id }}</div>
                </td>
            </tr>
        </table>
    </div>

    <div class="p-10">
        <!-- Daty -->
        <table class="w-full text-right" style="margin-bottom: 40px;">
            <tr>
                <td class="text-sm">
                    <span class="text-gray-500">Data wystawienia:</span> <span class="font-bold">{{ $invoice->date_delivered }}</span><br>
                    <span class="text-gray-500">Data sprzedaży:</span> <span class="font-bold">{{ $invoice->date_sold }}</span>
                </td>
            </tr>
        </table>

        <!-- Dane stron -->
        <table class="w-full" style="margin-bottom: 40px;">
            <tr>
                <td style="width: 50%; vertical-align: top; padding-right: 20px;">
                    <div class="text-xs font-bold uppercase tracking-widest brand-text border-b-2 brand-border" style="margin-bottom: 10px; padding-bottom: 4px;">Sprzedawca</div>
                    <div class="text-gray-900 font-bold" style="font-size: 13px;">{{ $userData['name'] }}</div>
                    <div class="text-gray-500 text-sm">{!! nl2br(e($userData['address'] ?? '')) !!}</div>
                </td>
                <td style="width: 50%; vertical-align: top; padding-left: 20px;">
                    <div class="text-xs font-bold uppercase tracking-widest brand-text border-b-2 brand-border" style="margin-bottom: 10px; padding-bottom: 4px;">Nabywca</div>
                    <div class="text-gray-900 font-bold" style="font-size: 13px;">{{ $invoice->customer->name }} {{ $invoice->customer->lastName }}</div>
                    <div class="text-gray-500 text-sm">{!! nl2br(e($invoice->customer->address)) !!}</div>
                </td>
            </tr>
        </table>

        <!-- Tabela pozycji -->
        <table class="w-full" style="border-collapse: collapse;">
            <thead>
                <tr class="bg-gray-50 text-gray-500 uppercase tracking-widest" style="font-size: 10px;">
                    <th class="text-center font-bold px-4 py-3 border-b-2 border-gray-200" style="width: 40px;">Lp.</th>
                    <th class="text-left font-bold px-4 py-3 border-b-2 border-gray-200">Opis usługi / towaru</th>
                    <th class="text-right font-bold px-4 py-3 border-b-2 border-gray-200">Netto</th>
                    <th class="text-center font-bold px-4 py-3 border-b-2 border-gray-200">VAT</th>
                    <th class="text-right font-bold px-4 py-3 border-b-2 border-gray-200">Brutto</th>
                </tr>
            </thead>
            <tbody class="text-gray-900">
                @php
                    $currencies = new \Money\Currencies\ISOCurrencies();
                    $numberFormatter = new \NumberFormatter('pl_PL', \NumberFormatter::CURRENCY);
                    $moneyFormatter = new \Money\Formatter\IntlMoneyFormatter($numberFormatter, $currencies);
                    $spellout = new \NumberFormatter('pl', \NumberFormatter::SPELLOUT);
                    $amountAsFloat = (float) ($brutto->getAmount() / 100);
                @endphp
                <tr>
                    <td class="text-center px-4 py-4 border-b border-gray-200">1</td>
                    <td class="px-4 py-4 border-b border-gray-200 font-bold">{{ $invoice->product_name }}</td>
                    <td class="text-right px-4 py-4 border-b border-gray-200">{{ $moneyFormatter->format($netto) }}</td>
                    <td class="text-center px-4 py-4 border-b border-gray-200">{{ $invoice->vat }}%</td>
                    <td class="text-right px-4 py-4 border-b border-gray-200 font-bold">{{ $moneyFormatter->format($brutto) }}</td>
                </tr>
            </tbody>
        </table>

        <!-- Podsumowanie -->
        <div style="margin-top: 30px; width: 100%;">
            <table style="width: 40%; margin-left: auto; border-collapse: collapse;">
                <tr class="text-sm">
                    <td class="py-2 px-4 text-gray-500">Suma Netto:</td>
                    <td class="py-2 px-4 text-right font-bold">{{ $moneyFormatter->format($netto) }}</td>
                </tr>
                <tr class="text-sm">
                    <td class="py-2 px-4 text-gray-500">Suma VAT:</td>
                    <td class="py-2 px-4 text-right font-bold">{{ $moneyFormatter->format($vatValue) }}</td>
                </tr>
                <tr class="brand-bg text-white">
                    <td class="py-3 px-4 font-bold uppercase tracking-widest text-xs">Do zapłaty:</td>
                    <td class="py-3 px-4 text-right font-bold" style="font-size: 16px;">{{ $moneyFormatter->format($brutto) }}</td>
                </tr>
            </table>
        </div>

        <!-- Słownie -->
        <div style="margin-top: 40px; padding: 15px; background: #f3f4f6; border-radius: 8px;">
            <span class="text-xs font-bold text-gray-500 uppercase tracking-widest">Kwota słownie:</span><br>
            <strong style="text-transform: capitalize; font-size: 12px;">{{ $spellout->format($amountAsFloat) }}</strong>
        </div>

        <!-- Podpisy -->
        <table class="w-full" style="margin-top: 80px;">
            <tr>
                <td class="text-center" style="width: 50%;">
                    <div style="border-top: 1px solid #d1d5db; width: 70%; margin: 0 auto 5px auto;"></div>
                    <div class="text-xs text-gray-500 uppercase tracking-tighter">Wystawca</div>
                </td>
                <td class="text-center" style="width: 50%;">
                    <div style="border-top: 1px solid #d1d5db; width: 70%; margin: 0 auto 5px auto;"></div>
                    <div class="text-xs text-gray-500 uppercase tracking-tighter">Odbiorca</div>
                </td>
            </tr>
        </table>
    </div>
</body>
</html>
