<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notificación de Cita Psicológica</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f4f4; margin: 0; padding: 0; }
        .container { max-width: 600px; margin: 20px auto; background-color: #ffffff; border-radius: 8px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05); overflow: hidden; }
        .header { background-color: #007bff; color: #ffffff; padding: 20px; text-align: center; }
        .header h1 { margin: 0; font-size: 24px; }
        .content { padding: 30px; line-height: 1.6; color: #333333; }
        .content p { margin-bottom: 15px; }
        .highlight { background-color: #fff3cd; padding: 15px; border-radius: 6px; margin: 20px 0; border-left: 5px solid #ffc107; color: #856404; }
        .highlight strong { color: #856404; }
        .details { background-color: #e9ecef; padding: 15px; border-radius: 6px; margin: 20px 0; }
        .footer { background-color: #e9ecef; color: #6c757d; padding: 15px; text-align: center; font-size: 12px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Citación al Área de Psicología IESTP</h1>
        </div>
        <div class="content">
            <p>Estimado(a) alumno(a) <strong><?= esc($data['alumno_nombre']) ?></strong>,</p>

            <p>Se le notifica que ha sido citado(a) para una sesión en el **Área de Psicología** de la institución.</p>
            
            <div class="highlight">
                <p><strong>IMPORTANTE:</strong> Por favor, asista puntualmente a su cita programada. Su presencia es fundamental para el seguimiento de su caso.</p>
            </div>

            <p>Los detalles de su cita son los siguientes:</p>
            
            <div class="details">
                <p><strong>Fecha de Cita:</strong> **<?= esc($data['atencion_fech']) ?>**</p>
                <p><strong>Hora Programada:</strong> **<?= esc($data['hora_inicio']) ?> - <?= esc($data['hora_fin']) ?>**</p>
                <p>(La información del psicólogo(a) y el lugar se le indicarán a su llegada).</p>
            </div>

            <p>Lo esperamos. Si tiene alguna duda, por favor contacte al área de Psicología.</p>
            
            <p>Atentamente,<br>Área de Psicología IESTP</p>
        </div>
        <div class="footer">
            Este es un correo automático del sistema IESTP Psicología.
        </div>
    </div>
</body>
</html>