<x-layout>
    <div class="relative z-10 mx-auto w-full max-w-[500px] bg-white p-12 rounded-[24px] shadow-[0_20px_40px_rgba(0,0,0,0.15)] transition-transform duration-300">
        
        <div class="flex justify-center mb-6">
            <div class="w-16 h-16 bg-blue-50 text-blue-600 rounded-full flex items-center justify-center text-2xl shadow-inner border border-blue-100/50">
                <i class="fas fa-lock"></i>
            </div>
        </div>

        <h2 class="text-3xl font-extrabold text-gray-900 mb-2 text-center tracking-tight">Zaloguj się</h2>
        <p class="text-sm text-gray-500 text-center mb-10 font-medium">Witaj w systemie Fakturomat</p>

        <form action="/login" method="post" class="space-y-6 text-left">
            @csrf

            <!-- Email -->
            <div>
                <label for="email" class="block text-[11px] font-bold text-gray-400 uppercase tracking-widest mb-4 px-1">Email</label>
                <input type="email" name="email" id="email" 
                    value="{{ old('email') }}" 
                    placeholder="twoj@email.pl"
                    class="block w-full px-5 py-4 bg-gray-50 border @error('email') border-red-500 @else border-gray-200 @enderror rounded-2xl focus:ring-2 focus:ring-blue-500 focus:bg-white focus:border-transparent transition-all outline-none placeholder:text-gray-300" 
                    required
                    autofocus>
                @error('email')
                    <p class="mt-2 text-xs text-red-500 font-semibold flex items-center gap-1 italic">
                        <i class="fas fa-exclamation-circle text-[10px]"></i> {{ $message }}
                    </p>
                @enderror
            </div>

            <!-- Hasło -->
            <div>
                <label for="password" class="block text-[11px] font-bold text-gray-400 uppercase tracking-widest mt-2 mb-4 px-1">Hasło</label>
                <input type="password" name="password" id="password" 
                    placeholder="••••••••"
                    class="block w-full px-5 py-4 bg-gray-50 border @error('password') border-red-500 @else border-gray-200 @enderror rounded-2xl focus:ring-2 focus:ring-blue-500 focus:bg-white focus:border-transparent transition-all outline-none placeholder:text-gray-300" 
                    required>
                @error('password')
                    <p class="mt-2 text-xs text-red-500 font-semibold flex items-center gap-1 italic">
                        <i class="fas fa-exclamation-circle text-[10px]"></i> {{ $message }}
                    </p>
                @enderror
            </div>

            <!-- przyciski -->
            <div class="flex items-center justify-between pt-4">
                <a href="/register" class="text-sm font-bold text-blue-600 hover:text-blue-800 transition-colors underline-offset-4 hover:underline">
                    Utwórz konto
                </a>
                <button type="submit" class="px-8 py-3 bg-blue-600 text-white text-sm font-bold rounded-2xl hover:bg-blue-700 focus:ring-4 focus:ring-blue-500/20 transition-all shadow-lg shadow-blue-600/20 active:scale-95 cursor-pointer">
                    Zaloguj się
                </button>
            </div>
        </form>
    </div>
</x-layout>
