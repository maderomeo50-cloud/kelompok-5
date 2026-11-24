<?php

namespace Tests\Feature;

use Tests\TestCase;

class TopupTest extends TestCase
{
    public function test_topup_page_displays_the_form(): void
    {
        $this->get('/')
            ->assertOk()
            ->assertSee('Masukkan data akun')
            ->assertSee('Pilih nominal diamond')
            ->assertSee('Buat Pesanan Simulasi');
    }

    public function test_valid_order_displays_a_simulated_confirmation(): void
    {
        $this->post('/topup', [
            'player_id' => '12345678',
            'server_id' => '1234',
            'package' => '86',
            'payment_method' => 'qris',
        ])->assertRedirect('/');

        $this->get('/')
            ->assertOk()
            ->assertSee('Konfirmasi simulasi')
            ->assertSee('12345678 (1234)')
            ->assertSee('Rp20.000');
    }

    public function test_order_rejects_an_unknown_package(): void
    {
        $this->from('/')
            ->post('/topup', [
                'player_id' => '12345678',
                'server_id' => '1234',
                'package' => '999999',
                'payment_method' => 'qris',
            ])
            ->assertRedirect('/')
            ->assertSessionHasErrors('package');
    }
}
