<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Appointment;
use Carbon\Carbon;
use App\Notifications\AppointmentReminder;
use App\Services\PushNotificationService;

class SendAppointmentReminders extends Command
{
    protected $signature = 'appointments:reminders';
    protected $description = 'Enviar recordatorio 1 día antes';

    public function handle(PushNotificationService $push)
    {
        $tomorrow = Carbon::tomorrow()->toDateString();

        $appointments = Appointment::with('pet.client')
            ->whereDate('appointment_date', $tomorrow)
            ->where('status', 'Pendiente')
            ->orderBy('appointment_date', 'asc')
            ->get()
            ->groupBy(function ($appointment) {
                return $appointment->pet->client->id;
            });

        foreach ($appointments as $clientAppointments) {

            $client = $clientAppointments->first()->pet->client;

            if (!$client || !$client->access_code) {
                continue;
            }

            // Agrupar citas por hora
            $groupedByHour = $clientAppointments->groupBy(function ($appointment) {
                return Carbon::parse($appointment->appointment_date)->format('g:i A');
            });

            $lines = [];

            foreach ($groupedByHour as $hour => $items) {

                $petNames = $items->pluck('pet.name')->toArray();

                $names = $this->formatPetNames($petNames);

                $lines[] = $names . ' a las ' . $hour;
            }

            // Mensaje profesional dinámico
            if (count($lines) === 1) {
                $message = 'Mañana tienes cita para ' . $lines[0];
            } else {
                $message = "Mañana tienes citas para:\n" . implode("\n", $lines);
            }

            $push->send(
                $client->access_code,
                '🐶 Recordatorio de cita',
                $message
            );
        }

        $this->info('Recordatorios enviados');
    
    }

    private function formatPetNames(array $names)
    {
        $count = count($names);

        if ($count === 1) {
            return $names[0];
        }

        if ($count === 2) {
            return $names[0] . ' y ' . $names[1];
        }

        $last = array_pop($names);

        return implode(', ', $names) . ' y ' . $last;
    }
}
