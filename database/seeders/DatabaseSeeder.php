<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Buat Akun Admin Utama
        User::create([
            'name' => 'Admin Bioskop',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // 2. Buat Akun Penonton
        for ($i = 1; $i <= 15; $i++) {
            User::create([
                'name' => 'Penonton '.$i,
                'email' => 'penonton'.$i.'@gmail.com',
                'password' => Hash::make('password'),
                'role' => 'user',
            ]);
        }

        // 3. Buat Data Master Film / Tiket Bioskop
        $tickets = [
            ['nama_film' => 'Avenger: Endgame', 'harga' => 45000, 'studio' => 'Studio 1'],
            ['nama_film' => 'Interstellar', 'harga' => 45000, 'studio' => 'Studio 2'],
            ['nama_film' => 'Toy Story 4', 'harga' => 40000, 'studio' => 'Studio 3'],
            ['nama_film' => 'Pengabdi Setan', 'harga' => 40000, 'studio' => 'Studio 1'],
            ['nama_film' => 'Agak Laen', 'harga' => 45000, 'studio' => 'Studio 2'],
        ];

        foreach ($tickets as $t) {
            Ticket::create($t);
        }

        // 4. Buat 15 Data Transaksi (Orders & Order Details) untuk Laporan per Periode
        $users = User::where('role', 'user')->get();
        $allTickets = Ticket::all();

        for ($i = 1; $i <= 15; $i++) {
            $ticket = $allTickets->random();
            $user = $users->random();
            $qty = rand(1, 3);
            $subtotal = $ticket->harga * $qty;

            $order = Order::create([
                'user_id' => $user->id,
                'total_harga' => $subtotal,
                'status' => 'success',
                'created_at' => now()->subDays(rand(0, 10)), // Tanggal acak untuk laporan whereBetween
            ]);

            OrderDetail::create([
                'order_id' => $order->id,
                'ticket_id' => $ticket->id,
                'jumlah_tiket' => $qty,
                'subtotal' => $subtotal,
            ]);
        }
    }
}
