<?php

namespace App\Rules;

use App\Models\Cita;

class CitaRules
{
    private string $error = 'El horario de atención seleccionado ya está ocupado o se solapa con otra cita.';

    public function check_appointment_overlap(?string $horaInicio, ?string $field, array $data): bool
    {
        $fechaAtencion = $data['fecha_atencion'] ?? null;
        $usuarioId = $data['usuario_id'] ?? null;
        $horaFin = $data['hora_fin'] ?? null;
        $citaIdToIgnore = $data['id'] ?? null;

        if (empty($fechaAtencion) || empty($usuarioId) || empty($horaFin)) {
            $this->error = 'Faltan datos de la cita (fecha, psicólogo u hora).';
            return false;
        }

        $citaModel = new Cita();
        $builder = $citaModel->where('atencion_fech', $fechaAtencion)
                             ->where('usuario_id', $usuarioId)
                             ->where('deleted_at', null)
                             ->orderBy('hora_inicio', 'ASC');

        if (!empty($citaIdToIgnore)) $builder->where('id !=', $citaIdToIgnore);
        $existingCitas = $builder->findAll();
        if (empty($existingCitas)) return true;

        $newStartTime = strtotime($horaInicio);
        $newEndTime = strtotime($horaFin);

        foreach ($existingCitas as $cita) {
            $existingStartTime = strtotime($cita['hora_inicio']);
            $existingEndTime = strtotime($cita['hora_fin']);
            
            if ($newStartTime < $existingEndTime && $newEndTime > $existingStartTime) {
                $this->error = 'El horario seleccionado se cruza con una cita existente (' . $cita['hora_inicio'] . ' - ' . $cita['hora_fin'] . ').';
                return false;
            }
        }
        return true;
    }

    public function getError(): string
    {
        return $this->error;
    }
}