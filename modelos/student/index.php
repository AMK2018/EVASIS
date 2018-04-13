<?php ob_start(); session_start();?>
<!DOCTYPE HTML>
<html>

<head><meta http-equiv="Content-Type" content="text/html; charset=gb18030">
    <title>Estudiante</title>
    
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <script defer src="https://use.fontawesome.com/releases/v5.0.6/js/all.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css">
    <link rel="stylesheet" href="../assets/css/main.css" />
    <link rel="stylesheet" type="text/css" href="../assets/css/form.css">
    <script src="//cdnjs.cloudflare.com/ajax/libs/list.js/1.5.0/list.min.js"></script>
</head>

<body>
    <?php 
			if(isset($_SESSION['username']) || isset($_SESSION['tipo'])){
				$name = $_SESSION['username'];
				$tipo = $_SESSION['tipo'];
                $id = $_SESSION['id'];
			}else{
				header("location: ../../");
			}
		?>
    <!-- Header -->
    <div id="header">

        <div class="top">

            <!-- Logo -->
            <div id="logo">
                <span class="image avatar48"><a href="#" class="icon fa-user"></a></span>
                <h1 id="title">
                    <?php echo $tipo;?>
                </h1>
                <p>
                    <?php echo $name;?>
                </p>
            </div>

            <!-- Nav -->
            <nav id="nav">
                <ul>
                    <li><a href="#top" id="top-link" class="skel-layers-ignoreHref"><span class="icon fa-home">INTRO</span></a></li>
                    <li><a href="#evaluaciones" id="evaluaciones-link" class="skel-layers-ignoreHref"><span class="icon fa-th">Mis Evaluaciones</span></a></li>
                </ul>
            </nav>

        </div>

        <div class="bottom">
            <ul class="icons">
                <li><a href="../../php/logout.php" class="icon fa-sign-out"><span class="label">Cerrar sesión</span></a></li>
            </ul>

        </div>

    </div>

    <!-- Main -->
    <div id="main">

        <!-- Intro -->
        <section id="top" class="one dark cover">
            <div class="container">

                <header>
                    <h2 class="alt animated fadeInRight">Hola te presentamos el sistema de administración de evaluaciones.</h2>
                    <p class="animated fadeInLeft">Aqui podras realizar tus evaluaciones sin contratiempos y de la forma mas segura.</p>
                </header>

                <footer class="animated fadeInUp delay-1">
                    <a href="#evaluaciones" class="button scrolly">Ir a mis evaluaciones</a>
                </footer>

            </div>
        </section>
        <!-- evaluaciones -->
        <section id="evaluaciones" class="two cover allpage">
            <div class="container">
                <header>
                    <h2 class="lbldate">Mis Evaluaciones</h2>
                </header>
                <div id="eva-list">
                    <ul class="list">
                        
                    </ul>
                </div>
            </div>
        </section>
    </div>
    <!-- Footer -->
    <div id="footer">
        <!-- Copyright -->
        <ul class="copyright">
            <li>&copy; Amicus Marketing S.A. de C.V. 2017.</li>
            <li><a href="https://amicusdemexico.com/page/aviso-de-privacidad/" target="_blank">Aviso de Privacidad</a></li>
        </ul>

    </div>

        <!-- Scripts -->
        <script src="../assets/js/jquery.min.js"></script>
        <script src="../assets/js/jquery.scrolly.min.js"></script>
        <script src="../assets/js/jquery.scrollzer.min.js"></script>
        <script src="../assets/js/skel.min.js"></script>
        <script src="../assets/js/util.js"></script>
        <!--[if lte IE 8]><script src="assets/js/ie/respond.min.js"></script><![endif]-->
        <script src="../assets/js/main.js"></script>
        <script src="../assets/js/requests.js"></script>
        <script type="text/javascript">
            $(document).ready(function() {
              var id = '<?php echo $id;?>';  
              $("#eva-list").getUserEva("../assets/php/getAsigns.php", id, 2);
            });
        </script>
</body>

</html>
<?php ob_end_flush();?>