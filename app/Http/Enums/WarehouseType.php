<?php

namespace App\Http\Enums;

enum WarehouseType: string
{
    case Shop = 'shop';
    case SelfPickup = 'self pickup';
    case DeliverTo = 'deliver to';
    case Storage = 'storage';

    public function toInt(): int
    {
        return match($this) {
            self::Shop => 1,
            self::SelfPickup => 2,
            self::DeliverTo => 3,
            self::Storage => 4,
        };
    }

    public static function fromInt(int $int): WarehouseType
    {
        return match ($int) {
            2 => self::SelfPickup,
            3 => self::DeliverTo,
            4 => self::Storage,
            default => self::Shop,
        };
    }
}
