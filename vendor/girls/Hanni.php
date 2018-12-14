<?php

class Hanni{
	static function love($request,$sakura){
		$cliente=$request['clie'];
		$personaje=$request['per'];
		$fecha=$request['f'];
		$circulacion=$request['cir'];
		$tipo=$request['tip'];
	
	
		$response=$sakura->prepare("select * from menu_items where id =$personaje");
		$response->execute();
		$button=$response->fetchAll();
		
		switch ($circulacion) {
			case 1:
				$sql="SELECT
					n.idEditorial as id,
					p.Nombre AS 'Periodico',
					n.Fecha,
					n.Titulo,
					c.Categoria AS 'Categoria',
					e.Nombre AS 'Estado',
					s.seccion AS 'Seccion',
					n.CREL as crel,
					n.costoNota as costo,
					p.idPeriodico as idMedio, 
					CONCAT('https://www.gaimpresos.com/Periodicos/',p.Nombre,'/',n.Fecha,'/',n.NumeroPagina) AS 'pdf',
					CONCAT('https://www.gaimpresos.com/Periodicos/',p.Nombre,'/',n.Fecha,'/',n.NumeroPagina,'.jpg') AS 'jpg'
					FROM
						noticiasDia n,
						periodicos p,
						categoriasPeriodicos c,
						estados e,
						seccionesPeriodicos s 
					WHERE "
						.$button[0]['criteria']." AND
						p.tipo=".$tipo." AND
						p.idPeriodico=n.Periodico AND
						n.Fecha ='".$fecha."' AND
						s.idSeccion=n.Seccion AND
						n.Categoria = c.idCategoria AND
						c.idCategoria!=80 AND
						p.Pais = 1 AND
						n.Activo = 1 AND
						p.Estado != 9 AND
						p.Estado = e.idEstado
					ORDER BY 
						p.Estado,
						p.Nombre";
			
			break;
			case 2:
				$sql="SELECT
					n.idEditorial as id,
					p.Nombre AS 'Periodico',
					n.Fecha,
					n.Titulo,
					c.Categoria AS 'Categoria',
					e.Nombre AS 'Estado',
					s.seccion AS 'Seccion',
					n.CREL as crel,
					n.costoNota as costo,
					p.idPeriodico as idMedio, 
					CONCAT('https://www.gaimpresos.com/Periodicos/',p.Nombre,'/',n.Fecha,'/',n.NumeroPagina) AS 'pdf',
					CONCAT('https://www.gaimpresos.com/Periodicos/',p.Nombre,'/',n.Fecha,'/',n.NumeroPagina,'.jpg') AS 'jpg'
					FROM
						noticiasDia n,
						periodicos p,
						categoriasPeriodicos c,
						estados e,
						seccionesPeriodicos s 
					WHERE "
						.$button[0]['criteria']." AND
						p.tipo=".$tipo." AND
						p.idPeriodico=n.Periodico AND
						n.Fecha ='".$fecha."' AND
						s.idSeccion=n.Seccion AND
						n.Categoria = c.idCategoria AND
						c.idCategoria!=80 AND
						p.Pais = 1 AND
						n.Activo = 1 AND
						p.Estado = 9 AND
						p.Estado = e.idEstado
					ORDER BY 
						p.Estado,
						p.Nombre";
			break;
			case 3:
				$sql="SELECT
					n.idEditorial as id,
					p.Nombre AS Periodico,
					n.Fecha,
					n.Titulo,
					c.Categoria AS Categoria,
					e.Nombre AS Estado,
					s.seccion AS Seccion,
					n.CREL as crel,
					n.costoNota as costo,
					p.idPeriodico as idMedio,
					Encabezado AS link,
					(
						SELECT CASE pieces.status
							WHEN 'n' THEN 'Negativa'
							WHEN 'nn' THEN 'Neutra'
							WHEN 'p' THEN 'Positiva'
							ELSE 'Sin Calificacion' END as calificacion
						from newPoliJalisco.pieces
							inner join newPoliJalisco.actors on newPoliJalisco.pieces.actor_id=newPoliJalisco.actors.id
							inner join newPoliJalisco.audit_piece on newPoliJalisco.audit_piece.piece_id=newPoliJalisco.pieces.id
							inner join newPoliJalisco.audits on newPoliJalisco.audit_piece.audit_id=newPoliJalisco.audits.id
						where newPoliJalisco.audits.character_id=$personaje and newPoliJalisco.audits.note_id=n.idEditorial
					) as calificacion
					FROM
						noticiasDia n,
						periodicos p,
						categoriasPeriodicos c,
						estados e,
						seccionesPeriodicos s
					WHERE ".$button[0]['criteria']." AND
						n.Periodico=p.idPeriodico AND
						n.Fecha ='".$fecha."' AND
						n.Seccion = s.idSeccion AND
						n.Categoria = c.idCategoria AND
						c.idCategoria=80 AND
						n.Activo = 1 AND
						p.Estado = e.idEstado
						ORDER BY p.Estado,p.Nombre";
			
			break;
			default:
				return 'n_n';
			break;
		}
		$response=$sakura->prepare($sql);
		$response->execute();
		return $response->fetchAll();

	}
}
