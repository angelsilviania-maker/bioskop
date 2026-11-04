<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Katalog Film & Pemesanan Tiket') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-10">
            
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
                    <span class="block sm:inline font-medium">{{ session('success') }}</span>
                </div>
            @endif

            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- KATALOG FILM -->
            <div>
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-xl font-bold text-gray-900">Jadwal Film Sedang Tayang</h3>
                    <span class="text-sm text-gray-500">Pilih film untuk memesan tiket</span>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @forelse($tickets as $ticket)
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg flex flex-col justify-between hover:shadow-md transition border border-gray-100">
                            <div class="p-6">
                                <div class="flex items-center justify-between mb-3">
                                    <span class="text-xs font-semibold inline-block py-1 px-2.5 uppercase rounded-full text-indigo-700 bg-indigo-100">
                                        {{ $ticket->studio }}
                                    </span>
                                    <span class="text-xs text-gray-400">Tersedia</span>
                                </div>
                                <h4 class="font-bold text-lg text-gray-900 mt-1">{{ $ticket->nama_film }}</h4>
                                <p class="text-indigo-600 text-xl mt-2 font-bold">
                                    Rp {{ number_format($ticket->harga, 0, ',', '.') }}
                                </p>
                            </div>

                            <div class="p-6 pt-0">
                                <a href="{{ route('tickets.show', $ticket->id) }}" class="inline-block w-full text-center bg-gray-900 text-white font-semibold py-2.5 px-4 rounded-lg hover:bg-gray-800 transition shadow-sm">
                                    Pesan Tiket Sekarang &rarr;
                                </a>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-3 bg-white overflow-hidden shadow-sm sm:rounded-lg p-10 text-center text-gray-500">
                            <p class="text-base font-medium">Saat ini belum ada jadwal film yang tersedia.</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- RIWAYAT PEMESANAN TIKET SAYA -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="flex items-center justify-between mb-4 border-b border-gray-200 pb-4">
                    <div>
                        <h3 class="text-lg font-bold text-gray-900">Riwayat Pemesanan Tiket Saya</h3>
                        <p class="text-sm text-gray-500">Daftar transaksi dan tiket yang sudah Anda pesan</p>
                    </div>
                    <span class="text-sm bg-gray-100 text-gray-700 font-semibold px-3 py-1 rounded-full">
                        Total Pesanan: {{ $myOrders->count() }}
                    </span>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full border-collapse border border-gray-200 text-sm">
                        <thead>
                            <tr class="bg-gray-50 text-gray-700">
                                <th class="border border-gray-200 px-4 py-3 text-center">ID Order</th>
                                <th class="border border-gray-200 px-4 py-3 text-left">Judul Film & Studio</th>
                                <th class="border border-gray-200 px-4 py-3 text-center">Jumlah Tiket</th>
                                <th class="border border-gray-200 px-4 py-3 text-right">Total Harga</th>
                                <th class="border border-gray-200 px-4 py-3 text-center">Tanggal Pemesanan</th>
                                <th class="border border-gray-200 px-4 py-3 text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse($myOrders as $order)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="border border-gray-200 px-4 py-3 text-center font-mono font-semibold text-gray-600">
                                        #{{ $order->id }}
                                    </td>
                                    <td class="border border-gray-200 px-4 py-3">
                                        @foreach($order->orderDetails as $detail)
                                            <div class="font-medium text-gray-900">{{ $detail->ticket->nama_film ?? 'Film tidak tersedia' }}</div>
                                            <div class="text-xs text-gray-500">{{ $detail->ticket->studio ?? '-' }}</div>
                                        @endforeach
                                    </td>
                                    <td class="border border-gray-200 px-4 py-3 text-center font-semibold">
                                        @foreach($order->orderDetails as $detail)
                                            {{ $detail->jumlah_tiket }} tiket
                                        @endforeach
                                    </td>
                                    <td class="border border-gray-200 px-4 py-3 text-right font-bold text-gray-900">
                                        Rp {{ number_format($order->total_harga, 0, ',', '.') }}
                                    </td>
                                    <td class="border border-gray-200 px-4 py-3 text-center text-gray-500">
                                        {{ $order->created_at->format('d-m-Y H:i') }}
                                    </td>
                                    <td class="border border-gray-200 px-4 py-3 text-center">
                                        <span class="inline-block px-2.5 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                            {{ ucfirst($order->status ?? 'success') }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="border border-gray-200 px-4 py-8 text-center text-gray-500">
                                        Anda belum pernah memesan tiket. Silakan pilih film di atas untuk memesan tiket!
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
