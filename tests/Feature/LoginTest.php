<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class LoginTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_login_logout_singup(): void
    {
        Artisan::call('migrate');

        $response = $this->postJson('/api/signup',['user_name'=>'test_user_name','email'=>'test@test.com','password'=>'password','user_type_id'=>2,'name'=>'test','last_name'=>'test']);
        

        $response->assertStatus(200)
            ->assertJsonStructure([
                'token'
            ]);

        $jsonResponse = $response->json();
        $token = $jsonResponse['token'];

        // Verificar que el token no está vacío
        $this->assertNotEmpty($token);
        $this->assertDatabaseHas('users',['email'=>'test@test.com']);

        $login = $this->withHeaders(['Authorization'=>'Bearer',$token])->postJson('/api/login',['email'=>'test@test.com','password'=>'password']);
        $login->assertStatus(200);
    }
}
