<?php

namespace App\Services;

use CodeIgniter\Email\Email;

/**
 * Servicio encargado del envío de correos electrónicos en el sistema IESTP Psicología.
 *
 * Esta clase actúa como una capa de abstracción sobre el servicio de correo de CodeIgniter,
 * facilitando el envío de correos mediante el protocolo SMTP (por defecto configurado para Gmail).
 *
 * Actualmente se utiliza principalmente para el envío de códigos de autenticación en dos pasos (2FA),
 * pero puede reutilizarse para otros fines de notificación.
 *
 * @package App\Services
 */
class EmailService
{
    /**
     * Instancia del servicio de correo de CodeIgniter.
     *
     * @var Email
     */
    protected $email;

    /**
     * Constructor: inicializa el servicio de correo utilizando la configuración definida en `Config\Email`.
     */
    public function __construct()
    {
        $this->email = service('email');
    }

    /**
     * Envía un correo electrónico utilizando la configuración SMTP del sistema.
     *
     * Este método configura los encabezados básicos (remitente, destinatario, asunto y tipo de contenido),
     * y gestiona tanto los errores de envío como las excepciones que puedan ocurrir durante el proceso.
     *
     * @param string $to       Dirección de correo del destinatario.
     * @param string $subject  Asunto del mensaje.
     * @param string $message  Contenido del correo (HTML o texto plano).
     *
     * @return bool Retorna `true` si el correo fue enviado correctamente, o `false` si ocurrió algún error.
     *
     * @example
     * ```php
     * $emailService = new \App\Services\EmailService();
     * $emailService->sendEmail(
     *     'usuario@dominio.com',
     *     'Código de verificación',
     *     '<p>Tu código es: <strong>123456</strong></p>'
     * );
     * ```
     */
    public function sendEmail(string $to, string $subject, string $message): bool
    {
        try {
            $this->email->setTo($to);
            $this->email->setFrom(config('Email')->fromEmail, config('Email')->fromName);
            $this->email->setSubject($subject);
            $this->email->setMessage($message);
            $this->email->setMailType('html');

            if ($this->email->send()) {
                return true;
            } else {
                log_message(
                    'error',
                    'Fallo al enviar el correo a ' . $to . ': ' .
                    $this->email->printDebugger(['headers'])
                );
                return false;
            }
        } catch (\Exception $e) {
            log_message('critical', 'Error fatal al enviar correo: ' . $e->getMessage());
            return false;
        }
    }
}