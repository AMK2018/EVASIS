<?php 

	session_start();
    if(isset($_POST['info'])){
	   $info = $_POST['info'];
        if(isset($_SESSION['username']) || isset($_SESSION['tipo'])){
		  $name = $_SESSION['username'];
          $tipo = $_SESSION['tipo'];		
          $id = $_SESSION['id'];	
        }else{
            echo '<script>alert("No puedes realizar una evaluación sin haberte logueado");
            window.close();</script>';
        }
    }else{
        echo '<script>alert("No puedes realizar una evaluación sin haberte logueado");
        window.close();</script>';
    }
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="shortcut icon" type="image/svg" href="../images/books.svg" />
    <title>Evaluación</title>
    <script defer src="https://use.fontawesome.com/releases/v5.0.6/js/all.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css">
    <link rel="stylesheet" href="../assets/css/reveal.css">
    <link rel="stylesheet" href="../assets/css/theme/moon.css">
    <link rel="stylesheet" href="css/modal.css">
    <link rel="stylesheet" href="css/form.css">
    <style type="text/css">
        #video-container {
            position: absolute;
            background: #ccc;
            width: 20%;
            height: 20%;
            padding: 10px;
            z-index: 1000;
        }

        #video {
            width: 100%;
            height: 100%;
        }
    </style>
</head>

<body>

    <div id="video-container">
        <video id="video"></video>
    </div>

    <div class="reveal">
        <form class="slides">

        </form>
    </div>

    <!--modalContent -->
    <div id="modal" class="animated zoomIn">
        <div id="modalMedia"></div>
        <div class="content">
            <h1>BIENVENIDO</h1>
            <p>
                AL REALIZAR ESTA EVALUACIÓN USTED SE COMPROMETE A ACEPTAR LAS CONDICIONES DE USO DE ESTE SISTEMA, POR MOTIVOS DE SEGURIDAD SE LE GRABARÁ HACIENDO USO DE AL WEBCAM DEL EQUIPO.
            </p>
            <p>
                RESTRICCIONES PARA LA APROBACIÓN DE SU EVALUACIÓN:
            </p>
            <ol>
                <li>NO SE PERMITE VOLTEAR HACIA LOS LADOS</li>
                <li>NO SE PERMITE PLATICAR</li>
                <li>EL ALUMNO SOLO PODRA TENER ABIERTO UNICAMENTE EL SISTEMA DE EVALUACIÓN DURANTE EL TRANSCURSO DE LA PRUEBA.
                </li>
            </ol>
            <p>
                <button id="startEvaRec" style="cursor:pointer;">Continuar</button>
            </p>
        </div>
    </div>

    <script src="../assets/js/jquery.min.js"></script>
    <script src="../assets/lib/js/head.min.js"></script>
    <script src="../assets/js/reveal.js"></script>
    <script src="../../js/animatedModal.js"></script>
    <script src="../assets/js/requests.js"></script>
    <script src="https://www.webrtc-experiment.com/MediaStreamRecorder.js">
    </script>

    <script type="text/javascript">
        $(document).ready(function() {
            //get the information from the evaluation
            var json = JSON.parse('<?php echo $info;?>');
            
            //create slides about the question from eva info
            $(".slides").empty();
            $(".slides").append(
                "<section >" +
                "<h1>EVALUACIÓN - <label class='lblTitle'></label></h1>" +
                "<ul>" +
                "<li>Fecha: <label class='lblDate'></label></li>" +
                "<li>Número de Preguntas: <label class='lblNum'></label></li>" +
                "<li>Tema: <label class='lblTheme'></label></li>" +
                "<li>Tipo: <label class='lblType'></label></li>" +
                "</ul>" +
                "</section>");

            $(".lblTitle").text(json.titulo);
            $(".lblDate").text(json.date);
            $(".lblTheme").text(json.theme);
            $(".lblType").text(json.type);

            var idUser = "<?php echo $id; ?>";
            var idEva = json.idEva;
            var date = json['asign-date'];
        
            switch(idUser){
                case "1":
                    getQtns("php/qtns.php", json.theme);
                break;
                case "2":
                    if(date != null && date != "" && date != undefined){
                        date = myDate(date);
                        checkEvaDone(idUser, idEva, date);
                    }
                break;
                case "3":
                    getQtns("php/qtns.php", json.theme);
                break;
            }
            
            function checkEvaDone(idUser, idEva, date){
                $.post("php/check.php",{iduser:idUser, ideva:idEva, date:date}, function (data) {
                    if (data.status.includes('true')) {
                        if(data.stuff.status == "Incomplete"){
                            getQtns("php/qtns.php", json.theme);
                        }else{
                            $("#modal").removeClass("zoomIn");
                            $("#modal").addClass("zoomOut");
                            $("#modal").remove();
                            $("#video-container").remove();
                            
                            var media = data.stuff.media.replace('../','');
                            $(".slides").append("<section><h2>Puntaje</h2></br><p>Score: " +data.stuff.score+"%</p></section>");
                            $(".slides").append("<section data-background-video="+media+"><h2>Comprobante</h2></section>");
                            intiSlides();
                        }
                    }else {
                        alert("falla al confirmar datos intenta de nuevo mas tarde...");
                    }
                }, 'json').done(function () {

                }).fail(function (xhr, status, error) {
                    alert("Error intenta de nuevo...");
                }).always(function () {
                    
                });
            }

            function myDate(mydate){
                mydate = mydate.replace(/de/g, '');
                var months = ["ENERO", "FEBRERO", "MARZO", "ABRIL", "MAYO", "JUNIO", "JULIO", "AGOSTO", "SEPTIEMBRE", "OCTUBRE", "NOVIEMBRE", "DICIEMBRE"];
                
                var split = mydate.split('  ');
                
                if(split.length > 1){
                    var m;
                    for(var i = 0; i < months.length; i++){
                        if(split[1].toUpperCase() == months[i]){
                            m = i + 1;
                            if(m.toString().length <= 1){
                                m = "0"+m;
                            }
                        }
                    }
                
                    var newDate = split[2] + "-" + m + "-" + split[0];
                    return newDate;
                }
                return null;
            }

            //call questions
            function getQtns(path, tema){
                var questions;
                $.get(path,{theme:tema}, function (data) {
                    if (data.status.includes('true')) {
                       questions = data.stuff;
                    }else {
                        alert(data.msg);
                    }
                }, 'json').done(function () {

                }).fail(function (xhr, status, error) {
                    alert("Error intenta de nuevo...");
                }).always(function () {
                    if(questions != undefined ){
                        if(json.num < questions.length){
                            createSlides(questions, json.num, json.type);

                            intiSlides();

                            initVideoRecorder(questions);
                        }else{
                            createSlides(questions, questions.lenth, json.type);
                            
                            intiSlides();

                            initVideoRecorder(questions);
                        }
                    }
                });
            }

            function createSlides(questions, num, type){
                switch(type){
                    case "Cuestionario":
                        $(".lblNum").text(num);
                        for (var i = 0; i < questions.length; i++) {
                            var pregunta = questions[i].pregunta;
                            $(".slides").append('<section><h2>Pregunta ' + (i + 1) + '</h2></br>'+ pregunta +'</br><input type="text" name="p'+i+'"/></section>');
                        }
                        $(".slides").append('<section><h2> FELICIDADES TERMINASTE TU EVALUACIÓN</h2><label id="stopEvaRec" style="cursor:pointer;">Salir</label></section>');
                    break;
                    case "Relacion de Columnas":
                    break;
                    case "Opcion Multiple":
                    break;    
                }
            }
            
            //record video functions
            function initVideoRecorder(questions){
                 //video recorder
                function captureUserMedia(mediaConstraints, successCallback, errorCallback) {
                    navigator.mediaDevices.getUserMedia(mediaConstraints).then(successCallback).catch(errorCallback);
                }
                var mediaConstraints = {
                    audio: !IsOpera && !IsEdge, // record both audio/video in Firefox/Chrome
                    video: true
                };

                var videosContainer = document.getElementById('video-container');
                var index = 1;
                var mediaRecorder, mediaStream;

                function onMediaSuccess(stream) {
                    var video = document.querySelector('#video');
                    video = mergeProps(video, {
                        controls: false,
                        muted: true
                    });
                    video.srcObject = stream;
                    mediaStream = stream;
                    video.play();
                    mediaRecorder = new MediaStreamRecorder(stream);
                    mediaRecorder.mimeType = 'video/webm';
                    mediaRecorder.ondataavailable = function(blob) {
                        uploadToPHPServer(blob);
                    };
                    mediaRecorder.start();
                }

                function onMediaError(e) {
                    console.log('media error', e);
                }

                function uploadToPHPServer(blob) {
                    var name = "<?php echo $name; ?>";
                    name = name.replace(/ /g,'_');
                    var file = new File([blob],  name +'-' + (new Date).toISOString().replace(/:|\./g, '-') + '.webm', {
                        type: 'video/webm'
                    });

                    // create FormData
                    var formData = new FormData();
                    formData.append('video-filename', file.name);
                    formData.append('video-blob', file);
                    
                    var score = checkQuestions(questions);

                    formData.append('score', score);
                    formData.append('ideva', json.idEva);
                    formData.append('iduser', idUser);

                    var date = myDate(json['asign-date']);
                    formData.append('date', date);

                    makeXMLHttpRequest('php/scores.php', formData, function(data) {
                        if(data.status.includes('true')){
                            window.close();
                        }else if(data.status.includes('no-asigned')){
                            alert("Esta evaluación no ha sido asignada a este usuario, los datos no se guardaran");
                        }else{
                            alert("falla al enviar datos intenta de nuevo mas tarde...");
                        }
                    });
                }

                function makeXMLHttpRequest(url, data, callback) {
                    var request = new XMLHttpRequest();
                    request.onreadystatechange = function() {
                        if (request.readyState == 4 && request.status == 200) {
                            if( typeof callback === 'function' ){
                                callback(JSON.parse(request.responseText));
                            }
                        }
                    };
                    request.open('POST', url);
                    request.send(data);
                }

                var checkQuestions = function(qtns){
                    var formarray = $(".reveal .slides").serializeArray();
                    var score = 0;
                    $.map(formarray,  function (val, index) {  
                        var answ = qtns[index].respuesta;
                        var v = val.value;
                        if(v == answ){
                            score++;
                        }
                    });
                    var qtnsNums = $(".lblNum").text();
                    
                    return (score * 100)/qtnsNums;
                }

                document.querySelector('#startEvaRec').onclick = function() {
                    this.disabled = true;
                    captureUserMedia(mediaConstraints, onMediaSuccess, onMediaError);
                    $("#modal").removeClass("zoomIn");
                    $("#modal").addClass("zoomOut");
                    $("#modal").hide();
                };

                document.querySelector('#stopEvaRec').onclick = function() {
                    this.disabled = true;
                    console.log('Just stopped the recording');
                    mediaStream.getVideoTracks()[0].stop();
                    mediaRecorder.stop();
                    $(".controls").hide();
                    //window.close();
                };

                window.onbeforeunload = function() {
                    document.querySelector('#start-recording').disabled = false;
                };
            }

            function intiSlides(){
                
                Reveal.initialize({
                    controls: true,
                    progress: true,
                    history: true,
                    center: true,

                    transition: 'fade',

                    dependencies: [{
                            src: '../assets/lib/js/classList.js',
                            condition: function() {
                                return !document.body.classList;
                            }
                        },
                        {
                            src: '../assets/plugin/markdown/marked.js',
                            condition: function() {
                                return !!document.querySelector('[data-markdown]');
                            }
                        },
                        {
                            src: '../assets/plugin/markdown/markdown.js',
                            condition: function() {
                                return !!document.querySelector('[data-markdown]');
                            }
                        },
                        {
                            src: '../assets/plugin/highlight/highlight.js',
                            async: true,
                            callback: function() {
                                hljs.initHighlightingOnLoad();
                            }
                        },
                        {
                            src: '../assets/plugin/search/search.js',
                            async: true
                        },
                        {
                            src: '../assets/plugin/zoom-js/zoom.js',
                            async: true
                        },
                        {
                            src: '../assets/plugin/notes/notes.js',
                            async: true
                        }
                    ]
                });
            }
        });
    </script>
</body>

</html>