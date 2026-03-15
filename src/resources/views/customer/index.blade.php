<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zarządzanie Klientami - Fakturomat</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-light">

<div class="container py-5">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
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

    <div class="row g-4">
        <div class="col-lg-4">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-user-plus me-2"></i>Nowy Klient</h5>
                </div>
                <div class="card-body">
                    <form action="/customer" method="post">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label fw-bold small">Imię</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="np. Jan" value="{{ old('name') }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold small">Nazwisko</label>
                            <input type="text" name="lastName" class="form-control @error('lastName') is-invalid @enderror" placeholder="np. Kowalski" value="{{ old('lastName') }}" required>
                        </div>
                         <div class="mb-3">
                            <label class="form-label fw-bold small">Email</label>
                            <textarea name="email" class="form-control @error('email') is-invalid @enderror" rows="2" placeholder="example@example.com" required>{{ old('address') }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold small">Adres</label>
                            <textarea name="address" class="form-control @error('address') is-invalid @enderror" rows="2" placeholder="ul. Prosta 1, 00-001 Miasto" required>{{ old('address') }}</textarea>
                        </div>
                        <button type="submit" class="btn btn-primary w-100 shadow-sm">Dodaj Klienta</button>
                    </form>
                </div>
            </div>
            <a href="/pdf" class="btn btn-link mt-3 text-decoration-none text-muted"><i class="fas fa-arrow-left"></i> Powrót do faktur</a>
        </div>

        <div class="col-lg-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-dark text-white">
                    <h5 class="mb-0"><i class="fas fa-users me-2"></i>Baza Klientów</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-4">Klient</th>
                                    <th>Adres</th>
                                    <th class="text-end pe-4">Akcje</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($customers as $c)
                                <tr>
                                    <td class="ps-4">
                                        <div class="fw-bold">{{ $c->name }} {{ $c->lastName }}</div>
                                    </td>
                                    <td class="text-muted small">{{ $c->address }}</td>
                                    <td class="text-end pe-4">
                                        <div class="btn-group">
                                            <a href="/customer/{{ $c->id }}/edit" class="btn btn-sm btn-outline-secondary">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="/customer/{{ $c->id }}" method="POST" class="d-inline" onsubmit="return confirm('Czy usunąć klienta? Spowoduje to błędy w powiązanych fakturach!')">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" class="text-center py-4">Brak klientów w bazie.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>