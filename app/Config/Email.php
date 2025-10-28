<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

/**
 * Configuración de correo electrónico para la aplicación.
 *
 * Define los parámetros necesarios para enviar correos a través de SMTP u otros protocolos.
 * Los valores pueden ser sobreescritos mediante variables de entorno en el archivo `.env`.
 *
 * @package Config
 */
class Email extends BaseConfig
{
    /** @var string Correo electrónico del remitente por defecto. */
    public string $fromEmail  = '';

    /** @var string Nombre del remitente por defecto. */
    public string $fromName   = '';

    /** @var string Destinatarios predefinidos (usualmente vacío). */
    public string $recipients = '';

    /** @var string Nombre del agente de usuario usado en el encabezado. */
    public string $userAgent = 'CodeIgniter';

    /** @var string Protocolo usado para el envío de correos (smtp, mail, sendmail). */
    public string $protocol = 'smtp';

    /** @var string Ruta al ejecutable de sendmail (si aplica). */
    public string $mailPath = '/usr/sbin/sendmail';

    /** @var string Host del servidor SMTP. */
    public string $SMTPHost;

    /** @var string Usuario SMTP. */
    public string $SMTPUser;

    /** @var string Contraseña del usuario SMTP. */
    public string $SMTPPass;

    /** @var int Puerto del servidor SMTP. */
    public int $SMTPPort;

    /** @var string Tipo de cifrado (tls, ssl o vacío). */
    public string $SMTPCrypto;

    /** @var int Tiempo máximo de espera en segundos para conexión SMTP. */
    public int $SMTPTimeout = 5;

    /** @var bool Indica si debe mantener la conexión SMTP activa. */
    public bool $SMTPKeepAlive = false;

    /** @var bool Habilita el ajuste automático de línea. */
    public bool $wordWrap = true;

    /** @var int Número máximo de caracteres por línea al ajustar texto. */
    public int $wrapChars = 76;

    /** @var string Tipo de contenido del correo (text o html). */
    public string $mailType = 'html';

    /** @var string Codificación de caracteres usada en los correos. */
    public string $charset = 'UTF-8';

    /** @var bool Indica si debe validarse la dirección de correo. */
    public bool $validate = false;

    /** @var int Prioridad del correo (1 = alta, 5 = baja). */
    public int $priority = 3;

    /** @var string Carácter CRLF usado en los encabezados. */
    public string $CRLF = "\r\n";

    /** @var string Nueva línea usada en los encabezados. */
    public string $newline = "\r\n";

    /** @var bool Habilita el modo de envío por lotes (BCC). */
    public bool $BCCBatchMode = false;

    /** @var int Cantidad máxima de correos por lote si BCC está activado. */
    public int $BCCBatchSize = 200;

    /** @var bool Habilita notificaciones de entrega (Delivery Status Notification). */
    public bool $DSN = false;

    /**
     * Constructor de configuración de correo.
     *
     * Carga los valores desde variables de entorno o aplica valores por defecto.
     */
    public function __construct()
    {
        parent::__construct();

        $this->fromEmail  = env('email.fromEmail', 'default@example.com');
        $this->fromName   = env('email.fromName', 'IESTP Psicología');

        $this->SMTPHost   = env('email.SMTPHost', 'smtp.gmail.com');
        $this->SMTPUser   = env('email.SMTPUser', '');
        $this->SMTPPass   = env('email.SMTPPass', '');
        $this->SMTPPort   = (int) env('email.SMTPPort', 587);
        $this->SMTPCrypto = env('email.SMTPCrypto', 'tls');
    }
}