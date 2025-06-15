<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Riwayat Periksa Pasien') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="overflow-hidden rounded-md">
                        <table class="table-auto w-full rounded-md">
                            <thead class="bg-gray-100 text-gray-700">
                                <tr>
                                    <th class="px-4 py-2 text-left">No</th>
                                    <th class="px-4 py-2 text-left">Poliklinik</th>
                                    <th class="px-4 py-2 text-left">Dokter</th>
                                    <th class="px-4 py-2 text-left">Hari</th>
                                    <th class="px-4 py-2 text-left">Mulai</th>
                                    <th class="px-4 py-2 text-left">Selesai</th>
                                    <th class="px-4 py-2 text-left">Antrian</th>
                                    <th class="px-4 py-2 text-left">Status</th>
                                    <th class="px-4 py-2 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($data as $index => $row)
                                    <tr class="hover:bg-gray-50">
                                        <td class="border-b border-gray-300 px-4 py-3 text-gray-700">{{ $index + 1 }}
                                        </td>
                                        <td class="border-b border-gray-300 px-4 py-3 text-gray-700">
                                            {{ $row->jadwalPeriksa->dokter->poli }}</td>
                                        <td class="border-b border-gray-300 px-4 py-3 text-gray-700">
                                            {{ $row->jadwalPeriksa->dokter->nama }}</td>
                                        <td class="border-b border-gray-300 px-4 py-3 text-gray-700">
                                            {{ $row->jadwalPeriksa->dokter->hari }}</td>
                                        <td class="border-b border-gray-300 px-4 py-3 text-gray-700">
                                            {{ \Carbon\Carbon::parse($row->jadwalPeriksa->jam_mulai)->format('H.i') }}
                                        </td>
                                        <td class="border-b border-gray-300 px-4 py-3 text-gray-700">
                                            {{ \Carbon\Carbon::parse($row->jadwalPeriksa->jam_selesai)->format('H.i') }}
                                        </td>
                                        <td class="border-b border-gray-300 px-4 py-3 text-gray-700">
                                            {{ $row->no_antrian }}</td>
                                        <td class="border-b border-gray-300 px-4 py-3">
                                            @if ($row->periksa)
                                                <span class="text-white px-2 py-1 bg-green-500 rounded-md">Sudah
                                                    Diperiksa</span>
                                            @else
                                                <span class="text-white px-2 py-1 bg-red-500 rounded-md">Belum
                                                    Diperiksa</span>
                                            @endif
                                        </td>
                                        <td class="border-b border-gray-300 px-4 py-3 text-center">
                                            @php
                                                $modalId = 'modal-' . $row->id;
                                            @endphp

                                            <button type="button"
                                                onclick="document.getElementById('{{ $modalId }}').showModal()"
                                                class="inline-block py-2 px-4 text-white bg-blue-700 rounded-lg hover:bg-blue-800 text-base transition active:scale-90 focus:scale-95 mb-2">
                                                Detail
                                            </button>

                                            <dialog id="{{ $modalId }}" class="modal rounded-md">
                                                <div
                                                    class="modal-box w-full max-w-lg bg-white p-6 rounded-lg shadow-lg">
                                                    <div class="flex justify-between items-start mb-4">
                                                        <h2 class="text-lg font-semibold">
                                                            Detail Riwayat Pemeriksaan
                                                        </h2>
                                                        <form method="dialog">
                                                            <button
                                                                class="text-gray-500 hover:text-gray-800 text-2xl leading-none">&times;</button>
                                                        </form>
                                                    </div>


                                                    <ul class="space-y-2 text-sm text-gray-700">
                                                        <li><strong>Poliklinik:</strong>
                                                            {{ $row->jadwalPeriksa->dokter->poli }}</li>
                                                        <li><strong>Nama Dokter:</strong>
                                                            {{ $row->jadwalPeriksa->dokter->nama }}</li>
                                                        <li><strong>Hari Pemeriksaan:</strong>
                                                            {{ $row->jadwalPeriksa->hari }}</li>
                                                        <li><strong>Jam Mulai:</strong>
                                                            {{ \Carbon\Carbon::parse($row->jadwalPeriksa->jam_mulai)->format('H.i') }}
                                                        </li>
                                                        <li><strong>Jam Selesai:</strong>
                                                            {{ \Carbon\Carbon::parse($row->jadwalPeriksa->jam_selesai)->format('H.i') }}
                                                        </li>
                                                    </ul>
                                                    <div class="mt-4 text-center">
                                                        <div class="text-base font-semibold mb-1">Nomor Antrian Anda
                                                        </div>
                                                        <span
                                                            class="inline-block bg-blue-600 text-white text-xl px-4 py-2 rounded-lg">
                                                            {{ $row->no_antrian }}
                                                        </span>
                                                    </div>
                                                    @if ($row->periksa)
                                                        <div class="join mt-2 join-vertical bg-base-100 w-full">
                                                            <div
                                                                class="collapse collapse-arrow join-item border-base-300 border">
                                                                <input type="checkbox" name="my-accordion-4" />
                                                                <div class="collapse-title font-semibold text-left">
                                                                    Riwayat Pemeriksaan
                                                                </div>
                                                                <div class="collapse-content text-sm text-left">
                                                                    <ul class="space-y-2 text-sm text-gray-700 mb-4">
                                                                        <li><strong>Tanggal Periksa:</strong>
                                                                            {{ \Carbon\Carbon::parse($row->periksa->tgl_periksa)->translatedFormat('d F Y H.i') }}
                                                                        </li>
                                                                        <li><strong>Catatan:</strong>
                                                                            {{ $row->periksa->catatan }}
                                                                        </li>
                                                                    </ul>

                                                                    <h3 class="text-sm font-semibold mb-2">Daftar Obat
                                                                        Diresepkan:
                                                                    </h3>
                                                                    <ul
                                                                        class="space-y-1 mb-4 list-disc list-inside text-sm text-gray-700">
                                                                        @foreach ($row->periksa->detailPeriksas as $item)
                                                                            <li>{{ $item->obat->nama_obat }}
                                                                                {{ $item->obat->kemasan }}
                                                                            </li>
                                                                        @endforeach
                                                                    </ul>


                                                                    <div
                                                                        class="p-3 bg-blue-50 text-blue-700 rounded-md text-sm">
                                                                        <strong>Biaya Periksa:</strong>
                                                                        {{ 'Rp' . number_format($row->periksa->biaya_periksa, 0, ',', '.') }}
                                                                    </div>

                                                                </div>
                                                            </div>

                                                        </div>
                                                    @endif




                                                  

                                                </div>
                                            </dialog>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center text-gray-500 py-4">Tidak ada data riwayat
                                            periksa pasien.</td>
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
