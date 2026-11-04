<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Kelola Jadwal & Tiket Film') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 text-gray-900">
                
                <div class="flex justify-between items-center mb-4">
                    <a href="{{ route('admin.dashboard') }}" class="text-blue-600 hover:underline">&larr; Kembali ke Dashboard</a>
                    <a href="{{ route('admin.tickets.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded text-sm font-bold hover:bg-blue-700">+ Tambah Film Baru</a>
                </div>

                @if(session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                        {{ session('success') }}
                    </div>
                @endif

                <table class="w-full border-collapse border border-gray-300 text-sm">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="border border-gray-300 px-4 py-2">Nama Film</th>
                            <th class="border border-gray-300 px-4 py-2">Harga</th>
                            <th class="border border-gray-300 px-4 py-2">Studio</th>
                            <th class="border border-gray-300 px-4 py-2">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($tickets as $ticket)
                            <tr>
                                <td class="border border-gray-300 px-4 py-2">{{ $ticket->nama_film }}</td>
                                <td class="border border-gray-300 px-4 py-2">Rp {{ number_format($ticket->harga, 0, ',', '.') }}</td>
                                <td class="border border-gray-300 px-4 py-2 text-center">{{ $ticket->studio }}</td>
                                <td class="border border-gray-300 px-4 py-2 text-center whitespace-nowrap">
                                    <a href="{{ route('admin.tickets.edit', $ticket->id) }}" class="text-blue-600 font-bold hover:underline mr-3">Edit</a>
                                    <form action="{{ route('admin.tickets.destroy', $ticket->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus film ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 font-bold hover:underline">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="border border-gray-300 px-4 py-2 text-center text-gray-500">Belum ada data film.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</x-app-layout>
