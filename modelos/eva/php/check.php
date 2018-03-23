<?php 
    require("../../../php/connect.php");
    date_default_timezone_set('UTC');

    $iduser = $_POST['iduser'];
    $ideva = $_POST['ideva'];
    $date = $_POST['date'];

    $check = mysqli_query($con, "SELECT * FROM asignaciones WHERE idUsuario=$iduser AND idEvaluacion=$ideva AND fecha_asign='$date'")or die(mysqli_error($con));

    $count = mysqli_num_rows($check);
    $response = null;

    if($count > 0){

        $data = mysqli_fetch_array($check);

        $stuff['score'] = $data['score'];
        $stuff['media'] = $data['media'];
        $stuff['status'] = $data['status'];
        $response["stuff"]= $stuff;
        $response['status'] = 'true';

    }else{
        $response['status'] = 'false';
    }

    echo(json_encode($response));
?>