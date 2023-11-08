<?php

namespace App\Enums;

enum SaleStatus: string
{
    case PENDING = 'pending';
    case PROCESSING = 'processing';
    case CANCELLED = 'cancelled';
    case COMPLETED = 'completed';

    public function isPending(): bool
    {
        return $this === self::PENDING;
    }

    public function isProcessing(): bool
    {
        return $this === self::PROCESSING;
    }

    public function isCancelled(): bool
    {
        return $this === self::CANCELLED;
    }

    public function isCompleted(): bool
    {
        return $this === self::COMPLETED;
    }

    public function getLabelColor(): string
    {
        return match ($this) {
            self::PENDING => 'rgb(148 163 184)', // gray color
            self::PROCESSING => '#5D00BB', // primary color
            self::CANCELLED => 'rgb(239 68 68)', // danger color
            self::COMPLETED => '#059669', // success color
        };
    }

    public function getLabelText(): string
    {
        return match ($this) {
            self::PENDING => 'Pending',
            self::PROCESSING => 'Processing',
            self::CANCELLED => 'Cancelled',
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
