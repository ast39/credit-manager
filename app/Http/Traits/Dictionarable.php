<?php

namespace App\Http\Traits;

use App\Http\Resources\Wallet\WalletCurrencyResource;
use App\Models\Wallet\WalletCurrency;
use Illuminate\Http\Resources\Json\ResourceCollection;

trait Dictionarable {

    /**
     * Все валюты
     *
     * @return ResourceCollection
     */
    private function walletCurrencies(): ResourceCollection
    {
        return WalletCurrencyResource::collection(WalletCurrency::all()->sortBy('currency_id'));
    }

}
