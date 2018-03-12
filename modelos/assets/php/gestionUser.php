<?php 
	require "../../../php/connect.php";

	if(isset($_POST['petition'])){
		$petition = $_POST['petition'];
		$fields = $_POST['formdata'];

		$name = $fields[0]['value'];
		$email = $fields[1]['value'];
		$username = $fields[2]['value'];
		$password = $fields[3]['value'];
		$date = $fields[5]['value'];
		$type = $fields[6]['value'];

		switch($petition){
			case "insert":
				$password = md5($password);
				$query = mysqli_query($con, "INSERT INTO usuarios (nombre, email, username, password, fecha_ingreso, idtipo) VALUES ('$name', '$email', '$username', '$password', '$date', '$type')")or die(mysqli_error($con));
				if($query){
					echo true;
				}else{
					echo false;
				}
			break;
			case "update":
				$id = $_POST['iduser'];
				if(strlen($password) < 12){
					$password = md5($password);
				}
				$query = mysqli_query($con, "UPDATE usuarios SET nombre='$name', email='$email', username='$username', password='$password', fecha_ingreso='$date', idtipo='$type' WHERE idUsuario=$id")or die(mysqli_error($con));
				if($query){
					echo true;
				}else{
					echo false;
				}
			break;
			case "delete":
				$id = $_POST['iduser'];
				$query = mysqli_query($con, "DELETE FROM usuarios WHERE idUsuario=$id")or die(mysqli_error($con));
				if($query){
					echo true;
				}else{
					echo false;
				}
			break;
		}
	}
?>