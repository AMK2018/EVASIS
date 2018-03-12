<?php 
	require "../../../php/connect.php";
    require "tools.php";

    $id = $_POST['id'];

    $query = mysqli_query($con, "SELECT * FROM asignaciones WHERE idUsuario = $id")or die(mysqli_error($con));
    
    $response["stuff"] = array();
	$count = mysqli_num_rows($query);

	if($count > 0){
        while($user = mysqli_fetch_array($query)){
            
            $idEva = $user['idEvaluacion'];
            $stuff["asign-date"] = fechaCastellano($user['fecha_asign']);
            $stuff["status"] = $user['status'];
            
            $query = mysqli_query($con, "SELECT * FROM evaluaciones WHERE idEvaluacion = $idEva")or die(mysqli_error($con));
            $eva = mysqli_fetch_array($query);
            
            $stuff['idEva'] = $idEva;
            $stuff ['titulo'] = $eva['titulo'];
            $stuff ['num'] = $eva['num_preguntas'];
            
            $idTema = $eva['idTema'];
            $idTipo = $eva['idTipo'];
            
            $qr = mysqli_query($con, "SELECT * FROM temas WHERE idTema=$idTema")or die(mysqli_error($con));
            $evaTheme = mysqli_fetch_array($qr);
            $stuff['theme'] = $evaTheme['tema'];

            $qu = mysqli_query($con, "SELECT * FROM tipos_de_evaluaciones WHERE idTipo=$idTipo")or die(mysqli_error($con));
            $evaType = mysqli_fetch_array($qu);
            $stuff['type'] = $evaType['tipo'];
            
            $stuff['date'] = fechaCastellano($eva['fecha']);
            $stuff['owner'] = $eva['idOwner'];
            array_push($response["stuff"], $stuff);
        }
        $response["success"] = "true";
        echo(json_encode($response));
    }else{
        $response["success"] = "false";
		echo(json_encode($response));
    }
?>