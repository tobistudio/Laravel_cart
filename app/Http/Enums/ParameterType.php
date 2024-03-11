<?php

namespace App\Http\Enums;

enum ParameterType: string
{
    case Default = 'default';
    case Code = 'code';

    public function toInt(): int
    {
        return match($this) {
            self::Default => 1,
            self::Code => 2,
        };
    }

    public static function fromInt(int $int): ParameterType
    {
        return match ($int) {
            2 => self::Code,
            default => self::Default,
        };
    }
}
