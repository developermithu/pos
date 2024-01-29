<?php

namespace App\Enums;

enum AttendanceStatus: string
{
    case PRESENT = 'present';
    case ABSENT = 'absent';

    public function isPresent(): bool
    {
        return $this === self::PRESENT;
    }

    public function isAbsent(): bool
    {
        return $this === self::ABSENT;
    }

    public function getLabelColor(): string
    {
        return match ($this) {
            self::PRESENT => '#059669', // success color
            self::ABSENT => 'rgb(239 68 68)', // danger color
        };
    }

    public function getLabelText(): string
    {
        return match ($this) {
            self::PRESENT => 'Present',
            self::ABSENT => 'Absent',
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
