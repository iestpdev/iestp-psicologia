CREATE OR REPLACE VIEW view_usuario_full_info AS
SELECT 
    u.id,
    u.correo_institucional,
    u.username,
    u.rol,
    u.estado,
    u.created_at,
    u.updated_at,
    u.deleted_at,

    -- Info Persona
    p.id AS persona_id,
    CONCAT(p.nombres, ' ', p.apellidos) AS persona_nombres_completos,
    p.dni,
    p.telefono

FROM usuarios u
LEFT JOIN personas p ON u.persona_id = p.id;
