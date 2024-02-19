<?php

namespace App\Enums;

enum SalePaymentStatus: string
{
    case DUE = 'due';
    case PARTIAL = 'partial';
    case PAID = 'paid';

    public static function forSelect(): array
    {
        return array_column(self::cases(), 'name', 'value');
    }

    public function isDue(): bool
    {
        return $this === self::DUE;
    }

    public function isPartial(): bool
    {
        return $this === self::PARTIAL;
    }

    public function isPaid(): bool
    {
        return $this === self::PAID;
    }

    public function getLabelTextColor(): string
    {
        return match ($this) {
            self::DUE => 'rgb(248 113 113)', // danger color
            self::PARTIAL => 'rgb(14 165 233)', // primary color
            self::PAID => 'rgb(34 197 94)', // success color
        };
    }

    public function getLabelBackgroundColor(): string
    {
        return match ($this) {
            self::DUE => 'rgb(254 242 242)', // danger color
            self::PARTIAL => 'rgb(224 242 254)', // primary color
            self::PAID => 'rgb(240 253 244)', // success color
        };
    }

    public function getLabelText(): string
    {
        return match ($this) {
            self::DUE => 'Due',
            self::PARTIAL => 'Partial',
            self::PAID => 'Paid',
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
