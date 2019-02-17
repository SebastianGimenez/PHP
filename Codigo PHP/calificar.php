<?php 
	session_start(); 
	$tipoUsuario = NULL;
	$vNRO = NULL;
	if(isset($_SESSION['usuario'])){
		$fila = $_SESSION['usuario'];
		$tipoUsuario = $fila['TipoUsuario'];
		if($tipoUsuario != 3) header("location:index.php");
		else{
			$nombreUsuario = $fila['Usuario'];
			$idUsuario = $fila['Id'];
			if(isset($_SESSION["carro"])) $vNRO=count($_SESSION["carro"]); else $vNRO=0;
			if(isset($_POST['idSelect'])) $idItem = $_POST['idSelect'];
			else header("location:error.html");
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Calificar</title>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous" type="text/css" />
<link href="dashboard.css" rel="stylesheet" type="text/css" />
<link href="propio.css" rel="stylesheet" type="text/css" />
</head>

<body>
	<?php include_once("cabecera.php"); ?>
	
	<div class="col-sm-4 col-md-4">
		<h3 class="page-header">Calificar</h3>
	</div>
	<div class="container">
		<div class="row placeholders">
			<div class="col-xs-7 col-sm-10 placeholder">
			<?php
				include ("conexion.inc");
				$vSql = "CALL ItemsGetOne('$idItem')";
				$vResultado = mysqli_query($link, $vSql);
				unset($link); 
				while($fila = mysqli_fetch_array($vResultado)){
					include ("conexion.inc");
					$vSql = "CALL ClasificacionesGetOne('$idItem', '$idUsuario')";
					$vRes = mysqli_query($link, $vSql);
					$res = mysqli_fetch_row($vRes);
					unset($link);
			?>
				<form action="clasificacion.php" method="post" id="califica" name="califica">
					<table>
						<tr>
							<td>
							<img src="<?php echo($fila['url_portada']); ?>" width="200" height="200" class="img-responsive" alt="Generic placeholder thumbnail">
							</td>
							<td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>
							<td>
								<table>
									<tr style="vertical-align:text-bottom">
										<td colspan="2">
											<h2><?php echo($fila['titulo'])." - ".($fila['nombre_artista']);?></h3>
										</td>
									</tr>
									<tr>
										<h4>Lanzamiento:<?php echo $fila['anio_lanzamiento']; ?></h4>
									</tr>
									<tr style="vertical-align:text-bottom">
										<td colspan="2">
											<h2>Promedio: <?php if(!isset($fila['prom'])) echo "No fue calificado"; else echo round($fila['prom']);?></h2>
										</td>
									</tr>
									<tr>
										<td>
											<table align="center">
											<tr>
												<td><h3>Puntos:</h3></td>
											<td><select class="form-control" name="estrellas" id="estrellas">
												<option value="0" <?php if(isset($res[1])){ if($res[1]==0){ ?> selected="selected" <?php } } ?>>0</option>
												<option value="1" <?php if(isset($res[1])){ if($res[1]==1){ ?> selected="selected" <?php } } ?> >1</option>
												<option value="2" <?php if(isset($res[1])){ if($res[1]==2){ ?> selected="selected" <?php } } ?> >2</option>
												<option value="3" <?php if(isset($res[1])){ if($res[1]==3){ ?> selected="selected" <?php } } ?> >3</option>
												<option value="4" <?php if(isset($res[1])){ if($res[1]==4){ ?> selected="selected" <?php } } ?> >4</option>
												<option value="5" <?php if(isset($res[1])){ if($res[1]==5){ ?> selected="selected" <?php } } ?> >5</option>
											</select></td>
											</tr>
										</table>
										</td>
									</tr>
									<tr>
										<td colspan=3 style="text-align: center">
											<textarea style="height: 200px; width: 100%; overflow: auto;" class="form-control" name="messageAdd" id="messageAdd"></textarea>
										</td>
									</tr>
									<tr>
										<td colspan="2">
											<br />
											<input type="hidden" name="idSelect" id="idSelect" value="<?php echo $idItem; ?>" /> 
											<input class="btn btn-success" type="submit" value="Calificar" id="event" name="event" /> 
											<input class="btn btn-default" type="submit" value="Cancelar" id="event" name="event" />
										</td>
									</tr>									
								</table>
							</td>		
						</tr>
						</table>
				</form>
				<?php } ?>
			</div>
		</div>
	</div>
	<br /><br /><br />
	<div class="col-sm-4 col-md-4">
		<h3 class="page-header">Comentarios</h3>
		<?php
			include("conexion.inc");
			$vSql = "CALL ClasificacionesGetAll('$idItem')";
			$vRes = mysqli_query($link, $vSql);
			unset($link);
			if(mysqli_num_rows($vRes) != 0){
				while($fila = mysqli_fetch_array($vRes)){ 
					if(isset($fila['mensaje_adjunto'])){
		?>
						<div class="col-md">        
				          <div class="card">
				            <div class="card-header">
            					<?php echo "Usuario: ".$fila['nombre_usuario']; ?></div>
				            </div>
				            <div class="card-body">
				              <p class="card-text"><?php echo $fila['mensaje_adjunto']; ?> </p>
				            </div>
				          </div>          
				      </div>
					  <br />
		<?php 
					} 
				}
			} else{ ?>
				<h4>Sin Comentarios</h4>
		<?php } ?>
	</div>

	<?php include("pie.php"); ?>
</body>
</html>
<?php } } else header("location:resumenCompras.php"); ?>