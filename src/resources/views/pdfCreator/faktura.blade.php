<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="utf-8">
    <style>
        /* Reset marginesów dla PDF */
        @page { margin: 0; }
        body { font-family: 'DejaVu Sans', sans-serif; color: #333; line-height: 1.5; font-size: 11px; margin: 0; padding: 0; background-color: #fff; }
        
        /* Kolorowy Nagłówek */
        .header-brand { 
            background-color: {{ $invoice->user->brand_color ?? '#0d6efd' }}; 
            color: #ffffff; 
            padding: 40px 20px;
        }

        .container { padding: 30px; }
        
        /* Tabela nagłówkowa */
        .header-table { width: 100%; border: none; }
        .invoice-title { font-size: 26px; font-weight: bold; margin-bottom: 5px; }
        
        .logo-box { 
            background: white; 
            padding: 10px; 
            display: inline-block; 
            border-radius: 5px;
            text-align: center;
        }

        /* Sekcja danych */
        .details-table { width: 100%; margin-bottom: 30px; margin-top: 20px; }
        .details-table td { width: 50%; vertical-align: top; }
        .section-title { font-weight: bold; text-transform: uppercase; border-bottom: 2px solid {{ $invoice->user->brand_color ?? '#eee' }}; margin-bottom: 8px; padding-bottom: 3px; color: #555; }

        /* Tabela przedmiotów */
        .items-table { width: 100%; border-collapse: collapse; }
        .items-table th { background: #f8f9fa; border-bottom: 2px solid #dee2e6; padding: 10px; text-align: left; }
        .items-table td { padding: 10px; border-bottom: 1px solid #eee; }

        /* Podsumowanie */
        .summary-wrapper { margin-top: 30px; width: 100%; }
        .summary-table { width: 45%; margin-left: auto; border-collapse: collapse; }
        .summary-table td { padding: 8px 10px; }
        .total-row { 
            background: {{ $invoice->user->brand_color ?? '#0d6efd' }}; 
            color: white; 
            font-weight: bold; 
            font-size: 15px; 
        }

        /* Podpisy */
        .signature-table { width: 100%; margin-top: 60px; }
        .signature-line { border-top: 1px solid #ccc; width: 80%; margin: 40px auto 5px auto; }
        .text-center { text-align: center; }
    </style>
</head>
<body>
    <div class="header-brand">
        <table class="header-table">
            <tr>
                <td style="vertical-align: middle;">
                    @if($invoice->user->logo_path)
                    <div class="logo-box">
                        <img src="{{ public_path('storage/' . $invoice->user->logo_path) }}" 
                             style="max-width: 120px; max-height: 60px; height: auto;">
                    </div>
                    @endif
                </td>
                <td style="text-align: right; vertical-align: middle;">
                    <div class="invoice-title">FAKTURA VAT</div>
                    <div style="font-size: 16px; opacity: 0.9;">nr {{ $invoice->invoice_number ?? $invoice->id }}</div>
                </td>
            </tr>
        </table>
    </div>

    <div class="container">
        <table style="width: 100%; margin-bottom: 20px; text-align: right;">
            <tr>
                <td>
                    Data wystawienia: <strong>{{ $invoice->date_delivered }}</strong><br>
                    Data sprzedaży: <strong>{{ $invoice->date_sold }}</strong>
                </td>
            </tr>
        </table>

        <table class="details-table">
            <tr>
                <td>
                    <div class="section-title">Sprzedawca</div>
                    <strong>{{ $userData['name'] }}</strong><br>
                    {!! nl2br(e($userData['address'] ?? 'ul. Przykładowa 123')) !!}
                </td>
                <td>
                    <div class="section-title">Nabywca</div>
                    <strong>{{ $invoice->customer->name }} {{ $invoice->customer->lastName }}</strong><br>
                    {!! nl2br(e($invoice->customer->address)) !!}
                </td>
            </tr>
        </table>

        <table class="items-table">
            <thead>
                <tr>
                    <th>Lp.</th>
                    <th>Nazwa towaru lub usługi</th>
                    <th style="text-align: right;">Netto</th>
                    <th style="text-align: center;">VAT</th>
                    <th style="text-align: right;">Brutto</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $currencies = new \Money\Currencies\ISOCurrencies();
                    $numberFormatter = new \NumberFormatter('pl_PL', \NumberFormatter::CURRENCY);
                    $moneyFormatter = new \Money\Formatter\IntlMoneyFormatter($numberFormatter, $currencies);
                    $spellout = new \NumberFormatter('pl', \NumberFormatter::SPELLOUT);
                    $amountAsFloat = (float) ($brutto->getAmount() / 100);
                @endphp
                <tr>
                    <td>1</td>
                    <td>{{ $invoice->product_name }}</td>
                    <td style="text-align: right;">{{ $moneyFormatter->format($netto) }}</td>
                    <td style="text-align: center;">{{ $invoice->vat }}%</td>
                    <td style="text-align: right;">{{ $moneyFormatter->format($brutto) }}</td>
                </tr>
            </tbody>
        </table>

        <div class="summary-wrapper">
            <table class="summary-table">
                <tr>
                    <td>Suma Netto:</td>
                    <td style="text-align: right;">{{ $moneyFormatter->format($netto) }}</td>
                </tr>
                <tr>
                    <td>Suma VAT:</td>
                    <td style="text-align: right;">{{ $moneyFormatter->format($vatValue) }}</td>
                </tr>
                <tr class="total-row">
                    <td>DO ZAPŁATY:</td>
                    <td style="text-align: right;">{{ $moneyFormatter->format($brutto) }}</td>
                </tr>
            </table>
        </div>

        <p style="margin-top: 25px;">
            Słownie: <strong style="text-transform: capitalize;">{{ $spellout->format($amountAsFloat) }}</strong>
        </p>

        <table class="signature-table">
            <tr>
                <td class="text-center">
                    <div class="signature-line"></div>
                    <div style="font-size: 9px; color: #888;">Osoba upoważniona do wystawienia</div>
                </td>
                <td class="text-center">
                    <div class="signature-line"></div>
                    <div style="font-size: 9px; color: #888;">Osoba upoważniona do odbioru</div>
                </td>
            </tr>
        </table>
    </div>
</body>
</html>