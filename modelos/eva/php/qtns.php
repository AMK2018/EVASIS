<?php 
    require "../../../php/connect.php";
    $theme = $_GET['theme'];
    
    $query = mysqli_query($con, "SELECT * FROM temas WHERE tema='$theme'")or die(mysqli_error($con));

    $list = mysqli_fetch_array($query);
    
    $response["stuff"] = array();
	$count = mysqli_num_rows($query);

	if($count > 0){
        $idTema = $list['idTema'];
       
        $qtns = mysqli_query($con, "SELECT * FROM preguntas WHERE idTema=$idTema")or die(mysqli_error($con));

        $count2 = mysqli_num_rows($qtns);

        if($count2 > 0){
            while($q = mysqli_fetch_array($qtns)){
                $stuff = array();

                $idQ = $q['idPregunta'];
                $stuff['pregunta'] = $q['pregunta'];
                
                $anws = mysqli_query($con, "SELECT * FROM respuestas WHERE idPregunta=$idQ")or die(mysqli_error($con));
                $r = mysqli_fetch_array($anws);
                $stuff['respuesta'] = $r['respuesta'];
            
                array_push($response["stuff"], $stuff);
            }

            $response["success"] = "true";
		    echo(json_encode($response));
        }else{
            $response["success"] = "false";
            $response["msg"] = "No hay preguntas para este tema";
        }
	}else{
        $response["success"] = "false";
        $response["msg"] = "Tema inexistente";
		echo(json_encode($response));
	}	
?>