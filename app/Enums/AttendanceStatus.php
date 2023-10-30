<?php

namespace App\Enums;

enum AttendanceStatus: string
{
    case PRESENT = 'present';
    case ABSENT = 'absent';
    case LEAVE = 'leave';

    public function isPresent(): bool
    {
        return $this === self::PRESENT;
    }

    public function isAbsent(): bool
    {
        return $this === self::ABSENT;
    }

    public function isLeave(): bool
    {
        return $this === self::LEAVE;
    }

    public function getLabelColor(): string
    {
        return match ($this) {
            self::PRESENT => '#059669', // success color
            self::ABSENT => 'rgb(239 68 68)', // danger color
            self::LEAVE => 'rgb(148 163 184)', // gray color
        };
    }

    public function getLabelText(): string
    {
        return match ($this) {
            self::PRESENT => 'Present',
            self::ABSENT => 'Absent',
            self::LEAVE => 'Leave',
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
