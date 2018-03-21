<!DOCTYPE HTML>
<html>
	<head>
		<title>Especialista</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<script defer src="https://use.fontawesome.com/releases/v5.0.6/js/all.js"></script>
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css">
		<link rel="stylesheet" href="../assets/css/main.css" />
		<link rel="stylesheet" type="text/css" href="../assets/css/form.css">
	</head>
	<body>
		<?php 

			session_start();
			if(isset($_SESSION['username']) || isset($_SESSION['tipo'])){
				$name = $_SESSION['username'];
				$tipo = $_SESSION['tipo'];			
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
							<h1 id="title"><?php echo $tipo;?></h1>
							<p><?php echo $name;?></p>
						</div>

					<!-- Nav -->
						<nav id="nav">
							<ul>
								<li><a href="#top" id="top-link" class="skel-layers-ignoreHref"><span class="icon fa-home">INTRO</span></a></li>
								<li><a href="#evaluaciones" id="evaluaciones-link" class="skel-layers-ignoreHref"><span class="icon fa-th">Evaluaciones</span></a></li>
								<li><a href="#usuarios" id="usuarios-link" class="skel-layers-ignoreHref"><span class="icon fa-users">Usuarios</span></a></li>
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
					<section id="top" class="one dark cover allpage">
						<div class="container">

							<header>
								<h2 class="alt animated fadeInRight">Hola te presentamos el sistema de administración de evaluaciones.</h2>
								<p class="animated fadeInLeft">Aqui podras implementar tus evaluaciones sin contratiempos y de la forma mas segura.</p>
							</header>

							<footer class="animated fadeInUp delay-1">
								<a href="#evaluaciones" class="button scrolly">Ir a evaluaciones</a>
							</footer>

						</div>
					</section>

				<!-- evaluaciones -->
					<section id="evaluaciones" class="two">
						<div class="container">

							<header>
								<h2 class="lbldate">Evaluaciones</h2>
							</header>

							<p>
								<ul class="icons">
									<li>
										<a href="preguntas/" target="_blank" class="icon fa-plus"><span class="label">Agregar evaluación</span></a>
										<li id="syncEvas">
											<i class="icon fas fa-sync-alt"></i>
										</li>
									</li>
								</ul>
							</p>

							<div id="gestionEva">
						        <!--THIS IS IMPORTANT! to close the modal, the class name has to match the name given on the ID  class="close-animatedModal" -->
						        <div class="btgeva" style="display: none;"></div>
						        <div class="close-gestionEva"> 
						            <ul class="icons">
										<li>
											<a class="icon fa-close"><span class="label">Close</span></a>
										</li>
									</ul>
						        </div>
						            
						        <div class="modal-content">
						        	<header>
										<h2>Editar Evaluación</h2>
									</header>
						         	<form method="post">
						         		<input type="hidden" class="txtidEva">
						         		<div class='field'>
											<input class="txtTitulo" placeholder='Titulo' type="text" name="title">
										</div>
										<div class='field'>
											<input class="txtNum" placeholder='Número de Preguntas' type='number' name="num">
										</div>
										<div class="field">
											<select class="slctTema" name="theme">
												
											</select>
										</div>
										<div class="field">
											<select class="slctTipoEva" name="type">
												
											</select>
										</div>
										
										<div class='field form-actions'>
										 	<button class="btAddEva">Editar</button>
										</div>
						         	</form>
						        </div>
						    </div>

							<div class="evaTable">
								<div class="tbl-header">
								    <table cellpadding="0" cellspacing="0" border="0">
								      <thead>
								        <tr>
								          <th>ID</th>
								          <th>Titulo</th>
								          <th>Preguntas (#)</th>
								          <th>Tema</th>
								          <th>Tipo</th>
								          <th>Fecha</th>
								          <th>Accion</th>
								        </tr>
								      </thead>
								    </table>
								</div>
								<div class="tbl-content">
								    <table cellpadding="0" cellspacing="0" border="0">
								      <tbody>
								        <!--<tr>
								        	<td>1</td>
								        	<td>2</td>
								        	<td>3</td>
								        	<td>4</td>
								        	<td>5</td>
								        	<td class="actions">
								        		<ul class="icons">
													<li>
														<a class="icon fa-eye"><span class="label">Ver</span></a>
													</li>
												</ul>
								        	</td>
								        </tr>-->
								      </tbody>
								    </table>
								    <div class="loader">
									    <img src="../images/loading.svg">
									</div>
								</div>
							</div>
					</section>
				<!--Usuarios-->
					<section id="usuarios" class="two">
						<div class="container">
							<header>
								<h2>Usuarios</h2>
							</header>

							<p>
								<ul class="icons actions">
									<li>
										<a id="add-modal" href="#gestion" class="icon fa-plus"><span class="label">Agregar usuario</span></a>
									</li>
									<li id="syncUsers">
										<i class="icon fas fa-sync-alt"></i>
									</li>
								</ul>
							</p>

							<div id="gestion">
						        <!--THIS IS IMPORTANT! to close the modal, the class name has to match the name given on the ID  class="close-animatedModal" -->
						        <div class="close-gestion"> 
						            <ul class="icons">
										<li>
											<a class="icon fa-close"><span class="label">Close</span></a>
										</li>
									</ul>
						        </div>
						            
						        <div class="modal-content">
						        	<header>
										<h2>Alta de Usuario</h2>
									</header>
						         	<form method="post">
						         		<input type="hidden" class="txtiduser">
						         		<div class='field'>
											<input class="txtname" placeholder='Nombre Completo' type="text" name="name">
										</div>
										<div class='field'>
											<input class="txtemail" placeholder='Email' type='email' name="email">
										</div>
										<div class='field'>
											<input class="txtusername" placeholder='Nombre de usuario' type="text" name="username">
										</div>
										<div class='field'>
											<input class="pass1" placeholder='Contraseña' type="password" name="password">
										</div>
										<div class='field'>
											<input class="pass2" placeholder='Repetir Contraseña' type="password" name="password">
										</div>
										<div class='field'>
											<input class="txtdate" placeholder='Fecha' type="date" name="date">
										</div>
										<div class="field">
											<select class="slctTipo" name="tipos">
												
											</select>
										</div>
										<div class='field form-actions'>
										 	<button class="btAddUser">Dar de Alta</button>
										</div>
						         	</form>
						        </div>
						    </div>
                            
                             <div id="gestionAsign">
                                <!--THIS IS IMPORTANT! to close the modal, the class name has to match the name given on the ID  class="close-animatedModal" -->
                                <div class="close-gestionAsign">
                                    <ul class="icons">
                                        <li>
                                            <a class="icon fa-close"><span class="label">Close</span></a>
                                        </li>
                                    </ul>
                                </div>

                                <div class="modal-content">
                                    <header>
                                        <h2>Asignar Evaluación</h2>
                                    </header>
                                    <form method="post">
                                        <input type="hidden" name="iduser" class="txtiduser">
                                        <div class="field">
                                            <select class="slctEva" name="evas">

                                            </select>
                                        </div>
                                        <div class='field form-actions'>
                                            <button class="btAsignEva">Asignar</button>
                                        </div>
                                        <ul class="evaslist">
                                        	
                                        </ul>
                                    </form>
                                </div>
                            </div>
                            
						    <div class="userTable">
								<div class="tbl-header">
								    <table cellpadding="0" cellspacing="0" border="0">
								      <thead>
								        <tr>
								          <th>ID</th>
								          <th>Nombre</th>
								          <th>Fecha de Ingreso</th>
								          <th>Tipo</th>
								          <th>Acciones</th>
								        </tr>
								      </thead>
								    </table>
								</div>
								<div class="tbl-content">
								    <table cellpadding="0" cellspacing="0" border="0">
								      <tbody>
								        
								      </tbody>
								    </table>
								    <div class="loader">
									    <img src="../images/loading.svg">
									</div>
	  							</div>
	  						</div>
						</div>
					</section>
			</div>

		<!-- Footer -->
			<div id="footer">

				<!-- Copyright -->
					<ul class="copyright">
						<li>&copy; Amicus Marketing S.A. de C.V. 2017.</li><li><a href="https://amicusdemexico.com/page/aviso-de-privacidad/" target="_blank">Aviso de Privacidad</a></li>
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
			<script src="../../js/animatedModal.js"></script>
			<script src="../assets/js/requests.js"></script>
			<script type="text/javascript">
				$(document).ready(function(){
                    var tipo = '<?php echo $tipo;?>';
                    var id = '<?php echo $_SESSION['id'];?>';
					updateTable("../assets/php/allUsers.php", ".userTable .tbl-content table", ".userTable .tbl-content .loader", 1, tipo);
					updateTable("../assets/php/getEvas.php", ".evaTable .tbl-content table", ".evaTable .tbl-content .loader", 2, tipo, id);
					var closevent = $("#add-modal").animatedModal({
						modalTarget:'gestion',
		                animatedIn:'slideInUp',
		                animatedOut:'slideOutDown',
		                color:'#f5fafa',
		                beforeOpen: function() {
                    		$("#gestion").css("display", "block");
		                },           
		                afterOpen: function() {
		                    console.log("The animation is completed");
		                }, 
		                beforeClose: function() {
		                    console.log("The animation was called");
		                }, 
		                afterClose: function() {
		                   $("#gestion").css("display", "none");
		                }
					});

					var closeventEva = $(".btgeva").animatedModal({
						modalTarget:'gestionEva',
		                animatedIn:'slideInUp',
		                animatedOut:'slideOutDown',
		                color:'#f5fafa',
		                beforeOpen: function() {
                    		$("#gestionEva").css("display", "block");
		                },           
		                afterOpen: function() {
		                    console.log("The animation is completed");
		                }, 
		                beforeClose: function() {
		                    console.log("The animation was called");
		                }, 
		                afterClose: function() {
		                   $("#gestionEva").css("display", "none");
		                }
					});

					$(".slctTipo").fillData("../assets/php/types.php");
					$(".slctTema").fillData("../assets/php/temas.php");
					$(".slctTipoEva").fillData("../assets/php/evaTypes.php");
                    $(".slctEva").getEvaluations("../assets/php/evas.php");
                    
					$(".btAddUser").off("click").on("click", function(e){
						e.preventDefault();
						var t = $(this).text()
						switch(t){
							case "Dar de Alta":
								$("#gestion .modal-content form").addUser("../assets/php/gestionUser.php", closevent);
							break;
							case "Actualizar":
								$("#gestion .modal-content form").editUser($(".txtiduser").val(), "../assets/php/gestionUser.php", closevent);
							break;
							case "Dar de Baja":
								$("#gestion .modal-content form").deleteUser($(".txtiduser").val(), "../assets/php/gestionUser.php", closevent);
							break;
						}
					});

					$(".btAddEva").off("click").on("click", function(e){
						e.preventDefault();
						var t = $(this).text()
						switch(t){
							case "Editar":
								$("#gestionEva .modal-content form").editEva($(".txtidEva").val() ,"../assets/php/gestionEvas.php", closeventEva, "../assets/php/getEvas.php");
							break;
							case "Eliminar":
								$("#gestionEva .modal-content form").deleteEva($(".txtidEva").val() ,"../assets/php/gestionEvas.php", closeventEva, "../assets/php/getEvas.php");
							break;
						}
					});

					$("#syncUsers").off("click").on("click", function(e){
						updateTable("../assets/php/allUsers.php", ".userTable .tbl-content table", ".tbl-content .loader", 1);
					});

					$("#syncEvas").off("click").on("click", function(e){
						updateTable("../assets/php/getEvas.php", ".evaTable .tbl-content table", ".evaTable .tbl-content .loader", 2);
					});

					 $(".btAsignEva").off("click").on("click", function(e){
					 	 e.preventDefault();
	                    var t = $(this).text()
	                    switch (t) {
	                        case "Asignar":
	                        	$("#gestionAsign .modal-content form").asignEva("../assets/php/asignEva.php");
	                        break;
	                        case "Eliminar":
	                        	alert("deleted");
	                        break;
	                    }
                	});
				});

				$(document).keyup(function(e) {
					     if (e.keyCode == 27) { // escape key maps to keycode `27`
					     	if($("#gestion").hasClass('gestion-on')){
					       		closevent.click();
					   		}
					   		
					   		if($("#gestionEva").hasClass('gestionEva-on')){
					   			closeventEva.click();
					   		}
					    }

					});
			</script>
	</body>
</html>