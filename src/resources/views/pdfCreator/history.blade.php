<x-layout>
    <div class="w-full max-w-5xl mx-auto px-4 py-8 space-y-6">
        
        <!-- Powiadomienia -->
        @if(session('success'))
        <div class="flex items-center gap-3 bg-green-50 border border-green-200 text-green-700 px-6 py-4 rounded-2xl shadow-sm animate-fade-in">
            <i class="fas fa-check-circle text-xl"></i>
            <span class="font-semibold">{{ session('success') }}</span>
        </div>
        @endif

        <!-- Nagłówek -->
        <div class="flex flex-col md:flex-row justify-between items-center gap-4 mb-2">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-2xl flex items-center justify-center text-xl shadow-sm border border-blue-100/50">
                    <i class="fas fa-history"></i>
                </div>
                <div>
                    <h2 class="text-2xl font-extrabold text-gray-900 tracking-tight">Historia zmian</h2>
                    <p class="text-[11px] text-gray-400 font-bold uppercase tracking-widest">Wykaz wszystkich rewizji faktury</p>
                </div>
            </div>
            <a href="/pdf" class="px-6 py-3 bg-white border border-gray-200 text-gray-600 text-sm font-bold rounded-xl hover:bg-gray-50 hover:text-blue-600 transition-all shadow-sm flex items-center gap-2">
                <i class="fas fa-arrow-left text-[10px]"></i> Powrót do panelu
            </a>
        </div>

        <!-- Lista rewizji (Timeline) -->
        <div class="space-y-4">
            @foreach($history as $rev)
            <div class="relative group bg-white p-6 rounded-[24px] shadow-sm hover:shadow-md border border-gray-100 transition-all duration-300 hover:translate-x-1 
                {{ $rev->is_active ? 'border-l-8 border-l-green-500 bg-green-50/20' : 'border-l-8 border-l-gray-300' }}">
                
                <div class="flex flex-col md:flex-row items-center gap-6">
                    
                    <!-- Lewa sekcja: Numer wersji i status -->
                    <div class="flex flex-col items-center justify-center min-w-[100px] border-r border-gray-100 pr-6 hidden md:flex">
                        <div class="w-14 h-14 rounded-full flex items-center justify-center text-lg font-black mb-2
                            {{ $rev->is_active ? 'bg-green-100 text-green-700 shadow-inner' : 'bg-gray-50 text-gray-400 border border-gray-200' }}">
                            v{{ $rev->version }}
                        </div>
                        <span class="text-[10px] font-black uppercase tracking-tighter px-2 py-0.5 rounded {{ $rev->is_active ? 'bg-green-500 text-white' : 'bg-gray-200 text-gray-500' }}">
                            {{ $rev->is_active ? 'Aktywna' : 'Archiwalna' }}
                        </span>
                    </div>

                    <!-- Środkowa sekcja: Szczegóły -->
                    <div class="flex-1 space-y-1 text-center md:text-left">
                        <div class="text-[11px] font-bold text-blue-500 uppercase tracking-widest flex items-center justify-center md:justify-start gap-2">
                            <i class="fas fa-calendar-alt"></i>
                            Edytowano: {{ $rev->updated_at->format('d.m.Y H:i') }}
                        </div>
                        <h4 class="text-xl font-extrabold text-gray-900 tracking-tight">{{ $rev->product_name }}</h4>
                        <div class="flex flex-wrap items-center justify-center md:justify-start gap-x-4 text-sm font-medium">
                            <span class="text-gray-500 flex items-center gap-1">
                                <i class="fas fa-user text-[10px] opacity-40"></i> {{ $rev->customer->name ?? 'Brak danych' }}
                            </span>
                            <span class="text-blue-600 font-bold bg-blue-50 px-2 py-0.5 rounded-lg">
                                {{ number_format($rev->price, 2, ',', ' ') }} PLN
                            </span>
                        </div>
                    </div>

                    <!-- Prawa sekcja: Akcje -->
                    <div class="flex items-center gap-2">
                        <div class="inline-flex bg-gray-50 border border-gray-200 rounded-xl p-1 shadow-sm group-hover:bg-white transition-all">
                            
                            <!-- Podgląd -->
                            <a href="/download-pdf/{{ $rev->id }}?action=stream" target="_blank" title="Podgląd"
                               class="p-3 text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-all">
                                <i class="fas fa-eye text-sm"></i>
                            </a>

                            <!-- Pobierz PDF -->
                            <a href="/download-pdf/{{ $rev->id }}?action=download" title="Pobierz"
                               class="p-3 text-gray-400 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition-all">
                                <i class="fas fa-download text-sm"></i>
                            </a>

                            <!-- Przywróć wersję -->
                            @if(!$rev->is_active)
                            <form action="{{ route('pdf.restore', $rev->id) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" onclick="return confirm('Czy chcesz przywrócić tę wersję?')" title="Przywróć"
                                    class="p-3 text-gray-400 hover:text-amber-600 hover:bg-amber-50 rounded-lg transition-all cursor-pointer">
                                    <i class="fas fa-undo text-sm"></i>
                                </button>
                            </form>
                            @endif
                        </div>
                    </div>

                </div>
            </div>
            @endforeach
        </div>
    </div>
</x-layout>
