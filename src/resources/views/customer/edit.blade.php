<x-layout>
    <div class="w-full max-w-2xl mx-auto px-4 py-10">
        
        <!-- Breadcrumb (Nawigacja okruszkowa) -->
        <nav class="flex mb-6 text-sm font-medium ml-1" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li class="inline-flex items-center">
                    <a href="/" class="text-gray-400 hover:text-blue-600 transition-colors flex items-center">
                        <i class="fas fa-home mr-2 text-xs"></i> Start
                    </a>
                </li>
                <li>
                    <div class="flex items-center">
                        <i class="fas fa-chevron-right text-gray-300 text-[10px] mx-2"></i>
                        <a href="/customer" class="text-gray-400 hover:text-blue-600 transition-colors">Klienci</a>
                    </div>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <i class="fas fa-chevron-right text-gray-300 text-[10px] mx-2"></i>
                        <span class="text-blue-600 font-bold">Edycja</span>
                    </div>
                </li>
            </ol>
        </nav>

        <!-- Karta główna -->
        <div class="bg-white rounded-[24px] shadow-2xl overflow-hidden border border-gray-100">
            <!-- Header -->
            <div class="bg-gray-900 px-8 py-6 flex items-center gap-3">
                <div class="w-10 h-10 bg-blue-600/20 rounded-xl flex items-center justify-center text-blue-400">
                    <i class="fas fa-user-edit"></i>
                </div>
                <h2 class="text-xl font-bold text-white tracking-tight">Edytuj dane klienta</h2>
            </div>

            <!-- Formularz -->
            <div class="p-8 md:p-10">
                <form action="/customer/{{ $customer->id }}" method="post" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Imię -->
                        <div class="space-y-1.5">
                            <label class="block text-[11px] font-bold text-gray-500 uppercase tracking-widest ml-1">Imię</label>
                            <input type="text" name="name" value="{{ old('name', $customer->name) }}" required
                                class="block w-full px-4 py-3 bg-gray-50 border @error('name') border-red-500 @else border-gray-200 @enderror rounded-xl focus:ring-2 focus:ring-blue-500 focus:bg-white transition-all outline-none text-gray-700">
                            @error('name') <p class="text-[10px] text-red-500 font-bold mt-1 ml-1 uppercase">{{ $message }}</p> @enderror
                        </div>

                        <!-- Nazwisko -->
                        <div class="space-y-1.5">
                            <label class="block text-[11px] font-bold text-gray-500 uppercase tracking-widest ml-1">Nazwisko</label>
                            <input type="text" name="lastName" value="{{ old('lastName', $customer->lastName) }}" required
                                class="block w-full px-4 py-3 bg-gray-50 border @error('lastName') border-red-500 @else border-gray-200 @enderror rounded-xl focus:ring-2 focus:ring-blue-500 focus:bg-white transition-all outline-none text-gray-700">
                            @error('lastName') <p class="text-[10px] text-red-500 font-bold mt-1 ml-1 uppercase">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <!-- Email -->
                    <div class="space-y-1.5">
                        <label class="block text-[11px] font-bold text-gray-500 uppercase tracking-widest ml-1">Email kontaktowy</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-gray-400">
                                <i class="fas fa-envelope text-xs"></i>
                            </span>
                            <input type="email" name="email" value="{{ old('email', $customer->email) }}" required
                                class="block w-full pl-10 pr-4 py-3 bg-gray-50 border @error('email') border-red-500 @else border-gray-200 @enderror rounded-xl focus:ring-2 focus:ring-blue-500 focus:bg-white transition-all outline-none text-gray-700">
                        </div>
                        @error('email') <p class="text-[10px] text-red-500 font-bold mt-1 ml-1 uppercase">{{ $message }}</p> @enderror
                    </div>

                    <!-- Adres -->
                    <div class="space-y-1.5">
                        <label class="block text-[11px] font-bold text-gray-500 uppercase tracking-widest ml-1">Pełny Adres</label>
                        <textarea name="address" rows="3" required
                            class="block w-full px-4 py-3 bg-gray-50 border @error('address') border-red-500 @else border-gray-200 @enderror rounded-xl focus:ring-2 focus:ring-blue-500 focus:bg-white transition-all outline-none text-gray-700 resize-none">{{ old('address', $customer->address) }}</textarea>
                        @error('address') <p class="text-[10px] text-red-500 font-bold mt-1 ml-1 uppercase">{{ $message }}</p> @enderror
                    </div>

                    <!-- Stopka / Przyciski -->
                    <div class="flex items-center gap-4 pt-4">
                        <button type="submit" class="flex-1 md:flex-none px-8 py-4 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-2xl shadow-lg shadow-blue-600/20 transition-all active:scale-95 flex items-center justify-center gap-2 cursor-pointer">
                            <i class="fas fa-save text-sm"></i> Zapisz zmiany
                        </button>
                        <a href="/customer" class="flex-1 md:flex-none px-8 py-4 bg-gray-100 hover:bg-gray-200 text-gray-600 font-bold rounded-2xl transition-all text-center">
                            Anuluj
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layout>
