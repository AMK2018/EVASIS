<?php 
	require "../../../php/connect.php";
	$query = mysqli_query($con, "SELECT * FROM temas")or die(mysqli_error($con));

	$response["stuff"] = array();
	$count = mysqli_num_rows($query);

	if($count > 0){
		while ($types = mysqli_fetch_array($query)) {
			$stuff = array();
			$stuff['id'] = $types['idTema'];
			$stuff['etiqueta'] = $types['tema'];
			array_push($response["stuff"], $stuff);
		}
		$response["success"] = "true";
		echo(json_encode($response));
	}else{
		$response["success"] = "false";
		echo(json_encode($response));
	}	
?>