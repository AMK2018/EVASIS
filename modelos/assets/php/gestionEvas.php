
<?php 
	require "../../../php/connect.php";
	date_default_timezone_set('UTC');
	
	if(isset($_POST['petition'])){
		$petition = $_POST['petition'];
		$fields = $_POST['formdata'];
        
		$titulo = strtoupper($fields[0]['value']);
		$num = $fields[1]['value'];
		$tema = $fields[2]['value'];
		$tipo = $fields[3]['value'];
		$fecha =  date("Y-m-d");
		
        session_start();
        $idUser = $_SESSION['id'];
        
		switch($petition){
			case "insert":
				$query = mysqli_query($con, "INSERT INTO evaluaciones (titulo, num_preguntas, idTema, idTipo, fecha, idOwner) VALUES ('$titulo',$num,$tema,$tipo, '$fecha', $idUser)")or die(mysqli_error($con));
				if($query){
					echo "true";
				}else{
					echo "false";
				}
			break;
			case "update":
				$id = $_POST['idEva'];

				$query = mysqli_query($con, "UPDATE evaluaciones SET titulo='$titulo', num_preguntas='$num', idTema='$tema', idTipo='$tipo' WHERE idEvaluacion=$id")or die(mysqli_error($con));
				if($query){
					echo "true";
				}else{
					echo "false";
				}
			break;
			case "delete":
				$id = $_POST['idEva'];
				$query = mysqli_query($con, "DELETE FROM evaluaciones WHERE idEvaluacion=$id")or die(mysqli_error($con));
				if($query){
					echo "true";
				}else{
					echo "false";
				}
			break;
		}
	}
?>