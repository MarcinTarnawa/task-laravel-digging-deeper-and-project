<x-layout>
    <div class="circle circle-1"></div>
    <div class="circle circle-2"></div>

    <div class="card mx-auto">
        <div class="icon-box">
            <i class="fas fa-file-invoice-dollar"></i>
        </div>
        
        <h1 class="text-2xl font-bold text-gray-800 mb-2">Witaj w Fakturomacie</h1>
        <p class="text-gray-500 mb-8">Zarządzaj swoimi fakturami i klientami w jednym, bezpiecznym miejscu.</p>
        
        <a href="/pdf" class="btn-start">
            Uruchom system <i class="fas fa-arrow-right"></i>
        </a>

        @guest
            <div class="mt-8 pt-6 border-t border-gray-100">
                <p class="text-sm text-gray-400 mb-4">System generowania faktur v3.0</p>
                <div class="flex justify-center gap-4">
                    <a href="/login" class="text-sm font-semibold text-indigo-600 hover:text-indigo-800 transition">Zaloguj się</a>
                    <span class="text-gray-300">|</span>
                    <a href="/register" class="text-sm font-semibold text-indigo-600 hover:text-indigo-800 transition">Załóż konto</a>
                </div>
            </div>
        @endguest

        @auth
            <div class="mt-8 text-sm text-gray-400">
                Zalogowano jako: <span class="font-medium text-gray-600">{{ auth()->user()->name }}</span>
            </div>
        @endauth
    </div>
</x-layout>

<style>
    /* Dodatkowe style specyficzne dla strony powitalnej, 
       które współpracują z klasami w x-layout */
    
    .card {
        background: white;
        padding: 3rem;
        border-radius: 24px;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
        text-align: center;
        max-width: 500px;
        width: 100%;
        position: relative;
        z-index: 10;
        transition: transform 0.3s ease;
    }

    .card:hover {
        transform: translateY(-5px);
    }

    .icon-box {
        width: 80px;
        height: 80px;
        background: #f0f7ff;
        color: #0d6efd;
        border-radius: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2.2rem;
        margin: 0 auto 1.5rem;
    }

    .btn-start {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 12px;
        background: #0d6efd;
        color: white;
        text-decoration: none;
        padding: 14px 30px;
        border-radius: 12px;
        font-weight: 600;
        transition: all 0.3s ease;
        width: 100%;
    }

    .btn-start:hover {
        background: #0056b3;
        box-shadow: 0 8px 15px rgba(13, 110, 253, 0.3);
        gap: 18px;
    }

    /* Dekoracyjne koła w tle main */
    .circle {
        position: absolute;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
        z-index: 0;
        pointer-events: none;
    }
    .circle-1 { width: 400px; height: 400px; top: -100px; left: -150px; }
    .circle-2 { width: 300px; height: 300px; bottom: -50px; right: -100px; }
</style>
