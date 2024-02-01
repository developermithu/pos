<?php

namespace App\Enums;

enum ProductType: string
{
    case STANDARD = 'standard';
    case SERVICE = 'service';

    public static function forSelect(): array
    {
        return array_column(self::cases(), 'name', 'value');
    }

    public function isStandard(): bool
    {
        return $this === self::STANDARD;
    }

    public function isService(): bool
    {
        return $this === self::SERVICE;
    }

    public function getLabelTextColor(): string
    {
        return match ($this) {
            self::SERVICE => 'rgb(248 113 113)', // danger color
            self::STANDARD => 'rgb(34 197 94)', // success color
        };
    }

    public function getLabelBackgroundColor(): string
    {
        return match ($this) {
            self::SERVICE => 'rgb(254 242 242)', // danger color
            self::STANDARD => 'rgb(240 253 244)', // success color
        };
    }

    public function getLabelText(): string
    {
        return match ($this) {
            self::STANDARD => 'Standard',
            self::SERVICE => 'Service',
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
