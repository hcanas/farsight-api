<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'password',
        'pin',
    ];

    protected $hidden = [
        'id',
        'password',
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    protected static function boot(): void
    {
        parent::boot();

        self::creating(function ($model) {
            $model->uuid = Str::uuid()->toString();
        });
    }

    protected function password(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => $value,
            set: fn (?string $value) => !empty($value) ? Hash::make($value) : null,
        );
    }

    protected function pin(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => $value,
            set: fn (?string $value) => !empty($value) ? Hash::make($value) : null,
        );
    }

    public function verifyHash(string $value, string $field): bool
    {
        return Hash::check($value, $this->getAttribute($field));
    }

    public function wallets(): BelongsToMany
    {
        return $this->belongsToMany(Wallet::class, 'user_wallets', 'user_id', 'wallet_id');
    }
}
