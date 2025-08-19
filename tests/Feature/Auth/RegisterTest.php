<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected array $inputs;

    protected string $url;

    protected function setUp(): void
    {
        parent::setUp();

        $this->inputs = [
            'password' => 'password',
            'password_confirmation' => 'password',
            'pin' => '123456',
            'pin_confirmation' => '123456',
        ];

        $this->url = route('register');
    }

    public function test_can_register(): void
    {
        $this->postJson($this->url, $this->inputs)
            ->assertCreated()
            ->assertJsonStructure([
                'message',
                'uuid',
            ]);
    }

    #[DataProvider('invalidPasswordProvider')]
    public function test_returns_422_with_invalid_password(?string $password): void
    {
        $invalid_inputs = [
            'password_confirmation' => $this->inputs['password_confirmation'],
            'pin' => $this->inputs['pin'],
            'pin_confirmation' => $this->inputs['pin'],
        ];

        if ($password !== 'undefined') {
            $invalid_inputs['password'] = $password;
        }

        $this->postJson($this->url, $invalid_inputs)
            ->assertUnprocessable()
            ->assertJsonValidationErrors(['password']);
    }

    #[DataProvider('invalidPinProvider')]
    public function test_returns_422_with_invalid_pin(?string $pin): void
    {
        $invalid_inputs = [
            'password' => $this->inputs['password'],
            'password_confirmation' => $this->inputs['password_confirmation'],
            'pin_confirmation' => $this->inputs['pin_confirmation'],
        ];

        if ($pin !== 'undefined') {
            $invalid_inputs['pin'] = $pin;
        }

        $this->postJson($this->url, $invalid_inputs)
            ->assertUnprocessable()
            ->assertJsonValidationErrors(['pin']);
    }

    public static function invalidPasswordProvider(): array
    {
        return [
            'undefined' => ['undefined'],
            'null' => [null],
            'empty' => [''],
            'too short' => ['a'],
            'mismatch' => ['mismatch'],
        ];
    }

    public static function invalidPinProvider(): array
    {
        return [
            'undefined' => ['undefined'],
            'null' => [null],
            'empty' => [''],
            'too short' => ['1'],
            'too long' => ['1234567'],
            'mismatch' => ['111111'],
        ];
    }
}
