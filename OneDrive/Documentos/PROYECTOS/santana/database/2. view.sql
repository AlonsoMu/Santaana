USE dbsa;

-- F) VISTA (TEMPORAL) DE ASISTENCIAS DEL DÍA ACTUAL
CREATE VIEW v_asistencia_listar
AS
	SELECT
		ASI.idasistencia,
		MAT.idmatricula,
		PER.nrodocumento,
		PER.apepaterno, 
		PER.apematerno, 
		PER.nombres,
		PER.fotografia,
		GRU.grado,
		GRU.seccion,
		ASI.horaentradaalu,
		HOR.horaentrada,
		ASI.fecharegistro,
		HOR.horasalida
	FROM asistencias ASI
		INNER JOIN matriculas MAT ON MAT.idmatricula = ASI.idmatricula_fk
		INNER JOIN personas PER ON PER.idpersona = MAT.idalumna_fk
		INNER JOIN grupos GRU ON GRU.idgrupo = MAT.idgrupo_fk
		INNER JOIN horarios HOR ON HOR.idhorario = GRU.idhorario_fk
		WHERE
			ASI.fecharegistro = CURDATE();


CREATE VIEW v_horarios_listar
AS
	SELECT
		MAT.idmatricula,
		HOR.horaentrada,
		HOR.horasalida
	FROM personas PER
		INNER JOIN matriculas MAT ON PER.idpersona = MAT.idalumna_fk
		INNER JOIN grupos GRU ON GRU.idgrupo = MAT.idgrupo_fk
		INNER JOIN horarios HOR ON HOR.idhorario = GRU.idhorario_fk
		INNER JOIN periodos PRD ON PRD.idperiodo = HOR.idperiodo_fk
		WHERE
			MAT.estado = 'A'		AND
			PRD.anio = YEAR(NOW());
		

CREATE VIEW v_permisos_listar
AS
	SELECT
		ASI.idasistencia,
		ALU.nrodocumento,
		ALU.apepaterno,
		ALU.apematerno,
		ALU.nombres,
		MOT.descripcionmotivo,
		PRM.fechahorapermiso,
		PER.apepaterno AS apepatcolaborador,
		PER.apematerno AS apematcolaborador,
		PER.nombres AS colaborador,
		CAR.nombrecargo
	FROM permisos PRM
		INNER JOIN motivos MOT ON MOT.idmotivo = PRM.idmotivo_fk
		INNER JOIN asistencias ASI ON PRM.idasistencia_fk = ASI.idasistencia
		INNER JOIN matriculas MAT ON ASI.idmatricula_fk = MAT.idmatricula
		INNER JOIN personas ALU ON MAT.idalumna_fk = ALU.idpersona
		INNER JOIN colaboradores COL ON PRM.idcolaboradorautoriza_fk = COL.idcolaborador
		INNER JOIN cargos CAR ON CAR.idcargo = COL.idcargo_fk
		INNER JOIN personas PER ON COL.idpersona_fk = PER.idpersona;