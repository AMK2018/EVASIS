<?php 
    require "../../../php/connect.php";
    $theme = $_GET['theme'];
    $type = $_GET['type'];

    $query = mysqli_query($con, "SELECT * FROM temas WHERE tema='$theme'")or die(mysqli_error($con));

    $list = mysqli_fetch_array($query);
    
    $response["stuff"] = array();
	$count = mysqli_num_rows($query);

    $q2 = mysqli_query($con, "SELECT * FROM tipos_de_evaluaciones WHERE tipo='$type'")or die(mysqli_error($con));

    $list2 = mysqli_fetch_array($q2);

	if($count > 0){
        $idTema = $list['idTema'];
        $idTipo = $list2['idTipo'];

        $qtns = mysqli_query($con, "SELECT * FROM preguntas WHERE idTema=$idTema AND idTipo=$idTipo")or die(mysqli_error($con));

        $count2 = mysqli_num_rows($qtns);

        if($count2 > 0){
            while($q = mysqli_fetch_array($qtns)){
                $stuff = array();

                $idQ = $q['idPregunta'];
                $stuff['pregunta'] = $q['pregunta'];

                $anws = mysqli_query($con, "SELECT * FROM respuestas WHERE idPregunta=$idQ")or die(mysqli_error($con));
                
                $stuff["respuesta"] = array();
                $count3 = mysqli_num_rows($anws);
                
                if($count3 > 0){
                    while($r = mysqli_fetch_array($anws)){
                        $respuestas  = array();
                        $respuestas['respuesta'] = $r['respuesta'];
                        array_push($stuff['respuesta'], $respuestas);
                    }
                }else{
                    $response["status"] = "false";
                    $response["msg"] = "No hay respuestas para esta pregunta";
                }
            
                array_push($response["stuff"], $stuff);
            }

            $response["status"] = "true";
        }else{
            $response["status"] = "false";
            $response["msg"] = "No hay preguntas para este tema";
        }
	}else{
        $response["status"] = "false";
        $response["msg"] = "Tema inexistente";
    }	
    
    
	echo(json_encode($response));
?>