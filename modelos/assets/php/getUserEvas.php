<?php 
	require "../../../php/connect.php";
	$id = $_POST['id'];

	$query = mysqli_query($con, "SELECT * FROM asignaciones WHERE idUsuario = $id")or die(mysqli_error($con));

	$response["stuff"] = array();
	$count = mysqli_num_rows($query);

	if($count > 0){
		while($asign = mysqli_fetch_array($query)){
            $stuff = array();

            $idEva = $asign['idEvaluacion'];

            $qe = mysqli_query($con, "SELECT * FROM evaluaciones WHERE idEvaluacion=$idEva")or die(mysqli_error($con));
            $EVA = mysqli_fetch_array($qe);

            $stuff["titulo"] = $EVA['titulo'];
            $stuff["num"] = $EVA['num_preguntas'];
            $idTema = $EVA['idTema'];
            $idTipo = $EVA['idTipo'];

            $qr = mysqli_query($con, "SELECT * FROM temas WHERE idTema=$idTema")or die(mysqli_error($con));
            $evaTheme = mysqli_fetch_array($qr);
            $stuff['tema'] = $evaTheme['tema'];

            $qu = mysqli_query($con, "SELECT * FROM tipos_de_evaluaciones WHERE idTipo=$idTipo")or die(mysqli_error($con));
            $evaType = mysqli_fetch_array($qu);
            $stuff['tipo'] = $evaType['tipo'];

            $stuff['date'] = $EVA['fecha'];
            $stuff['status'] = $asign['status'];
            array_push($response["stuff"], $stuff);
        }
		$response["success"] = "true";
		echo(json_encode($response));
	}else{
		$response["success"] = "false";
		echo(json_encode($response));
	}

?>