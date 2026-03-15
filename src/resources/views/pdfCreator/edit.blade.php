<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Fakturomat') }}</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        .uppercase {
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .card {
            border-radius: 15px;
            overflow: hidden;
        }
    </style>
</head>
<body class="bg-light">

<div class="card shadow-sm border-0">
    <div class="card-header bg-warning text-dark py-3">
        <h5 class="mb-0"><i class="fas fa-edit me-2"></i>Edycja faktury nr {{ $invoice->invoice_number }}</h5>
    </div>
    <div class="card-body p-4">
        <form action="/update/{{ $invoice->id }}" method="post">
            @csrf
            @method('PUT')
      @if($errors->any())
        <div class="alert alert-danger shadow-sm mb-4">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
            <div class="row g-4">
                <div class="col-md-12">
                    <label class="form-label fw-bold small uppercase text-muted">Kontrahent</label>
                    <select class="form-select" name="customer_id" required>
                        @foreach($customers as $customer)
                            <option value="{{ $customer->id }}" {{ $invoice->customer_id == $customer->id ? 'selected' : '' }}>
                                {{ $customer->name }} {{ $customer->lastName }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-12">
                    <label class="form-label fw-bold small uppercase text-muted">Nazwa usługi / produktu</label>
                    <input type="text" name="product_name" class="form-control" value="{{ $invoice->product_name }}" required>
                </div>

                <div class="col-md-4">
                    <label class="form-label fw-bold small uppercase text-muted">Cena Netto</label>
                    <div class="input-group">
                        <input type="number" name="price" id="netto_input" class="form-control" step="0.01" value="{{ number_format($invoice->price / 100, 2, '.', '') }}" required>
                        <span class="input-group-text">PLN</span>
                    </div>
                </div>

                <div class="col-md-4">
                    <label class="form-label fw-bold small uppercase text-muted">Stawka VAT</label>
                    <select class="form-select" name="vat" id="vat_select">
                        <option value="23" {{ $invoice->vat == 23 ? 'selected' : '' }}>23%</option>
                        <option value="8" {{ $invoice->vat == 8 ? 'selected' : '' }}>8%</option>
                        <option value="5" {{ $invoice->vat == 5 ? 'selected' : '' }}>5%</option>
                        <option value="0" {{ $invoice->vat == 0 ? 'selected' : '' }}>0% (zw.)</option>
                    </select>
                </div>

                <div class="col-md-4">
                    <label class="form-label fw-bold small uppercase text-muted">Wartość Brutto</label>
                    <div class="form-control bg-light d-flex justify-content-between align-items-center">
                        <span id="brutto_display" class="fw-bold text-primary">0.00</span>
                        <span class="text-muted small">PLN</span>
                    </div>
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-bold small uppercase text-muted">Data sprzedaży</label>
                    <input type="date" name="date_sold" class="form-control" value="{{ $invoice->date_sold }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-bold small uppercase text-muted">Data wystawienia</label>
                    <input type="date" name="date_delivered" class="form-control" value="{{ $invoice->date_delivered }}" required>
                </div>

                <div class="col-12 mt-4 d-flex gap-2">
                    <button type="submit" class="btn btn-warning flex-grow-1 shadow-sm">
                        <i class="fas fa-save me-2"></i>Zatwierdź zmiany
                    </button>
                    <a href="/pdf" class="btn btn-outline-secondary px-4">Anuluj</a>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const nettoInput = document.getElementById('netto_input');
        const vatSelect = document.getElementById('vat_select');
        const bruttoDisplay = document.getElementById('brutto_display');

        function calculateBrutto() {
            const netto = parseFloat(nettoInput.value) || 0;
            const vat = parseFloat(vatSelect.value) || 0;
            const brutto = netto * (1 + (vat / 100));
            
            bruttoDisplay.innerText = brutto.toLocaleString('pl-PL', { 
                minimumFractionDigits: 2, 
                maximumFractionDigits: 2 
            });
        }

        nettoInput.addEventListener('input', calculateBrutto);
        vatSelect.addEventListener('change', calculateBrutto);
        calculateBrutto();
    });
</script>

</body>
</html>