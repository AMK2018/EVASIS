<?php 
	require "../../../php/connect.php";
    
    session_start();
    $idUser = $_SESSION['id'];

	$query = mysqli_query($con, "SELECT * FROM evaluaciones WHERE idOwner = '$idUser'")or die(mysqli_error($con));

	$response["stuff"] = array();
	$count = mysqli_num_rows($query);

	if($count > 0){
		while ($types = mysqli_fetch_array($query)) {
			$stuff = array();
			$stuff['idEva'] = $types['idEvaluacion'];
			$stuff["titulo"] = $types['titulo'];
			array_push($response["stuff"], $stuff);
		}
		$response["success"] = "true";
		echo(json_encode($response));
	}else{
		$response["success"] = "false";
		echo(json_encode($response));
	}

?>