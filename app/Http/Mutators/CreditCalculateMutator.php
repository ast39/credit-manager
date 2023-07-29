<?php

namespace App\Http\Mutators;

use App\Enums\CreditSubjectEnum;
use App\Libs\Finance\Credit\CreditManager;
use App\Libs\Finance\Credit\ResponseData;
use App\Libs\Finance\Exceptions\RequestDataException;
use App\Models\Credit\CreditCalculate;

class CreditCalculateMutator {

    /**
     * @param CreditCalculate $credit
     * @return ResponseData|string
     * @throws RequestDataException
     */
    public function __invoke(CreditCalculate $credit): ResponseData|string
    {
        $credit = CreditManager::setCredit(
            $credit->title,
            $credit->currency,
            $credit->payment_type,
            null,
            null,
            $credit->subject,
            $credit->amount,
            $credit->percent,
            $credit->period,
            $credit->payment,
            null
        );

        return match($credit->subject) {

            CreditSubjectEnum::Amount->value  => (new CreditManager())->findAmount($credit),
            CreditSubjectEnum::Percent->value => (new CreditManager())->findPercent($credit),
            CreditSubjectEnum::Period->value  => (new CreditManager())->findPeriod($credit),

            default   => (new CreditManager())->findPayment($credit),
        };
    }
}
