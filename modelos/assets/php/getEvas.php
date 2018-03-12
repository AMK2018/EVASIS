<?php 
	require "../../../php/connect.php";

	date_default_timezone_set('UTC');

    session_start();
    $idUser = $_SESSION['id'];

	$query = mysqli_query($con, "SELECT * FROM evaluaciones WHERE idOwner = '$idUser'")or die(mysqli_error($con));

	$response["stuff"] = array();
	$count = mysqli_num_rows($query);
	if($count > 0){
		while ($eva = mysqli_fetch_array($query)) {
			$stuff = array();
			$preguntas = array();
			$stuff['idEva'] = $eva['idEvaluacion'];
			$stuff['title'] = $eva['titulo'];
			$stuff['num'] = $eva['num_preguntas'];
			$idTema = $eva['idTema'];

			$qr = mysqli_query($con, "SELECT * FROM temas WHERE idTema=$idTema")or die(mysqli_error($con));
			$evaTheme = mysqli_fetch_array($qr);
			$stuff['theme'] = $evaTheme['tema'];
			$idTipo = $eva['idTipo'];

			$qu = mysqli_query($con, "SELECT * FROM tipos_de_evaluaciones WHERE idTipo=$idTipo")or die(mysqli_error($con));
			$evaType = mysqli_fetch_array($qu);
			$stuff['type'] = $evaType['tipo'];

			$stuff['date'] = $eva['fecha'];
            $stuff['owner'] = $eva['idOwner'];
			array_push($response["stuff"], $stuff);
		}
		$response["success"] = true;
		echo(json_encode($response));
	}else{
		$response["success"] = false;
		echo(json_encode($response));
	}	

?>