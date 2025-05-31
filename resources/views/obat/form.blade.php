<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $action === 'store' ? __('Tambah Obat') : __('Edit Obat') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h2 class="font-bold text-xl mb-4">{{ $action === 'store' ? __('Tambah Obat') : __('Edit Obat') }}</h2>
                    <form 
                        action="{{ $action === 'store' ? route('obat.store') : route('obat.update', $data->id ?? '') }}" 
                        method="POST" 
                        class="flex flex-col gap-5"
                    >
                        @csrf
                        @if ($action === 'update')
                            @method('PUT')
                        @endif

                        <div>
                            <x-input-label for="name" :value="__('Nama Obat')" />
                            <x-text-input 
                                id="name" 
                                name="nama_obat" 
                                type="text" 
                                class="mt-1 block w-full" 
                                value="{{ old('nama_obat', $data->nama_obat ?? '') }}" 
                                required 
                            />
                            <x-input-error :messages="$errors->get('nama_obat')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="kemasan" :value="__('Kemasan')" />
                            <x-text-input 
                                id="kemasan" 
                                name="kemasan" 
                                type="text" 
                                class="mt-1 block w-full" 
                                value="{{ old('kemasan', $data->kemasan ?? '') }}" 
                                required 
                            />
                            <x-input-error :messages="$errors->get('kemasan')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="no_hp" :value="__('Harga')" />
                            <x-text-input 
                                id="harga" 
                                name="harga" 
                                type="number" 
                                class="mt-1 block w-full" 
                                value="{{ old('harga', $data->harga ?? '') }}" 
                                required 
                            />
                            <x-input-error :messages="$errors->get('no_hp')" class="mt-2" />
                        </div>

                        <!-- Tombol dan Status -->
                        <div class="flex items-center gap-4">
                            <x-primary-button>
                                {{ $action === 'store' ? __('Save') : __('Update') }}
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
