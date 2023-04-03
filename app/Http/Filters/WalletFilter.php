<?php

namespace App\Http\Filters;

use Illuminate\Database\Eloquent\Builder;

class WalletFilter extends AbstractFilter {

    public const BALANCE_FROM = 'balance_from';
    public const BALANCE_TO   = 'balance_to';

    /**
     * @return array[]
     */
    protected function getCallbacks(): array
    {
        return [

            self::BALANCE_FROM => [$this, 'balanceFrom'],
            self::BALANCE_TO   => [$this, 'balanceTo'],
        ];
    }

    /**
     * @param Builder $builder
     * @param $value
     * @return void
     */
    public function balanceFrom(Builder $builder, $value): void
    {
        $builder->where('amount', '>=', $value);
    }

    /**
     * @param Builder $builder
     * @param $value
     * @return void
     */
    public function balanceTo(Builder $builder, $value): void
    {
        $builder->where('amount', '<=', $value);
    }

}
