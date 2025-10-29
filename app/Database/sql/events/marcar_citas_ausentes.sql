DROP EVENT IF EXISTS marcar_citas_ausentes;
DELIMITER $$
CREATE EVENT marcar_citas_ausentes
STARTS TIMESTAMP(CURRENT_DATE, '00:30:00')
DO
BEGIN
    UPDATE citas
		SET 	asistencia = 'AUSENTE',
	    		updated_at = NOW()
		WHERE asistencia = 'PENDIENTE'
	  	AND deleted_at IS NULL
	  	AND atencion_fech < CURDATE();
	END$$
DELIMITER ;
