<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Admin - Bioskop') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 text-gray-900">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
                    <div>
                        <h3 class="text-xl font-bold">Laporan & Daftar Transaksi Penonton</h3>
                        <p class="text-sm text-gray-500">Pantau seluruh pemesanan tiket dan pendapatan bioskop</p>
                    </div>
                    
                    <a href="{{ route('admin.tickets.index') }}" class="inline-flex items-center bg-green-600 text-white px-4 py-2 rounded-lg text-sm font-bold hover:bg-green-700 transition">
                        Kelola Jadwal / Tiket Film &rarr;
                    </a>
                </div>

                <!-- FILTER PERIODE LAPORAN -->
                <div class="bg-gray-50 p-4 rounded-lg border border-gray-200 mb-6">
                    <form method="GET" action="{{ route('admin.dashboard') }}" class="flex flex-col md:flex-row md:items-end gap-4">
                        <div class="flex-1">
                            <label for="start_date" class="block text-xs font-semibold text-gray-700 mb-1">Dari Tanggal</label>
                            <input 
                                type="date" 
                                name="start_date" 
                                id="start_date" 
                                value="{{ request('start_date') }}" 
                                class="w-full text-sm rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            >
                        </div>
                        <div class="flex-1">
                            <label for="end_date" class="block text-xs font-semibold text-gray-700 mb-1">Sampai Tanggal</label>
                            <input 
                                type="date" 
                                name="end_date" 
                                id="end_date" 
                                value="{{ request('end_date') }}" 
                                class="w-full text-sm rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            >
                        </div>
                        <div class="flex items-center gap-2">
                            <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-md text-sm font-semibold hover:bg-indigo-700 transition">
                                Filter Periode
                            </button>
                            @if(request('start_date') || request('end_date'))
                                <a href="{{ route('admin.dashboard') }}" class="bg-gray-200 text-gray-700 px-4 py-2 rounded-md text-sm font-semibold hover:bg-gray-300 transition">
                                    Reset
                                </a>
                            @endif
                        </div>
                    </form>
                </div>

                <div class="mb-4 flex items-center justify-between">
                    <span class="bg-blue-100 text-blue-800 text-sm font-semibold px-4 py-2 rounded-lg">
                        Total Pendapatan: Rp {{ number_format($totalPendapatan, 0, ',', '.') }}
                    </span>
                    <span class="text-sm text-gray-600">
                        Total: <strong>{{ $orders->count() }}</strong> transaksi ditemukan
                    </span>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full border-collapse border border-gray-300 text-sm">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="border border-gray-300 px-4 py-2.5 text-center">ID Order</th>
                                <th class="border border-gray-300 px-4 py-2.5 text-left">Nama Pemesan</th>
                                <th class="border border-gray-300 px-4 py-2.5 text-left">Film & Studio</th>
                                <th class="border border-gray-300 px-4 py-2.5 text-center">Jumlah</th>
                                <th class="border border-gray-300 px-4 py-2.5 text-right">Subtotal</th>
                                <th class="border border-gray-300 px-4 py-2.5 text-center">Tanggal</th>
                                <th class="border border-gray-300 px-4 py-2.5 text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($orders as $order)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="border border-gray-300 px-4 py-2 text-center font-mono">#{{ $order->id }}</td>
                                    <td class="border border-gray-300 px-4 py-2 font-medium">{{ $order->user->name ?? 'User Terhapus' }}</td>
                                    <td class="border border-gray-300 px-4 py-2">
                                        @foreach($order->orderDetails as $detail)
                                            <div>{{ $detail->ticket->nama_film ?? '-' }} ({{ $detail->ticket->studio ?? '-' }})</div>
                                        @endforeach
                                    </td>
                                    <td class="border border-gray-300 px-4 py-2 text-center">
                                        @foreach($order->orderDetails as $detail)
                                            {{ $detail->jumlah_tiket }}
                                        @endforeach
                                    </td>
                                    <td class="border border-gray-300 px-4 py-2 text-right font-semibold">
                                        Rp {{ number_format($order->total_harga, 0, ',', '.') }}
                                    </td>
                                    <td class="border border-gray-300 px-4 py-2 text-center text-gray-600">
                                        {{ $order->created_at->format('d-m-Y H:i') }}
                                    </td>
                                    <td class="border border-gray-300 px-4 py-2 text-center">
                                        <span class="inline-block px-2 py-0.5 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                            {{ ucfirst($order->status ?? 'success') }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="border border-gray-300 px-4 py-6 text-center text-gray-500">
                                        Belum ada transaksi pemesanan tiket untuk periode ini.
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
