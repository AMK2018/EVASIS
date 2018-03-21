<?php 

	session_start();
    if(isset($_POST['info'])){
	   $info = $_POST['info'];
        if(isset($_SESSION['username']) || isset($_SESSION['tipo'])){
		  $name = $_SESSION['username'];
		  $tipo = $_SESSION['tipo'];			
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
                <button id="startEvaRec">Continuar</button>
            </p>
        </div>
    </div>

    <script src="../assets/js/jquery.min.js"></script>
    <script src="../assets/lib/js/head.min.js"></script>
    <script src="../assets/js/reveal.js"></script>
    <script src="../../js/animatedModal.js"></script>
    <script src="https://www.webrtc-experiment.com/MediaStreamRecorder.js">
    </script>

    <script type="text/javascript">
        $(document).ready(function() {
            //get the information from the evaluation
            var json = JSON.parse('<?php echo $info;?>');
            
           
            getQtns("php/qtns.php", json.theme);

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

            $(".lblTitle").text(json.title);
            $(".lblDate").text(json.date);
            $(".lblTheme").text(json.theme);
            $(".lblType").text(json.type);


           

            //modal content

            //call questions
            function getQtns(path, tema){
                var questions;
                $.get(path,{theme:tema}, function (data) {
                    if (data.success == "true") {
                       questions = data.stuff;
                    } else {
                        alert("falla al cargar datos intenta de nuevo mas tarde...");
                    }
                }, 'json').done(function () {

                }).fail(function (xhr, status, error) {
                    alert("Error intenta de nuevo...");
                }).always(function () {
                    if(json.num < questions.length){
                        $(".lblNum").text(json.num);
                        for (var i = 0; i < json.num; i++) {
                            var pregunta = questions[i].pregunta;
                            $(".slides").append('<section><h2>Pregunta ' + (i + 1) + '</h2></br>'+ pregunta +'</section>');
                        }
                    }else{
                        $(".lblNum").text(questions.length);
                        for (var i = 0; i < questions.length; i++) {
                            var pregunta = questions[i].pregunta;
                            $(".slides").append('<section><h2>Pregunta ' + (i + 1) + '</h2></br>'+ pregunta +'</br><input type="text" name="p'+i+'/>"</section>');
                        }
                        $(".slides").append('<section><h2> FELICIDADES TERMINASTE TU EVALUACIÓN</h2><buuton id="stopEvaRec">Salir</button></section>');

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

                        initVideoRecorder();
                    }
                });
            }

            function initVideoRecorder(){
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
                    var file = new File([blob], 'msr-' + (new Date).toISOString().replace(/:|\./g, '-') + '.webm', {
                        type: 'video/webm'
                    });

                    // create FormData
                    var formData = new FormData();
                    formData.append('video-filename', file.name);
                    formData.append('video-blob', file);

                    makeXMLHttpRequest('php/upload.php', formData, function() {
                        window.close();
                    });
                }

                function makeXMLHttpRequest(url, data, callback) {
                    var request = new XMLHttpRequest();
                    request.onreadystatechange = function() {
                        if (request.readyState == 4 && request.status == 200) {
                            callback();
                        }
                    };
                    request.open('POST', url);
                    request.send(data);
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
        });
    </script>
</body>

</html>