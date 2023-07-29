<?php

namespace Database\Seeders;

use App\Enums\CurrencyEnum;
use App\Models\Credit\Credit;
use App\Models\Credit\CreditPayment;
use App\Models\User;
use App\Models\Wallet\WalletCurrency;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DemoDataSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'name'     => 'Заемщик',
            'email'    => 'demo@mail.ru',
            'password' => Hash::make('demo1234'),
            'email_verified_at' => Carbon::now(),
        ])->id;

        $credit = Credit::create([
            'currency_id'  => CurrencyEnum::RUB->value,
            'owner_id'     => $user,
            'title'        => 'Автомобиль',
            'creditor'     => 'Драйв Клик Банк',
            'amount'       => 1000000,
            'percent'      => 17.9,
            'period'       => 36,
            'payment'      => 36102,
            'start_date'   => 1649116800,
            'payment_date' => 1651881600,
            'status'       => 1,
        ])->credit_id;

        CreditPayment::create([
            'credit_id' => $credit,
            'amount'    => 36102,
            'status'    => 1,
        ]);

        CreditPayment::create([
            'credit_id' => $credit,
            'amount'    => 36102,
            'status'    => 1,
        ]);

        CreditPayment::create([
            'credit_id' => $credit,
            'amount'    => 36102,
            'status'    => 1,
        ]);

        CreditPayment::create([
            'credit_id' => $credit,
            'amount'    => 36102,
            'status'    => 1,
        ]);

        $credit = Credit::create([
            'currency_id'  => CurrencyEnum::RUB->value,
            'owner_id'     => $user,
            'title'        => 'Айфон',
            'creditor'     => 'МТС банк',
            'amount'       => 90000,
            'percent'      => 12.4,
            'period'       => 12,
            'payment'      => 8014,
            'start_date'   => 1679356800,
            'payment_date' => 1682121600,
            'status'       => 1,
        ])->credit_id;

        CreditPayment::create([
            'credit_id' => $credit,
            'amount'    => 8014,
            'status'    => 1,
        ]);

        $credit = Credit::create([
            'currency_id'  => CurrencyEnum::USD->value,
            'owner_id'     => $user,
            'title'        => 'Ипотека',
            'creditor'     => 'ВТБ',
            'amount'       => 27000,
            'percent'      => 3.2,
            'period'       => 84,
            'payment'      => 359.20,
            'start_date'   => 1684022400,
            'payment_date' => 1686787200,
            'status'       => 1,
        ])->credit_id;

        CreditPayment::create([
            'credit_id' => $credit,
            'amount'    => 359.20,
            'status'    => 1,
        ]);

        CreditPayment::create([
            'credit_id' => $credit,
            'amount'    => 359.20,
            'status'    => 1,
        ]);
    }
}
