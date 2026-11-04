<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    // Menampilkan daftar tiket/jadwal film (halaman admin)
    public function index()
    {
        $tickets = Ticket::all();

        return view('admin.tickets.index', compact('tickets'));
    }

    // Form tambah film
    public function create()
    {
        return view('admin.tickets.create');
    }

    // Simpan data film baru
    public function store(Request $request)
    {
        $request->validate([
            'nama_film' => 'required|string|max:255',
            'harga' => 'required|numeric',
            'studio' => 'required|string|max:50',
        ]);

        Ticket::create($request->all());

        return redirect()->route('admin.tickets.index')->with('success', 'Jadwal film berhasil ditambahkan.');
    }

    // Form edit film
    public function edit(Ticket $ticket)
    {
        return view('admin.tickets.edit', compact('ticket'));
    }

    // Update data film
    public function update(Request $request, Ticket $ticket)
    {
        $request->validate([
            'nama_film' => 'required|string|max:255',
            'harga' => 'required|numeric',
            'studio' => 'required|string|max:50',
        ]);

        $ticket->update($request->all());

        return redirect()->route('admin.tickets.index')->with('success', 'Jadwal film berhasil diperbarui.');
    }

    // Hapus film
    public function destroy(Ticket $ticket)
    {
        $ticket->delete();

        return redirect()->route('admin.tickets.index')->with('success', 'Jadwal film berhasil dihapus.');
    }
}
