<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class TransactionTypeEnum extends Enum
{
    const DEFAULT_TRANSACTION =   "DEFAULT";
    const CREATE_ACCOUNT =   "CREATE";
    const USER_TRANSACTION =   "MONEY_TRANSFER";
}
