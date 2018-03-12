<?php 
	require "../../../php/connect.php";
    date_default_timezone_set('UTC');
    $fields = $_POST['formdata'];
    $iduser = $fields[0]['value'];
    $eva = $fields[1]['value'];
    $fecha =  date("Y-m-d");

	$query = mysqli_query($con, "INSERT INTO asignaciones (idUsuario, idEvaluacion, fecha_asign, status) VALUES($iduser, $eva, '$fecha', 'incomplete')")or die(mysqli_error($con));

	if($query){
    echo "true"; 
    }else{ 
        echo "false"; 
    }

?>
