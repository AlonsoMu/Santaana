USE dbsa;

-- G) CREACIÓN DE PROCEDIMIENTOS ALMACENADOS
-- ---------------
-- COLABORADOES --
-- ---------------
-- 1.0. INICIAR SESIÓN
DELIMITER $$
CREATE PROCEDURE spu_colaborador_login(IN _nombreusuario VARCHAR(70))
BEGIN
	SELECT
		PER.idpersona,
		COL.idcolaborador,
		PER.apepaterno,
		PER.apematerno,
		PER.nombres,
		COL.nombreusuario,
		COL.claveacceso,
		CASE
			WHEN COL.nivelacceso = 'DIR' THEN 'DIRECTOR'
			WHEN COL.nivelacceso = 'SUB' THEN 'SUBDIRECTOR(A)'
			WHEN COL.nivelacceso = 'DOC' THEN 'DOCENTE'
			WHEN COL.nivelacceso = 'AUX' THEN 'AUXILIAR'
			WHEN COL.nivelacceso = 'APO' THEN 'APODERADO'
		END 'nivelacceso'
	FROM personas PER
		INNER JOIN colaboradores COL ON PER.idpersona = COL.idpersona_fk
		WHERE
			(COL.nombreusuario = _nombreusuario OR PER.email = _nombreusuario)	AND
			COL.estado = '1';
END $$


-- 1.1. OBTENER TURNO DE LA BD Y COMPARARLO AL MOMENTO DE MARCARLO EN EL INICIO DE SESIÓN
DELIMITER $$
CREATE PROCEDURE spu_turno_obtener(IN _turno CHAR(1))
BEGIN
	SELECT
		PRD.idperiodo,
		CASE
			WHEN HOR.turno = 'M' THEN 'Mañana'
			WHEN HOR.turno = 'T' THEN 'Tarde'
		END 'turno',
		HOR.horaentrada,
		HOR.horasalida,
		HOR.toleranciamin
	FROM horarios HOR
		INNER JOIN periodos PRD ON PRD.idperiodo = HOR.idperiodo_fk
		WHERE
			PRD.anio = YEAR(NOW()) 	AND
			HOR.turno = _turno 			AND
			HOR.estado = '1';
END $$


-- 1.2. BUSCAR COLABORADOR QUE OLVIDÓ SU CONTRASEÑA
DELIMITER $$
CREATE PROCEDURE spu_colaborador_buscar(IN _nombreusuario VARCHAR(70))
BEGIN
	SELECT
		COL.idcolaborador,
		PER.apepaterno,
		PER.apematerno,
		PER.nombres,
		PER.email
	FROM colaboradores COL
		INNER JOIN personas PER ON COL.idpersona_fk = PER.idpersona
		WHERE
			COL.nombreusuario = _nombreusuario 	AND
			COL.estado = '1';
END $$


-- 1.3. REGISTRAR CLAVE DE RECUPERACIÓN
DELIMITER $$
CREATE PROCEDURE spu_desbloqueo_registrar
(
	IN _idcolaborador_fk	INT,
	IN _email							VARCHAR(120),
	IN _clavegenerada			CHAR(4)
)
BEGIN
	UPDATE desbloqueos SET estado = '0'
		WHERE idcolaborador_fk = _idcolaborador_fk;
	
	INSERT INTO desbloqueos (idcolaborador_fk, email, clavegenerada)
		VALUES(_idcolaborador_fk, _email, _clavegenerada);
END $$


-- 1.4. VALIDAR TIEMPO (15 MINUTOS)
DELIMITER $$
CREATE PROCEDURE spu_colaborador_validartiempo(IN _idcolaborador_fk INT)
BEGIN
	IF((SELECT COUNT(*) FROM desbloqueos WHERE idcolaborador_fk = _idcolaborador_fk) = 0) THEN
		SELECT 'GENERAR' AS 'status';
	ELSE
		-- Buscamos el ultimo estado vigente del usuario no importa si es 0 o 1 
		IF ((SELECT estado FROM desbloqueos WHERE idcolaborador_fk = _idcolaborador_fk ORDER BY 1 DESC LIMIT 1) = 0) THEN
			SELECT 'GENERAR' AS 'status';
		ELSE
			-- En esta seccion el ultimo registro es '1' no sabemos si esta dentro de los 15 min permitidos (TIENE ESTADO)
			IF
			(
				(
				-- SI NO ESTÁ DENTRO DE LOS 15 MINUTOS ENTONCES EL RESULTADO ES '1'
				SELECT COUNT(*) FROM desbloqueos 
				WHERE idcolaborador_fk = _idcolaborador_fk AND estado = '1' AND NOW() NOT BETWEEN fechageneracion AND DATE_ADD(fechageneracion,INTERVAL 15 MINUTE)
				ORDER BY fechageneracion DESC LIMIT 1
				) = 1
			)THEN
			-- El usuario tiene estado 1, pero esta afuera de los 15 minutos
				SELECT 'GENERAR' AS 'status';
			-- NO TIENE ESTADO
			ELSE
				SELECT 'DENEGAR' AS 'status';
			END IF;
		END IF;
	END IF;
END $$


-- 1.5. VALIDAR CLAVE INGRESADA POR EL COLABORADOR
DELIMITER $$
CREATE PROCEDURE spu_colaborador_validarclave
(
	IN _idcolaborador_fk 	INT,
	IN _clavegenerada			CHAR(4)
)
BEGIN 
	IF
	(
		(
		SELECT clavegenerada FROM desbloqueos
		WHERE idcolaborador_fk = _idcolaborador_fk AND estado = '1'
		LIMIT 1
		) = _clavegenerada
	)
	THEN
		SELECT 'PERMITIDO' AS 'status';
	ELSE
		SELECT 'DENEGADO' AS 'status';
	END IF;
END $$


-- 1.6. PROCEDIMIENTO QUE FINALMENTE ACTUALIZARA LA CLAVE DESPUES DE TODAS LAS VALIDACIONES
DELIMITER $$
CREATE PROCEDURE spu_colaborador_actualizarclave
(
	IN _idcolaborador	INT,
	IN _claveacceso		VARCHAR(100)
)
BEGIN
	UPDATE colaboradores SET claveacceso = _claveacceso
		WHERE idcolaborador = _idcolaborador;
	
	UPDATE desbloqueos SET estado = '0'
		WHERE idcolaborador_fk = _idcolaborador;
END $$


-- --------------------
-- MÓDULO ASISTENCIA --
-- --------------------
-- 2.0. OBTENER DATOS DE LA ALUMNA AL INGRESAR DNI/ESCANEAR EL CÓDIGO DE BARRAS
DELIMITER $$
CREATE PROCEDURE spu_alumna_obtener(IN _nrodocumento VARCHAR(9))
BEGIN
	SELECT
		MAT.idmatricula,
		PER.nrodocumento,
		PER.apepaterno, 
		PER.apematerno, 
		PER.nombres, 
		PER.fotografia,
		GRU.grado,
		GRU.seccion,
		HOR.turno
	FROM personas PER
		INNER JOIN matriculas MAT ON PER.idpersona = MAT.idalumna_fk
		INNER JOIN grupos GRU ON GRU.idgrupo = MAT.idgrupo_fk
		INNER JOIN horarios HOR ON HOR.idhorario = GRU.idhorario_fk
		INNER JOIN periodos PRD ON PRD.idperiodo = HOR.idperiodo_fk
		WHERE 	
			PER.nrodocumento = _nrodocumento 	AND 
			MAT.estado = 'A'									AND
			PRD.anio = YEAR(NOW());
END $$


-- 2.1. REGISTRAR ASISTENCIA LUEGO DE ENCONTRAR AL ALUMNA POR SU DNI
DELIMITER $$
CREATE PROCEDURE spu_asistencia_registrar(IN _idmatricula_fk INT)
BEGIN
	DECLARE _horaentrada TIME;
	DECLARE _horasalida TIME;
	
	SET _horaentrada = (SELECT horaentrada FROM v_horarios_listar WHERE idmatricula = _idmatricula_fk);
	SET _horasalida = (SELECT horasalida FROM v_horarios_listar WHERE idmatricula = _idmatricula_fk);
	
	-- SI LA HORA ACTUAL NO ESTÁ ENTRE LA HORA ENTRADA Y LA HORA SALIDA
	-- ENTONCES NO PUEDE MARCAR ASISTENCIA | AUSENTE
	IF (CURTIME() NOT BETWEEN (DATE_ADD(_horaentrada, INTERVAL -20 MINUTE)) AND (DATE_ADD(_horasalida, INTERVAL 30 MINUTE))) THEN
		SELECT 'Ausente' AS 'status';
	ELSE
		-- ESTAMOS ENTRE LA HORA DE ENTRADA Y HORA DE SALIDA
		-- SI LA ALUMNA NO ESTÁ EN LA LISTA DE LAS QUE YA REGISTRARON SU ASISTENCIA,
		-- ENTONCES MARCAR ASISTENCIA (INSERT)
		IF ((SELECT COUNT(*) FROM v_asistencia_listar WHERE idmatricula = _idmatricula_fk) = 0) THEN
			SELECT 'Entrada' AS 'status';
			
			IF (CURTIME() BETWEEN (DATE_ADD(_horaentrada, INTERVAL -20 MINUTE)) AND (DATE_ADD(_horaentrada, INTERVAL 25 MINUTE))) THEN
				INSERT INTO asistencias (idmatricula_fk)
					VALUES (_idmatricula_fk);
					
				SELECT 'Puntual' AS 'status';
			ELSE
				INSERT INTO asistencias (idmatricula_fk, estado)
					VALUES (_idmatricula_fk, 'T');
				
				SELECT 'Tardanza' AS 'status';
			END IF;
		ELSE
			-- LA ALUMNA YA MARCÓ ASISTENCIA (ENTRADA) PERO NO SABEMOS SI YA HAN PASADO 4h PARA PODER MARCAR SALIDA
			-- VERIFICAMOS QUE HAYAN PASADO 4h
			IF (TIMEDIFF(CURTIME(), _horaentrada) >= '05:00:00') THEN
				SELECT 'Salida' AS 'status';
				-- SI YA HAN PASADO 4h ENTONCES MARCAR SALIDA (UPDATE)
				UPDATE asistencias SET horasalidaalu = CURTIME()
					WHERE idmatricula_fk = _idmatricula_fk AND fecharegistro = CURDATE();
			END IF;
			
			SELECT 'Verificar' AS 'status';
		END IF;
	END IF;	
END $$


-- 2.2. LISTAR ASISTENCIAS DE ALUMNAS POR HORA DE INGRESO
DELIMITER $$
CREATE PROCEDURE spu_asistencia_listar()
BEGIN
	SELECT
		MAT.idmatricula,
		PER.nombres,
		ASI.horaentradaalu,
		ASI.horasalidaalu,
		CASE
				WHEN ASI.estado = 'P' THEN 'Puntual'
				WHEN ASI.estado = 'T' THEN 'Tardanza'
				ELSE 'Ausente'
		END AS estado
	FROM asistencias ASI
		INNER JOIN matriculas MAT ON MAT.idmatricula = ASI.idmatricula_fk
		INNER JOIN personas PER ON PER.idpersona = MAT.idalumna_fk
		WHERE
			ASI.fecharegistro = CURDATE() 	AND
			MAT.estado = 'A'								AND
			PER.estado = '1'
		ORDER BY ASI.horaentradaalu DESC
		LIMIT 14;
END $$


-- 2.3. BUSCAR ALUMNA EN LA LISTA PARA SABER SI ES QUE ASISTIÓ ESE DÍA
DELIMITER $$
CREATE PROCEDURE spu_alumna_buscar(IN _nombres VARCHAR(50))
BEGIN
	SELECT
		idmatricula,
		apepaterno, 
		apematerno, 
		nombres,
		grado,
		seccion,
		horaentradaalu
	FROM v_asistencia_listar
		WHERE nombres LIKE CONCAT('%',_nombres,'%');
END $$


-- ---------------------
-- MÓDULO ESTUDIANTES --
-- ---------------------
-- A) MATRÍCULA
-- 3.0. LISTAR LOS UBIGEOS
DELIMITER $$
CREATE PROCEDURE spu_ubigeos_listar()
BEGIN
	SELECT * FROM ubigeos;
END $$


-- 3.1. LISTAR GRADOS
DELIMITER $$
CREATE PROCEDURE spu_grado_listar()
BEGIN
	SELECT
		grado
	FROM grupos
		WHERE estado = '1'
		GROUP BY grado;
END $$


-- 3.2. LISTAR SECCIONES AL ELEGIR UN GRADO
DELIMITER $$
CREATE PROCEDURE spu_seccion_listar(IN _grado CHAR(1))
BEGIN
	SELECT
		seccion
	FROM grupos
		WHERE
			grado = _grado	AND
			estado = '1';
END $$


-- 3.3. OBTENER AULA AL ELEGIR GRADO Y SECCIÓN
DELIMITER $$
CREATE PROCEDURE spu_aula_obtener
(
	IN _grado 	CHAR(1),
	IN _seccion CHAR(1)
)
BEGIN
	SELECT 
		idgrupo
	FROM grupos
		WHERE
			grado = _grado			AND
			seccion = _seccion	AND
			estado = '1';
END $$


-- 3.4. REGISTRAR Y MATRICULAR A UNA ESTUDIANTE
DELIMITER $$
CREATE PROCEDURE spu_alumna_matricular
(
	IN _idubigeo_fk		INT,
	IN _tipodocumento	CHAR(1),
	IN _nrodocumento	CHAR(9),
	IN _fechanac			DATE,
	IN _apepaterno		VARCHAR(50),
	IN _apematerno		VARCHAR(50),
	IN _nombres				VARCHAR(50),
	IN _direccion			VARCHAR(100),
	IN _telefono			CHAR(9),
	IN _idgrupo_fk		INT
)
BEGIN
	DECLARE _idalumna_fk 	INT;

	INSERT INTO personas (idubigeo_fk, tipodocumento, nrodocumento, fechanac, apepaterno, apematerno, nombres, direccion, telefono)
		VALUES (_idubigeo_fk, _tipodocumento, _nrodocumento, _fechanac, _apepaterno, _apematerno, _nombres, _direccion, _telefono);
	
	IF ((SELECT idpersona FROM personas WHERE tipodocumento = _tipodocumento AND nrodocumento = _nrodocumento) IS NOT NULL) THEN
		SET _idalumna_fk = (SELECT idpersona FROM personas WHERE tipodocumento = _tipodocumento AND nrodocumento = _nrodocumento);
		
		INSERT INTO matriculas (idgrupo_fk, idalumna_fk)
			VALUES (_idgrupo_fk, _idalumna_fk);
		
		SELECT 'MATRICULA' AS 'status';
	END IF;
END $$

-- call spu_alumna_matricular(1, 'C', '71445405', '2010-05-16', 'APEPATERNO', 'APEMATERNO', 'Nick', 'JR. ABC', '988975641', 1);


-- B) INFORMACIÓN
-- 3.5. LISTAR ALUMNAS AL ELEGIR UN GRADO Y UNA SECCIÓN
DELIMITER $$
CREATE PROCEDURE spu_alumnas_listar
(
	IN _grado		CHAR(1),
	IN _seccion	CHAR(1)
)
BEGIN
	SELECT
		PER.idpersona,
		MAT.idmatricula,
		PER.apepaterno,
		PER.apematerno,
		PER.nombres,
		PER.fotografia
	FROM matriculas MAT
		INNER JOIN personas PER ON PER.idpersona = MAT.idalumna_fk
		INNER JOIN grupos GRU ON GRU.idgrupo = MAT.idgrupo_fk
		INNER JOIN horarios HOR ON HOR.idhorario = GRU.idhorario_fk
		INNER JOIN periodos PRD ON PRD.idperiodo = HOR.idperiodo_fk
		WHERE
			MAT.estado = 'A'				AND
			PER.estado = '1'				AND
			GRU.grado = _grado			AND
			GRU.seccion = _seccion	AND
			PRD.anio = YEAR(NOW());
END $$


-- 3.6. OBTENER DATOS AL HACER CLIC EN EDITAR EN LA TABLA ESTUDIANTES
DELIMITER $$
CREATE PROCEDURE spu_alumna_obtenerinfo(IN _idpersona INT)
BEGIN
	SELECT
		PER.idpersona,
		PER.apepaterno,
		PER.apematerno,
		PER.nombres,
		GRU.grado,
		GRU.seccion,
		PER.fotografia
	FROM personas PER
		INNER JOIN matriculas MAT ON PER.idpersona = MAT.idalumna_fk
		INNER JOIN grupos GRU ON GRU.idgrupo = MAT.idgrupo_fk
		INNER JOIN horarios HOR ON HOR.idhorario = GRU.idhorario_fk
		INNER JOIN periodos PRD ON PRD.idperiodo = HOR.idperiodo_fk
		WHERE
			PER.idpersona = _idpersona	AND
			PER.estado = '1'						AND
			MAT.estado = 'A'						AND
			PRD.anio = YEAR(NOW());
END $$


-- 3.7. ACTUALIZAR FOTOGRAFÍA
DELIMITER $$
CREATE PROCEDURE spu_alumna_actualizarfotografia
(
	IN _idpersona 	INT,
	IN _fotografia 	VARCHAR(100)
)
BEGIN
	IF _fotografia = '' THEN
		SET _fotografia = NULL;
	END IF;
	
	UPDATE personas SET fotografia = _fotografia
		WHERE idpersona = _idpersona;
END $$


-- ------------------
-- MÓDULO REPORTES --
-- ------------------
-- A) ESTUDIANTE
-- 4.0. REPORTE DE ASISTENCIAS EN UN RANGO DE FECHAS
DELIMITER $$
CREATE PROCEDURE spu_alumna_obtenerasifechas
(
	IN _nrodocumento 	CHAR(9),
	IN _desde					DATETIME,
	IN _hasta					DATETIME
)
BEGIN
	SELECT
		MAT.idmatricula,
		PER.apepaterno,
		PER.apematerno,
		PER.nombres,
		GRU.grado,
		GRU.seccion,
		ASI.horaentradaalu,
		ASI.horasalidaalu,
		CONCAT(DAY(ASI.fecharegistro), '-', UPPER(LEFT(DATE_FORMAT(ASI.fecharegistro, '%M'), 3)), '-', YEAR(ASI.fecharegistro)) AS fecharegistro,
		CASE
			WHEN ASI.estado = 'P' THEN 'Puntual'
			WHEN ASI.estado = 'T' THEN 'Tardanza'
			WHEN ASI.estado IS NULL THEN 'Ausente'
		END AS estado,
		COUNT(ASI.estado) AS cantidad
	FROM matriculas MAT
	INNER JOIN grupos GRU ON GRU.idgrupo = MAT.idgrupo_fk
	INNER JOIN asistencias ASI ON MAT.idmatricula = ASI.idmatricula_fk AND ASI.fecharegistro BETWEEN _desde AND _hasta
	INNER JOIN personas PER ON PER.idpersona = MAT.idalumna_fk
	WHERE
		PER.nrodocumento = _nrodocumento
	GROUP BY MAT.idmatricula, ASI.fecharegistro, ASI.estado
	ORDER BY ASI.estado, ASI.fecharegistro;
END $$


-- 4.1. OBTENER LISTA DE TODOS LOS PERMISOS DE UNA ALUMNA EN UN RANGO DE FECHAS
DELIMITER $$
CREATE PROCEDURE spu_alumna_obtenerpermisofechas
(
	IN _nrodocumento 	INT,
	IN _desde					DATE,
	IN _hasta					DATE
)
BEGIN
	SELECT
		*
	FROM v_permisos_listar
		WHERE
			nrodocumento = _nrodocumento 	AND
			DATE(fechahorapermiso) BETWEEN _desde AND _hasta;
END $$




-- B) AULA
-- 4.2. REPORTE DE ASISTENCIA DIARIA
DELIMITER $$
CREATE PROCEDURE spu_aula_obtenerasidiaria
(
	IN _grado		CHAR(1),
	IN _seccion		CHAR(1)
)
BEGIN
	SELECT
		MAT.idmatricula,
		PER.apepaterno,
		PER.apematerno,
		PER.nombres,
		ASI.horaentradaalu,
		ASI.horasalidaalu,
		CONCAT(DAY(ASI.fecharegistro), '-', UPPER(LEFT(DATE_FORMAT(ASI.fecharegistro, '%M'), 3)), '-', YEAR(ASI.fecharegistro)) 'fecharegistro',
		CASE
				WHEN ASI.estado = 'P' THEN 'Puntual'
				WHEN ASI.estado = 'T' THEN 'Tardanza'
				WHEN ASI.estado IS NULL THEN 'Ausente'
		END AS estado
	FROM matriculas MAT
		LEFT JOIN personas PER ON PER.idpersona = MAT.idalumna_fk
		LEFT JOIN grupos GRU ON GRU.idgrupo = MAT.idgrupo_fk
		LEFT JOIN asistencias ASI ON MAT.idmatricula = ASI.idmatricula_fk AND ASI.fecharegistro = CURDATE()
		WHERE
			GRU.grado = _grado 			AND
			GRU.seccion = _seccion
		ORDER BY ASI.horaentradaalu DESC;
END $$


-- 4.3. REPORTE DE ASISTENCIA EN UN RAGO DE FECHAS
DELIMITER $$
CREATE PROCEDURE spu_aula_obtenerasifechas
(
	IN _grado		CHAR(1),
	IN _seccion		CHAR(1),
	IN _desde		DATETIME,
	IN _hasta		DATETIME
)
BEGIN
	SELECT
-- 		MAT.idmatricula,
-- 		PER.apepaterno,
-- 		PER.apematerno,
-- 		PER.nombres,
-- 		ASI.horaentradaalu,
-- 		ASI.horasalidaalu,
-- 		CONCAT(DAY(ASI.fecharegistro), '-', UPPER(LEFT(DATE_FORMAT(ASI.fecharegistro, '%M'), 3)), '-', YEAR(ASI.fecharegistro)) 'fecharegistro',
		CASE
				WHEN ASI.estado = 'P' THEN 'Puntual'
				WHEN ASI.estado = 'T' THEN 'Tardanza'
				WHEN ASI.estado IS NULL THEN 'Ausente'
		END AS estado,
		COUNT('estado') 'cantidad'
	FROM matriculas MAT
		LEFT JOIN personas PER ON PER.idpersona = MAT.idalumna_fk
		LEFT JOIN grupos GRU ON GRU.idgrupo = MAT.idgrupo_fk
-- 		LEFT JOIN horarios HOR ON HOR.idhorario = GRU.idhorario_fk
-- 		LEFT JOIN periodos PRD ON PRD.idperiodo = HOR.idperiodo_fk
		LEFT JOIN asistencias ASI ON MAT.idmatricula = ASI.idmatricula_fk AND ASI.fecharegistro BETWEEN _desde AND _hasta
		WHERE
			GRU.grado = _grado 			AND
			GRU.seccion = _seccion			
		GROUP BY /*MAT.idmatricula,*/ estado;
END $$

-- CALL spu_aula_obtenerasifechas('1', 'A', '2023-01-01', '2023-07-28');


-- ------------------
-- MÓDULO PERMISOS --
-- ------------------
-- 5.0. LISTAR LOS MOTIVOS
DELIMITER $$
CREATE PROCEDURE spu_motivos_listar()
BEGIN
	SELECT
		idmotivo,
		descripcionmotivo
	FROM motivos
		WHERE estado = '1';
END $$


-- 5.1. VERIFICAR QUE LA ALUMNA HAYA MARCADO ASISTENCIA
DELIMITER $$
CREATE PROCEDURE spu_alumna_verificarasistencia(IN _nrodocumento CHAR(9))
BEGIN
	SELECT
		idasistencia,
		nrodocumento,
		apepaterno,
		apematerno,
		nombres,
		grado,
		seccion
	FROM v_asistencia_listar
		WHERE
			nrodocumento = _nrodocumento;
END $$


-- 5.2. REGISTRAR PERMISO ALUMNA Y MARCAR SALIDA
DELIMITER $$
CREATE PROCEDURE spu_permiso_registrar
(
	IN _idasistencia_fk						INT,
	IN _idmotivo_fk								INT,
	IN _idcolaboradorautoriza_fk	INT,
	IN _comentario								TEXT,
	IN _evidencia									VARCHAR(100)
)
BEGIN
	IF ((SELECT COUNT(*) FROM v_permisos_listar WHERE idasistencia = _idasistencia_fk AND DATE(fechahorapermiso) = CURDATE()) = 0) THEN
		INSERT INTO permisos (idasistencia_fk, idmotivo_fk, idcolaboradorautoriza_fk, comentario, evidencia) VALUES
			(_idasistencia_fk, _idmotivo_fk, _idcolaboradorautoriza_fk, _comentario, _evidencia);

		UPDATE asistencias SET horasalidaalu = CURTIME()
			WHERE idasistencia = _idasistencia_fk AND fecharegistro = CURDATE();
		
		SELECT 'PERMISO' AS 'status';
	ELSE
		SELECT 'DENEGAR' AS 'status';
	END IF;
END $$


-- 5.3. OBTENER REPORTE DE LA ALUMNA AL MOMENTO QUE EL COLABORADOR REGISTRA EL PERMISO
DELIMITER $$
CREATE PROCEDURE spu_alumna_obtenerpermiso(IN _idasistencia INT)
BEGIN
	SELECT
		*
	FROM v_permisos_listar
		WHERE
			idasistencia = _idasistencia 	AND
			DATE(fechahorapermiso) = CURDATE();
END $$



-- ----------------
-- MÓDULO INICIO --
-- ----------------
DELIMITER $$
CREATE PROCEDURE spu_asistenciadiaria_obtenerestado()
BEGIN
	SELECT
		CASE
				WHEN ASI.estado = 'P' THEN 'Puntual'
				WHEN ASI.estado = 'T' THEN 'Tardanza'
				WHEN ASI.estado IS NULL THEN 'Ausente'
		END AS estado,
		COUNT(MAT.idmatricula) AS total
	FROM matriculas MAT
		LEFT JOIN personas PER ON PER.idpersona = MAT.idalumna_fk
		LEFT JOIN asistencias ASI ON MAT.idmatricula = ASI.idmatricula_fk AND ASI.fecharegistro = CURDATE()
		GROUP BY estado;
END $$