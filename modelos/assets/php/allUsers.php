<?php 
	require "../../../php/connect.php";
    session_start();
    $tipo = $_SESSION['tipo'];

    switch($tipo){
        case "Administrador":
            $query = mysqli_query($con, "SELECT * FROM usuarios")or die(mysqli_error($con));

            $response["stuff"] = array();
            $count = mysqli_num_rows($query);
            if($count > 0){
                while ($user = mysqli_fetch_array($query)) {
                    $stuff = array();
                    $stuff['id'] = $user['idUsuario'];
                    $stuff['name'] = $user['nombre'];
                    $stuff['email'] = $user['email'];
                    $stuff['username'] = $user['username'];
                    $stuff['password'] = $user['password'];
                    $stuff['fecha'] = $user['fecha_ingreso'];
                    $tipo = $user['idtipo'];
                    $qt = mysqli_query($con, "SELECT * FROM tipos_de_usuarios WHERE idtipo=$tipo")or die(mysqli_error($con));
                    $userType = mysqli_fetch_array($qt);
                    $stuff['tipo'] = $userType['etiqueta'];
                    array_push($response["stuff"], $stuff);
                }
                $response["success"] = true;
                echo(json_encode($response));
            }else{
                $response["success"] = false;
                echo(json_encode($response));
            }	
            break;
        case "Especialista":
            
            $q = mysqli_query($con, "SELECT * FROM tipos_de_usuarios WHERE etiqueta = 'Estudiante'")or die(mysqli_error($con));
            $t = mysqli_fetch_array($q);
            $idTipo = $t['idtipo'];
            
            $query = mysqli_query($con, "SELECT * FROM usuarios WHERE idtipo = '$idTipo'")or die(mysqli_error($con));

	       $response["stuff"] = array();
            $count = mysqli_num_rows($query);
            if($count > 0){
                while ($user = mysqli_fetch_array($query)) {
                    $stuff = array();
                    $stuff['id'] = $user['idUsuario'];
                    $stuff['name'] = $user['nombre'];
                    $stuff['email'] = $user['email'];
                    $stuff['username'] = $user['username'];
                    $stuff['password'] = $user['password'];
                    $stuff['fecha'] = $user['fecha_ingreso'];
                    $tipo = $user['idtipo'];
                    $qt = mysqli_query($con, "SELECT * FROM tipos_de_usuarios WHERE idtipo=$tipo")or die(mysqli_error($con));
                    $userType = mysqli_fetch_array($qt);
                    $stuff['tipo'] = $userType['etiqueta'];
                    array_push($response["stuff"], $stuff);
                }
                $response["success"] = true;
                echo(json_encode($response));
            }else{
                $response["success"] = false;
                echo(json_encode($response));
            }	
            break;
    }
	
?>