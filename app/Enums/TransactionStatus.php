<?php

namespace App\Enums;

enum TransactionStatus: string
{
    case PENDING = 'pending';
    case COMPLETED = 'completed';

    public function isPending(): bool
    {
        return $this === self::PENDING;
    }

    public function isCompleted(): bool
    {
        return $this === self::COMPLETED;
    }

    public function getLabelColor(): string
    {
        return match ($this) {
            self::PENDING => 'rgb(148 163 184)', // gray color
            self::COMPLETED => '#059669', // success color
        };
    }

    public function getLabelText(): string
    {
        return match ($this) {
            self::PENDING => 'Pending',
            self::COMPLETED => 'Completed',
        };
    }

    public function getLabelHTML(): string
    {
        return sprintf(
            '<span class="px-3 py-1 text-xs text-white rounded" style="background-color: %s;">%s</span>',
            $this->getLabelColor(),
            $this->getLabelText()
        );
    }
}
