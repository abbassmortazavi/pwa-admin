<?php

namespace App\Enums;

use App\Models\Appointment;

enum AppointmentStatus: int
{
    case SCHEDULED = 1;
    case CONFIRMED = 2;
    case CANCELED = 3;

    public function color(): string
    {
        return match ($this) {
            AppointmentStatus::SCHEDULED => 'primary',
            AppointmentStatus::CANCELED => 'danger',
            AppointmentStatus::CONFIRMED => 'success',
        };
    }
}
