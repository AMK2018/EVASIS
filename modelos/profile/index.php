<!DOCTYPE HTML>
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

<html>

<head>
    <title>
        <?php echo $name;?>
    </title>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <meta name="description" content="" />
    <meta name="keywords" content="" />
    <!--[if lte IE 8]><script src="css/ie/html5shiv.js"></script><![endif]-->
    <script src="js/jquery.min.js"></script>
    <script src="js/jquery.poptrox.min.js"></script>
    <script src="js/skel.min.js"></script>
    <script src="js/init.js"></script>
    <noscript>
        <link rel="stylesheet" href="css/skel.css" />
        <link rel="stylesheet" href="css/style.css" />
        <link rel="stylesheet" href="css/style-xlarge.css" />
    </noscript>
    <!--[if lte IE 8]><link rel="stylesheet" href="css/ie/v8.css" /><![endif]-->
</head>

<body id="top">

    <!-- Header -->
    <header id="header">
        <a href="#" class="image avatar"><img src="images/user-circle-o.svg" alt="" /></a>
        <h1><strong><?php echo $tipo;?></strong>:
            <?php echo $name;?><br /></h1>
        <p>Usuario registardo el día <strong class="user_date"></strong></p>
    </header>

    <!-- Main -->
    <div id="main">

        <section class="secEvas">
            <h2>Evaluaciones Asignadas</h2>
            <div class="table-wrapper">
                <table>
                    <thead>
                        <tr>
                            <th>Titulo</th>
                            <th>preguntas(#)</th>
                            <th>Tema</th>
                            <th>Tipo</th>
                            <th>Fecha de Creación</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        
                    </tbody>
                </table>
            </div>
        </section>
    </div>

    <!-- Footer -->
    <footer id="footer">
        <ul class="icons">
            <li><a href="#" class="icon fa-twitter"><span class="label">Twitter</span></a></li>
            <li><a href="#" class="icon fa-github"><span class="label">Github</span></a></li>
            <li><a href="#" class="icon fa-dribbble"><span class="label">Dribbble</span></a></li>
            <li><a href="#" class="icon fa-envelope-o"><span class="label">Email</span></a></li>
        </ul>
        <ul class="copyright">
            <li>&copy; Amicus Marketing S.A. de C.V. 2017.</li>
            <li><a href="https://amicusdemexico.com/page/aviso-de-privacidad/" target="_blank">Aviso de Privacidad</a></li>
        </ul>
    </footer>

    <script src="../assets/js/jquery.min.js"></script>
    <script src="../assets/js/requests.js"></script>
    <script>
        $(document).ready(function() {
            //get the information from the evaluation
            var json = JSON.parse('<?php echo $info;?>');

            $(".user_date").text(json.fecha);

            $(".image.avatar").hover(function() {
                $(".image.avatar img").attr("src", "images/user-circle.svg");
            }, function() {
                $(".image.avatar img").attr("src", "images/user-circle-o.svg");
            });
            
            $(".secEvas .table-wrapper table").getUserEva("../assets/php/getUserEvas.php", json.id, 1);
        });

    </script>
</body>

</html>
