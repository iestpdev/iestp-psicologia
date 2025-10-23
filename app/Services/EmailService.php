<?php

namespace App\Services;

use CodeIgniter\Email\Email;

/**
 * Servicio para el envío de correos electrónicos utilizando la configuración de CodeIgniter.
 * Se configura para usar SMTP de Gmail para la autenticación de 2 pasos (2FA).
 */
class EmailService
{
    /**
     * @var Email
     */
    protected $email;

    public function __construct()
    {
        $this->email = service('email');
    }

    /**
     * Envía un correo electrónico con el código de 2FA.
     *
     * @param string $to La dirección de correo del destinatario.
     * @param string $subject El asunto del correo.
     * @param string $message El contenido HTML o de texto del correo.
     * @return bool Retorna verdadero si el envío fue exitoso, falso en caso contrario.
     */
    public function sendEmail(string $to, string $subject, string $message): bool
    {
        try {
            $this->email->setTo($to);
            $this->email->setFrom(config('Email')->fromEmail, config('Email')->fromName);
            $this->email->setSubject($subject);
            $this->email->setMessage($message);
            $this->email->setMailType('html');

            // Intenta enviar el correo
            if ($this->email->send()) {
                // Éxito
                return true;
            } else {
                log_message('error', 'Fallo al enviar el correo a ' . $to . ': ' . $this->email->printDebugger(['headers']));
                return false;
            }
        } catch (\Exception $e) {
            log_message('critical', 'Error fatal al enviar correo: ' . $e->getMessage());
            return false;
        }
    }
}
