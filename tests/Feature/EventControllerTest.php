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
        // teniendo una solicitud post al enpoint 'api/event' con el metodo post
        $response = $this->post('api/event', ["type" => "deposit", "destination" => "100", "amount" => 10
        ]);
        // cuando el enpoint responde
        // entonces obtendremos un status 201, un content: 'ok' y la base de datos limpia
        $response->assertStatus(201);
        $response->assertJsonFragment(["destination" => ["id" => "100", "balance" => 10]]);
    }
}
