CREATE OR REPLACE VIEW view_alumnos_full_info AS
SELECT 
	a.id,
	a.dni,
	a.apellidos,
	a.nombres,
	a.ciclo,
	a.turno,
	a.created_at,
	a.updated_at,
	a.deleted_at,

	-- Info programa de estudio
	pe.id AS programa_estudio_id,
	pe.nombre AS programa_estudio,

	-- Info religión
	r.id AS religion_id,
	r.nombre AS religion,

	-- Info estado civil
	ec.id AS estado_civil_id,
	ec.nombre AS estado_civil

FROM alumnos AS a
LEFT JOIN programas_estudios pe ON pe.id = a.programa_estudio_id
LEFT JOIN religiones r ON r.id = a.religion_id
LEFT JOIN estados_civiles ec ON ec.id = a.estado_civil_id;