<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Derivación Recibida y Programación de Cita</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f4f4; margin: 0; padding: 0; }
        .container { max-width: 600px; margin: 20px auto; background-color: #ffffff; border-radius: 8px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05); overflow: hidden; }
        .header { background-color: #007bff; color: #ffffff; padding: 20px; text-align: center; }
        .header h1 { margin: 0; font-size: 24px; }
        .content { padding: 30px; line-height: 1.6; color: #333333; }
        .content p { margin-bottom: 15px; }
        .highlight { background-color: #e9ecef; padding: 15px; border-radius: 6px; margin: 20px 0; border-left: 5px solid #007bff; }
        .highlight strong { color: #007bff; }
        .footer { background-color: #e9ecef; color: #6c757d; padding: 15px; text-align: center; font-size: 12px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>IESTP Psicología - Derivación Recibida</h1>
        </div>
        <div class="content">
            <p>Estimado(a) <strong><?= esc($data['derivador_nombre']) ?></strong>,</p>

            <p>Le confirmamos que la derivación del alumno(a) **<?= esc($data['alumno_nombre']) ?>** ha sido **recibida y procesada** por el área de Psicología.</p>

            <p>El(la) psicólogo(a) encargado(a) de la atención ha programado la cita de la siguiente manera:</p>

            <div class="highlight">
                <p><strong>Psicólogo(a) Asignado:</strong> <?= esc($data['psicologo_nombre']) ?></p>
                <p><strong>Fecha de Cita:</strong> **<?= esc($data['atencion_fech']) ?>**</p>
                <p><strong>Hora Programada:</strong> **<?= esc($data['hora_inicio']) ?> - <?= esc($data['hora_fin']) ?>**</p>
                <p><strong>Motivo de la Derivación:</strong> <?= esc($data['motivo']) ?></p>
            </div>

            <p>Le agradecemos su colaboración en el proceso. En caso de requerir más información, puede contactarse con el área de Psicología.</p>
            
            <p>Atentamente,<br>Área de Psicología IESTP</p>
        </div>
        <div class="footer">
            Este es un correo automático. Por favor, no responda a este mensaje.
        </div>
    </div>
</body>
</html>