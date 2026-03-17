<x-layout>
    <div class="relative z-10 mx-auto w-full max-w-[500px] bg-white p-10 md:p-12 rounded-[24px] shadow-2xl transition-all duration-300">
        
        <div class="flex justify-center mb-6">
            <div class="w-16 h-16 bg-blue-50 text-blue-600 rounded-2xl flex items-center justify-center text-2xl shadow-sm border border-blue-100/50">
                <i class="fas fa-user-plus"></i>
            </div>
        </div>

        <h2 class="text-3xl font-extrabold text-gray-900 mb-1 text-center tracking-tight">Stwórz konto</h2>
        <p class="text-sm text-gray-400 text-center mb-10 font-medium">Dołącz do użytkowników Fakturomat</p>

        <form action="/register" method="POST" class="space-y-5 text-left">
            @csrf

            <!-- Imię i nazwisko -->
            <div class="space-y-1.5">
                <label for="name" class="block text-[11px] font-bold text-gray-500 uppercase tracking-widest ml-1">
                    Imię i nazwisko
                </label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" 
                    placeholder="np. Jan Kowalski"
                    class="block w-full px-4 py-3 bg-gray-50 border @error('name') border-red-500 @else border-gray-200 @enderror rounded-xl focus:ring-2 focus:ring-blue-500 focus:bg-white focus:border-transparent transition-all outline-none placeholder:text-gray-300 text-gray-700" 
                    required
                    autofocus>
                @error('name') 
                    <p class="mt-1 text-[11px] text-red-500 font-semibold px-1 italic">{{ $message }}</p> 
                @enderror
            </div>

            <!-- Email -->
            <div class="space-y-1.5">
                <label for="email" class="block text-[11px] font-bold text-gray-500 uppercase tracking-widest ml-1">
                    Adres e-mail
                </label>
                <input type="email" name="email" id="email" value="{{ old('email') }}" 
                    placeholder="twoj@email.pl"
                    class="block w-full px-4 py-3 bg-gray-50 border @error('email') border-red-500 @else border-gray-200 @enderror rounded-xl focus:ring-2 focus:ring-blue-500 focus:bg-white focus:border-transparent transition-all outline-none placeholder:text-gray-300 text-gray-700" 
                    required>
                @error('email') 
                    <p class="mt-1 text-[11px] text-red-500 font-semibold px-1 italic">{{ $message }}</p> 
                @enderror
            </div>

            <!-- Hasło -->
            <div class="space-y-1.5">
                <label for="password" class="block text-[11px] font-bold text-gray-500 uppercase tracking-widest ml-1">
                    Hasło
                </label>
                <input type="password" name="password" id="password" 
                    placeholder="••••••••"
                    class="block w-full px-4 py-3 bg-gray-50 border @error('password') border-red-500 @else border-gray-200 @enderror rounded-xl focus:ring-2 focus:ring-blue-500 focus:bg-white focus:border-transparent transition-all outline-none placeholder:text-gray-300 text-gray-700" 
                    required>
                @error('password') 
                    <p class="mt-1 text-[11px] text-red-500 font-semibold px-1 italic">{{ $message }}</p> 
                @enderror
            </div>

            <!-- Potwierdzenie hasła -->
            <div class="space-y-1.5">
                <label for="password_confirmation" class="block text-[11px] font-bold text-gray-500 uppercase tracking-widest ml-1">
                    Potwierdź hasło
                </label>
                <input type="password" name="password_confirmation" id="password_confirmation" 
                    placeholder="••••••••"
                    class="block w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:bg-white focus:border-transparent transition-all outline-none placeholder:text-gray-300 text-gray-700" 
                    required>
            </div>

            <!-- Przyciski -->
            <div class="flex items-center justify-between pt-6">
                <a href="/login" class="text-sm font-bold text-gray-500 hover:text-blue-600 transition-colors group">
                    Masz już konto? <span class="text-blue-600 group-hover:text-blue-800">Zaloguj się</span>
                </a>
                <button type="submit" class="px-8 py-3.5 bg-blue-600 text-white text-sm font-bold rounded-xl hover:bg-blue-700 focus:ring-4 focus:ring-blue-500/20 transition-all shadow-lg shadow-blue-600/20 active:scale-95 cursor-pointer">
                    Zarejestruj
                </button>
            </div>
        </form>
    </div>
</x-layout>
