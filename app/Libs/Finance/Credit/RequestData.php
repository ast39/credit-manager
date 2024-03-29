<?php

namespace App\Libs\Finance\Credit;

use App\Libs\Finance\Exceptions\RequestDataException;
use App\Models\Wallet\WalletCurrency;

/**
 * Объект кредита - запрос
 */
class RequestData {

    # ID кредита
    public ?int $credit_id;

    # Заголовок кредита
    public string $title;

    # Валюта кредита
    public WalletCurrency $currency;

    # Тип платежа
    public string $payment_type;

    # Дата взятия кредита
    public ?int $start_date;

    # Дата первого платежа
    public ?int $payment_date;

    # Что нужно рассчитать в кредите
    public ?string $subject;

    # Сумма кредита
    public ?float  $amount;

    # Процент по кредиту
    public ?float  $percent;

    # Срок кредита в месяцах
    public ?int    $period;

    # Ежемесячный платеж
    public ?float  $payment;

    # Список сделанных платежей
    public ?array  $payments;

    # Банк
    public ?string $creditor;


    /**
     * @param string $title
     * @param WalletCurrency $currency
     * @param int $payment_type
     * @param int|null $start_date
     * @param int|null $payment_date
     * @param string|null $subject
     * @param float|null $amount
     * @param float|null $percent
     * @param int|null $period
     * @param float|null $payment
     * @param array|null $payments
     * @param int|null $credit_id
     * @param string|null $creditor
     * @throws RequestDataException
     */
    public function __construct(
        string  $title,
        WalletCurrency $currency,
        int     $payment_type,
        ?int    $start_date   = null,
        ?int    $payment_date = null,
        ?string $subject      = null,
        ?float  $amount       = null,
        ?float  $percent      = null,
        ?int    $period       = null,
        ?float  $payment      = null,
        ?array  $payments     = null,
        ?int    $credit_id    = null,
        ?string $creditor     = null,
    ) {
        $this->title        = $title;
        $this->currency     = $currency;
        $this->payment_type = $payment_type;
        $this->start_date   = $start_date   ?: time();
        $this->payment_date = $payment_date ?: $this->plusMonth(time());
        $this->subject      = $subject;
        $this->amount     = (float) str_replace(',', '.', $amount);
        $this->percent    = (float) str_replace(',', '.', $percent);
        $this->period     = $period;
        $this->payment    = (float) str_replace(',', '.', $payment);
        $this->payments   = $payments ?: [];
        $this->credit_id  = $credit_id;
        $this->creditor   = $creditor;

        $this->validate();
    }

    /**
     * Валидация кредита
     *
     * @return void
     * @throws RequestDataException
     */
    private function validate()
    {
        if ($this->amount < 0) {
            throw new RequestDataException('Условия кредита невыполнимы. Сумма кредита 0 или меньше.', 901);
        }

        if ($this->percent < 0) {
            throw new RequestDataException('Условия кредита невыполнимы. Процент по кредиту 0 или ниже.', 902);
        }

        if ($this->period < 0) {
            throw new RequestDataException('Условия кредита невыполнимы. Срок кредита 0 или меньше.', 903);
        }

        if ($this->payment < 0) {
            throw new RequestDataException('Условия кредита невыполнимы. Платеж по кредиту 0 или меньше.', 904);
        }
    }

    /**
     * @param int $time
     * @param int $monthes
     * @return int
     */
    private function plusMonth(int $time, int $monthes = 1): int
    {
        $year  = (int) date('Y', $time);
        $month = (int) date('m', $time);
        $day   = (int) date('d', $time);

        $month = $month == 12 ? 1 : $month + 1;
        $year  = $month == 1  ? $year + 1 : $year;

        $day = match ($month) {

            2           => $year%4 == 0 ? (min($day, 29)) : (min($day, 28)),
            4, 6, 11, 9 => min($day, 30),

            default     => $day,
        };

        return strtotime(
            str_pad($day, 2, 0, STR_PAD_LEFT) . '-'
            . str_pad($month, 2, 0, STR_PAD_LEFT). '-'
            . str_pad($year, 4, 0, STR_PAD_LEFT) . ' 09:00:00'
        );
    }
}
