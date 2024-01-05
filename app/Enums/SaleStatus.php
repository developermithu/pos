<?php

namespace App\Enums;

enum SaleStatus: string
{
    case ORDERED = 'ordered';
    case PENDING = 'pending';
    case DELIVERED = 'delivered';

    public static function forSelect(): array
    {
        return array_column(self::cases(), 'name', 'value');
    }

    public function isOrdered(): bool
    {
        return $this === self::ORDERED;
    }

    public function isPending(): bool
    {
        return $this === self::PENDING;
    }

    public function isDelivered(): bool
    {
        return $this === self::DELIVERED;
    }

    public function getLabelTextColor(): string
    {
        return match ($this) {
            self::ORDERED => '#5D00BB', // primary color
            self::PENDING => 'rgb(148 163 184)', // gray color
            self::DELIVERED => 'rgb(34 197 94)', // success color
        };
    }

    public function getLabelBackgroundColor(): string
    {
        return match ($this) {
            self::ORDERED => '#5D00cc', // primary color
            self::PENDING => 'rgb(254 242 242)', // danger color
            self::DELIVERED => 'rgb(240 253 244)', // success color
        };
    }

    public function getLabelText(): string
    {
        return match ($this) {
            self::ORDERED => 'Ordered',
            self::PENDING => 'Pending',
            self::DELIVERED => 'Delivered',
        };
    }

    public function getLabelHTML(): string
    {
        return sprintf(
            '<span class="px-3 py-1 text-xs font-semibold rounded" style="color: %s; background-color: %s;">%s</span>',
            $this->getLabelTextColor(),
            $this->getLabelBackgroundColor(),
            $this->getLabelText()
        );
    }
}
