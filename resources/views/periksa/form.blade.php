<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $action === 'store' ? __('Tambah Periksa') : __('Edit Periksa') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h2 class="font-bold text-xl mb-4">{{ $action === 'store' ? __('Tambah Periksa') : __('Edit Periksa') }}</h2>
                    <form 
                        action="{{ $action === 'store' ? route('periksa.store') : route('periksa.update', $data->id ?? '') }}" 
                        method="POST" 
                        class="flex flex-col gap-5"
                    >
                        @csrf
                        @if ($action === 'update')
                            @method('PUT')
                        @endif

                        <!-- Input Pasien -->
                        <div>
                            <x-input-label for="id_pasien" :value="__('Pasien')" />
                            <select id="id_pasien" name="id_pasien" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                <option value="">Pilih Pasien</option>
                                @foreach ($pasiens as $pasien)
                                    <option value="{{ $pasien->id }}" 
                                        {{ old('id_pasien', $data->id_pasien ?? '') == $pasien->id ? 'selected' : '' }} >
                                        {{ $pasien->nama }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('id_pasien')" class="mt-2" />
                        </div>

                        <!-- Input Dokter -->
                        <div>
                            <x-input-label for="id_dokter" :value="__('Dokter')" />
                            <select id="id_dokter" name="id_dokter" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                <option value="">Pilih Dokter</option>
                                @foreach ($dokters as $dokter)
                                    <option value="{{ $dokter->id }}" 
                                        {{ old('id_dokter', $data->id_dokter ?? '') == $dokter->id ? 'selected' : '' }} >
                                        {{ $dokter->nama }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('id_dokter')" class="mt-2" />
                        </div>

                        <!-- Input Tanggal Periksa -->
                        <div>
                            <x-input-label for="tgl_periksa" :value="__('Tanggal Periksa')" />
                            <x-text-input 
                                id="tgl_periksa" 
                                name="tgl_periksa" 
                                type="datetime-local" 
                                class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" 
                                value="{{ old('tgl_periksa', $data->tgl_periksa ?? '') }}" 
                                required 
                            />
                            <x-input-error :messages="$errors->get('tgl_periksa')" class="mt-2" />
                        </div>

                        <!-- Input Catatan -->
                        <div>
                            <x-input-label for="catatan" :value="__('Catatan')" />
                            <x-text-input 
                                id="catatan" 
                                name="catatan" 
                                type="text" 
                                class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" 
                                value="{{ old('catatan', $data->catatan ?? '') }}" 
                            />
                            <x-input-error :messages="$errors->get('catatan')" class="mt-2" />
                        </div>

                        <!-- Input Obat -->
                        <div>
                            <x-input-label for="obat" :value="__('Obat')" />
                            <x-text-input 
                                id="obat" 
                                name="obat" 
                                type="text" 
                                class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" 
                                value="{{ old('obat', $data->obat ?? '') }}" 
                            />
                            <x-input-error :messages="$errors->get('obat')" class="mt-2" />
                        </div>

                        <!-- Tombol dan Status -->
                        <div class="flex items-center gap-4">
                            <x-primary-button>
                                {{ $action === 'store' ? __('Simpan') : __('Update') }}
                            </x-primary-button>

                            @if (session('status'))
                                <p
                                    x-data="{ show: true }"
                                    x-show="show"
                                    x-transition
                                    x-init="setTimeout(() => show = false, 2000)"
                                    class="text-sm text-gray-600"
                                >
                                    {{ session('status') }}
                                </p>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
