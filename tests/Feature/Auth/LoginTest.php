<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected User $user;

    protected array $inputs;

    protected string $url;

    protected function setUp(): void
    {
        parent::setUp();

        $password = fake()->password();

        $this->user = User::factory()->create(['password' => $password]);

        $this->inputs = [
            'uuid' => $this->user->uuid,
            'password' => $password,
        ];

        $this->url = route('login');
    }

    public function test_can_login(): void
    {
        $this->postJson($this->url, $this->inputs)
            ->assertOk()
            ->assertJsonStructure([
                'message',
                'token',
            ]);
    }

    public function test_returns_401_with_incorrect_password(): void
    {
        $this->inputs['password'] = 'wrong-password';

        $this->postJson($this->url, $this->inputs)
            ->assertUnauthorized()
            ->assertJsonStructure(['message']);
    }

    #[DataProvider('invalidUuidProvider')]
    public function test_returns_422_with_invalid_uuid(?string $uuid): void
    {
        $invalid_inputs['password'] = $this->inputs['password'];

        if ($uuid !== 'undefined') {
            $invalid_inputs['uuid'] = $uuid;
        }

        $this->postJson($this->url, $invalid_inputs)
            ->assertUnprocessable()
            ->assertJsonStructure(['message']);
    }

    #[DataProvider('invalidPasswordProvider')]
    public function test_returns_422_with_invalid_password(?string $password): void
    {
        $invalid_inputs['uuid'] = $this->inputs['uuid'];

        if ($password !== 'undefined') {
            $invalid_inputs['password'] = $password;
        }

        $this->postJson($this->url, $invalid_inputs)
            ->assertUnprocessable()
            ->assertJsonStructure(['message']);
    }

    public static function invalidUuidProvider(): array
    {
        return [
            'undefined' => ['undefined'],
            'null' => [null],
            'empty' => [''],
            'not uuid' => ['uuid'],
            'unregistered uuid' => [fake()->uuid],
        ];
    }

    public static function invalidPasswordProvider(): array
    {
        return [
            'undefined' => ['undefined'],
            'null' => [null],
            'empty' => [''],
            'too short' => ['a'],
        ];
    }
}
