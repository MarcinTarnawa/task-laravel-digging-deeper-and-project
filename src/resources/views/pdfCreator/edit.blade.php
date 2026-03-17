<x-layout>
    <div class="w-full max-w-4xl mx-auto px-4 py-8">
        
        <!-- Powiadomienia o błędach -->
        @if($errors->any())
            <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-6 py-4 rounded-2xl shadow-sm">
                <ul class="list-disc list-inside font-medium text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="bg-white rounded-[24px] shadow-2xl overflow-hidden border border-gray-100">
            <!-- Header (Amber/Warning) -->
            <div class="bg-amber-500 px-8 py-6 flex items-center gap-3">
                <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center text-white">
                    <i class="fas fa-edit"></i>
                </div>
                <h2 class="text-xl font-bold text-white tracking-tight">Edycja faktury nr {{ $invoice->id }}</h2>
            </div>

            <div class="p-8 md:p-10">
                <form action="/update/{{ $invoice->id }}" method="post" class="space-y-8">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        
                        <!-- Kontrahent -->
                        <div class="md:col-span-2 space-y-2">
                            <label class="block text-[11px] font-bold text-gray-400 uppercase tracking-widest ml-1">Kontrahent</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-gray-400 pointer-events-none">
                                    <i class="fas fa-users text-xs"></i>
                                </span>
                                <select name="customer_id" required 
                                    class="block w-full pl-10 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-700 font-medium focus:ring-2 focus:ring-amber-500 transition-all outline-none appearance-none cursor-pointer">
                                    @foreach($customers as $customer)
                                        <option value="{{ $customer->id }}" {{ $invoice->customer_id == $customer->id ? 'selected' : '' }}>
                                            {{ $customer->name }} {{ $customer->lastName }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- Nazwa produktu -->
                        <div class="md:col-span-2 space-y-2">
                            <label class="block text-[11px] font-bold text-gray-400 uppercase tracking-widest ml-1">Nazwa usługi / produktu</label>
                            <input type="text" name="product_name" value="{{ $invoice->product_name }}" required
                                class="block w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-amber-500 transition-all outline-none text-gray-700 font-medium">
                        </div>

                        <!-- Cena Netto -->
                        <div class="space-y-2">
                            <label class="block text-[11px] font-bold text-gray-400 uppercase tracking-widest ml-1">Cena Netto</label>
                            <div class="relative">
                                <input type="number" name="price" id="netto_input" step="0.01" value="{{ number_format($invoice->price / 100, 2, '.', '') }}" required
                                    class="block w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-amber-500 transition-all outline-none text-gray-700 font-bold">
                                <span class="absolute right-4 top-1/2 -translate-y-1/2 text-[10px] font-bold text-gray-400">PLN</span>
                            </div>
                        </div>

                        <!-- VAT -->
                        <div class="space-y-2">
                            <label class="block text-[11px] font-bold text-gray-400 uppercase tracking-widest ml-1">Stawka VAT</label>
                            <select name="vat" id="vat_select" 
                                class="block w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-amber-500 transition-all outline-none appearance-none cursor-pointer text-gray-700 font-medium">
                                <option value="23" {{ $invoice->vat == 23 ? 'selected' : '' }}>23%</option>
                                <option value="8" {{ $invoice->vat == 8 ? 'selected' : '' }}>8%</option>
                                <option value="5" {{ $invoice->vat == 5 ? 'selected' : '' }}>5%</option>
                                <option value="0" {{ $invoice->vat == 0 ? 'selected' : '' }}>0% (zw.)</option>
                            </select>
                        </div>

                        <!-- Brutto (Wyświetlanie) -->
                        <div class="md:col-span-2 p-6 bg-amber-50 border border-amber-100 rounded-2xl flex justify-between items-center shadow-inner">
                            <div>
                                <p class="text-[10px] font-bold text-amber-600 uppercase tracking-widest">Szacowana wartość Brutto</p>
                                <p class="text-3xl font-black text-amber-700 leading-tight">
                                    <span id="brutto_display">0.00</span> <span class="text-lg">PLN</span>
                                </p>
                            </div>
                            <div class="text-amber-200 text-4xl">
                                <i class="fas fa-calculator"></i>
                            </div>
                        </div>

                        <!-- Daty -->
                        <div class="space-y-2">
                            <label class="block text-[11px] font-bold text-gray-400 uppercase tracking-widest ml-1">Data sprzedaży</label>
                            <input type="date" name="date_sold" value="{{ $invoice->date_sold }}" required
                                class="block w-full px-4 py-3 bg-white border border-gray-200 rounded-xl focus:ring-2 focus:ring-amber-500 outline-none transition-all">
                        </div>
                        <div class="space-y-2">
                            <label class="block text-[11px] font-bold text-gray-400 uppercase tracking-widest ml-1">Data wystawienia</label>
                            <input type="date" name="date_delivered" value="{{ $invoice->date_delivered }}" required
                                class="block w-full px-4 py-3 bg-white border border-gray-200 rounded-xl focus:ring-2 focus:ring-amber-500 outline-none transition-all">
                        </div>
                    </div>

                    <!-- Przyciski -->
                    <div class="flex items-center gap-4 pt-6">
                        <button type="submit" class="flex-1 py-4 bg-amber-500 hover:bg-amber-600 text-white font-bold rounded-2xl shadow-lg shadow-amber-500/20 transition-all active:scale-95 flex items-center justify-center gap-2 cursor-pointer">
                            <i class="fas fa-save"></i> Zatwierdź zmiany
                        </button>
                        <a href="/pdf" class="flex-1 py-4 bg-gray-100 hover:bg-gray-200 text-gray-600 font-bold rounded-2xl transition-all text-center">
                            Anuluj
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const nettoInput = document.getElementById('netto_input');
            const vatSelect = document.getElementById('vat_select');
            const bruttoDisplay = document.getElementById('brutto_display');

            function calculateBrutto() {
                const netto = parseFloat(nettoInput.value) || 0;
                const vat = parseFloat(vatSelect.value) || 0;
                const brutto = netto * (1 + (vat / 100));
                
                bruttoDisplay.innerText = brutto.toLocaleString('pl-PL', { 
                    minimumFractionDigits: 2, 
                    maximumFractionDigits: 2 
                });
            }

            nettoInput.addEventListener('input', calculateBrutto);
            vatSelect.addEventListener('change', calculateBrutto);
            calculateBrutto();
        });
    </script>
</x-layout>
