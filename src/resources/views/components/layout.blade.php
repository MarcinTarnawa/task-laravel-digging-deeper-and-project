<!DOCTYPE html>
<html lang="pl" class="h-full">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fakturomat - Start</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>

<body class="antialiased min-h-screen flex flex-col bg-gradient-to-br from-blue-600 to-blue-900">

    <!-- Navbar -->
    <nav class="bg-white/5 backdrop-blur-md border-b border-white/10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <div class="flex items-center">
                    <a href="/" class="text-xl font-bold text-white tracking-tight">Fakturomat</a>
                </div>

                <div class="flex items-center space-x-3">
                    @guest
                    <a href="/login" class="px-4 py-2 text-sm font-semibold rounded-xl bg-white text-blue-700 hover:bg-blue-50 transition-all duration-200 shadow-sm">
                        Zaloguj
                    </a>
                    <a href="/register" class="px-4 py-2 text-sm font-semibold rounded-xl bg-white text-blue-700 hover:bg-blue-50 transition-all duration-200 shadow-sm border border-blue-100/50">
                        Rejestracja
                    </a>
                    @endguest

                    @auth
                    <div class="flex items-center space-x-3">
                        <span class="hidden md:inline-block px-4 py-2 text-sm font-medium rounded-xl bg-white text-blue-800 shadow-sm">
                            Witaj, <strong class="text-blue-600">{{ auth()->user()->name }}</strong>
                        </span>
                        <a href="{{ route('user.edit', auth()->user()->id) }}" class="px-4 py-2 text-sm font-medium rounded-xl bg-white text-blue-800 shadow-sm hover:bg-blue-50 transition-colors">
                            <i class="fas fa-user-edit mr-1"></i> <span class="hidden sm:inline">Edycja</span>
                        </a>

                        <form method="POST" action="/logout" class="inline">
                            @csrf
                            <button type="submit" class="px-4 py-2 text-sm font-medium rounded-xl bg-white text-blue-700 hover:bg-red-50 hover:text-red-600 transition-all duration-200 shadow-sm border border-transparent hover:border-red-100">
                                <i class="fas fa-sign-out-alt"></i> <span class="hidden sm:inline ml-1">Wyloguj</span>
                            </button>
                        </form>
                    </div>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="flex-1 flex items-center justify-center relative overflow-hidden p-6">
        
        <!-- Dekoracyjne tło (Circles) -->
        <div class="absolute -top-24 -left-24 w-96 h-96 bg-white/5 rounded-full pointer-events-none"></div>
        <div class="absolute -bottom-24 -right-24 w-80 h-80 bg-white/5 rounded-full pointer-events-none"></div>

        <!-- Karta główna -->
        <div  class="w-full flex-1 flex flex-col items-center">
            @if(isset($slot) && $slot->isNotEmpty())
                {{ $slot }}
            @else
                <!-- Icon Box -->
                <div class="w-20 h-20 bg-blue-50 text-blue-600 rounded-2xl flex items-center justify-center text-3xl mx-auto mb-6">
                    <i class="fa-solid fa-file-invoice-dollar"></i>
                </div>

                <h1 class="text-3xl font-bold text-gray-900 mb-3 tracking-tight">Witaj w Fakturomat</h1>
                <p class="text-gray-500 mb-10 leading-relaxed">
                    Zarządzaj swoimi wydatkami i fakturami w jednym, bezpiecznym miejscu.
                </p>

                <a href="/pdf" class="inline-flex items-center gap-3 bg-blue-600 hover:bg-blue-700 text-white px-8 py-4 rounded-xl font-semibold transition-all duration-300 hover:-translate-y-1 hover:shadow-lg hover:shadow-blue-500/30">
                    Zacznij teraz
                    <i class="fa-solid fa-arrow-right text-sm"></i>
                </a>

                <p class="mt-8 text-xs text-gray-400 font-medium uppercase tracking-widest">
                    © 2024 Fakturomat
                </p>
            @endif
        </div>
    </main>

</body>
</html>
