<?php

namespace App\Http\Enums;

enum ProductRelationType: string
{
    case CrossSell = 'crossSell';
    case InPackage = 'inPackage';

    public function toInt(): int
    {
        return match($this) {
            self::CrossSell => 1,
            self::InPackage => 2,
        };
    }

    public static function fromInt(int $int): ProductRelationType
    {
        return match ($int) {
            2 => self::InPackage,
            default => self::CrossSell,
        };
    }
}
