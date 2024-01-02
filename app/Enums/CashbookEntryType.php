<?php

namespace App\Enums;

enum CashbookEntryType: string
{
    case DEPOSIT = 'deposit';
    case EXPENSE = 'expense';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public static function forSelect(): array
    {
        return array_column(self::cases(), 'name', 'value');
    }

    public function getLabelTextColor(): string
    {
        return match ($this) {
            self::DEPOSIT => 'rgb(34 197 94)', // success color
            self::EXPENSE => 'rgb(248 113 113)', // danger color
        };
    }

    public function getLabelBackgroundColor(): string
    {
        return match ($this) {
            self::DEPOSIT => 'rgb(240 253 244)', // success color
            self::EXPENSE => 'rgb(254 242 242)', // danger color
        };
    }

    public function getLabelText(): string
    {
        return match ($this) {
            self::DEPOSIT => 'Deposit',
            self::EXPENSE => 'Expense',
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
