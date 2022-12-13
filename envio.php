<?	
	//Archivo que incluye el proceso de conexión
	include("conexion.php");
	$link=conectarse();

	header('Content-Type: text/html; charset=ISO-8859-1');

//Avisa cual de los textarea esta enviando los datos y lo concatena con el mensaje correspondiente (yo me entiendo)
$mensaje_actual = utf8_decode($_POST['actual']);

mysql_query("INSERT INTO comments VALUES ('', '".utf8_decode($_POST['fusuario_'.$mensaje_actual])."', now(), '".utf8_decode($_POST['fmensaje_'.$mensaje_actual])."', ".utf8_decode($_POST['news']).")",$link);



//Consulta y muestreo de los comentarios de la noticia actual
										$comentariosBlog = mysql_query("SELECT * FROM comments WHERE news=".utf8_decode($_POST['news'])." ORDER BY code ASC",$link);
										while($campo = mysql_fetch_array($comentariosBlog)){
										echo "<div id='each_message'>".nl2br($campo['message'])."<br/><br/>
													  <div id='user_message'>Escrito por ".htmlentities($campo['user'])." el ".date('d/m/Y', strtotime($campo['date']))." a las ".date('H:i', strtotime($campo['date'])).".</div>
												  </div>
												  <br/>";
										};
?>

