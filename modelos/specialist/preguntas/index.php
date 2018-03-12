<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<title>Preguntas</title>
	<link rel="stylesheet" type="text/css" href="../../assets/css/form.css">
	<link rel="stylesheet" type="text/css" href="../../assets/css/main.css">
	<script defer src="https://use.fontawesome.com/releases/v5.0.6/js/all.js"></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css">
	<script src="../../assets/js/jquery.min.js"></script>
</head>
<body>
	<?php 

		session_start();

		if(isset($_SESSION['username']) || isset($_SESSION['tipo'])){
			$name = $_SESSION['username'];
			$tipo = $_SESSION['tipo'];			
		}else{
			header("location: ../../../");
		}
	?>

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
						<li><a href="#evaluaciones" id="evaluaciones-link" class="skel-layers-ignoreHref"><span class="icon fa-book">Evaluaciones</span></a></li>
						<li><a href="#themes" id="themes-link" class="skel-layers-ignoreHref"><span class="icon fa-graduation-cap">Temas</span></a></li>
						<li><a href="#add-evaluation" id="add-evaluation-link" class="skel-layers-ignoreHref"><span class="icon fa-plus-square">Crear Evaluación</span></a></li>
						<li><a href="#add-questions" id="add-questions-link" class="skel-layers-ignoreHref"><span class="icon fa-plus-square">Crear Preguntas</span></a></li>
					</ul>
				</nav>

		</div>

		<div class="bottom">

				<!--<ul class="icons">
					<li><a href="#" class="icon fa-twitter"><span class="label">Twitter</span></a></li>
					<li><a href="#" class="icon fa-facebook"><span class="label">Facebook</span></a></li>
					<li><a href="#" class="icon fa-github"><span class="label">Github</span></a></li>
					<li><a href="#" class="icon fa-dribbble"><span class="label">Dribbble</span></a></li>
					<li><a href="#" class="icon fa-envelope"><span class="label">Email</span></a></li>
				</ul>-->
				<ul class="icons">
					<li><a href="javascript:close_window();" class="icon fa-angle-left"><span class="label">Cerrar sesión</span></a></li>
				</ul>

		</div>

	</div>

	<div id="main">

		<section id="top" class="two allpage">
			<div class="container">
				<header>
					<h2 class="alt"> <div class="animated fadeInLeft">GESTION</div><div class="animated fadeIn">DE</div><div class="animated fadeInRight">EVALUACIONES</div></h2>
					<div class="animated fadeInUp delay-1">
                        <h3>Creación, Edición y Eliminación de evaluaciones.</h3>
						<img src="../../images/books.svg" width="300">
                    </div>
				</header>
			</div>
		</section>
		<!--Evaluaciones-->
		<section id="evaluaciones" class="two biggerpage">
			<div class="container">
				<header class="animated fadeInDown">
					<h2>Evaluaciónes</h2>
				</header>
				<p>
					<ul class="icons">
						<li>
							<a href="#add-evaluation" class="icon fa-plus"><span class="label">Agregar evaluación</span></a>
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
						    <img src="../../images/loading.svg">
						</div>
					</div>
				</div>
			</div>
		</section>

		<!--Temas-->
		<section id="themes" class="two biggerpage">
			<div class="container">
				<header class="animated fadeInDown">
						<h2>Temas</h2>
				</header>
				<footer class="animated fadeInUp">
					
					<p>
						<ul class="icons">
							<li>
								<a id="add-Theme" href="#gestionTheme" class="icon fa-plus"><span class="label">Agregar Tema</span></a>
								<li id="syncThemes">
									<i class="icon fas fa-sync-alt"></i>
								</li>
							</li>
						</ul>
					</p>


					<div id="gestionTheme">
				        <!--THIS IS IMPORTANT! to close the modal, the class name has to match the name given on the ID  class="close-animatedModal" -->
				        <div class="btgTheme" style="display: none;"></div>
				        <div class="close-gestionTheme"> 
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
				         		<input type="hidden" class="txtidTheme">
				         		<div class='field'>
									<input class="txtTema" placeholder='Tema' type="text" name="tema">
								</div>
							
								
								<div class='field form-actions'>
								 	<button class="btAddTheme">Editar</button>
								</div>
				         	</form>
				        </div>
				    </div>

					<div class="themeTable">
						<div class="tbl-header">
						    <table cellpadding="0" cellspacing="0" border="0">
						      <thead>
						        <tr>
						          <th>ID</th>
						          <th>Tema</th>
						          <th>Accion</th>
						        </tr>
						      </thead>
						    </table>
						</div>
						<div class="tbl-content" style="height: 400px !important;">
						    <table cellpadding="0" cellspacing="0" border="0">
						      <tbody>
						        <!--<tr>
						        	<td>1</td>
						        	<td>2</td>
						        	
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
							    <img src="../../images/loading.svg">
							</div>
						</div>
					</div>
				</footer>
			</div>
		</section>
		<!--Creacion de evaluaciones-->
		<section id="add-evaluation" class="two">
			<div class="container">
				<header class="animated fadeInDown">
						<h2>Crear Evaluación</h2>
				</header>

				<footer class="animated fadeInUp">
					<form>
						<div class='field'>
							<input placeholder='Evaluación' type="Text" name="titulo">
							<label>Evaluación</label>
						</div>
						<div class='field'>
							<input placeholder='Numero de Preguntas' type="number" name="num">
							<label>Numero de Preguntas</label>
						</div>
						<div class="field">
							<label>Tema</label>
							<select class="slctTema" name="tema">
								
							</select>
						</div>
						<div class="field">
							<label>Tipo</label>
							<select class="slctTipo" name="tipo">
								
							</select>
						</div><br>
					</form>
					<a class="button">Crear Evaluación</a>
				</footer>
			</div>
		</section>
		<!--Creacion de preguntas para evaluaciones-->
		<section id="add-questions" class="two biggerpage">
			<div class="container">
				<header class="animated fadeInDown">
					<h2>Crear Preguntas</h2>
				</header>
				<footer class="animated fadeInUp eva">
					<div class="field">
                        <select class="slctTema QSNSlctTema" name="tema">

                        </select>
                    </div>
                    <div class="field">
                        <select class="slctTipo QSNSlctTipo" name="tipo">

                        </select>
                    </div>
					<br>
                    <label>Añadir Pregunta &nbsp;&nbsp;<a id="addQ" class="icon fa-plus" style="cursor: pointer;"></a>&nbsp;&nbsp; <i class="np">Numero de preguntas 0 </i></label>
					<br>
					
					<form class="Qform" method="post" class="animated fadeInUp delay-1">

					</form><br>
					<a class="button">Guardar Preguntas</a>
				</footer>
			</div>
		</section>
	</div>

	<script src="../../assets/js/jquery.min.js"></script>
	<script src="../../assets/js/jquery.scrolly.min.js"></script>
	<script src="../../assets/js/jquery.scrollzer.min.js"></script>
	<script src="../../assets/js/skel.min.js"></script>
	<script src="../../assets/js/util.js"></script>
	<script src="../../assets/js/main.js"></script>
	<script src="../../assets/js/requests.js"></script>
	<script src="../../../js/animatedModal.js"></script>
	<script type="text/javascript">
		$(document).ready(function(){
            var tipo = '<?php echo $tipo; ?>';
            var id = '<?php echo $_SESSION['id']; ?>';
			updateTable("../../assets/php/allEvas.php", ".evaTable .tbl-content table", ".evaTable .tbl-content .loader", 2, tipo, id);
			updateTable("../../assets/php/temas.php", ".themeTable .tbl-content table", ".themeTable .tbl-content .loader", 3);
			$("#gestionEva, #gestionTheme").css("display", "none");
			$(".slctTema").fillData("../../assets/php/temas.php");
			$(".slctTipo").fillData("../../assets/php/evaTypes.php");
			$(".slctEva").getEvaluations("../../assets/php/evas.php");

			$("#add-evaluation footer .button").off("click").on("click", function(){
				$("#add-evaluation footer form").addEva("../../assets/php/gestionEvas.php", "../../assets/php/");
			});

			var closeventEva = $(".btgeva").animatedModal({
				modalTarget:'gestionEva',
                animatedIn:'slideInUp',
                animatedOut:'slideOutDown',
                color:'#f5fafa'
			});

			var closevent = $("#add-Theme").animatedModal({
						modalTarget:'gestionTheme',
		                animatedIn:'slideInUp',
		                animatedOut:'slideOutDown',
		                color:'#f5fafa',
		                beforeOpen: function() {
                    		$("#gestionTheme").css("display", "block");
		                },           
		                afterOpen: function() {
		                    console.log("The animation is completed");
		                }, 
		                beforeClose: function() {
		                    console.log("The animation was called");
		                }, 
		                afterClose: function() {
		                   $("#gestionTheme").css("display", "none");
		                }
					});

			var closeventTheme = $(".btgTheme").animatedModal({
						modalTarget:'gestionTheme',
		                animatedIn:'slideInUp',
		                animatedOut:'slideOutDown',
		                color:'#f5fafa',
		                beforeOpen: function() {
		                	$("#gestionTheme").css("display", "block");
		                },           
		                afterOpen: function() {
		                    console.log("The animation is completed");
		                }, 
		                beforeClose: function() {
		                    console.log("The animation was called");
		                }, 
		                afterClose: function() {
		                    $("#gestionTheme").css("display", "none");
		                }
					});

			$(".slctTema").fillData("../../assets/php/temas.php");
			$(".slctTipoEva").fillData("../../assets/php/evaTypes.php");
            
			/*$(".slctEva").change(function(event) {
				$(this).evaInfo("../../assets/php/getEva.php");
			});*/
            var n = 0;
            
            $(".QSNSlctTema").change(function(){
                $("#add-questions footer.eva form").empty();
                n = 0;
                $(".np").text("Numero de preguntas " + n);
            });
            
            $(".QSNSlctTipo").change(function(){
                $("#add-questions footer.eva form").empty();
                n = 0;
                $(".np").text("Numero de preguntas " + n);
            });
            
			$("#addQ").off("click").on("click", function(){
				
                var tipo = $('.QSNSlctTipo :selected').text();
                var q = null;
                
                switch(tipo){
                    case "Opcion Multiple":
                        q = "<div class='question'>" +
                            "<div id='p' class='field'>" +
                                "<input placeholder='Pregunta "+(n + 1)+"' type='Text' name='p"+(n + 1)+"'>"+
                                "<label>Pregunta "+(n + 1)+"</label>"+
                            "</div>" +
                            "<div id='r' class='field'>"+
                                "<input placeholder='Respuesta 1' type='Text' name='p"+(n + 1)+"-r1'>"+
                                "<label>Respuesta 1</label>" +
                            "</div>"+
                            "<div id='r' class='field'>"+
                                "<input placeholder='Respuesta 2' type='Text' name='p"+(n + 1)+"-r2'>"+
                                "<label>Respuesta 2</label>"+
                            "</div>"+
                            "<div id='r' class='field'>"+
                                "<input placeholder='Respuesta 3' type='Text' name='p"+(n + 1)+"-r3'>"+
                                "<label>Respuesta 3</label>"+
                            "</div>"+
                        "</div>";
                    break;
                    case "Cuestionario":
                        q = "<div class='question'>" +
                                    "<div id='p' class='field'>" +
                                        "<input placeholder='Pregunta "+(n + 1)+"' type='Text' name='p"+(n + 1)+"'>" +
                                        "<label>Pregunta "+(n + 1)+"</label>"+
                                    "</div>"+
                                    "<div id='ur' class='field'>" +
                                        "<input placeholder='Respuesta' type='Text' name='p"+(n + 1)+"-r1'>" +
                                        "<label>Respuesta</label>"+
                                    "</div>"+
                                "</div>";
                    break;
                    case "Relacion de Columnas":
                        q = "<div class='question'>" +
                                    "<div id='p' class='field'>" +
                                        "<input placeholder='Pregunta "+(n + 1)+"' type='Text' name='p"+(n + 1)+"'>" +
                                        "<label>Pregunta "+(n + 1)+"</label>"+
                                    "</div>"+
                                    "<div id='ur' class='field'>" +
                                        "<input placeholder='Respuesta' type='Text' name='p"+(n + 1)+"-r1'>" +
                                        "<label>Respuesta</label>"+
                                    "</div>"+
                                "</div>";
                    break;
                }
				
                if(tipo != "Seleccionar"){
                    $("#add-questions footer.eva form").append(q);
                    $(".np").text("Numero de preguntas " + (n + 1));
                    n++;    
                }
			});

			$("#add-questions footer .button").off("click").on("click", function(){

				var tipo = $('.QSNSlctTipo :selected').text();;
				var tema = $('.QSNSlctTema :selected').text();;

				$("#add-questions footer form").addQuestions("../../assets/php/addQns.php", tipo, tema);
			});

			$("#syncEvas").off("click").on("click", function(e){
				updateTable("../../assets/php/allEvas.php", ".evaTable .tbl-content table", ".evaTable .tbl-content .loader", 2);
			});

			$("#syncThemes").off("click").on("click", function(e){
				updateTable("../../assets/php/temas.php", ".themeTable .tbl-content table", ".themeTable .tbl-content .loader", 3);
			});

			$(".btAddEva").off("click").on("click", function(e){
				e.preventDefault();
				var t = $(this).text()
				switch(t){
					case "Editar":
						$("#gestionEva .modal-content form").editEva($(".txtidEva").val() ,"../../assets/php/gestionEvas.php", closeventEva,"../../assets/php/allEvas.php");
					break;
					case "Eliminar":
						$("#gestionEva .modal-content form").deleteEva($(".txtidEva").val() ,"../../assets/php/gestionEvas.php", closeventEva,"../../assets/php/allEvas.php");
					break;
				}
			});

			$(".btAddTheme").off("click").on("click", function(e){
				e.preventDefault();
				var t = $(this).text()
				switch(t){
					case "Agregar":
						$("#gestionTheme .modal-content form").addTheme("../../assets/php/gestionThemes.php", closeventEva);
					break;
					case "Editar":
						$("#gestionTheme .modal-content form").editTheme($(".txtidTheme").val(), "../../assets/php/gestionThemes.php", closeventEva);
					break;
					case "Eliminar":
						$("#gestionTheme .modal-content form").deleteTheme($(".txtidTheme").val(), "../../assets/php/gestionThemes.php", closeventEva);
					break;
				}
			});
		});
		function close_window() {
		  if (confirm("Se cerrara la ventana...")) {
		    close();
		  }
		}
		$(document).keyup(function(e) {
		     if (e.keyCode == 27) { // escape key maps to keycode `27`
		     	if($("#gestionTheme").hasClass('gestionTheme-on')){
		       		closeventTheme.click();
		   		}
		    }

		});
	</script>
</body>
</html>