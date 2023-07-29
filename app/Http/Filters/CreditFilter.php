<?php

namespace App\Http\Filters;

use Illuminate\Database\Eloquent\Builder;

class CreditFilter extends AbstractFilter {

    public const CURRENCY = 'currency';
    public const TITLE    = 'title';
    public const BANK     = 'bank';

    /**
     * @return array[]
     */
    protected function getCallbacks(): array
    {
        return [

            self::CURRENCY => [$this, 'currency'],
            self::TITLE    => [$this, 'title'],
            self::BANK     => [$this, 'bank'],
        ];
    }

    /**
     * @param Builder $builder
     * @param $value
     * @return void
     */
    public function currency(Builder $builder, $value): void
    {
        $builder->where('currency_id', $value);
    }

    /**
     * @param Builder $builder
     * @param $value
     * @return void
     */
    public function title(Builder $builder, $value): void
    {
        $builder->where('title', 'like', '%' . $value . '%');
    }

    /**
     * @param Builder $builder
     * @param $value
     * @return void
     */
    public function bank(Builder $builder, $value): void
    {
        $builder->where('creditor', 'like', '%' . $value . '%');
    }

}
