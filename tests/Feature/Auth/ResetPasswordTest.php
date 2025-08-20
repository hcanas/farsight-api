<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use App\Models\Wallet;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class ResetPasswordTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected User $user;

    protected Wallet $wallet;

    protected array $inputs;

    protected string $url;

    protected function setUp(): void
    {
        parent::setUp();

        $pin = fake()->randomNumber(6, true);

        $this->user = User::factory()->create(['pin' => $pin]);

        $this->wallet = Wallet::factory()->create();

        $this->user->wallets()->attach($this->wallet);

        $this->inputs = [
            'wallet_address' => $this->wallet->address,
            'password' => 'new-password',
            'password_confirmation' => 'new-password',
            'pin' => $pin,
        ];

        $this->url = route('reset-password');
    }

    public function test_can_reset_password(): void
    {
        $response = $this->patchJson($this->url, $this->inputs);

        $response->assertOk();
        $response->assertJsonStructure(['message']);

        $this->user->refresh();
        $this->assertTrue(Hash::check($this->inputs['password'], $this->user->password));
    }
}
