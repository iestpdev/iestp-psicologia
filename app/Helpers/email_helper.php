<?php

use App\Models\Usuario;

/**
 * Función que inicia el proceso de Autenticación de Dos Factores (2FA).
 * Genera un código, lo guarda en el usuario y envía el correo.
 *
 * @param array $usuarioData El registro completo del usuario. Debe contener 'id' y 'correo_institucional'.
 * @return bool True si el proceso fue exitoso (código guardado y correo enviado), False en caso contrario.
 */
function autenticacion2FA(array $usuarioData): bool
{
    // Validar que el usuario tenga un email registrado. (Usando 'correo_institucional' como indicas)
    if (!isset($usuarioData['correo_institucional']) || empty($usuarioData['correo_institucional'])) {
        log_message('error', 'El usuario ID ' . ($usuarioData['id'] ?? 'N/A') . ' no tiene un correo electrónico para 2FA.');
        return false;
    }

    // Generar el código de 6 dígitos
    $code2FA = random_int(100000, 999999);

    // Establecer el tiempo de expiración (5 minutos a partir de ahora)
    $expirationTime = time() + (5 * 60);

    // Actualizar el registro del usuario con el código y expiración
    $usuarioModel = new Usuario();
    $updateData = [
        'codigo_2fa'        => (string)$code2FA, // Aseguramos que sea string para VARCHAR
        'codigo_2fa_expira' => date('Y-m-d H:i:s', $expirationTime),
    ];

    if (!$usuarioModel->update($usuarioData['id'], $updateData)) {
        log_message('error', 'Fallo al actualizar el código 2FA para el usuario ID ' . $usuarioData['id']);
        return false;
    }

    $emailService = service('emailService');
    if ($emailService === null) {
        log_message('critical', 'El servicio de correo (\App\Services\EmailService) no se pudo cargar.');
        return false;
    }

    $subject = 'Código de Verificación 2FA IESTP Psicología';
    $message = view('modules/auth/email_2fa_template', [
        'code'    => $code2FA,
        'nombres' => $usuarioData['nombres'] ?? 'Usuario',
    ]);

    $recipient = $usuarioData['correo_institucional'];

    if (!$emailService->sendEmail($recipient, $subject, $message)) {
        log_message('error', 'Fallo en el envío del correo 2FA para ' . $recipient);
        return false;
    }

    // Almacenar temporalmente el ID del usuario en sesión
    session()->set('temp_user_id', $usuarioData['id']);

    return true;
}