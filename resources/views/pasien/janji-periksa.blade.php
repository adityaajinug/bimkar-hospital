<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Janji Periksa') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h2 class="text-lg font-medium text-gray-900">
                        {{ __('Buat Janji Periksa') }}
                    </h2>
                    <p class="mt-1 text-sm text-gray-600">
                        {{ __('Atur jadwal pertemuan dengan dokter untuk mendapatkan layanan konsultasi dan pemeriksaan kesehatan sesuai kebutuhan Anda.') }}
                    </p>

                    <form class="mt-6 flex flex-col gap-5" action="{{ route('janji-periksa.store') }}" method="POST">
                        @csrf
                        <div>
                            <x-input-label for="name" :value="__('Nomor Rekam Medis')" />
                            <x-text-input id="name" name="no_rm" type="text" class="mt-1 block w-full"
                                value="{{ old('no_rm', $no_rm ?? '') }}" required readonly />
                            <x-input-error :messages="$errors->get('no_rm')" class="mt-2" />
                        </div>
                        <div>
                            <x-input-label for="name" :value="__('Dokter')" />
                            <x-select-input id="id_dokter" name="id_dokter" class="mt-1 block w-full" :disabled="false"
                                :readonly="false">
                                <option value="">-- Pilih --</option>
                                @foreach ($dokters as $dokter)
                                    @foreach ($dokter->jadwalPeriksas as $jadwal)
                                        <option value="{{ $dokter->id }}">
                                            {{ $dokter->nama }} - Spesialis {{ $dokter->poli }} |
                                            {{ $jadwal->hari }},
                                            {{ \Carbon\Carbon::parse($jadwal->jam_mulai)->format('H.i') }} -
                                            {{ \Carbon\Carbon::parse($jadwal->jam_selesai)->format('H.i') }}
                                        </option>
                                    @endforeach
                                @endforeach
                            </x-select-input>
                            <x-input-error :messages="$errors->get('no_rm')" class="mt-2" />
                        </div>
                        <div>
                            <x-input-label for="keluhan" :value="__('Keluhan')" />

                            <x-textarea-input id="keluhan" name="keluhan" class="mt-1 block w-full" rows="4"
                                :readonly="false" {{-- atau false --}}>
                                {{ old('keluhan', $keluhan ?? '') }}
                            </x-textarea-input>

                            <x-input-error :messages="$errors->get('keluhan')" class="mt-2" />

                        </div>

                        <div>
                            <!-- Tombol dan Status -->
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
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    @if (session('status'))
                        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)"
                            class="{{ session('status') === 'success' ? 'bg-green-500' : 'bg-red-500' }} text-white p-4 rounded-md mb-4 transition-opacity duration-500"
                            x-transition:leave="opacity-100" x-transition:leave-end="opacity-0">
                            {{ session('message') }}
                        </div>
                    @endif
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
                                        <td class="border-b border-gray-300 px-4 py-3 text-gray-700">
                                            {{ $index + 1 }}
                                        </td>
                                        <td class="border-b border-gray-300 px-4 py-3 text-gray-700">
                                            {{ $row->jadwalPeriksa->dokter->poli }}</td>
                                        <td class="border-b border-gray-300 px-4 py-3 text-gray-700">
                                            {{ $row->jadwalPeriksa->dokter->nama }}</td>
                                        <td class="border-b border-gray-300 px-4 py-3 text-gray-700">
                                            {{ $row->jadwalPeriksa->hari }}</td>
                                        <td class="border-b border-gray-300 px-4 py-3 text-gray-700">
                                            {{ \Carbon\Carbon::parse($row->jadwalPeriksa->jam_mulai)->format('H.i') }}
                                        </td>
                                        <td class="border-b border-gray-300 px-4 py-3 text-gray-700">
                                            {{ \Carbon\Carbon::parse($row->jadwalPeriksa->jam_selesai)->format('H.i') }}
                                        </td>
                                        <td class="border-b border-gray-300 px-4 py-3 text-gray-700">
                                            {{ $row->no_antrian }}</td>
                                        <td class="border-b border-gray-300 px-4 py-3">
                                            @if ($row->no_antrian)
                                                <span class="text-white px-2 py-1 bg-green-500 rounded-md">Aktif</span>
                                            @else
                                                <span class="text-white px-2 py-1 bg-red-500 rounded-md">Tidak
                                                    Aktif</span>
                                            @endif
                                        </td>
                                        <td class="border-b border-gray-300 px-4 py-3 text-center">
                                            @php
                                                $modalId = 'modal-' . $row->id;
                                            @endphp

                                            <button type="button"
                                                onclick="document.getElementById('{{ $modalId }}').showModal()"
                                                class="py-2 px-4 text-white bg-blue-700 rounded-lg hover:bg-blue-800 text-base transition active:scale-90 focus:scale-95 mb-2">
                                                {{ is_null($row->periksa) ? 'Detail' : 'Riwayat' }}
                                            </button>

                                            <dialog id="{{ $modalId }}" class="modal rounded-md">
                                                <div
                                                    class="modal-box w-full max-w-lg bg-white p-6 rounded-lg shadow-lg">
                                                    <div class="flex justify-between items-center mb-4">
                                                        <h2 class="text-lg font-semibold">
                                                            {{ is_null($row->periksa) ? 'Detail Janji Periksa' : 'Riwayat Pemeriksaan ' . $row->jadwalPeriksa->dokter->poli }}
                                                        </h2>
                                                        <form method="dialog">
                                                            <button
                                                                class="text-gray-500 hover:text-gray-800 text-2xl leading-none">&times;</button>
                                                        </form>
                                                    </div>

                                                    @if (is_null($row->periksa))
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
                                                                class="inline-block bg-blue-600 text-white text-xl px-4 py-2 rounded-full">
                                                                {{ $row->no_antrian }}
                                                            </span>
                                                        </div>
                                                    @else
                                                        <ul class="space-y-2 text-sm text-gray-700 mb-4">
                                                            <li><strong>Tanggal Periksa:</strong>
                                                                {{ \Carbon\Carbon::parse($row->periksa->tgl_periksa)->translatedFormat('d F Y H.i') }}
                                                            </li>
                                                            <li><strong>Catatan:</strong> {{ $row->periksa->catatan }}
                                                            </li>
                                                        </ul>

                                                        <h3 class="text-sm font-semibold mb-2">Daftar Obat Diresepkan:
                                                        </h3>
                                                        <ul
                                                            class="space-y-1 mb-4 list-disc list-inside text-sm text-gray-700">
                                                            @foreach ($row->periksa->detailPeriksa as $detailPeriksa)
                                                                <li>{{ $detailPeriksa->obat->nama_obat }}
                                                                    {{ $detailPeriksa->obat->kemasan }}</li>
                                                            @endforeach
                                                        </ul>

                                                        <div class="p-3 bg-blue-50 text-blue-700 rounded-md text-sm">
                                                            <strong>Biaya Periksa:</strong>
                                                            {{ 'Rp' . number_format($row->periksa->biaya_periksa, 0, ',', '.') }}
                                                        </div>
                                                    @endif
                                                </div>
                                            </dialog>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center text-gray-500 py-4">Tidak ada data janji
                                            periksa.</td>
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
