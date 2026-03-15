<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Fakturomat') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
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
    <div class="container py-5">
        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm mb-4" role="alert">
            <i class="fas fa-check-circle me-2"></i><strong>Sukces!</strong> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        @if($errors->any())
        <div class="alert alert-danger shadow-sm mb-4">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <div class="card shadow-sm border-0">
            <div class="card-header bg-primary text-white py-3 d-flex justify-content-between align-items-center">
                <h4 class="mb-0"><i class="fas fa-file-invoice me-2"></i>Fakturomat</h4>

                <div class="d-flex align-items-center gap-3">
                    @auth
                    <a href="/customer" class="btn btn-sm btn-outline-light">
                        <i class="fas fa-user-plus me-1"></i> Dodaj klienta
                    </a>

                    <a href="{{ route('user.edit', auth()->user()->id) }}" class="btn btn-sm btn-outline-light">
                        <i class="fas fa-user-edit me-1"></i> Edycja
                    </a>

                    <div class="d-flex align-items-center ms-2">
                        <span class="small me-3">
                            Cześć, <strong class="text-white">{{ auth()->user()->name }}</strong>!
                        </span>

                        <form method="POST" action="/logout" class="m-0">
                            @csrf
                            <button class="btn btn-sm btn-light text-primary fw-bold">Wyloguj</button>
                        </form>
                    </div>
                    @endauth

                    @guest
                    <a href="/login" class="btn btn-sm btn-outline-light">Zaloguj</a>
                    <a href="/register" class="btn btn-sm btn-light text-primary">Rejestracja</a>
                    @endguest
                </div>
            </div>
        </div>

        <div class="card-body p-4">
            <form action="/pdfCreatorStore" method="post">
                @csrf

                <div class="row g-4">
                    <div class="col-md-6">
                        <label class="form-label fw-bold text-muted small uppercase">Sprzedający</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light"><i class="fas fa-user-tie"></i></span>
                            <input type="text" name="name" class="form-control bg-light" readonly value="{{ $userData['name'] }}">
                        </div>
                        <div class="form-text mt-1">Dane pobrane z profilu.</div>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold text-muted small uppercase">Kupujący</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-users"></i></span>
                            <select class="form-select" name="customer_id" required>
                                <option value="" selected disabled>Wybierz klienta...</option>
                                @foreach($customers as $customer)
                                <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-12">
                        <hr class="my-2 text-muted opacity-25">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold">Data sprzedaży</label>
                        <input type="date" name="date_sold" class="form-control" value="{{ now()->format('Y-m-d') }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Data wystawienia</label>
                        <input type="date" name="date_delivered" class="form-control" value="{{ now()->format('Y-m-d') }}" required>
                    </div>

                    <div class="col-md-7">
                        <label class="form-label fw-bold">Nazwa produktu / usługi</label>
                        <input type="text" name="product_name" class="form-control" placeholder="np. Konsultacje IT" required>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label fw-bold">Cena (Netto)</label>
                        <div class="input-group">
                            <input type="number" name="price" class="form-control" step="0.01" required>
                            <span class="input-group-text">PLN</span>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <label class="form-label fw-bold">VAT</label>
                        <select class="form-select bg-light" name="vat">
                            <option value="23">23%</option>
                            <option value="8">8%</option>
                            <option value="5">5%</option>
                            <option value="0">0%</option>
                        </select>
                    </div>

                    <div class="col-12 mt-4">
                        <button type="submit" class="btn btn-success btn-lg w-100 shadow-sm">
                            <i class="fas fa-save me-2"></i> Zapisz i generuj PDF
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    </div>
    <div class="card shadow-sm border-0 mt-5">
        <div class="card-header bg-dark text-white py-3">
            <h5 class="mb-0"><i class="fas fa-list me-2"></i>Ostatnio wystawione faktury</h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">Klient</th>
                            <th>Produkt/Usługa</th>
                            <th>Data sprzedaży</th>
                            <th>Cena Netto</th>
                            <th>VAT</th>
                            <th class="text-center">Logo</th>
                            <th class="text-end pe-4">Akcje</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($invoices as $invoice)
                        <tr>
                            <td class="ps-4">
                                <span class="fw-bold text-dark">{{ $invoice->customer->name ?? 'Brak danych' }}</span>
                            </td>
                            <td><small class="text-muted d-block">{{ $invoice->product_name }}</small></td>
                            <td>{{ $invoice->date_sold }}</td>
                            <td class="fw-bold">{{ number_format($invoice->price / 100, 2, ',', ' ') }} PLN</td>
                            <td><span class="badge bg-secondary">{{ $invoice->vat }}%</span></td>
                            <td class="text-center">
                                @if($invoice->user->logo_path)
                                <img src="{{ asset('storage/' . $invoice->user->logo_path) }}"
                                    alt="Logo"
                                    style="width: 40px; height: 40px; object-fit: contain;"
                                    class="rounded border bg-white p-1">
                                @else
                                <i class="fas fa-image text-muted opacity-25"></i>
                                @endif
                            </td>
                            <td class="text-end pe-4">
                                <div class="btn-group shadow-sm" role="group" style="white-space: nowrap;">
                                    <a href="{{ route('pdf.download', $invoice->id) }}?action=stream"
                                        class="btn btn-sm btn-outline-info" target="_blank" title="Podgląd">
                                        <i class="fas fa-eye"></i>
                                    </a>

                                    <a href="{{ route('pdf.edit', $invoice->id) }}"
                                        class="btn btn-sm btn-outline-warning" title="Edytuj">
                                        <i class="fas fa-edit"></i>
                                    </a>

                                    <a href="{{ route('pdf.download', $invoice->id) }}?action=download"
                                        class="btn btn-sm btn-outline-primary" title="Pobierz PDF">
                                        <i class="fas fa-download"></i>
                                    </a>

                                    <a href="{{ route('pdf.history', $invoice->invoice_uuid) }}"
                                        class="btn btn-sm btn-outline-secondary" title="Historia wersji">
                                        <i class="fas fa-history"></i>
                                    </a>

                                    @php $hasConsent = $invoice->customer->email_consent; @endphp
                                    <form action="{{ route('pdf.sendEmail', $invoice->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit"
                                            class="btn btn-sm {{ $hasConsent ? 'btn-outline-secondary' : 'btn-outline-warning' }}"
                                            title="{{ $hasConsent ? 'Wyślij Fakturę' : 'Brak zgody' }}"
                                            onclick="return confirm('{{ $hasConsent ? 'Wysłać fakturę?' : 'Klient nie wyraził zgody. Kontynuować?' }}')">
                                            <i class="fas {{ $hasConsent ? 'fa-envelope' : 'fa-user-check' }}"></i>
                                        </button>
                                    </form>

                                    <form action="{{ route('pdf.destroy', $invoice->id) }}" method="POST" class="d-inline">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger"
                                            onclick="return confirm('Usunąć nieodwracalnie?')" title="Usuń">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-4 text-muted">Brak wystawionych faktur.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>