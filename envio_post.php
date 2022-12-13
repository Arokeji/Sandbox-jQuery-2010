<?	
	//Archivo que incluye el proceso de conexión
	include("conexion.php");
	$link=conectarse();

	header('Content-Type: text/html; charset=ISO-8859-1');
	
	if(utf8_decode($_POST['ftitulo']) != "" && utf8_decode($_POST['fusuario']) != "" && utf8_decode($_POST['fpost']) != "Escribe aquí tu post" && utf8_decode($_POST['fpost']) != ""){
		mysql_query("INSERT INTO news VALUES ('', '".utf8_decode($_POST['ftitulo'])."','".utf8_decode($_POST['fpost'])."', '".utf8_decode($_POST['fusuario'])."', now())",$link);
		echo "<script> window.location.href='index.php';</script>";
		}
	else{
		echo "<script>alert('Comprueba que el título, nombre y el texto del post estén escritos. No se admiten campos en blanco.');</script>";
		echo "<script> window.history.back();</script>";
	}

?>

