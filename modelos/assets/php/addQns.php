<?php 
	require "../../../php/connect.php";

	$preguntas = $_POST['pregs'];
	$respuestas = $_POST['resps'];

	$tipo = $_POST['evaType'];
	$tema = $_POST['evaTheme'];

	$tquery = mysqli_query($con, "SELECT * FROM temas WHERE tema = '$tema'")or die(mysqli_error($con));
	$t = mysqli_fetch_array($tquery);
	$idTema = $t['idTema'];
    $tiquery = mysqli_query($con, "SELECT * FROM tipos_de_evaluaciones WHERE tipo = '$tipo'")or die(mysqli_error($con));
	$ti = mysqli_fetch_array($tiquery);
    $idTipo =  $ti['idTipo'];

	$idPregunta = null;
	switch($tipo){
		case "Opcion Multiple":
			for ($i=0; $i < count($preguntas); $i++) { 
				$p = $preguntas[$i]['value'];

				$check = mysqli_query($con, "SELECT * FROM preguntas WHERE pregunta = '$p'")or die(mysqli_error($con));
				$count = mysqli_num_rows($check);
				if($count <= 0){
					$pquery = mysqli_query($con, "INSERT INTO preguntas (pregunta, idTema, idTipo) VALUES ('$p', $idTema, $idTipo)")or die(mysqli_error($con));
					if(!$pquery){
						echo "false";
						break;
					}else{
						$ipquery = mysqli_query($con, "SELECT * FROM preguntas WHERE pregunta = '$p'")or die(mysqli_error($con));
						$ip = mysqli_fetch_array($ipquery);
						$idPregunta = $ip['idPregunta'];
					}

					for ($r=0; $r < count($respuestas); $r++) { 
						$res = $respuestas[$r]['value'];
						if(strpos($respuestas[$r]['name'], $preguntas[$i]['name']) !== false){
							$rquery = mysqli_query($con, "INSERT INTO respuestas (idPregunta, respuesta) VALUES ($idPregunta, '$res')")or die(mysqli_error($con));
							if(!$pquery){
								echo "false";
								break;
							}
						}
					}
				}
			}

			echo "true";
		break;
		case "Cuestionario":
			for ($i=0; $i < count($preguntas); $i++) { 
				$p = $preguntas[$i]['value'];

				$check = mysqli_query($con, "SELECT * FROM preguntas WHERE pregunta = '$p'")or die(mysqli_error($con));
				$count = mysqli_num_rows($check);
				if($count <= 0){
					$pquery = mysqli_query($con, "INSERT INTO preguntas (pregunta, idTema, idTipo) VALUES ('$p', $idTema, $idTipo)")or die(mysqli_error($con));
					if(!$pquery){
						echo "false";
						break;
					}else{
						$ipquery = mysqli_query($con, "SELECT * FROM preguntas WHERE pregunta = '$p'")or die(mysqli_error($con));
						$ip = mysqli_fetch_array($ipquery);
						$idPregunta = $ip['idPregunta'];
					}

					for ($r=0; $r < count($respuestas); $r++) { 
						$res = $respuestas[$r]['value'];
						if(strpos($respuestas[$r]['name'], $preguntas[$i]['name']) !== false){
							$rquery = mysqli_query($con, "INSERT INTO respuestas (idPregunta, respuesta) VALUES ($idPregunta, '$res')")or die(mysqli_error($con));
							if(!$pquery){
								echo "false";
								break;
							}
						}
					}
				}
			}

			echo "true";
		break;
		case "Relacion de Columnas":

		break;
	}


?>