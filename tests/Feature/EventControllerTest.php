<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
// use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class EventControllerTest extends TestCase
{
    use DatabaseMigrations;
    use RefreshDatabase;
    /** @test  */
    public function deposit_for_nonexisting_account_return_an_account_created()
    {
        // —
        // # Create account with initial balance
        // POST /event {"type":"deposit", "destination":"100", "amount":10}
        // 201 {"destination": {"id":"100", "balance":10}}
        // —
        // # Deposit into existing account
        // POST /event {"type":"deposit", "destination":"100", "amount":10}
        // 201 {"destination": {"id":"100", "balance":20}}
        // —

        // teniendo una solicitud al enpoint 'api/event' con el metodo POST
        $response = $this->post('api/event', [
            "type" => "deposit", "destination" => "100", "amount" => 10
        ]);
        // cuando el enpoint responde
        // entonces obtendremos un status 201, un content: 'ok' y la base de datos limpia
        $response->assertStatus(201);
        $response->assertJsonFragment(["destination" => ["id" => "100", "balance" => 10]]);
    }
    /** @test  */
    public function withdraw_for_nonexisting_account_return_404()
    {
        // # Withdraw from non-existing account
        // POST /event {"type":"withdraw", "origin":"200", "amount":10}
        // 404 0
        // —

        // Teniendo una solicitud al endpoint 'api/rest' con el metodo POST,
        // Cuando solicitemos un retiro (withdraw) a una cuenta no existente
        // Entonces el endpoint nos respondera con una respuesta con content: 0 y codigo http 404
        $response = $this->post('api/event', [
            "type" => "withdraw", "origin" => "200", "amount" => 10
        ]);

        $response->assertStatus(404);
        $this->assertEquals($response->getContent(), "0");
    }
    /** @test  */
    public function withdraw_for_existing_account_return_correct_balance()
    {
        // # Withdraw from existing account
        // POST /event {"type":"withdraw", "origin":"100", "amount":5}
        // 201 {"origin": {"id":"100", "balance":15}
        
        // Teniendo una solicitud al endpoint 'api/rest' con el metodo POST, y una cuenta "100" con un bancele de 20
        $this->post('api/event', [
            "type" => "deposit", "destination" => "100", "amount" => 20
        ]);
        // Cuando solicitemos un retiro (withdraw) a una cuenta existente
        // Entonces el endpoint nos respondera con una respuesta con content: {"origin": {"id":"100", "balance":15} y codigo http 201
        $response = $this->post('api/event',["type" => "withdraw", "origin" => "100", "amount" => 5]);
        $response->assertStatus(201);
        $response->assertJsonFragment(["origin" => ["id" => "100", "balance" => 15]]);
    }
}
