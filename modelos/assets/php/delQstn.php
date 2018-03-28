<?php 
    require "../../../php/connect.php";

    $idpregunta = $_POST['idPregunta'];


    $del = mysqli_query($con, "DELETE FROM preguntas WHERE idPregunta=$idpregunta")or die(mysqli_error($con));

    if($del){
        echo "true"; 
    }else{ 
        echo "false"; 
    }
?>