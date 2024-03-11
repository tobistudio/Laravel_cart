<?php

namespace App\Http\Enums;

enum AttributeType: string
{
    case Select = 'select';
    case MultiSelect = 'multiselect';

    public function toInt(): int
    {
        return match($this) {
            self::Select => 1,
            self::MultiSelect => 2,
        };
    }

    public static function fromInt(int $int): AttributeType
    {
        return match ($int) {
            2 => self::MultiSelect,
            default => self::Select,
        };
    }
}
