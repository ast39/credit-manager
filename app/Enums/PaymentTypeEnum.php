<?php

namespace App\Enums;

enum PaymentTypeEnum: int {

    # Аннуитетный
    case Annuitant = 1;

    # Дифференцированный
    case Difference = 2;

}
