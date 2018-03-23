<?php 
    require "../../../php/connect.php";
    date_default_timezone_set('UTC');

    $score = $_POST['score'];
    $iduser = $_POST['iduser'];
    $ideva = $_POST['ideva'];
    $fecha = $_POST['date'];

    if($score >= 70){
        $status = "Success";
    }else{
        $status = "Failed";
    }


    #init saving video
        if (!isset($_POST['audio-filename']) && !isset($_POST['video-filename'])) {
            echo 'PermissionDeniedError';
            return;
        }

        $fileName = '';
        $tempName = '';

        if (isset($_POST['audio-filename'])) {
            $fileName = $_POST['audio-filename'];
            $tempName = $_FILES['audio-blob']['tmp_name'];
        } else {
            $fileName = $_POST['video-filename'];
            $tempName = $_FILES['video-blob']['tmp_name'];
        }

        if (empty($fileName) || empty($tempName)) {
            echo 'PermissionDeniedError';
            return;
        }
        $filePath = '../../../media/' . $fileName;

        // make sure that one can upload only allowed audio/video files
        $allowed = array(
            'webm',
            'wav',
            'mp4',
            'mp3',
            'ogg'
        );
        $extension = pathinfo($filePath, PATHINFO_EXTENSION);
        if (!$extension || empty($extension) || !in_array($extension, $allowed)) {
            echo 'PermissionDeniedError';
            continue;
        }

        if (!move_uploaded_file($tempName, $filePath)) {
            echo ('Problem saving file.'. $tempName."/".$filePath);
            return;
        }
    #end saving video

    $response = null;
    
    $stat = mysqli_query($con, "UPDATE asignaciones SET score='$score', status='$status', media='$filePath' WHERE idUsuario=$iduser AND idEvaluacion=$ideva AND fecha_asign='$fecha'")or die(mysqli_error($con));

    if($stat){
        $response['status'] = "true";
    }else{
        $response['status'] = "no-asigned";
    }
    
    echo(json_encode($response));

?>