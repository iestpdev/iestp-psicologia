<?php

use App\Models\Usuario;

/**
 * Inicia el proceso de Autenticación en Dos Factores (2FA).
 *
 * Genera un código temporal, lo almacena en el usuario y lo envía por correo.
 *
 * @param array $usuarioData Datos del usuario (requiere al menos 'id' y 'correo_institucional').
 * @return bool True si el código se genera, guarda y envía correctamente; False en caso contrario.
 */
function autenticacion2FA(array $usuarioData): bool
{
    if (empty($usuarioData['correo_institucional'])) {
        log_message('error', 'El usuario ID ' . ($usuarioData['id'] ?? 'N/A') . ' no tiene correo institucional.');
        return false;
    }

    $code2FA = random_int(100000, 999999);
    $expirationTime = time() + (5 * 60); // 5 minutos

    $usuarioModel = new Usuario();
    $updateData = [
        'codigo_2fa'        => (string)$code2FA,
        'codigo_2fa_expira' => date('Y-m-d H:i:s', $expirationTime),
    ];

    if (!$usuarioModel->update($usuarioData['id'], $updateData)) {
        log_message('error', "No se pudo actualizar el código 2FA del usuario ID {$usuarioData['id']}.");
        return false;
    }

    $emailService = service('emailService');
    if (!$emailService) {
        log_message('critical', 'No se pudo cargar el servicio de correo.');
        return false;
    }

    $subject = 'Código de Verificación 2FA - IESTP Psicología';
    $message = view('modules/auth/email_2fa_template', [
        'code'    => $code2FA,
        'nombres' => $usuarioData['nombres'] ?? 'Usuario',
    ]);

    if (!$emailService->sendEmail($usuarioData['correo_institucional'], $subject, $message)) {
        log_message('error', 'Error al enviar correo 2FA a ' . $usuarioData['correo_institucional']);
        return false;
    }

    session()->set('temp_user_id', $usuarioData['id']);
    return true;
}