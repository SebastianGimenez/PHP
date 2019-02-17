<?php 
	session_start(); 
	$tipoUsuario = NULL;
	$vNRO = NULL;
	if(isset($_SESSION['usuario'])){
		$fila = $_SESSION['usuario'];
		$tipoUsuario = $fila['TipoUsuario'];
		$nombreUsuario = $fila['Usuario'];
		
		if(isset($_SESSION["carro"])) $vNRO=count($_SESSION["carro"]); else $vNRO=0;
		
	}
echo ($_SESSION['Email']);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html" charset="utf-8" />
<title>Discos</title>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous" type="text/css" />
<link href="dashboard.css" rel="stylesheet" type="text/css" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
</head>
<?php  
		function error(){
			echo "<script type=\"text/javascript\">location.href='error.html';</script>";
		}
?>

<body>	
	<?php include_once("cabecera.php"); ?>
	<div class="container">
	<div class="col-sm-4 col-md-4">
		<h2 class="page-header">Novedades</h2>
	</div>
	<div class="row placeholders">
			<?php 
				include("conexion.inc");
				$vSql = 'CALL ItemsNovedades';
				$vResultado = mysqli_query($link, $vSql) or die (error());
				while ($vItem = mysqli_fetch_array($vResultado)){ 
			?>
          <div class="col-xs-6 col-sm-3 placeholder">
				<img src="<?php echo($vItem['url_portada']); ?>" width="200" height="200" class="img-responsive" alt="Generic placeholder thumbnail">
				<h5><?php echo($vItem['titulo']);?></h5>
				<h5 class="text-muted"><?php echo($vItem['nombre_artista']);  ?></h5>
				<h4>$<?php echo($vItem['monto']);?></h4>
				<form action="elegido.php" method="post" id="compra" name="compra">
					<input type="hidden" name="idSelect" id="idSelect" value="<?php echo $vItem['id_item']; ?>" /> 
					<input class="btn btn-success btn-sm" type="submit" value="Agregar"	id="eventSale" name="eventSale" />
				</form>
			</div>
		 <?php } ?>
	
	</div>
	<br />
	<div class="col-sm-4 col-md-4">
		<h2 class="text-capitalize">Top Ventas</h2>
	</div>
	<div class="row placeholders">
	<?php 
				include("conexion.inc");
				$vSql = 'CALL ItemsGetTop8';
				$vResultado = mysqli_query($link, $vSql) or die (error());
				while ($vItem = mysqli_fetch_array($vResultado)){ 
			?>
          <div class="col-xs-6 col-sm-3 placeholder">
				<img src="<?php echo($vItem['url_portada']); ?>" width="200" height="200" class="img-responsive" alt="Generic placeholder thumbnail">
				<h5><?php echo($vItem['titulo']);?></h5>
				<h5 class="text-muted"><?php echo($vItem['nombre_artista']);  ?></h5>
				<h4>$<?php echo($vItem['monto']);?></h4>
				<form action="elegido.php" method="post" id="compra" name="compra">
					<input type="hidden" name="idSelect" id="idSelect" value="<?php echo $vItem['id_item']; ?>" /> 
					<input class="btn btn-success btn-sm" type="submit" value="Agregar"	id="eventSale" name="eventSale" />
				</form>
			</div>
		 <?php } ?>
	
	</div>
	<br />
	<div class="col-sm-4 col-md-4">
		<h2 class="text-capitalize">Top Semanal</h2>
	</div>
	<div class="row placeholders">
	<?php 
				include("conexion.inc");
				$vSql = 'CALL ItemsGetTopSemana';
				$vResultado = mysqli_query($link, $vSql) or die (error());
				while ($vItem = mysqli_fetch_array($vResultado)){ 
			?>
          <div class="col-xs-6 col-sm-3 placeholder">
				<img src="<?php echo($vItem['url_portada']); ?>" width="200" height="200" class="img-responsive" alt="Generic placeholder thumbnail">
				<h5><?php echo($vItem['titulo']);?></h5>
				<h5 class="text-muted"><?php echo($vItem['nombre_artista']);  ?></h5>
				<h4>$<?php echo($vItem['monto']);?></h4>
				<form action="elegido.php" method="post" id="compra" name="compra">
					<input type="hidden" name="idSelect" id="idSelect" value="<?php echo $vItem['id_item']; ?>" /> 
					<input class="btn btn-success btn-sm" type="submit" value="Agregar"	id="eventSale" name="eventSale" />
				</form>
			</div>
		 <?php } ?>
	
	</div>
	<br />
	<div class="col-sm-4 col-md-4">
		<h2 class="text-capitalize">Top Mensual</h2>
	</div>
	<div class="row placeholders">
	<?php 
				include("conexion.inc");
				$vSql = 'CALL ItemsGetTopMes';
				$vResultado = mysqli_query($link, $vSql) or die (error());
				while ($vItem = mysqli_fetch_array($vResultado)){ 
			?>
          <div class="col-xs-6 col-sm-3 placeholder">
				<img src="<?php echo($vItem['url_portada']); ?>" width="200" height="200" class="img-responsive" alt="Generic placeholder thumbnail">
				<h5><?php echo($vItem['titulo']);?></h5>
				<h5 class="text-muted"><?php echo($vItem['nombre_artista']);  ?></h5>
				<h4>$<?php echo($vItem['monto']);?></h4>
				<form action="elegido.php" method="post" id="compra" name="compra">
					<input type="hidden" name="idSelect" id="idSelect" value="<?php echo $vItem['id_item']; ?>" /> 
					<input class="btn btn-success btn-sm" type="submit" value="Agregar"	id="eventSale" name="eventSale" />
				</form>
			</div>
		 <?php } ?>
	
	</div>
	<br />
	<div class="col-sm-4 col-md-4">
		<h2 class="text-capitalize">Mejores calificados</h2>
	</div>
	<div class="row placeholders">
	<?php 
				include("conexion.inc");
				$vSql = 'CALL ItemsGetMejorPromedio';
				$vResultado = mysqli_query($link, $vSql) or die (error());
				while ($vItem = mysqli_fetch_array($vResultado)){ 
			?>
          <div class="col-xs-6 col-sm-3 placeholder">
				<img src="<?php echo($vItem['url_portada']); ?>" width="200" height="200" class="img-responsive" alt="Generic placeholder thumbnail">
				<h5><?php echo($vItem['titulo']);?></h5>
				<h5 class="text-muted"><?php echo($vItem['nombre_artista']);  ?></h5>
				<h4>$<?php echo($vItem['monto']);?></h4>
				<form action="elegido.php" method="post" id="compra" name="compra">
					<input type="hidden" name="idSelect" id="idSelect" value="<?php echo $vItem['id_item']; ?>" /> 
					<input class="btn btn-success btn-sm" type="submit" value="Agregar"	id="eventSale" name="eventSale" />
				</form>
			</div>
		 <?php } ?>
	
	</div>
	</div>	
	<?php 
		include("pie.php");
		include_once("modal.php"); 
	?>


</body>
</html>