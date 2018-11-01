<?php

namespace Modules\Task\Enums;

use BenSampo\Enum\Enum;

final class TaskCompletedEnum extends Enum
{
    const Complete = 1;
    const InComplete = 0;

    public static function getDescription($value): string
    {
        if ($value === self::Complete) {
            return 'Yes';
        } elseif ($value === self::InComplete) {
            return 'No';
        }

        return parent::getDescription($value);
    }
}
