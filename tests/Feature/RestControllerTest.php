<?php

namespace Tests\Feature;

use App\Models\Account;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RestControllerTest extends TestCase
{
    /**
     * @test
     */
    public function reset_refresh_data_and_response_with_ok()
    {
        // teniendo una solcitud post al enpoint 'api/reset' con el metodo post
        $response = $this->post('api/reset');
        // cuando el enpoint responde
        // entonces obtendremos un status 200, un content: 'ok' y la base de datos limpia
        $response->assertStatus(200);
        $this->assertEquals($response->getContent(), "OK");
        $this->assertCount(0, Account::all());
    }
}
