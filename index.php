<?	
	//Archivo que incluye el proceso de conexión
	include("conexion.php");
	$link=conectarse();

?>

<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
<html xmlns='http://www.w3.org/1999/xhtml'>
<head>

	<meta http-equiv='Content-Type' content='text/html; charset=iso-8859-1' />
	<title>Cellarway</title>
	
	<link type="text/css" href="css/ui-lightness/jquery-ui-.custom.css" rel="stylesheet" />	
	<link type="text/css" href="css/cellarway-theme.css" rel="stylesheet" />
	<link href="css/jquery.tweet.css" rel="stylesheet" type="text/css" />
	<link rel="stylesheet" type="text/css" href="css/jquery.lightbox-0.5.css" media="screen" />

	<script type="text/javascript" src="js/jquery-1.4.2.min.js"></script>
	<script type="text/javascript" src="js/jquery-ui-1.8rc3.custom.min.js"></script>
	<script type="text/javascript" src="js/funciones.js"></script>
	<script type="text/javascript" src="js/jquery.tweet.js"></script>
	<script type="text/javascript" src="js/jquery.lightbox-0.5.js"></script>
	<script type="text/javascript" src="ckeditor/ckeditor.js"></script>



</head>

<body>
	<?
	if(!isset($code))
	$code = 1;
	else
	echo $code;
	?>

	<div id="chivato"></div>
	
	<div id='bg'>
		<img src='images/background_black.jpg' alt='' />
	</div>   

	<div id='menu'>
		<img src='images/esquina.png' name='esquina' alt='' border="0" usemap="#Map" />
			<map id='mapeado' name="Map">
  				<area shape="poly" coords="70,216,106,251,4,351,6,281" href="#" onMouseOver="document.images['esquina'].src='images/esquina_bio.png'" onMouseOut="document.images['esquina'].src='images/esquina.png'" onClick="crear('draggable_1', 'cerrar_1');"/>
				<area shape="poly" coords="167,119,203,153,108,250,71,216" href="#" onMouseOver="document.images['esquina'].src='images/esquina_media.png'" onMouseOut="document.images['esquina'].src='images/esquina.png'" onClick="crear('draggable_2', 'cerrar_2');"/>
				<area shape="poly" coords="169,119,203,151,351,5,282,4" href="#" onMouseOver="document.images['esquina'].src='images/esquina_contact.png'" onMouseOut="document.images['esquina'].src='images/esquina.png'" onClick="crear('draggable_3', 'cerrar_3');"/>
			</map>
	</div>
	
	<div id="contenedor_ventanas">
	
		<div id="nuevo_post" onMouseOver="document.getElementById('nuevo_post').style.zIndex=9;">
		<br/><br/>
			<form  method='post' action='envio_post.php' id='fo_post'  name='fo_post' accept-charset='utf-8' >
				Titulo: <input type='text' size='70' name='ftitulo' />
				<textarea class='fpost' name='fpost'>Escribe aquí tu post</textarea>
				<script type='text/javascript'>
					CKEDITOR.replace('fpost', {uiColor : '#f04646', resize_enabled: false, height: 300});
				</script>
				Tu nombre: <input type='text' size='50' name='fusuario' />	
				<input type='submit' name='enviarpost' value='Enviar' />
			</form>
		</div>
	
		<div id='blog_cabecera'></div>
		<div id="blog">
			<div style='position: absolute; right: -92px; top: -20px;'><img src="images/twitter.png"/></div>
			<div style='position: absolute; right: -290px; top: 10px;'>
				<div>
					<img src="images/bocadillo_cabecera.png"/>
				</div>
				<div class='tweet' style='position: relative; background-color: #ffffff; color:#000000; left: 36px; top: -22px; width: 167px; z-index: 9;'></div>
				<div style='position: relative; top: -40px;'>
					<img src="images/bocadillo_pie.png"/>
				</div>
			</div>
			
			
			<?
				//Obtiene el nº de pagina anterior y si no hay se usa 0 por defecto y se muestra el nombre del boton dependiendo del template seleccionado
				$comienzo=$_GET['code']; 
				if(!isset($comienzo))
					$comienzo = 0;
	
			
				//Numero de noticias por pagina
				$num=3;
				$click=0;
				
				//Cuenta para marcar el nombre del boton y poderse reconocer para redimensionar con javascript
				$cuenta = 0;
					
				//Consulta a la base de dato con unos limites basados en la primera y la ultima noticia mostrada
				$entradasBlog = mysql_query("SELECT * FROM news ORDER BY code DESC LIMIT $comienzo , $num",$link);
				
				
				//Nombra los comentarios
				$comentario = 0;
				
				//Recorrido y muestreo de las entradas
				while($campo = mysql_fetch_array($entradasBlog)){
					$cuenta +=1;
					echo "<br/>";
					echo "<div class='title'><a href='#'>".$campo['title']."</a></div>"; //Titular
					echo "<div class='title_date'>".date('d/m/Y', strtotime($campo['date']))." por ".$campo['user'].".</div>"; //Fecha
					echo "<br/><div class='description'>";
					echo $campo['text'];
					//El div con el nombre de la capa comentarios para que se pueda usar el accordion
					echo "<div id='comentarios_".$comentario."'>";
							//Consulta de la cantidad de comentarios
							$n_comentariosPost = mysql_num_rows(mysql_query("SELECT * FROM comments WHERE news=".$campo['code'],$link));
							echo "<div style='font-size: 15px;'><center><a href='#'><strong>".$n_comentariosPost."</strong> <img src='images/comentarios.png'/></a></center></div>
									<div id='comments_list_".$comentario."' style='font-size: 11px; padding: 20px;'>";
										//Consulta y muestreo de los comentarios de la noticia actual
										$comentariosBlog = mysql_query("SELECT * FROM comments WHERE news='".$campo['code']."' ORDER BY code ASC",$link);
										while($campo_comentarios = mysql_fetch_array($comentariosBlog)){
											echo "<div id='each_message'>".nl2br($campo_comentarios['message'])."<br/><br/>
													  <div id='user_message'>Escrito por ".htmlentities($campo_comentarios['user'])." el ".date('d/m/Y', strtotime($campo_comentarios['date']))." a las ".date('H:i', strtotime($campo_comentarios['date'])).".</div>
												  </div>
												  <br/>";
										}
					echo 			"<div>
										
										<form  method='post' action='envio.php' id='fo_".$comentario."'  name='fo_".$comentario."' accept-charset='utf-8' >
											<textarea rows='5' cols='75' name='fmensaje_".$comentario."' onFocus='cleartextarea(this);'>Escribe un comentario</textarea>
											
											<br/>
											Usuario:<input type='text' size='50' name='fusuario_".$comentario."' />
											<input type='text' style='visibility: hidden;' name='news' value='".$campo['code']."'/>
											<input type='text' style='visibility: hidden;' name='actual' value='".$comentario."'/>
											
											<input type='submit' name='mysubmit' value='Enviar' />
										</form>	
									</div>
											
									</div>
								</div>					
						  </div>";
					echo "<br/>";
					//Suma uno al comentario para que el siguiente tenga otra numeracion
					$comentario +=1;
				}
				
			?>
			
		</div>    
	</div>	

</body>

</html>