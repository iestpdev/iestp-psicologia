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

    -- Info docente
    d.id AS docente_id,
    d.nombres AS docente_nombres,
    d.apellidos AS docente_apellidos,
    d.dni AS docente_dni,
    d.telefono AS docente_telefono,
    
    -- Info psicólogo
    p.id AS psicologo_id,
    p.nombres AS psicologo_nombres,
    p.apellidos AS psicologo_apellidos,
    p.dni AS psicologo_dni,
    p.telefono AS psicologo_telefono,
    
    -- Info administrador
    a.id AS administrador_id,
    a.nombres AS administrador_nombres,
    a.apellidos AS administrador_apellidos,
    a.dni AS administrador_dni,
    a.telefono AS administrador_telefono

FROM usuarios u
LEFT JOIN docentes d ON u.docente_id = d.id
LEFT JOIN psicologos p ON u.psicologo_id = p.id
LEFT JOIN administradores a ON u.administrador_id = a.id;
