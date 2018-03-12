<?php 
	require "connect.php";

	if(isset($_POST['username']) && isset($_POST['pass'])){
		$_user = $_POST['username'];
		$_pass = md5($_POST['pass']);

		$query = mysqli_query($con, "SELECT * FROM usuarios WHERE username='$_user' AND password='$_pass'")or die(mysqli_error($con));
		$user = mysqli_fetch_array($query);

		if($user){
			session_start();
			$_SESSION['username'] =$user['nombre'];
			$tipo = $user['idtipo'];
            $_SESSION['id'] = $user['idUsuario'];
			$query2 = mysqli_query($con, "SELECT * FROM tipos_de_usuarios WHERE idtipo=$tipo")or die(mysqli_error($con));
			$userType = mysqli_fetch_array($query2);

			$_SESSION['tipo'] = $userType['etiqueta'];
			switch($tipo){
				case "1":
					header("location: ../modelos/admin/");
				break;
				case "2":
					header("location: ../modelos/student/");
				break;
				case "3":
					header("location: ../modelos/specialist/");
				break;
			}
		}else{
			header("location: ../");
		}
	}
?>