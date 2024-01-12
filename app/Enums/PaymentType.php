<?php

namespace App\Enums;

enum PaymentType: string
{
    case CREDIT = 'credit';
    case DEBIT = 'debit';

    public static function forSelect(): array
    {
        return array_column(self::cases(), 'name', 'value');
    }

    public function isCredit(): bool
    {
        return $this === self::CREDIT;
    }

    public function isDebit(): bool
    {
        return $this === self::DEBIT;
    }

    public function getLabelTextColor(): string
    {
        return match ($this) {
            self::DEBIT => 'rgb(248 113 113)', // danger color
            self::CREDIT => 'rgb(34 197 94)', // success color
        };
    }

    public function getLabelBackgroundColor(): string
    {
        return match ($this) {
            self::DEBIT => 'rgb(254 242 242)', // danger color
            self::CREDIT => 'rgb(240 253 244)', // success color
        };
    }

    public function getLabelText(): string
    {
        return match ($this) {
            self::CREDIT => 'Credit',
            self::DEBIT => 'Debit',
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
