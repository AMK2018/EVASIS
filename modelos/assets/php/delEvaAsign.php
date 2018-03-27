<?php 
    require "../../../php/connect.php";
    

    $fields = $_POST['fields'];
    $iduser = $fields[0]['value'];
    $ideva = $fields[1]['value'];


    $del = mysqli_query($con, "DELETE FROM asignaciones WHERE idUsuario=$iduser AND idEvaluacion=$ideva")or die(mysqli_error($con));

    if($del){
        echo "true"; 
    }else{ 
        echo "false"; 
    }
?>
