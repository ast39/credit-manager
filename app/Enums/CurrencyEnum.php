<?php

namespace App\Enums;

enum CurrencyEnum: int {

    # Рубли
    case RUB = 1;

    # Доллары
    case USD = 2;

    # Евро
    case EUR = 3;
}
