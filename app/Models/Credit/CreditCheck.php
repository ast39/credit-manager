<?php

namespace App\Models\Credit;

use App\Http\Traits\Filterable;
use App\Models\Wallet\WalletCurrency;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CreditCheck extends Model {

    use HasFactory, Filterable;


    protected $table         = 'credit_checks';

    protected $primaryKey    = 'calc_id';

    protected $keyType       = 'int';

    public    $incrementing  = true;

    public    $timestamps    = true;


    /**
     * Валюта кредита
     *
     * @return BelongsTo
     */
    public function currency(): BelongsTo
    {
        return $this->belongsTo(WalletCurrency::class, 'currency_id', 'currency_id');
    }


    protected $casts = [
        'created_at' => 'timestamp',
        'updated_at' => 'timestamp',
    ];

    protected $fillable = [
        'calc_id', 'currency_id', 'owner_id', 'title',
        'currency', 'amount', 'percent', 'period', 'payment',
        'created_at', 'updated_at',
    ];

    protected $hidden = [];
}
