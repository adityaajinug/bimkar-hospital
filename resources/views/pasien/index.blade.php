<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Pasien') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    @if (session('status'))
                        <div 
                            x-data="{ show: true }" 
                            x-show="show" 
                            x-init="setTimeout(() => show = false, 3000)" 
                            class="{{ session('status') === 'success' ? 'bg-green-500' : 'bg-red-500' }} text-white p-4 rounded-md mb-4 transition-opacity duration-500"
                            x-transition:leave="opacity-100" 
                            x-transition:leave-end="opacity-0"
                        >
                            {{ session('message') }}
                        </div>
                    @endif
                    <div class="flex justify-end">
                        <a href="{{ route('pasien.create') }}" class="inline-block py-2 px-4 text-white bg-blue-700 rounded-lg hover:bg-blue-800 text-base transform transition duration-150 active:scale-90 focus:scale-95 mb-5">Tambah</a>
                    </div>
                    <div class="overflow-hidden rounded-md">
                        <table class="table-auto w-full rounded-md">
                            <thead class="bg-gray-100 text-gray-700">
                                <tr>
                                    <th class="px-4 py-2 text-left">No</th>
                                    <th class="px-4 py-2 text-left">Nama</th>
                                    <th class="px-4 py-2 text-left">Alamat</th>
                                    <th class="px-4 py-2 text-left">No HP</th>
                                    <th class="px-4 py-2 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($data as $index => $pasien)
                                    <tr class="hover:bg-gray-50">
                                        <td class="border-b border-gray-300 px-4 py-3 text-gray-700">{{ $index + 1 }}</td>
                                        <td class="border-b border-gray-300 px-4 py-3 text-gray-700">{{ $pasien->nama }}</td>
                                        <td class="border-b border-gray-300 px-4 py-3 text-gray-700">{{ $pasien->alamat }}</td>
                                        <td class="border-b border-gray-300 px-4 py-3 text-gray-700">{{ $pasien->no_hp }}</td>
                                        <td class="border-b border-gray-300 px-4 py-3 text-center">
                                            <a href="{{ route('pasien.edit', $pasien->id) }}" 
                                               class="inline-block py-1 px-3 text-white bg-green-500 rounded-lg hover:bg-green-600 text-sm transform transition duration-150 active:scale-90 focus:scale-95">
                                               Edit
                                            </a>
                                            <form action="{{ route('pasien.destroy', $pasien->id) }}" method="POST" class="inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="py-1 px-3 text-white bg-red-500 rounded-lg hover:bg-red-600 text-sm transform transition duration-150 active:scale-90 focus:scale-95"
                                                        onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                                    Hapus
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center text-gray-500 py-4">Tidak ada data pasien.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
