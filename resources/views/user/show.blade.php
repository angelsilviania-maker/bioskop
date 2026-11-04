<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail & Pemesanan Tiket Film') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-4">
                <a href="{{ route('customer.index') }}" class="text-indigo-600 hover:text-indigo-800 font-medium inline-flex items-center text-sm">
                    &larr; Kembali ke Katalog Film
                </a>
            </div>

            @if(session('success'))
                <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg" x-data="{ harga: {{ $ticket->harga }}, qty: 1 }">
                <div class="p-6 sm:p-8">
                    <div class="border-b border-gray-200 pb-6 mb-6">
                        <span class="text-xs font-semibold inline-block py-1 px-3 uppercase rounded-full text-indigo-700 bg-indigo-100">
                            {{ $ticket->studio }}
                        </span>
                        <h1 class="text-3xl font-extrabold text-gray-900 mt-3">{{ $ticket->nama_film }}</h1>
                        <p class="text-2xl font-bold text-indigo-600 mt-2">
                            Rp {{ number_format($ticket->harga, 0, ',', '.') }} <span class="text-sm font-normal text-gray-500">/ tiket</span>
                        </p>
                    </div>

                    <form action="{{ route('customer.checkout') }}" method="POST">
                        @csrf
                        <input type="hidden" name="ticket_id" value="{{ $ticket->id }}">

                        <div class="space-y-6">
                            <div>
                                <label for="jumlah_tiket" class="block text-sm font-medium text-gray-700">
                                    Jumlah Tiket yang Ingin Dipesan
                                </label>
                                <div class="mt-2 flex items-center space-x-3">
                                    <button type="button" @click="if (qty > 1) qty--" class="w-10 h-10 rounded-lg border border-gray-300 text-gray-600 hover:bg-gray-100 flex items-center justify-center text-xl font-bold transition">
                                        -
                                    </button>
                                    <input 
                                        type="number" 
                                        name="jumlah_tiket" 
                                        id="jumlah_tiket" 
                                        min="1" 
                                        x-model.number="qty" 
                                        class="w-24 text-center rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-lg font-semibold"
                                        required
                                    >
                                    <button type="button" @click="qty++" class="w-10 h-10 rounded-lg border border-gray-300 text-gray-600 hover:bg-gray-100 flex items-center justify-center text-xl font-bold transition">
                                        +
                                    </button>
                                </div>
                            </div>

                            <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                                <div class="flex justify-between items-center text-sm text-gray-600 mb-2">
                                    <span>Harga per Tiket</span>
                                    <span>Rp {{ number_format($ticket->harga, 0, ',', '.') }}</span>
                                </div>
                                <div class="flex justify-between items-center text-sm text-gray-600 mb-2">
                                    <span>Jumlah Tiket</span>
                                    <span x-text="qty + ' tiket'"></span>
                                </div>
                                <div class="border-t border-gray-200 pt-3 flex justify-between items-center">
                                    <span class="text-base font-semibold text-gray-800">Total Pembayaran</span>
                                    <span class="text-xl font-extrabold text-indigo-600" x-text="'Rp ' + (harga * (qty > 0 ? qty : 0)).toLocaleString('id-ID')"></span>
                                </div>
                            </div>

                            <div class="flex items-center space-x-4">
                                <button type="submit" class="flex-1 bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-6 rounded-lg shadow transition text-center">
                                    Konfirmasi & Pesan Tiket
                                </button>
                                <a href="{{ route('customer.index') }}" class="py-3 px-6 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-50 font-medium transition text-center">
                                    Batal
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
