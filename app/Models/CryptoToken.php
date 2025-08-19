<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;

class CryptoToken extends Model
{
    use HasFactory;

    protected $fillable = [
        'symbol',
        'name',
        'network',
        'contract_address',
        'decimals',
        'last_block',
    ];

    protected $hidden = [
        'id',
    ];

    protected static function boot(): void
    {
        parent::boot();

        self::creating(function ($model) {
            $model->uuid = Str::uuid()->toString();
        });
    }

    public function wallets(): BelongsToMany
    {
        return $this->belongsToMany(Wallet::class, 'wallet_tokens');
    }
}
