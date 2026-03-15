<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edytuj Klienta - Fakturomat</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-light">

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            
            <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/" class="text-decoration-none">Start</a></li>
                    <li class="breadcrumb-item"><a href="/customer" class="text-decoration-none">Klienci</a></li>
                    <li class="breadcrumb-item active">Edycja</li>
                </ol>
            </nav>

            <div class="card shadow-sm border-0">
                <div class="card-header bg-dark text-white py-3">
                    <h5 class="mb-0"><i class="fas fa-user-edit me-2"></i>Edytuj dane klienta</h5>
                </div>
                <div class="card-body p-4">
                    <form action="/customer/{{ $customer->id }}" method="post">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label fw-bold small">Imię</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
                                   value="{{ old('name', $customer->name) }}" required>
                            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold small">Nazwisko</label>
                            <input type="text" name="lastName" class="form-control @error('lastName') is-invalid @enderror" 
                                   value="{{ old('lastName', $customer->lastName) }}" required>
                            @error('lastName') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                         <div class="mb-3">
                            <label class="form-label fw-bold small">Email</label>
                            <input type="text" name="email" class="form-control @error('email') is-invalid @enderror" 
                                   value="{{ old('email', $customer->email) }}" required>
                            @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold small">Pełny Adres</label>
                            <textarea name="address" class="form-control @error('address') is-invalid @enderror" 
                                      rows="3" required>{{ old('address', $customer->address) }}</textarea>
                            @error('address') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary px-4 shadow-sm">
                                <i class="fas fa-save me-1"></i> Zapisz zmiany
                            </button>
                            <a href="/customer" class="btn btn-outline-secondary px-4">Anuluj</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>