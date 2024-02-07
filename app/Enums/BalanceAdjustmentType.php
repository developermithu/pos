<?php

namespace App\Enums;

enum BalanceAdjustmentType: string
{
    case AddBalance = 'add balance';
    case RemoveBalance = 'remove balance';

    public function isAddBalance(): bool
    {
        return $this === self::AddBalance;
    }

    public function isRemoveBalance(): bool
    {
        return $this === self::RemoveBalance;
    }

    public function getLabelTextColor(): string
    {
        return match ($this) {
            self::RemoveBalance => 'rgb(248 113 113)', // danger color
            self::AddBalance => 'rgb(34 197 94)', // success color
        };
    }

    public function getLabelBackgroundColor(): string
    {
        return match ($this) {
            self::RemoveBalance => 'rgb(254 242 242)', // danger color
            self::AddBalance => 'rgb(240 253 244)', // success color
        };
    }

    public function getLabelText(): string
    {
        return match ($this) {
            self::AddBalance => 'Add Balance',
            self::RemoveBalance => 'Remove Balance',
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
