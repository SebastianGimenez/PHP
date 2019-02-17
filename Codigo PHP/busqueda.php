<?php
	if(isset($_POST['buscar'])){
		$vBuscar = '%'.$_POST['buscar'].'%'; 
		session_start(); 
		$tipoUsuario = NULL;
		$vNRO = NULL;
		if(isset($_SESSION['usuario'])){
		$fila = $_SESSION['usuario'];
		$nombreUsuario = $fila['Usuario'];
		$tipoUsuario = $fila['TipoUsuario'];
		if(isset($_SESSION["carro"])) $vNRO=count($_SESSION["carro"]); else $vNRO=0;
	}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
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
<body>  <?php
	include("cabecera.php");
	?>
	<br />
		<div class="container">

			<h2 class="page-header">Resultados de la b&#250squeda </h2>
		<br />
		
		<!-- CARGAS DE RESULTADOS  --->
		<?php 
			include("conexion.inc");
			$vSql = "CALL ItemsBusqueda('$vBuscar')";
			$vResultado = mysqli_query($link, $vSql) or die (error());
			if(mysqli_num_rows($vResultado) == 0){
		?>
				<h3>No se encontraron resultados</h3>
		<?php
			} else{
		?>
				<div class="row placeholders">
		<?php
					while($vItem = mysqli_fetch_array($vResultado)){					
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
		<?php	
					}
		?>
				</div>
		</div>
		<?php
			}
include("modal.php");
		?>
			
	<?php include("pie.php"); ?>
</body>
</html>
<?php } else header("Location:error.html"); ?>