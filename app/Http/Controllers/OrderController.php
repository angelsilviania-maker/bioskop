<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    // Halaman utama Penonton/User (Pilih & Pesan Tiket)
    public function index()
    {
        $tickets = Ticket::all();
        $events = $tickets; // Alias for backward compatibility
        $myOrders = Order::with('orderDetails.ticket')->where('user_id', auth()->id())->latest()->get();

        return view('user.dashboard', compact('tickets', 'events', 'myOrders'));
    }

    // Detail Tiket Film & Pemesanan
    public function show($id)
    {
        $ticket = Ticket::findOrFail($id);

        return view('user.show', compact('ticket'));
    }

    // Proses Checkout / Simpan Transaksi Tiket
    public function store(Request $request)
    {
        $request->validate([
            'ticket_id' => 'required|exists:tickets,id',
            'jumlah_tiket' => 'required|integer|min:1',
        ]);

        $ticket = Ticket::findOrFail($request->ticket_id);
        $subtotal = $ticket->harga * $request->jumlah_tiket;

        DB::transaction(function () use ($request, $ticket, $subtotal) {
            $order = Order::create([
                'user_id' => auth()->id(),
                'total_harga' => $subtotal,
                'status' => 'success',
            ]);

            OrderDetail::create([
                'order_id' => $order->id,
                'ticket_id' => $ticket->id,
                'jumlah_tiket' => $request->jumlah_tiket,
                'subtotal' => $subtotal,
            ]);
        });

        return redirect()->route('customer.index')->with('success', 'Tiket berhasil dipesan!');
    }

    // Halaman Dashboard Admin / Laporan Transaksi
    public function adminDashboard(Request $request)
    {
        $query = Order::with(['user', 'orderDetails.ticket'])->latest();

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('created_at', [
                $request->start_date.' 00:00:00',
                $request->end_date.' 23:59:59',
            ]);
        }

        $orders = $query->get();
        $totalPendapatan = $orders->sum('total_harga');

        return view('admin.dashboard', compact('orders', 'totalPendapatan'));
    }

    // Update status pesanan (jika diperlukan)
    public function updateStatus(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $order->update(['status' => $request->status]);

        return back()->with('success', 'Status pesanan berhasil diperbarui.');
    }
}
