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

CREATE TABLE alumno_pariente(
	alumno_id			BIGINT NOT NULL,
	pariente_id			BIGINT NOT NULL,
	PRIMARY KEY(alumno_id, pariente_id),
	created_at			DATETIME NULL,
	updated_at			DATETIME NULL,
	deleted_at			DATETIME NULL,
	FOREIGN KEY (alumno_id) REFERENCES alumnos(id),
	FOREIGN KEY (pariente_id) REFERENCES parientes(id)
)ENGINE=INNODB;

CREATE TABLE docentes(
	id						BIGINT AUTO_INCREMENT PRIMARY KEY,
	nombres				VARCHAR(70) NOT NULL,
	apellidos			VARCHAR(70) NOT NULL,
	dni               CHAR(8) NOT NULL,
   telefono          VARCHAR(9) NULL,
   created_at			DATETIME NULL,
	updated_at			DATETIME NULL,
	deleted_at			DATETIME NULL
)ENGINE=INNODB;

CREATE TABLE derivaciones(
	id						BIGINT AUTO_INCREMENT PRIMARY KEY,
	docente_id			BIGINT NOT NULL,
	alumno_id			BIGINT NOT NULL,
	motivo				TEXT NOT NULL,
	urgencia				ENUM('1','2','3') NOT NULL,
	recibido				BOOLEAN DEFAULT FALSE,
	created_at			DATETIME NULL,
	updated_at			DATETIME NULL,
	deleted_at			DATETIME NULL,
	FOREIGN KEY (docente_id) REFERENCES docentes(id),
	FOREIGN KEY (alumno_id) REFERENCES alumnos(id)
)ENGINE=INNODB;

CREATE TABLE psicologos(
	id						BIGINT AUTO_INCREMENT PRIMARY KEY,
	nombres				VARCHAR(70) NOT NULL,
	apellidos			VARCHAR(70) NOT NULL,
	dni               CHAR(8) NOT NULL,
   telefono          VARCHAR(9) NULL,
   created_at			DATETIME NULL,
	updated_at			DATETIME NULL,
	deleted_at			DATETIME NULL
)ENGINE=INNODB;

CREATE TABLE citas(
	id						BIGINT AUTO_INCREMENT PRIMARY KEY,
	tipo_derivacion	ENUM('AUTONOMO','DOCENTE','PARIENTE') NOT NULL,
	atencion_fech		DATE NULL,
	hora_inicio			TIME NOT NULL,
	hora_fin				TIME NOT NULL,
	asistencia			ENUM('PENDIENTE','ASISTIDO', 'AUSENTE') NOT NULL,
	psicologo_id		BIGINT NOT NULL,
	alumno_id			BIGINT NULL,
	derivacion_id		BIGINT NULL,
	created_at			DATETIME NULL,
	updated_at			DATETIME NULL,
	deleted_at			DATETIME NULL,
	FOREIGN KEY (psicologo_id) REFERENCES psicologos(id),
	FOREIGN KEY (alumno_id) REFERENCES alumnos(id),
	FOREIGN KEY (derivacion_id) REFERENCES derivaciones(id)
)ENGINE=INNODB;

CREATE TABLE detalle_cita(
	id						BIGINT AUTO_INCREMENT PRIMARY KEY,
	cita_id				BIGINT NOT NULL,
	motivo				VARCHAR(255) NOT NULL,
	problema				VARCHAR(255) NULL,
	recomendacion		VARCHAR(255) NULL,
	aspecto_fisico		VARCHAR(255) NULL,
	aseo_personal		VARCHAR(255) NULL,
	conducta				VARCHAR(255) NULL,
	FOREIGN KEY (cita_id) REFERENCES citas(id)
)ENGINE=INNODB;

CREATE TABLE diagnosticos(
	id						BIGINT AUTO_INCREMENT PRIMARY KEY,
	cita_id				BIGINT NOT NULL,
	condicion_code		VARCHAR(20) NULL,
	analisis				TEXT NOT NULL,
	created_at			DATETIME NULL,
	updated_at			DATETIME NULL,
	deleted_at			DATETIME NULL,
	FOREIGN KEY (cita_id) REFERENCES citas(id)
)ENGINE=INNODB;

CREATE TABLE usuarios(
	id							BIGINT AUTO_INCREMENT PRIMARY KEY,
	correo_institucional VARCHAR(50) NOT NULL,
	username 				VARCHAR(18) NOT NULL,
   userpass 				TEXT NOT NULL,
   docente_id				BIGINT NULL,
   psicologo_id			BIGINT NULL,
   es_admin					BOOLEAN DEFAULT FALSE,
   estado					BOOLEAN DEFAULT TRUE,
	created_at				DATETIME NULL,
	updated_at				DATETIME NULL,
	deleted_at				DATETIME NULL,
	FOREIGN KEY (docente_id) REFERENCES docentes(id),
	FOREIGN KEY (psicologo_id) REFERENCES psicologos(id)							
)ENGINE=INNODB;