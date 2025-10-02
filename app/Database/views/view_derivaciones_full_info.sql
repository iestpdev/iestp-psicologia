CREATE OR REPLACE VIEW view_derivaciones_full_info AS
SELECT
    d.id,
    d.motivo,
    d.urgencia,
    d.recibido AS estado,
    d.created_at,
    d.updated_at,
    d.deleted_at,
    
    -- Info alumno
    a.id AS alumno_id,
    CONCAT(a.nombres, ' ', a.apellidos) AS alumno_nombres_completos,
    a.dni AS alumno_dni,
    
    -- Info usuario
    u.id AS usuario_id,
    u.correo_institucional AS usuario_correo,

    -- Info persona (docente)
    p.id AS persona_id,
    CONCAT(p.nombres, ' ', p.apellidos) AS docente_nombres_completos,
    p.dni AS docente_dni
    
FROM derivaciones AS d
LEFT JOIN alumnos AS a ON a.id = d.alumno_id
LEFT JOIN usuarios AS u ON u.id = d.usuario_id
LEFT JOIN personas AS p ON p.id = u.persona_id;