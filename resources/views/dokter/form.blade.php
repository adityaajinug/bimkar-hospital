<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $action === 'store' ? __('Tambah Dokter') : __('Edit Dokter') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h2 class="font-bold text-xl mb-4">{{ $action === 'store' ? __('Tambah Dokter') : __('Edit Dokter') }}</h2>
                    <form 
                        action="{{ $action === 'store' ? route('dokter.store') : route('dokter.update', $data->id ?? '') }}" 
                        method="POST" 
                        class="flex flex-col gap-5"
                    >
                        @csrf
                        @if ($action === 'update')
                            @method('PUT')
                        @endif

                        <!-- Input Nama -->
                        <div>
                            <x-input-label for="name" :value="__('Nama')" />
                            <x-text-input 
                                id="name" 
                                name="nama" 
                                type="text" 
                                class="mt-1 block w-full" 
                                value="{{ old('nama', $data->nama ?? '') }}" 
                                required 
                            />
                            <x-input-error :messages="$errors->get('nama')" class="mt-2" />
                        </div>

                        <!-- Input Alamat -->
                        <div>
                            <x-input-label for="alamat" :value="__('Alamat')" />
                            <x-text-input 
                                id="alamat" 
                                name="alamat" 
                                type="text" 
                                class="mt-1 block w-full" 
                                value="{{ old('alamat', $data->alamat ?? '') }}" 
                                required 
                            />
                            <x-input-error :messages="$errors->get('alamat')" class="mt-2" />
                        </div>

                        <!-- Input No HP -->
                        <div>
                            <x-input-label for="no_hp" :value="__('No HP')" />
                            <x-text-input 
                                id="no_hp" 
                                name="no_hp" 
                                type="text" 
                                class="mt-1 block w-full" 
                                value="{{ old('no_hp', $data->no_hp ?? '') }}" 
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
