<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use Tests\TestCase;

class AuthTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function test_register(): void
    {
        $email = 'test@mail.ru' . rand(100000, 999999);
        $name = 'John Doe';
        $password = 'password';

        $response = $this->post('/register', [
            'name' => $name,
            'email' => $email,
            'password' => $password,
            'password_confirmation' => $password,
        ]);

        $response->assertStatus(302);
        $user = User::query()->where('email', $email)->first();
        $this->assertNotNull($user);
        $this->assertEquals($email, $user->email);
        $this->assertEquals($name, $user->name);
        $this->assertTrue(\Hash::check($password, $user->password));
    }
}
