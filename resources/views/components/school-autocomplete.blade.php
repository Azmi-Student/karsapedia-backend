@props([
    'name' => 'school_name',
    'value' => '',
    'label' => 'Asal Sekolah',
    'placeholder' => 'Contoh: SMKN 1 Surabaya',
    'required' => false,
])

@php
    $initialValue = old($name, $value);
@endphp

<div x-data="{
        query: @js($initialValue ?? ''),
        npsn: '',
        suggestions: [],
        isOpen: false,
        isLoading: false,
        hasSearched: false,
        selectedIndex: -1,

        async searchSchools() {
            const term = (this.query || '').trim();
            if (term.length < 2) {
                this.suggestions = [];
                this.isOpen = false;
                this.hasSearched = false;
                return;
            }

            this.isLoading = true;
            this.hasSearched = true;

            try {
                const res = await fetch(`/api/schools?search=${encodeURIComponent(term)}`, {
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });

                if (res.ok) {
                    const json = await res.json();
                    this.suggestions = json.data || [];
                    this.isOpen = true;
                    this.selectedIndex = -1;
                }
            } catch (err) {
                console.error('Gagal memuat rekomendasi sekolah:', err);
            } finally {
                this.isLoading = false;
            }
        },

        selectItem(item) {
            this.query = item.name;
            this.npsn = item.npsn || '';
            this.isOpen = false;
            this.selectedIndex = -1;
        },

        onArrowDown() {
            if (!this.isOpen && this.suggestions.length > 0) {
                this.isOpen = true;
                return;
            }
            if (this.suggestions.length === 0) return;
            this.selectedIndex = (this.selectedIndex + 1) % this.suggestions.length;
        },

        onArrowUp() {
            if (!this.isOpen || this.suggestions.length === 0) return;
            this.selectedIndex = (this.selectedIndex - 1 + this.suggestions.length) % this.suggestions.length;
        },

        onEnter(event) {
            if (this.isOpen && this.selectedIndex >= 0 && this.suggestions[this.selectedIndex]) {
                event.preventDefault();
                this.selectItem(this.suggestions[this.selectedIndex]);
            }
        }
     }"
     @click.outside="isOpen = false"
     {{ $attributes->merge(['class' => 'relative space-y-1.5']) }}>

    @if($label)
        <label for="{{ $name }}" class="block text-xs font-bold text-[#1a1d1f] uppercase tracking-wider">
            {{ $label }}
            @if($required)
                <span class="text-rose-500">*</span>
            @endif
        </label>
    @endif

    <div class="relative">
        <input type="text"
               id="{{ $name }}"
               name="{{ $name }}"
               x-model="query"
               @input.debounce.300ms="npsn = ''; searchSchools()"
               @focus="if(suggestions.length > 0) isOpen = true"
               @keydown.arrow-down="onArrowDown()"
               @keydown.arrow-up="onArrowUp()"
               @keydown.enter="onEnter($event)"
               @keydown.escape="isOpen = false"
               autocomplete="off"
               placeholder="{{ $placeholder }}"
               {{ $required ? 'required' : '' }}
               class="w-full text-xs font-medium rounded-2xl border-slate-200 p-3.5 pr-10 focus:ring-2 focus:ring-slate-900 focus:border-slate-900 shadow-2xs @error($name) border-rose-500 @enderror">

        <!-- Hidden input untuk NPSN jika dipilih dari rekomendasi -->
        <input type="hidden" name="school_npsn" :value="npsn">

        <!-- Indikator Loading Mini -->
        <div x-show="isLoading"
             class="absolute right-3.5 top-1/2 -translate-y-1/2 flex items-center pointer-events-none"
             style="display: none;">
            <svg class="animate-spin h-4 w-4 text-slate-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
            </svg>
        </div>
    </div>

    <!-- Dropdown Rekomendasi Hasil Pencarian -->
    <div x-show="isOpen && (suggestions.length > 0 || (hasSearched && !isLoading))"
         x-transition:enter="transition ease-out duration-100"
         x-transition:enter-start="opacity-0 scale-98 -translate-y-1"
         x-transition:enter-end="opacity-100 scale-100 translate-y-0"
         x-transition:leave="transition ease-in duration-75"
         x-transition:leave-start="opacity-100 scale-100 translate-y-0"
         x-transition:leave-end="opacity-0 scale-98 -translate-y-1"
         class="absolute z-50 left-0 right-0 mt-1.5 bg-white rounded-2xl shadow-xl border border-slate-200/80 overflow-hidden max-h-56 overflow-y-auto"
         style="display: none;">

        <template x-if="suggestions.length > 0">
            <div class="py-1 divide-y divide-slate-100">
                <template x-for="(item, index) in suggestions" :key="(item.npsn || '') + item.name + index">
                    <button type="button"
                            @click="selectItem(item)"
                            :class="{
                                'bg-slate-100 text-slate-900': selectedIndex === index,
                                'text-slate-700 hover:bg-slate-50': selectedIndex !== index
                            }"
                            class="w-full text-left px-4 py-2.5 text-xs flex items-center justify-between transition group">
                        <div class="flex flex-col min-w-0 pr-3">
                            <span class="font-semibold text-slate-800 truncate" x-text="item.school_name || item.name"></span>
                            <span x-show="item.location" class="text-[11px] text-slate-400 truncate mt-0.5" x-text="item.location"></span>
                        </div>
                        <span class="text-[10px] font-semibold text-slate-400 group-hover:text-slate-700 shrink-0">
                            Pilih
                        </span>
                    </button>
                </template>
            </div>
        </template>

        <template x-if="suggestions.length === 0 && hasSearched && !isLoading">
            <div class="p-3.5 text-center">
                <p class="text-xs font-medium text-slate-600">
                    Sekolah tidak ditemukan dalam database.
                </p>
                <p class="text-[11px] text-slate-400 mt-0.5">
                    Nama ini akan disimpan sebagai data sekolah baru saat formulir dikirim.
                </p>
            </div>
        </template>
    </div>

    @error($name)
        <p class="text-[11px] text-rose-500 font-semibold mt-1">{{ $message }}</p>
    @enderror
</div>
