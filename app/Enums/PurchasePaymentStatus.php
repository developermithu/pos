<?php

namespace App\Enums;

enum PurchasePaymentStatus: string
{
    case PAID = 'paid';
    case UNPAID = 'unpaid';
    case PARTIAL = 'partial';

    public static function forSelect(): array
    {
        return array_column(self::cases(), 'name', 'value');
    }

    public function isPaid(): bool
    {
        return $this === self::PAID;
    }

    public function isUnpaid(): bool
    {
        return $this === self::UNPAID;
    }

    public function isPartial(): bool
    {
        return $this === self::PARTIAL;
    }

    public function getLabelTextColor(): string
    {
        return match ($this) {
            self::PAID => 'rgb(34 197 94)', // success color
            self::UNPAID => 'rgb(248 113 113)', // danger color
            self::PARTIAL => 'rgb(14 165 233)', // primary color
        };
    }

    public function getLabelBackgroundColor(): string
    {
        return match ($this) {
            self::PAID => 'rgb(240 253 244)', // success color
            self::UNPAID => 'rgb(254 242 242)', // danger color
            self::PARTIAL => 'rgb(224 242 254)', // primary color
        };
    }

    public function getLabelText(): string
    {
        return match ($this) {
            self::PAID => 'Paid',
            self::UNPAID => 'Unpaid',
            self::PARTIAL => 'Partial',
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
