SELECT
	CASE
		WHEN ASI.horaentradaalu BETWEEN DATE_ADD(HOR.horaentrada, INTERVAL -20 MINUTE) AND DATE_ADD(HOR.horaentrada, INTERVAL 25 MINUTE) THEN 'Temprano'
		WHEN ASI.horaentradaalu BETWEEN DATE_ADD(HOR.horaentrada, INTERVAL 25 MINUTE) AND HOR.horasalida THEN 'Tardanza'
		ELSE 'Ausente'
	END 'estado'
	-- count('estado') 'Total'
FROM matriculas MAT
	LEFT JOIN personas PER ON PER.idpersona = MAT.idalumna_fk
	LEFT JOIN grupos GRU ON GRU.idgrupo = MAT.idgrupo_fk
	LEFT JOIN horarios HOR ON HOR.idhorario = GRU.idhorario_fk
	LEFT JOIN periodos PRD ON PRD.idperiodo = HOR.idperiodo_fk
	LEFT JOIN asistencias ASI ON MAT.idmatricula = ASI.idmatricula_fk AND ASI.fecharegistro = CURDATE()
	GROUP BY ASI.idasistencia, estado;
	