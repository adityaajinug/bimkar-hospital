<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Periksa Pasien') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h2 class="text-lg font-medium text-gray-900">
                        {{ __('Periksa Pasien') }}
                    </h2>
                    <p class="mt-1 text-sm text-gray-600">
                        {{ __('Silakan isi form di bawah ini untuk mencatat hasil pemeriksaan pasien dan memilih obat yang diberikan.') }}
                    </p>

                    @php
                        $isUpdate = $action === 'update';
                        $routeName = $isUpdate ? 'memeriksa.update' : 'memeriksa.store';
                        $method = $isUpdate ? 'PUT' : 'POST';
                        $obatTerdipilih =
                            $isUpdate && isset($data->periksa) && $data->periksa->relationLoaded('detailPeriksas')
                                ? $data->periksa->detailPeriksas->pluck('id_obat')->toArray()
                                : [];
                    @endphp

                    <form action="{{ route($routeName, $data->id) }}" method="POST" class="flex flex-col gap-5">
                        @csrf
                        @if ($isUpdate)
                            @method('PUT')
                        @endif

                        <div>
                            <x-input-label for="nama" :value="__('Nama')" />
                            <x-text-input id="nama" name="nama" type="text" class="mt-1 block w-full"
                                value="{{ old('nama', $data->pasien->nama ?? '') }}" required readonly />
                            <x-input-error :messages="$errors->get('nama')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="tgl_periksa" :value="__('Tanggal Periksa')" />
                            <x-text-input id="tgl_periksa" name="tgl_periksa" type="datetime-local"
                                class="mt-1 block w-full"
                                value="{{ old('tgl_periksa', isset($data->periksa) ? \Carbon\Carbon::parse($data->periksa->tgl_periksa)->format('Y-m-d\TH:i') : '') }}"
                                required />
                            <x-input-error :messages="$errors->get('tgl_periksa')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="catatan" :value="__('Catatan')" />
                            <x-textarea-input id="catatan" name="catatan" class="mt-1 block w-full" rows="4"
                                placeholder="Catatan Pemeriksaan" :readonly="false">
                                {{ old('catatan', $data->periksa->catatan ?? '') }}
                            </x-textarea-input>
                            <x-input-error :messages="$errors->get('catatan')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="obat" :value="__('Obat')" />
                            <x-select-input id="obat" name="obat[]" class="mt-1 block w-full" :disabled="false"
                                :readonly="false" multiple onchange="hitungBiaya()">
                                <option value="">-- Pilih --</option>
                                @foreach ($obats as $obat)
                                    <option value="{{ $obat->id }}" data-harga="{{ $obat->harga }}"
                                        {{ in_array($obat->id, $obatTerdipilih) ? 'selected' : '' }}>
                                        {{ $obat->nama_obat }} - {{ $obat->kemasan }}
                                        (Rp {{ number_format($obat->harga, 0, ',', '.') }})
                                    </option>
                                @endforeach
                            </x-select-input>
                            <x-input-error :messages="$errors->get('obat')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="biaya_periksa" :value="__('Biaya Periksa')" />
                            <x-text-input id="biaya_periksa" name="biaya_periksa" type="text"
                                value="{{ old('biaya_periksa', $data->periksa->biaya_periksa ?? '') }}"
                                class="mt-1 block w-full" required readonly />
                            <x-input-error :messages="$errors->get('biaya_periksa')" class="mt-2" />
                        </div>

                        <div>
                            <div class="flex items-center gap-4">
                                <x-primary-button>
                                    {{ __('Submit') }}
                                </x-primary-button>

                                @if (session('status'))
                                    <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                                        class="text-sm text-gray-600">
                                        {{ session('status') }}
                                    </p>
                                @endif
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
<script>
    function hitungBiaya() {
        const baseBiaya = 150000;
        let totalBiaya = baseBiaya;
        const select =
            document.getElementById('obat');
        const selectedOptions = Array.from(select.selectedOptions);
        selectedOptions.forEach(option => {
            const harga =
                parseInt(option.getAttribute('data-harga')) || 0;
            totalBiaya += harga;
        });

        document.getElementById('biaya_periksa').value = totalBiaya;
    }
</script>
