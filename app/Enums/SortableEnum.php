<?php

namespace App\Enums;

enum SortableEnum: string
{

    # По сроку
    case Till    = 'till';

    # По проценту
    case Percent = 'percent';

    # По платежу
    case Payment = 'payment';

    # По сумме
    case Amount  = 'amount';

    # По переплате
    case Overpay = 'oberpay';
}
