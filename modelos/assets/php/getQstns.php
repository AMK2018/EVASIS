<?php 
    require "../../../php/connect.php";
    
    $query = mysqli_query($con, "SELECT * FROM preguntas")or die(mysqli_error($con));

    $response["stuff"] = array();
    $count = mysqli_num_rows($query);

    if($count > 0){
        while($p = mysqli_fetch_array($query)){
            $stuff = array();
            $idp = $p['idPregunta'];
            $stuff['idPregunta'] = $idp;
            $stuff['pregunta'] = $p['pregunta'];
            
            $idTema = $p['idTema'];
            $theme = mysqli_query($con, "SELECT * FROM temas WHERE idTema=$idTema")or die(mysqli_error($con));
            $tema = mysqli_fetch_array($theme);
            $stuff['tema'] = $tema['tema'];

            $idTipo = $p['idTipo'];
            $type = mysqli_query($con, "SELECT * FROM tipos_de_evaluaciones WHERE idTipo=$idTipo")or die(mysqli_error($con));
            $tipo = mysqli_fetch_array($type);
            $stuff['tipo'] = $tipo['tipo'];

            $qry = mysqli_query($con, "SELECT * FROM respuestas WHERE idPregunta=$idp")or die(mysqli_error($con));

            $stuff["respuesta"] = array();
            $count2 = mysqli_num_rows($qry);

            if($count2 > 0){
                while($r = mysqli_fetch_array($qry)){
                    $respuestas = array();
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

    echo(json_encode($response));
?>