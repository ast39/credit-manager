<?php

namespace App\Enums;

enum CreditSubjectEnum: string
{

    # Сумма
    case Amount  = 'amount';

    # Процент
    case Percent = 'percent';

    # Срок
    case Period  = 'period';

    # Платеж
    case Payment = 'payment';
}
