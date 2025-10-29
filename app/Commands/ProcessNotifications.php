<?php

namespace App\Commands;

use App\Services\SmsService;
use CodeIgniter\CLI\BaseCommand;

class ProcessNotifications extends BaseCommand
{
    protected $group = 'Custom';
    protected $name = 'process:notifications';
    protected $description = 'Envía las notificaciones pendientes (SMS y correo).';

    public function run(array $params)
    {
        $db = \Config\Database::connect();
        $notifs = $db->table('notificaciones_pendientes')
            ->where('procesado', 0)
            ->get()
            ->getResultArray();

        if (empty($notifs)) {
            echo "Sin notificaciones pendientes.\n";
            return;
        }

        $sms = new SmsService();
        $email = service('emailService');

        foreach ($notifs as $n) {
            try {
                if ($n['tipo'] === 'SMS') {
                    $sms->sendSms($n['destinatario'], $n['mensaje']);
                } elseif ($n['tipo'] === 'EMAIL') {
                    $email->sendEmail($n['destinatario'], $n['asunto'], $n['mensaje']);
                }

                $db->table('notificaciones_pendientes')
                   ->where('id', $n['id'])
                   ->update(['procesado' => 1]);
            } catch (\Throwable $e) {
                log_message('error', "Error al enviar notificación ID {$n['id']}: " . $e->getMessage());
            }
        }

        echo "Notificaciones procesadas correctamente.\n";
    }
}
