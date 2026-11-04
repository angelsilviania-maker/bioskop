<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Jadwal Film Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-4">
                <a href="{{ route('admin.tickets.index') }}" class="text-blue-600 hover:text-blue-800 font-medium inline-flex items-center text-sm">
                    &larr; Kembali ke Daftar Tiket Film
                </a>
            </div>

            @if ($errors->any())
                <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form action="{{ route('admin.tickets.store') }}" method="POST">
                    @csrf

                    <div class="space-y-6">
                        <div>
                            <label for="nama_film" class="block text-sm font-medium text-gray-700">Nama Film</label>
                            <input 
                                type="text" 
                                name="nama_film" 
                                id="nama_film" 
                                value="{{ old('nama_film') }}" 
                                required 
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm"
                                placeholder="Contoh: Avenger: Endgame"
                            >
                        </div>

                        <div>
                            <label for="harga" class="block text-sm font-medium text-gray-700">Harga Tiket (Rp)</label>
                            <input 
                                type="number" 
                                name="harga" 
                                id="harga" 
                                value="{{ old('harga') }}" 
                                required 
                                min="0" 
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm"
                                placeholder="Contoh: 45000"
                            >
                        </div>

                        <div>
                            <label for="studio" class="block text-sm font-medium text-gray-700">Studio</label>
                            <input 
                                type="text" 
                                name="studio" 
                                id="studio" 
                                value="{{ old('studio') }}" 
                                required 
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm"
                                placeholder="Contoh: Studio 1"
                            >
                        </div>

                        <div class="flex items-center justify-end space-x-3 pt-4 border-t border-gray-200">
                            <a href="{{ route('admin.tickets.index') }}" class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50 transition">
                                Batal
                            </a>
                            <button type="submit" class="px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-md text-sm font-bold shadow-sm transition">
                                Simpan Film
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
