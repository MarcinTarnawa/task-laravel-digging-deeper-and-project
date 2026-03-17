<x-layout>
   <div class="w-full max-w-full px-4 md:px-8 py-8 space-y-8 min-h-screen">

        <!-- Powiadomienia (Alerts) -->
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

        <!-- Sekcja Formularza (Tworzenie Faktury) -->
        <div class="bg-white rounded-[24px] shadow-xl overflow-hidden border border-gray-100">
            <!-- Header Karty -->
            <div class="bg-blue-600 px-8 py-6 flex flex-col md:flex-row justify-between items-center gap-4">
                <div class="flex items-center gap-3 text-white">
                    <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center">
                        <i class="fas fa-file-invoice text-xl"></i>
                    </div>
                    <h2 class="text-xl font-bold tracking-tight">Nowa Faktura</h2>
                </div>
                <a href="/customer" class="bg-white/10 hover:bg-white/20 text-white text-sm font-bold py-2.5 px-5 rounded-xl transition-all border border-white/20 flex items-center gap-2">
                    <i class="fas fa-user-plus text-xs"></i> Dodaj klienta
                </a>
            </div>

            <!-- Body Karty -->
            <div class="p-8 md:p-10">
                <form action="/pdfCreatorStore" method="post" class="space-y-8">
                    @csrf

                    <!-- Grid: Sprzedawca i Kupujący -->
                    <div class="grid md:grid-cols-2 gap-8">
                        <div class="space-y-2">
                            <label class="block text-[11px] font-bold text-gray-400 uppercase tracking-widest ml-1">Sprzedający</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-gray-400">
                                    <i class="fas fa-user-tie text-xs"></i>
                                </span>
                                <input type="text" name="name" readonly value="{{ $userData['name'] }}"
                                    class="block w-full pl-10 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-500 font-medium focus:outline-none">
                            </div>
                            <p class="text-[10px] text-blue-500 font-medium ml-1">Dane pobrane automatycznie z Twojego profilu.</p>
                        </div>

                        <div class="space-y-2">
                            <label class="block text-[11px] font-bold text-gray-500 uppercase tracking-widest ml-1">Kupujący</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-gray-400 pointer-events-none">
                                    <i class="fas fa-users text-xs"></i>
                                </span>
                                <select name="customer_id" required
                                    class="block w-full pl-10 pr-4 py-3 bg-white border border-gray-200 rounded-xl text-gray-700 font-medium focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all outline-none appearance-none cursor-pointer">
                                    <option value="" selected disabled>Wybierz klienta z listy...</option>
                                    @foreach($customers as $customer)
                                    <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="border-t border-gray-100 my-2"></div>

                    <!-- Grid: Daty i Szczegóły Produktu -->
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                        <div class="md:col-span-2 space-y-2">
                            <label class="block text-[11px] font-bold text-gray-500 uppercase tracking-widest ml-1">Data sprzedaży</label>
                            <input type="date" name="date_sold" value="{{ now()->format('Y-m-d') }}" required
                                class="block w-full px-4 py-3 bg-white border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 outline-none transition-all">
                        </div>
                        <div class="md:col-span-2 space-y-2">
                            <label class="block text-[11px] font-bold text-gray-500 uppercase tracking-widest ml-1">Data wystawienia</label>
                            <input type="date" name="date_delivered" value="{{ now()->format('Y-m-d') }}" required
                                class="block w-full px-4 py-3 bg-white border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 outline-none transition-all">
                        </div>

                        <div class="md:col-span-2 space-y-2">
                            <label class="block text-[11px] font-bold text-gray-500 uppercase tracking-widest ml-1">Nazwa produktu / usługi</label>
                            <input type="text" name="product_name" placeholder="np. Projektowanie strony WWW" required
                                class="block w-full px-4 py-3 bg-white border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 outline-none transition-all">
                        </div>

                        <div class="space-y-2">
                            <label class="block text-[11px] font-bold text-gray-500 uppercase tracking-widest ml-1">Cena Netto</label>
                            <div class="relative">
                                <input type="number" name="price" step="0.01" required
                                    class="block w-full px-4 py-3 bg-white border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 outline-none transition-all">
                                <span class="absolute right-4 top-1/2 -translate-y-1/2 text-[10px] font-bold text-gray-400">PLN</span>
                            </div>
                        </div>

                        <div class="space-y-2">
                            <label class="block text-[11px] font-bold text-gray-500 uppercase tracking-widest ml-1">Stawka VAT</label>
                            <select name="vat" class="block w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 outline-none transition-all appearance-none cursor-pointer">
                                <option value="23">23%</option>
                                <option value="8">8%</option>
                                <option value="5">5%</option>
                                <option value="0">0%</option>
                            </select>
                        </div>
                    </div>

                    <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-4 rounded-2xl shadow-lg shadow-green-600/20 transition-all active:scale-[0.98] flex items-center justify-center gap-3 mt-4">
                        <i class="fas fa-save text-lg"></i>
                        Zatwierdź i generuj PDF
                    </button>
                </form>
            </div>
        </div>

        <!-- Tabela Ostatnich Faktur -->
        <div class="bg-white rounded-[24px] shadow-xl overflow-hidden border border-gray-100">
            <div class="bg-gray-900 px-8 py-5 flex items-center gap-3">
                <i class="fas fa-list text-blue-400"></i>
                <h3 class="text-white font-bold tracking-wide">Ostatnio wystawione faktury</h3>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-100">
                            <th class="px-8 py-4 text-[11px] font-bold text-gray-400 uppercase tracking-widest">Klient</th>
                            <th class="px-4 py-4 text-[11px] font-bold text-gray-400 uppercase tracking-widest">Produkt</th>
                            <th class="px-4 py-4 text-[11px] font-bold text-gray-400 uppercase tracking-widest">Data</th>
                            <th class="px-4 py-4 text-[11px] font-bold text-gray-400 uppercase tracking-widest text-right">Suma Netto</th>
                            <th class="px-4 py-4 text-[11px] font-bold text-gray-400 uppercase tracking-widest text-center">VAT</th>
                            <th class="px-4 py-4 text-[11px] font-bold text-gray-400 uppercase tracking-widest text-center">Logo</th>
                            <th class="px-8 py-4 text-[11px] font-bold text-gray-400 uppercase tracking-widest text-right">Akcja</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($invoices as $invoice)
                        <tr class="hover:bg-blue-50/30 transition-colors group">
                            <!-- Klient -->
                            <td class="px-8 py-4">
                                <span class="font-bold text-gray-900">{{ $invoice->customer->name ?? 'Brak danych' }}</span>
                            </td>

                            <!-- Produkt -->
                            <td class="px-4 py-4 text-sm text-gray-600">
                                {{ $invoice->product_name }}
                            </td>

                            <!-- Data -->
                            <td class="px-4 py-4 text-sm text-gray-500 font-medium">
                                {{ $invoice->date_sold }}
                            </td>

                            <!-- Cena -->
                            <td class="px-4 py-4 text-right">
                                <span class="font-bold text-gray-900">{{ number_format($invoice->price / 100, 2, ',', ' ') }}</span>
                                <span class="text-[10px] font-bold text-gray-400 ml-1 uppercase">PLN</span>
                            </td>

                            <!-- VAT -->
                            <td class="px-4 py-4 text-center">
                                <span class="px-2 py-1 bg-gray-100 text-gray-600 rounded-md text-[10px] font-bold uppercase tracking-tight">
                                    {{ $invoice->vat }}%
                                </span>
                            </td>

                            <!-- Logo -->
                            <td class="px-4 py-4 text-center">
                                @if($invoice->user->logo_path)
                                <img src="{{ asset('storage/' . $invoice->user->logo_path) }}"
                                    class="h-8 w-8 object-contain mx-auto rounded border bg-white p-1 shadow-sm">
                                @else
                                <i class="fas fa-image text-gray-200"></i>
                                @endif
                            </td>

                            <!-- AKCJE -->
                            <td class="px-8 py-4 text-right">
                                <div class="inline-flex items-center bg-gray-50 border border-gray-200 rounded-xl p-1 shadow-sm group-hover:bg-white transition-all">

                                    <!-- Podgląd -->
                                    <a href="{{ route('pdf.download', $invoice->id) }}?action=stream"
                                        target="_blank" title="Podgląd"
                                        class="p-2 text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-all">
                                        <i class="fas fa-eye text-sm"></i>
                                    </a>

                                    <!-- Edycja -->
                                    <a href="{{ route('pdf.edit', $invoice->id) }}" title="Edytuj"
                                        class="p-2 text-gray-400 hover:text-amber-600 hover:bg-amber-50 rounded-lg transition-all">
                                        <i class="fas fa-edit text-sm"></i>
                                    </a>

                                    <!-- Pobierz -->
                                    <a href="{{ route('pdf.download', $invoice->id) }}?action=download" title="Pobierz PDF"
                                        class="p-2 text-gray-400 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition-all">
                                        <i class="fas fa-download text-sm"></i>
                                    </a>

                                    <!-- Historia -->
                                    <a href="{{ route('pdf.history', $invoice->invoice_uuid) }}" title="Historia wersji"
                                        class="p-2 text-gray-400 hover:text-slate-600 hover:bg-slate-100 rounded-lg transition-all">
                                        <i class="fas fa-history text-sm"></i>
                                    </a>

                                    <!-- Email -->
                                    @php $hasConsent = $invoice->customer->email_consent ?? false; @endphp
                                    <form action="{{ route('pdf.sendEmail', $invoice->id) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit"
                                            title="{{ $hasConsent ? 'Wyślij Fakturę' : 'Brak zgody' }}"
                                            onclick="return confirm('{{ $hasConsent ? 'Wysłać fakturę?' : 'Klient nie wyraził zgody. Kontynuować?' }}')"
                                            class="p-2 rounded-lg transition-all cursor-pointer {{ $hasConsent ? 'text-gray-400 hover:text-teal-600 hover:bg-teal-50' : 'text-amber-500 hover:text-amber-700 hover:bg-amber-50' }}">
                                            <i class="fas {{ $hasConsent ? 'fa-envelope' : 'fa-user-check' }} text-sm"></i>
                                        </button>
                                    </form>

                                    <!-- Usuń -->
                                    <form action="{{ route('pdf.destroy', $invoice->id) }}" method="POST" class="inline">
                                        @csrf @method('DELETE')
                                        <button type="submit" title="Usuń"
                                            onclick="return confirm('Usunąć nieodwracalnie?')"
                                            class="p-2 text-gray-300 hover:text-red-600 hover:bg-red-50 rounded-lg transition-all cursor-pointer">
                                            <i class="fas fa-trash text-sm"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="px-8 py-12 text-center text-gray-400 italic">
                                <div class="flex flex-col items-center gap-2">
                                    <i class="fas fa-inbox text-3xl opacity-20"></i>
                                    <span>Brak wystawionych faktur w systemie.</span>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>

                </table>
            </div>
        </div>
    </div>
</x-layout>