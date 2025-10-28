<?php

namespace Config;

use CodeIgniter\Config\BaseService;
use App\Services\EmailService;
use App\Services\SmsService;

/**
 * Configuración personalizada de servicios del sistema.
 *
 * Define instancias reutilizables (singleton) para servicios propios
 * como el envío de correos y mensajes SMS.
 *
 * @package Config
 */
class Services extends BaseService
{
    /**
     * Retorna una instancia del servicio de correo electrónico.
     *
     * @param bool $getShared Indica si se debe obtener la instancia compartida.
     * @return EmailService Instancia del servicio de correo.
     */
    public static function emailService(bool $getShared = true): EmailService
    {
        if ($getShared) {
            return static::getSharedInstance('emailService');
        }

        return new EmailService();
    }

    /**
     * Retorna una instancia del servicio de mensajería SMS.
     *
     * @param bool $getShared Indica si se debe obtener la instancia compartida.
     * @return SmsService Instancia del servicio SMS.
     */
    public static function smsService(bool $getShared = true): SmsService
    {
        if ($getShared) {
            return static::getSharedInstance('smsService');
        }

        return new SmsService();
    }
}