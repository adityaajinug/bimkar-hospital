<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Jadwal Periksa') }}
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
                        <button type="button" onclick="my_modal_3.showModal()" class="inline-block py-2 px-4 text-white bg-blue-700 rounded-lg hover:bg-blue-800 text-base transform transition duration-150 active:scale-90 focus:scale-95 mb-5">Tambah</button>
                    </div>
                    <div class="overflow-hidden rounded-md">
                        <table class="table-auto w-full rounded-md">
                            <thead class="bg-gray-100 text-gray-700">
                                <tr>
                                    <th class="px-4 py-2 text-left">No</th> 
                                    <th class="px-4 py-2 text-left">Hari</th> 
                                    <th class="px-4 py-2 text-left">Mulai</th> 
                                    <th class="px-4 py-2 text-left">Selesai</th> 
                                    <th class="px-4 py-2 text-left">Status</th> 
                                    <th class="px-4 py-2 text-right">Aksi</th> 
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($data as $index => $row)
                                    <tr class="hover:bg-gray-50">
                                        <td class="border-b border-gray-300 px-4 py-3 text-gray-700">{{ $index + 1 }}</td>
                                        <td class="border-b border-gray-300 px-4 py-3 text-gray-700">{{ $row->hari }}</td>
                                        <td class="border-b border-gray-300 px-4 py-3 text-gray-700">{{ \Carbon\Carbon::parse($row->jam_mulai)->format('H.i') }} </td>
                                        <td class="border-b border-gray-300 px-4 py-3 text-gray-700"> {{ \Carbon\Carbon::parse($row->jam_selesai)->format('H.i') }} </td>
                                        <td class="border-b border-gray-300 px-4 py-3">
                                            @if($row->status)
                                                <span class="text-white px-2 py-1 bg-green-500 rounded-md">Aktif</span>
                                            @else
                                                <span class="text-white px-2 py-1 bg-red-500 rounded-md">Tidak Aktif</span>
                                            @endif
                                        </td>
                                        <td class="border-b border-gray-300 px-4 py-3 text-right">
                                            <form action="{{ route('jadwal-periksa.update', $row->id) }}" method="POST" class="inline-block">
                                                @csrf
                                                @method('PATCH')
                                                
                                                @if(!$row->status)
                                                <button type="submit" 
                                                        class="py-1 px-3 text-white bg-green-500 rounded-lg hover:bg-green-600 text-sm transform transition duration-150 active:scale-90 focus:scale-95"
                                                        onclick="return confirm('Apakah Anda yakin ingin mengubah jadi aktif?')">
                                                    Aktif
                                                </button>
                                                @else
                                                <button type="submit" 
                                                        class="py-1 px-3 text-white bg-red-500 rounded-lg hover:bg-red-600 text-sm transform transition duration-150 active:scale-90 focus:scale-95"
                                                        onclick="return confirm('Apakah Anda yakin ingin mengubah jadi tidak aktif?')">
                                                    Non Aktif
                                                </button>
                                                @endif
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center text-gray-500 py-4">Tidak ada data Jadwal.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <dialog id="my_modal_3" class="modal">
        <div class="modal-box">
            <form id="formJadwal" action="{{ route('jadwal-periksa.store') }}" method="POST">
            @csrf

            <button type="button" class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2" onclick="my_modal_3.close()">✕</button>

            <h3 class="font-bold text-lg mb-4">Tambah Jadwal</h3>

            <div class="mb-4">
                <label class="label" for="hariSelect">
                <span class="label-text">Hari</span>
                </label>
                <select class="select select-bordered w-full" name="hari" id="hariSelect" required>
                <option value="">Pilih Hari</option>
                <option value="Senin">Senin</option>
                <option value="Selasa">Selasa</option>
                <option value="Rabu">Rabu</option>
                <option value="Kamis">Kamis</option>
                <option value="Jumat">Jumat</option>
                <option value="Sabtu">Sabtu</option>
                <option value="Minggu">Minggu</option>
                </select>
            </div>

            <div class="mb-4">
                <label class="label" for="jamMulai">
                <span class="label-text">Jam Mulai</span>
                </label>
                <input type="time" class="input input-bordered w-full" id="jamMulai" name="jam_mulai" required>
            </div>

            <div class="mb-4">
                <label class="label" for="jamSelesai">
                <span class="label-text">Jam Selesai</span>
                </label>
                <input type="time" class="input input-bordered w-full" id="jamSelesai" name="jam_selesai" required>
            </div>

            <div class="modal-action">
                <button type="submit" class="py-2 px-4 text-white bg-blue-700 rounded-lg hover:bg-blue-800">Simpan</button>
            </div>
            </form>
        </div>
    </dialog>

</x-app-layout>
