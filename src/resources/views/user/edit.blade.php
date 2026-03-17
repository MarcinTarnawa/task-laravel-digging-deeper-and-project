<x-layout>
    <!-- Kontener karty -->
    <div class="relative z-10 mx-auto w-full max-w-[500px] bg-white p-10 md:p-12 rounded-[24px] shadow-2xl transition-all duration-300">
        
        <div class="flex items-center gap-4 mb-8">
            <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-xl flex items-center justify-center text-xl shadow-sm border border-blue-100/50">
                <i class="fas fa-user-cog"></i>
            </div>
            <div>
                <h2 class="text-2xl font-extrabold text-gray-900 tracking-tight">Ustawienia Profilu</h2>
                <p class="text-xs text-gray-400 font-medium uppercase tracking-wider">Personalizacja Twoich faktur</p>
            </div>
        </div>

        <form action="{{ route('user.update', auth()->user()->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PATCH')

            <!-- Nazwa użytkownika -->
            <div class="space-y-1.5">
                <label class="block text-[11px] font-bold text-gray-500 uppercase tracking-widest ml-1">Nazwa użytkownika</label>
                <input type="text" name="name" value="{{ auth()->user()->name }}" 
                    class="block w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:bg-white transition-all outline-none text-gray-700 font-medium"
                    placeholder="Twoje imię lub nazwa firmy">
            </div>

            <!-- Kolor marki -->
            <div class="space-y-1.5">
                <label class="block text-[11px] font-bold text-gray-500 uppercase tracking-widest ml-1">Kolor Twojej marki</label>
                <div class="flex items-center gap-4 p-3 bg-gray-50 border border-gray-200 rounded-xl">
                    <input type="color" name="brand_color" value="{{ auth()->user()->brand_color ?? '#0d6efd' }}" 
                        class="w-12 h-12 border-0 bg-transparent cursor-pointer rounded-lg p-0 [&::-webkit-color-swatch-wrapper]:p-0 [&::-webkit-color-swatch]:rounded-lg [&::-webkit-color-swatch]:border-none">
                    <div class="flex flex-col">
                        <span class="text-sm font-semibold text-gray-700 italic">Akcent kolorystyczny</span>
                        <span class="text-[10px] text-gray-400 uppercase tracking-tighter">Pojawi się na wydrukach PDF</span>
                    </div>
                </div>
            </div>

            <!-- Logo Firmy -->
            <div class="space-y-3 p-5 bg-blue-50/30 border-2 border-dashed border-blue-100 rounded-2xl">
                <label class="block text-[11px] font-bold text-blue-600 uppercase tracking-widest ml-1">Logo firmy (PNG, JPG)</label>
                
                @if(auth()->user()->logo_path)
                    <div class="bg-white p-3 rounded-xl border border-blue-100 shadow-sm">
                        <p class="text-[10px] text-gray-400 mb-2 text-center uppercase font-bold tracking-tighter">Aktualne logo:</p>
                        <img src="{{ asset('storage/' . auth()->user()->logo_path) }}" 
                             class="max-h-16 mx-auto object-contain">
                    </div>
                @endif
                
                <input type="file" name="logo" 
                    class="block w-full text-xs text-gray-500
                    file:mr-4 file:py-2 file:px-4
                    file:rounded-full file:border-0
                    file:text-[11px] file:font-bold
                    file:bg-blue-600 file:text-white
                    hover:file:bg-blue-700 transition-all cursor-pointer">
            </div>

            <!-- Przyciski -->
            <div class="pt-4 flex flex-col gap-3">
                <button type="submit" 
                    class="w-full py-4 bg-blue-600 text-white text-sm font-bold rounded-2xl hover:bg-blue-700 shadow-lg shadow-blue-600/20 active:scale-95 transition-all cursor-pointer">
                    Zapisz zmiany
                </button>
                <a href="/pdf" class="text-center text-xs font-bold text-gray-400 hover:text-gray-600 transition-colors uppercase tracking-widest py-2">
                    <i class="fas fa-arrow-left mr-1"></i> Powrót
                </a>
            </div>
        </form>
    </div>
</x-layout>
