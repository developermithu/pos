<?php

namespace App\Enums;

enum PaymentPaidBy: string
{
    case CASH = 'cash';
    case CHEQUE = 'cheque';
    case BANK = 'bank';
    case DEPOSIT = 'deposit';

    public static function forSelect(): array
    {
        return array_column(self::cases(), 'name', 'value');
    }

    public function isCash(): bool
    {
        return $this === self::CASH;
    }

    public function isCheque(): bool
    {
        return $this === self::CHEQUE;
    }

    public function isBank(): bool
    {
        return $this === self::BANK;
    }

    public function isDeposit(): bool
    {
        return $this === self::DEPOSIT;
    }

    public function getLabelTextColor(): string
    {
        return match ($this) {
            self::CASH => '#EEEEEE',
            self::CHEQUE => '#EEEEEE',
            self::BANK => '#EEEEEE',
            self::DEPOSIT => '#EEEEEE',
        };
    }

    public function getLabelBackgroundColor(): string
    {
        return match ($this) {
            self::CASH => 'rgb(240 253 244)', // success 
            self::CHEQUE => 'rgb(234 179 8)', // yellow-500
            self::BANK => 'rgb(99 102 241)', // indigo-500
            self::DEPOSIT => 'rgb(8 145 178)', // cyan-500
        };
    }

    public function getLabelText(): string
    {
        return match ($this) {
            self::CASH => 'Cash',
            self::CHEQUE => 'Cheque',
            self::BANK => 'Bank',
            self::DEPOSIT => 'Deposit',
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
