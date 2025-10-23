<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Código de Verificación 2FA</title>
    <style>
        body { font-family: 'Arial', sans-serif; background-color: #f4f4f4; margin: 0; padding: 0; }
        .container { max-width: 600px; margin: 20px auto; background-color: #ffffff; border-radius: 8px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); overflow: hidden; }
        .header { background-color: #007bff; color: #ffffff; padding: 20px; text-align: center; }
        .content { padding: 30px; text-align: center; }
        .code-box { background-color: #e9ecef; color: #000; padding: 15px; border-radius: 6px; font-size: 24px; font-weight: bold; display: inline-block; margin: 20px 0; letter-spacing: 5px; }
        .footer { background-color: #f8f9fa; color: #6c757d; padding: 15px; text-align: center; font-size: 12px; border-top: 1px solid #dee2e6; }
        p { margin: 10px 0; color: #333; line-height: 1.5; }
        h1 { margin-top: 0; color: #ffffff; font-size: 24px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Verificación de Seguridad - IESTP Psicología</h1>
        </div>
        <div class="content">
            <p>Estimado/a <?= esc($nombres) ?>,</p>
            <p>Detectamos un intento de inicio de sesión en tu cuenta. Por favor, utiliza el siguiente código para completar la autenticación de dos factores (2FA):</p>
            
            <div class="code-box"><?= esc($code) ?></div>

            <p>Este código de seguridad **expirará en 5 minutos**.</p>
            <p>Si no solicitaste este código, por favor ignora este correo. Tu cuenta permanecerá segura.</p>
        </div>
        <div class="footer">
            IESTP Psicología - Sistema de Gestión de Consultas
        </div>
    </div>
</body>
</html>
