<?php

namespace App\Argument;

use App\Entity\Appointments;
use App\Entity\Users;

final class UsersAppointmentsArgument
{
    private bool $isAttended;

    public function __construct(
        private Users $doctor,
        private Users $patient,
        private Appointments $appointment
    )
    {
        $this->isAttended = false;
    }

    public function getDoctor(): Users
    {
        return $this->doctor;
    }

    public function getPatient(): Users
    {
        return $this->patient;
    }

    public function getAppointment(): Appointments
    {
        return $this->appointment;
    }

    public function getAttended(): bool
    {
        return $this->isAttended;
    }
}
