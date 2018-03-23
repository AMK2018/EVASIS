<?php 
	require "../../../php/connect.php";
    date_default_timezone_set('UTC');
    $fields = $_POST['formdata'];
    $iduser = $fields[0]['value'];
    $eva = $fields[1]['value'];
    $fecha =  date("Y-m-d");

    $q = mysqli_query($con, "SELECT * FROM asignaciones WHERE idUsuario=$iduser AND idEvaluacion=$eva")or die(mysqli_error($con));

    $count = mysqli_num_rows($q);

    if($count <= 0){
    	$query = mysqli_query($con, "INSERT INTO asignaciones (idUsuario, idEvaluacion, fecha_asign, score, status, media) VALUES($iduser, $eva, '$fecha', '', 'Incomplete', '')")or die(mysqli_error($con));

    	if($query){
            echo "true"; 
        }else{ 
            echo "false"; 
        }
    }else{
        echo "exists";
    }
?>
