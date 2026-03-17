<x-layout>
    <div class="w-full max-w-full px-4 md:px-10 py-8 space-y-8">
        
        <!-- Powiadomienia -->
        @if(session('success'))
            <div class="flex items-center gap-3 bg-green-50 border border-green-200 text-green-700 px-6 py-4 rounded-2xl shadow-sm animate-fade-in">
                <i class="fas fa-check-circle text-xl"></i>
                <span class="font-semibold">{{ session('success') }}</span>
            </div>
        @endif

        @if($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-700 px-6 py-4 rounded-2xl shadow-sm">
                <ul class="list-disc list-inside font-medium text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="flex flex-col lg:flex-row gap-8">
            <!-- LEWA KOLUMNA: Formularz (Dodaj Klienta) -->
            <div class="w-full lg:w-1/3">
                <div class="bg-white rounded-[24px] shadow-xl overflow-hidden border border-gray-100 sticky top-8">
                    <div class="bg-blue-600 px-6 py-5 flex items-center gap-3">
                        <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center text-white">
                            <i class="fas fa-user-plus"></i>
                        </div>
                        <h2 class="text-lg font-bold text-white tracking-tight">Nowy Klient</h2>
                    </div>

                    <div class="p-6 md:p-8">
                        <form action="/customer" method="post" class="space-y-5">
                            @csrf
                            <div class="space-y-1.5">
                                <label class="block text-[11px] font-bold text-gray-400 uppercase tracking-widest ml-1">Imię</label>
                                <input type="text" name="name" placeholder="np. Jan" value="{{ old('name') }}" required
                                    class="block w-full px-4 py-3 bg-gray-50 border @error('name') border-red-500 @else border-gray-200 @enderror rounded-xl focus:ring-2 focus:ring-blue-500 focus:bg-white transition-all outline-none">
                            </div>

                            <div class="space-y-1.5">
                                <label class="block text-[11px] font-bold text-gray-400 uppercase tracking-widest ml-1">Nazwisko</label>
                                <input type="text" name="lastName" placeholder="np. Kowalski" value="{{ old('lastName') }}" required
                                    class="block w-full px-4 py-3 bg-gray-50 border @error('lastName') border-red-500 @else border-gray-200 @enderror rounded-xl focus:ring-2 focus:ring-blue-500 focus:bg-white transition-all outline-none">
                            </div>

                            <div class="space-y-1.5">
                                <label class="block text-[11px] font-bold text-gray-400 uppercase tracking-widest ml-1">Email</label>
                                <input type="email" name="email" placeholder="example@example.com" value="{{ old('email') }}" required
                                    class="block w-full px-4 py-3 bg-gray-50 border @error('email') border-red-500 @else border-gray-200 @enderror rounded-xl focus:ring-2 focus:ring-blue-500 focus:bg-white transition-all outline-none">
                            </div>

                            <div class="space-y-1.5">
                                <label class="block text-[11px] font-bold text-gray-400 uppercase tracking-widest ml-1">Adres</label>
                                <textarea name="address" rows="2" placeholder="ul. Prosta 1, 00-001 Miasto" required
                                    class="block w-full px-4 py-3 bg-gray-50 border @error('address') border-red-500 @else border-gray-200 @enderror rounded-xl focus:ring-2 focus:ring-blue-500 focus:bg-white transition-all outline-none resize-none font-medium">{{ old('address') }}</textarea>
                            </div>

                            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-4 rounded-2xl shadow-lg shadow-blue-600/20 transition-all active:scale-[0.98] flex items-center justify-center gap-2 cursor-pointer mt-4">
                                <i class="fas fa-plus text-sm"></i> Dodaj Klienta
                            </button>
                        </form>

                        <a href="/pdf" class="block text-center text-xs font-bold text-gray-400 hover:text-blue-600 transition-colors uppercase tracking-widest mt-8">
                            <i class="fas fa-arrow-left mr-1 text-[10px]"></i> Powrót do faktur
                        </a>
                    </div>
                </div>
            </div>

            <!-- PRAWA KOLUMNA: Tabela (Baza Klientów) -->
            <div class="w-full lg:w-2/3">
                <div class="bg-white rounded-[24px] shadow-xl overflow-hidden border border-gray-100 h-full">
                    <div class="bg-gray-900 px-8 py-5 flex items-center gap-3">
                        <i class="fas fa-users text-blue-400"></i>
                        <h3 class="text-white font-bold tracking-wide">Baza Klientów</h3>
                    </div>
                    
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-gray-50 border-b border-gray-100">
                                    <th class="px-8 py-4 text-[11px] font-bold text-gray-400 uppercase tracking-widest">Imię i Nazwisko</th>
                                    <th class="px-4 py-4 text-[11px] font-bold text-gray-400 uppercase tracking-widest">Email i Adres</th>
                                    <th class="px-8 py-4 text-[11px] font-bold text-gray-400 uppercase tracking-widest text-right">Akcje</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50">
                                @forelse($customers as $c)
                                <tr class="hover:bg-blue-50/30 transition-colors group">
                                    <td class="px-8 py-4">
                                        <div class="font-bold text-gray-900">{{ $c->name }} {{ $c->lastName }}</div>
                                    </td>
                                    <td class="px-4 py-4">
                                        <div class="text-sm font-semibold text-blue-600">{{ $c->email }}</div>
                                        <div class="text-xs text-gray-400 leading-relaxed">{{ $c->address }}</div>
                                    </td>
                                    <td class="px-8 py-4 text-right">
                                        <div class="inline-flex bg-gray-50 border border-gray-200 rounded-xl p-1 group-hover:bg-white shadow-sm">
                                            <!-- Edytuj -->
                                            <a href="/customer/{{ $c->id }}/edit" 
                                               class="p-2 text-gray-400 hover:text-amber-600 hover:bg-amber-50 rounded-lg transition-all" title="Edytuj">
                                                <i class="fas fa-edit text-sm"></i>
                                            </a>
                                            <!-- Usuń -->
                                            <form action="/customer/{{ $c->id }}" method="POST" class="inline" onsubmit="return confirm('Czy usunąć klienta?')">
                                                @csrf
                                                @method('DELETE')
                                                <button class="p-2 text-gray-300 hover:text-red-600 hover:bg-red-50 rounded-lg transition-all cursor-pointer" title="Usuń">
                                                    <i class="fas fa-trash text-sm"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" class="px-8 py-16 text-center text-gray-400 italic">
                                        <div class="flex flex-col items-center gap-3">
                                            <i class="fas fa-user-slash text-4xl opacity-20"></i>
                                            <span>Brak klientów w Twojej bazie danych.</span>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layout>
