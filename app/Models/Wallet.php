<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;

class Wallet extends Model
{
    use HasFactory;

    protected $fillable = [
        'address',
        'network',
    ];

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function ($model) {
            $model->uuid = Str::uuid()->toString();
        });
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_wallets');
    }

    public function tokens(): BelongsToMany
    {
        return $this->belongsToMany(CryptoToken::class, 'wallet_tokens');
    }
}
