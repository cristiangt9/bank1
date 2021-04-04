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

        $responce = $this->get('api/bance?account_id=1234' );
        $responce->assertStatus(404);
        $this->assertEquals($responce->getcontent(), '0');
    }
    
}
