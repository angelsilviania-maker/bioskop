<?php

namespace Tests\Feature;

use App\Models\Ticket;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrderAndTicketTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_view_ticket_catalog(): void
    {
        $user = User::factory()->create(['role' => 'user']);
        $ticket = Ticket::create([
            'nama_film' => 'Pengabdi Setan',
            'harga' => 40000,
            'studio' => 'Studio 1',
        ]);

        $response = $this->actingAs($user)->get('/');

        $response->assertStatus(200);
        $response->assertSee('Pengabdi Setan');
        $response->assertSee('Studio 1');
    }

    public function test_user_can_view_ticket_detail(): void
    {
        $user = User::factory()->create(['role' => 'user']);
        $ticket = Ticket::create([
            'nama_film' => 'Pengabdi Setan',
            'harga' => 40000,
            'studio' => 'Studio 1',
        ]);

        $response = $this->actingAs($user)->get(route('tickets.show', $ticket->id));

        $response->assertStatus(200);
        $response->assertSee('Pengabdi Setan');
        $response->assertSee('Studio 1');
    }

    public function test_events_show_route_alias_works(): void
    {
        $user = User::factory()->create(['role' => 'user']);
        $ticket = Ticket::create([
            'nama_film' => 'Interstellar',
            'harga' => 45000,
            'studio' => 'Studio 2',
        ]);

        $response = $this->actingAs($user)->get(route('events.show', $ticket->id));

        $response->assertStatus(200);
        $response->assertSee('Interstellar');
    }

    public function test_user_can_checkout_ticket(): void
    {
        $user = User::factory()->create(['role' => 'user']);
        $ticket = Ticket::create([
            'nama_film' => 'Avenger: Endgame',
            'harga' => 50000,
            'studio' => 'Studio 1',
        ]);

        $response = $this->actingAs($user)->post(route('customer.checkout'), [
            'ticket_id' => $ticket->id,
            'jumlah_tiket' => 2,
        ]);

        $response->assertRedirect(route('customer.index'));
        $this->assertDatabaseHas('orders', [
            'user_id' => $user->id,
            'total_harga' => 100000,
            'status' => 'success',
        ]);
        $this->assertDatabaseHas('order_details', [
            'ticket_id' => $ticket->id,
            'jumlah_tiket' => 2,
            'subtotal' => 100000,
        ]);
    }

    public function test_admin_can_view_dashboard(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($admin)->get(route('admin.dashboard'));

        $response->assertStatus(200);
        $response->assertSee('Dashboard Admin - Bioskop');
    }

    public function test_admin_can_create_ticket(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($admin)->get(route('admin.tickets.create'));
        $response->assertStatus(200);

        $storeResponse = $this->actingAs($admin)->post(route('admin.tickets.store'), [
            'nama_film' => 'Agak Laen',
            'harga' => 45000,
            'studio' => 'Studio 3',
        ]);

        $storeResponse->assertRedirect(route('admin.tickets.index'));
        $this->assertDatabaseHas('tickets', [
            'nama_film' => 'Agak Laen',
            'harga' => 45000,
            'studio' => 'Studio 3',
        ]);
    }

    public function test_admin_can_edit_and_update_ticket(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $ticket = Ticket::create([
            'nama_film' => 'Film Lama',
            'harga' => 35000,
            'studio' => 'Studio 1',
        ]);

        $response = $this->actingAs($admin)->get(route('admin.tickets.edit', $ticket->id));
        $response->assertStatus(200);

        $updateResponse = $this->actingAs($admin)->put(route('admin.tickets.update', $ticket->id), [
            'nama_film' => 'Film Baru',
            'harga' => 50000,
            'studio' => 'Studio 2',
        ]);

        $updateResponse->assertRedirect(route('admin.tickets.index'));
        $this->assertDatabaseHas('tickets', [
            'id' => $ticket->id,
            'nama_film' => 'Film Baru',
            'harga' => 50000,
            'studio' => 'Studio 2',
        ]);
    }

    public function test_admin_can_delete_ticket(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $ticket = Ticket::create([
            'nama_film' => 'Film Dihapus',
            'harga' => 35000,
            'studio' => 'Studio 1',
        ]);

        $response = $this->actingAs($admin)->delete(route('admin.tickets.destroy', $ticket->id));

        $response->assertRedirect(route('admin.tickets.index'));
        $this->assertDatabaseMissing('tickets', [
            'id' => $ticket->id,
        ]);
    }
}
