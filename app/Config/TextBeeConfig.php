<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

/**
 * Configuración para el servicio de envío de SMS (TextBee.dev).
 *
 * Define los parámetros necesarios (ID de dispositivo, clave API, URL del endpoint)
 * para enviar SMS mediante el servicio TextBee.
 *
 * @package Config
 */
class TextBeeConfig extends BaseConfig
{
    /**
     * ID del dispositivo registrado en TextBee.
     *
     * @var string
     */
    public string $deviceId = '';

    /**
     * Clave de API proporcionada por TextBee para autenticación.
     *
     * @var string
     */
    public string $apiKey = '';

    /**
     * URL base de la API de TextBee para envío de SMS.
     *
     * @var string
     */
    public string $apiUrl = '';

    /**
     * Constructor que toma valores desde variables de entorno y configura la URL de envío.
     */
    public function __construct()
    {
        parent::__construct();

        $this->deviceId = env('textbee.deviceId', '');
        $this->apiKey   = env('textbee.apiKey', '');
        $this->apiUrl   = "https://api.textbee.dev/api/v1/gateway/devices/{$this->deviceId}/send-sms";
    }
}