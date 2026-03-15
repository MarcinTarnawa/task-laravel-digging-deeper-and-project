<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Historia Wersji - {{ config('app.name', 'Fakturomat') }}</title>

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

        /* Styl dla osi czasu */
        .timeline-container {
            max-width: 1000px;
            margin: 0 auto;
        }

        .version-card {
            transition: transform 0.2s ease-in-out;
            border-left: 5px solid #6c757d; /* Domyślny kolor dla archiwalnych */
        }

        .version-card:hover {
            transform: translateX(5px);
        }

        .version-card.active-version {
            border-left: 5px solid #198754; /* Zielony dla aktywnej */
            background-color: #f8fff9;
        }

        .badge-version {
            font-size: 0.9rem;
            width: 50px;
            height: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
        }
    </style>
</head>

<body class="bg-light">
    <div class="container py-5">

        {{-- Powiadomienia --}}
        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm mb-4" role="alert">
            <i class="fas fa-check-circle me-2"></i><strong>Sukces!</strong> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        {{-- Nagłówek strony historii --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="text-dark mb-0">
                <i class="fas fa-history me-2 text-primary"></i>Historia zmian
            </h3>
            <a href="/pdf" class="btn btn-outline-dark shadow-sm bg-white">
                <i class="fas fa-arrow-left me-1"></i> Powrót do panelu
            </a>
        </div>

        <div class="timeline-container">
            @foreach($history as $rev)
            <div class="card shadow-sm border-0 mb-3 version-card {{ $rev->is_active ? 'active-version' : '' }}">
                <div class="card-body p-4">
                    <div class="row align-items-center">
                        
                        {{-- Wersja --}}
                        <div class="col-md-2 text-center border-end">
                            <div class="badge-version {{ $rev->is_active ? 'bg-success text-white' : 'bg-light text-muted border' }} mx-auto mb-2">
                                <span class="fw-bold">v{{ $rev->version }}</span>
                            </div>
                            @if($rev->is_active)
                                <span class="badge bg-success uppercase small">Aktywna</span>
                            @else
                                <span class="badge bg-secondary uppercase small">Archiwum</span>
                            @endif
                        </div>

                        {{-- Szczegóły --}}
                        <div class="col-md-7 ps-4">
                            <div class="text-muted small uppercase fw-bold mb-1" style="font-size: 0.7rem;">
                                <i class="fas fa-calendar-alt me-1"></i> Edytowano: {{ $rev->updated_at->format('d.m.Y H:i') }}
                            </div>
                            <h5 class="mb-1 text-dark">{{ $rev->product_name }}</h5>
                            <p class="mb-0 text-muted">
                                <i class="fas fa-user me-1"></i> {{ $rev->customer->name ?? 'Brak danych' }} | 
                                <span class="fw-bold text-primary">{{ number_format($rev->price, 2, ',', ' ') }} PLN</span>
                            </p>
                        </div>

                        {{-- Akcje --}}
                        <div class="col-md-3 text-end">
                            <div class="btn-group shadow-sm">
                                <a href="/download-pdf/{{ $rev->id }}?action=stream" 
                                   class="btn btn-sm btn-outline-info" target="_blank" title="Podgląd">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="/download-pdf/{{ $rev->id }}?action=download" 
                                   class="btn btn-sm btn-outline-primary" title="Pobierz">
                                    <i class="fas fa-download"></i>
                                </a>
                                
                                @if(!$rev->is_active)
                                <form action="{{ route('pdf.restore', $rev->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-outline-warning" 
                                            onclick="return confirm('Czy chcesz przywrócić tę wersję jako aktualną?')" 
                                            title="Przywróć tę wersję">
                                        <i class="fas fa-undo"></i>
                                    </button>
                                </form>
                                @endif
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>