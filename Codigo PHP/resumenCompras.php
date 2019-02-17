<?php 
	session_start(); 
	$tipoUsuario = NULL;
	$vNRO = NULL;
	if(isset($_SESSION['usuario'])){
		$fila = $_SESSION['usuario'];
		$tipoUsuario = $fila['TipoUsuario'];
		if($tipoUsuario == 3){
			$idUsuario = $fila['Id'];
			$nombreUsuario = $fila['Usuario'];
			if(isset($_SESSION["carro"])) $vNRO=count($_SESSION["carro"]); else $vNRO=0;
		
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title>Compras</title>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous" type="text/css" />
<link href="dashboard.css" rel="stylesheet" type="text/css" />
<link href="propio.css" rel="stylesheet" type="text/css" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title>Compras</title>
</head>
<body>


	<?php include_once("cabecera.php"); ?>

		<div class="container">
			<h3>Compras</h3>			
			<div class="row">
				<table class="table table-hover" style="text-align: left">
					<thead>
						<tr>
							<th>C&oacute;digo</th>
							<th>Discos</th>
							<th>Fecha</th>
							<th>Precio Final</th>
						</tr>
					</thead>
					<?php 
						include("conexion.inc");
						$vSql = "CALL VentaItemGetAllForUser('$idUsuario')";
						$vResV = mysqli_query($link, $vSql) or die (error());
						unset($link);
						while ($filaV = mysqli_fetch_array($vResV)){ 
							$suma = 0; $idVenta = $filaV['id_venta'];
					?>
					<tbody>
						<tr>
							<td style="vertical-align: middle">
								<?php echo $filaV['id_venta']; ?>
							</td>
							<td style="vertical-align: middle">
								<?php
									include("conexion.inc");
									$vSql = "CALL VentaItemGetAllForVenta('$idVenta')"; 
									$vResVI = mysqli_query($link, $vSql) or die(error());
									unset($link); 
									while ($filaVI = mysqli_fetch_array($vResVI)){
										$idItem = $filaVI['id_item'];
										include("conexion.inc");
										$vSql = "CALL ItemsGetOne('$idItem')"; 
										$vResI = mysqli_query($link, $vSql) or die(error());
										while ($filaI = mysqli_fetch_array($vResI)){
											$suma=$suma+$filaVI['cantidad']*$filaI['monto'];
											echo $filaI['titulo']." ";
										} 
									} 
								?>
							</td>
							<td style="vertical-align: middle">
								<?php echo $filaV['fecha']; ?>
							</td>
							<td style="vertical-align: middle">
								<?php echo "$ ".$suma; ?>
							</td>
						</tr>
					</tbody>
					<?php } ?>
				</table>
			</div>
		</div>
	<?php 		include("pie.php"); ?>
</body>
<?php
	} else header("location:index.php"); 
	} else header("location:login.php");
		
?>
</html>