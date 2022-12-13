<?
echo "<div id='comentarios_".$comentario."'>";
							//Consulta de la cantidad de comentarios
							$n_comentariosPost = mysql_num_rows(mysql_query("SELECT * FROM comments WHERE news=".$campo['code'],$link));
							echo "<div style='font-size: 15px;'><center><a href='#'><strong>".$n_comentariosPost."</strong> <img src='images/comentarios.png'/></a></center></div>
									<div style='font-size: 11px; padding: 20px;'>";
										//Consulta y muestreo de los comentarios de la noticia actual
										$comentariosBlog = mysql_query("SELECT * FROM comments WHERE news='".$campo['code']."' ORDER BY code ASC",$link);
										while($campo = mysql_fetch_array($comentariosBlog)){
											echo "<div>".$campo['message']."
													  <div class='title_date'>escrito por ".$campo['user']." el ".date('d/m/Y', strtotime($campo['date']))." a las PONER LA HORA.</div>
												  </div><br/>";
										}
					echo 			"<div  id='result'></div>
										<form  method='post' action='envio.php' id='fo_0'  name='fo_0' >
											  <fieldset>
												<ol>
													<li><label>Texto:</label><input type='textarea' size='50' name='fmensaje' /></li>
													<li><label>Usuario:</label><input type='textarea' size='50' name='fusuario' /></li>
												</ol>
												<input type='submit' name='mysubmit' value='Enviar' />
											  </fieldset>
										</form>	
											
									</div>
								</div>";
?>