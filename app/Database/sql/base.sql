CREATE DATABASE psycho;
USE psycho;

CREATE TABLE ci_sessions (
    id VARCHAR(128) NOT NULL,
    ip_address VARCHAR(45) NOT NULL,
    timestamp INT(10) UNSIGNED NOT NULL DEFAULT 0,
    data BLOB NOT NULL,
    PRIMARY KEY (id),
    KEY ci_sessions_timestamp (timestamp)
);

-- mantenimiento/*
CREATE TABLE estados_civiles(
	id						INT AUTO_INCREMENT PRIMARY KEY,
	nombre				VARCHAR(70) NOT NULL,
	created_at			DATETIME NULL,
	updated_at			DATETIME NULL,
	deleted_at			DATETIME NULL
)ENGINE=INNODB;

CREATE TABLE programas_estudios(
	id						INT AUTO_INCREMENT PRIMARY KEY,
	nombre				VARCHAR(70) NOT NULL,
	created_at			DATETIME NULL,
	updated_at			DATETIME NULL,
	deleted_at			DATETIME NULL
)ENGINE=INNODB;

CREATE TABLE religiones(
	id						INT AUTO_INCREMENT PRIMARY KEY,
	nombre				VARCHAR(70) NOT NULL,
	created_at			DATETIME NULL,
	updated_at			DATETIME NULL,
	deleted_at			DATETIME NULL
)ENGINE=INNODB;

CREATE TABLE parentescos(
	id						INT AUTO_INCREMENT PRIMARY KEY,
	nombre				VARCHAR(70) NOT NULL,
	created_at			DATETIME NULL,
	updated_at			DATETIME NULL,
	deleted_at			DATETIME NULL
)ENGINE=INNODB;
-- */mantenimiento

CREATE TABLE alumnos (
    id                  BIGINT AUTO_INCREMENT PRIMARY KEY,
    nombres             VARCHAR(70) NOT NULL,
    apellidos           VARCHAR(70) NOT NULL,
    dni                 CHAR(8) NOT NULL,
	email               VARCHAR(120) NOT NULL,
    telefono            VARCHAR(9) NULL,
    direccion_nac       TEXT NULL,
    fecha_nac           DATE NULL,
    domicilio           TEXT NULL,
    sexo                ENUM('M','F') NOT NULL,
    ciclo               ENUM('1','2','3','4','5','6') NOT NULL,
    turno               ENUM('M','T') NOT NULL,
    programa_estudio_id INT NOT NULL,
    religion_id			INT NULL,
    estado_civil_id	   INT NULL,
    created_at          DATETIME NULL,
    updated_at          DATETIME NULL,
    deleted_at          DATETIME NULL,
    FOREIGN KEY (programa_estudio_id) REFERENCES programas_estudios(id),
    FOREIGN KEY (religion_id) REFERENCES religiones(id),
    FOREIGN KEY (estado_civil_id) REFERENCES estados_civiles(id)
) ENGINE=INNODB;

/*
 //TODO: la relacion entre parientes y familiares está mal hecha :')
 */
CREATE TABLE parientes(
	id						BIGINT AUTO_INCREMENT PRIMARY KEY,
	nombres				VARCHAR(70) NOT NULL,
	apellidos			VARCHAR(70) NOT NULL,
	dni					CHAR(8) NULL,
	telefono				VARCHAR(9) NOT NULL,
	parentesco_id		INT NOT NULL,
	created_at			DATETIME NULL,
	updated_at			DATETIME NULL,
	deleted_at			DATETIME NULL,
	FOREIGN KEY (parentesco_id) REFERENCES parentescos(id)
)ENGINE=INNODB;

CREATE TABLE familiares(
	id						BIGINT AUTO_INCREMENT PRIMARY KEY,
	alumno_id			BIGINT NOT NULL,
	pariente_id			BIGINT NOT NULL,
	created_at			DATETIME NULL,
	updated_at			DATETIME NULL,
	deleted_at			DATETIME NULL,
	FOREIGN KEY (alumno_id) REFERENCES alumnos(id),
	FOREIGN KEY (pariente_id) REFERENCES parientes(id)
)ENGINE=INNODB;

CREATE TABLE personas(
	id						BIGINT AUTO_INCREMENT PRIMARY KEY,
	nombres				VARCHAR(70) NOT NULL,
	apellidos			VARCHAR(70) NOT NULL,
	dni               CHAR(8) NOT NULL,
   telefono          VARCHAR(9) NULL,
   created_at			DATETIME NULL,
	updated_at			DATETIME NULL,
	deleted_at			DATETIME NULL
)ENGINE=INNODB;

CREATE TABLE usuarios(
	id							BIGINT AUTO_INCREMENT PRIMARY KEY,
	correo_institucional VARCHAR(50) NOT NULL,
	username 				VARCHAR(18) NOT NULL,
   userpass 				TEXT NOT NULL,
   persona_id   		   BIGINT NOT NULL,
   rol             		ENUM('ADMIN', 'PSICOLOGO','DOCENTE'),
   estado					BOOLEAN DEFAULT TRUE,
	codigo_2fa 				VARCHAR(6) NULL,
   codigo_2fa_expira 	DATETIME NULL,
	created_at				DATETIME NULL,
	updated_at				DATETIME NULL,
	deleted_at				DATETIME NULL,
	FOREIGN KEY (persona_id) REFERENCES personas(id)			
)ENGINE=INNODB;

CREATE TABLE configuraciones(
	id							BIGINT AUTO_INCREMENT PRIMARY KEY,
	usuario_id				BIGINT NOT NULL,
	auth_SMS					BOOL DEFAULT FALSE,
	auth_email				BOOL DEFAULT FALSE,
	notif_email				BOOL DEFAULT FALSE,
	created_at				DATETIME NULL,
	updated_at				DATETIME NULL,
	deleted_at				DATETIME NULL,
	FOREIGN KEY (usuario_id) REFERENCES usuarios(id)
)ENGINE=INNODB;

CREATE TABLE derivaciones(
	id						BIGINT AUTO_INCREMENT PRIMARY KEY,
	usuario_id			BIGINT NOT NULL,
	alumno_id			BIGINT NOT NULL,
	motivo				TEXT NOT NULL,
	urgencia				ENUM('BAJA','MEDIA','ALTA') NOT NULL,
	recibido				BOOLEAN DEFAULT FALSE,
	created_at			DATETIME NULL,
	updated_at			DATETIME NULL,
	deleted_at			DATETIME NULL,
	FOREIGN KEY (usuario_id) REFERENCES usuarios(id),
	FOREIGN KEY (alumno_id) REFERENCES alumnos(id)
)ENGINE=INNODB;

CREATE TABLE citas(
	id						BIGINT AUTO_INCREMENT PRIMARY KEY,
	tipo_derivacion	ENUM('AUTONOMO','DOCENTE','FAMLIAR') NOT NULL,
	atencion_fech		DATE NOT NULL,
	hora_inicio			TIME NOT NULL,
	hora_fin				TIME NOT NULL,
	asistencia			ENUM('PENDIENTE','ASISTIDO', 'AUSENTE') NOT NULL,
	usuario_id			BIGINT NOT NULL,
	alumno_id			BIGINT NOT NULL,
	derivacion_id		BIGINT NULL,
	familiar_id			BIGINT NULL,
	motivo				TEXT NOT NULL,
	created_at			DATETIME NULL,
	updated_at			DATETIME NULL,
	deleted_at			DATETIME NULL,
	FOREIGN KEY (usuario_id) REFERENCES usuarios(id),
	FOREIGN KEY (alumno_id) REFERENCES alumnos(id),
	FOREIGN KEY (derivacion_id) REFERENCES derivaciones(id),
	FOREIGN KEY (familiar_id) REFERENCES familiares(id)
)ENGINE=INNODB;

CREATE TABLE detalle_cita(
	id						BIGINT AUTO_INCREMENT PRIMARY KEY,
	cita_id				BIGINT NOT NULL,
	problema				TEXT NULL,
	recomendacion		TEXT NULL,
	aspecto_fisico		TEXT NULL,
	aseo_personal		TEXT NULL,
	conducta				TEXT NULL,
	FOREIGN KEY (cita_id) REFERENCES citas(id)
)ENGINE=INNODB;

CREATE TABLE notificaciones(
	id                  BIGINT AUTO_INCREMENT PRIMARY KEY,
	tipoNotificacion    VARCHAR(50) NOT NULL,
	entidad				  VARCHAR(50) NOT NULL,
	emisor				  BIGINT NOT NULL,
	receptor				  BIGINT NULL,
	descripcion			  TEXT NOT NULL,
	leido					  BOOLEAN DEFAULT 0,
	created_at				DATETIME NULL,
	updated_at				DATETIME NULL,
	deleted_at				DATETIME NULL,
	FOREIGN KEY (emisor) REFERENCES usuarios(id),
	FOREIGN KEY (receptor) REFERENCES usuarios(id)
);