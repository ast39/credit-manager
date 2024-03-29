<?php

namespace App\Http\Mutators;

use App\Libs\Time\TimeManager;
use Illuminate\Database\Eloquent\Collection;

class CreditEventMutator {

    /**
     * @param Collection $credits
     * @return array
     */
    public function __invoke(Collection $credits): array
    {
        $credits = $credits->toArray();

        $events = [];

        foreach ($credits as $credit) {
            $next_payment_date = TimeManager::shiftMonth(time(), $this->overDueTime($credit));

            $events[] = [
                'credit_id' => $credit['credit_id'],
                'date'      => date('d', $credit['payment_date']) . '.'
                    . date('m', $next_payment_date) . '.' . date('Y', $next_payment_date),
                'date_time' => TimeManager::shiftMonth($this->paymentDate($credit), $this->overDueTime($credit)),
                'title'     => $credit['title'],
                'creditor'  => $credit['creditor'],
                'payment'   => $credit['payment'],
                'currency'  => $credit['currency'],
                'status'    => $this->paymentStatus($credit),
            ];
        }

        return $events;
    }

    /**
     * @param array $credit
     * @return bool
     */
    private function paymentStatus(array $credit): bool
    {
        if ($this->firstPaymentInFuture($credit)) {
            return true;
        }

        $current_payment_date = $credit['payment_date'];

        for ($i = 1; $i <= $credit['period']; $i++) {

            if ($this->isCurrentMonth($current_payment_date)) {
                return count($credit['payments']) >= $i;
            }

            $current_payment_date = $this->plusMonth($current_payment_date);
        }

        return false;
    }

    /**
     * @param array $credit
     * @return int
     */
    private function overDueTime(array $credit): int
    {
        if ($this->firstPaymentInFuture($credit)) {
            return 0;
        }

        $current_payment_date = $credit['payment_date'];

        for ($i = 1; $i <= $credit['period']; $i++) {

            if ($this->isCurrentMonth($current_payment_date)) {
                return count($credit['payments']) - $i + 1;
            }

            $current_payment_date = $this->plusMonth($current_payment_date);
        }

        return 0;
    }

    /**
     * @param array $credit
     * @return int
     */
    private function paymentDate(array $credit): int
    {
        $current_payment_date = $credit['payment_date'];

        for ($i = 1; $i <= $credit['period']; $i++) {

            if ($this->isCurrentMonth($current_payment_date)) {
                return $current_payment_date;
            }

            $current_payment_date = $this->plusMonth($current_payment_date);
        }

        return 0;
    }

    /**
     * @param array $credit
     * @return bool
     */
    private function firstPaymentInFuture(array $credit): bool
    {
        $zero_first_payment_day = strtotime(date('d.m.Y', $credit['payment_date']) . ' 00:00:00');
        $zero_today             = strtotime(date('d.m.Y', time()) . ' 00:00:00');

        return $zero_first_payment_day > $zero_today;
    }

    /**
     * Добавить месяц к дате
     *
     * @param int $time
     * @return int
     */
    private function plusMonth(int $time): int
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

    /**
     * @param int $time
     * @return bool
     */
    private function isCurrentMonth(int $time): bool
    {
        return date('m', time()) == date('m', $time)
            && date('Y', time()) == date('Y', $time);
    }
}
