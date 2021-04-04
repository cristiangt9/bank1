<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BalanceControllerTest extends TestCase
{
    use DatabaseMigrations;
    use RefreshDatabase;
    /** @test  */
    public function balance_for_nonexisting_account_return_404()
    {
        // —
        // # Get balance for non-existing account
        // GET /balance?account_id=1234
        // 404 0
        // —
        // Teniendo una solicitud al endpoint 'api/balance' con el metodo GET,
        // Cuando solicitemos un balance (withdraw) de una cuenta no existente
        // Entonces el endpoint nos respondera con una respuesta con content: 0 y codigo http 404

        $responce = $this->get('api/balance?account_id=1234' );
        $responce->assertStatus(404);
        $this->assertEquals($responce->getcontent(), '0');
    }
    /** @test  */
    public function balance_for_existing_account_return_balance_only()
    {
        // # Get balance for existing account
        // GET /balance?account_id=100
        // 200 20
        // Teniendo una solicitud al endpoint 'api/balance' con el metodo GET, y una cuenta "100" con un bancele de 20
        // Cuando solicitemos un balance (withdraw) de una cuenta existente
        // Entonces el endpoint nos respondera con una respuesta con content: 20 y codigo http 404
        $this->post('api/event', [
            "type" => "deposit", "destination" => "100", "amount" => 20
        ]);
        $responce = $this->get('api/balance?account_id=100' );
        $responce->assertStatus(200);
        $this->assertEquals($responce->getcontent(), 20);
    }

}
