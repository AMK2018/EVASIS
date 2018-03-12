
<?php 
	require "../../../php/connect.php";

	if(isset($_POST['petition'])){
		$petition = $_POST['petition'];
		$fields = $_POST['formdata'];

		$theme = strtoupper($fields[0]['value']);

		switch($petition){
			case "insert":
				$query = mysqli_query($con, "INSERT INTO temas (tema) VALUES ('$theme')")or die(mysqli_error($con));
				if($query){
					echo "true";
				}else{
					echo "false";
				}
			break;
			case "update":
				$id = $_POST['idTheme'];

				$query = mysqli_query($con, "UPDATE temas SET tema = '$theme' WHERE idTema=$id")or die(mysqli_error($con));
				if($query){
					echo "true";
				}else{
					echo "false";
				}
			break;
			case "delete":
				$id = $_POST['idTheme'];
				$query = mysqli_query($con, "DELETE FROM temas WHERE idTema=$id")or die(mysqli_error($con));
				if($query){
					echo "true";
				}else{
					echo "false";
				}
			break;
		}
	}
?>