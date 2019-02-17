<?php 
	if(isset($_COOKIE['idItem'])){ 
		$vID = $_COOKIE['idItem'];
		setcookie("idItem", $_POST['idSelect'], time()-3600, "/");

		session_start(); 
		$tipoUsuario = NULL;
		$vNRO = NULL;
		if(isset($_SESSION['usuario'])){
			$fila = $_SESSION['usuario'];
			$nombreUsuario = $fila['Usuario'];
			$tipoUsuario = $fila['TipoUsuario'];
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous" type="text/css" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Eliminar Item</title>
</head>

<body>
	<script type="text/javascript">
		function busqueda(){
			buscar = document.form.busqueda.value
			if(buscar == null){
				alert("Ingrese nombre a buscar"); return false;
			} else return true;
		}
	</script>
	<?php 
		function error(){
			echo "<script type=\"text/javascript\">location.href='error.html';</script>";
		}	
		include("cabecera.php");
	?>
	

	<div class="col-sm-5 col-md-5">
		<h2 class="page-header">Eliminar Item</h2>

		<br />
		<?php
			include("conexion.inc");
			$vSql = "CALL ItemsGetOne('$vID')"; //Arma la instrucción SQL y luego la ejecuta
			$vResultado = mysqli_query($link, $vSql) or die (mysqli_error());
			$fila = mysqli_fetch_row($vResultado);
		?>
		<form role="form" action="itemGUARDAR.php" method="post" id="form" name="form">
			<div class="form-group">
				<b>C&oacute;digo:(*)</b>
				<input type="text" class="form-control" id="idItem" name="idItem" value="<?php echo $fila[0]; ?>" readonly="true"/>
			</div>
			<div class="form-group">
				<b>T&iacute;tulo:(*)</b>
				<input type="text" class="form-control" id="tituloItem" name="tituloItem" value="<?php echo $fila[1] ?>" readonly="true" />
			</div>
			<div class="form-group">
				<b>Autor:(*)</b>
				<select class="form-control" id="cmbArtista" name="cmbArtista" readonly="true" >
					<option>Seleccion Artista</option>
						<?php 
							include("conexion.inc"); 
							$vSql = 'CALL ArtistasGetAllHabilitado'; 
							$vResultado = mysqli_query($link, $vSql) or die (error()); 
							while($artista = mysqli_fetch_array($vResultado)){?>
					<option <?php if($fila[5]==$artista['id_artista']) { ?> selected="selected" <?php }  ?> value="<?php echo $artista['id_artista']; ?>">
						<?php echo $artista['nombre_artista']; ?>
					</option>
					<?php } ?>
				</select>
			</div>
			<div class="form-group">
				<b>G&eacute;nero:(*)</b>
				<select class="form-control" id="cmbGenero" name="cmbGenero" readonly="true" >
					<option>Seleccione Género</option>
						<?php 
							include("conexion.inc"); 
							$vSql = 'CALL GenerosGetAllHabilitado'; 
							$vResultado = mysqli_query($link, $vSql) or die (error()); 
							while($genero = mysqli_fetch_array($vResultado)){?>
					<option <?php if($fila[6]==$genero['id_genero']) { ?> selected="selected" <?php } ?> value="<?php echo $genero['id_genero']; ?>">
						<?php echo $genero['desc_genero']; ?>
					</option>
					<?php } ?>
				</select>
			</div>
			<div class="form-group">
				<b>Tipo de Disco:(*)</b>
				<select class="form-control" id="cmbTipoDisco" name="cmbTipoDisco" readonly="true">
					<option>Seleccione Tipo de Disco</option>
					<?php 
						include("conexion.inc"); 
						$vSql = 'CALL TiposItemGetAllHabilitados'; 
						$vResultado = mysqli_query($link, $vSql) or die (error()); 
						while($tipos = mysqli_fetch_array($vResultado)){
					?>
					<option <?php if($fila[7]==$tipos['id_tipo_item']) { ?> selected="selected" <?php } ?> value="<?php echo $tipos['id_tipo_item']; ?>">
						<?php echo $tipos['desc_tipo_item']; ?>
					</option>
					<?php } ?>
				</select>
			</div>
			<div class="form-group">
				<b>A&ntilde;o Lanzamiento:(*) </b>
				<input type="text" class="form-control" id="anioLanzamiento" name="anioLanzamiento" readonly="true" value="<?php echo $fila[2]; ?>"  />
			</div>
			<div class="form-group">
				<b>Precio:(*)</b>
				<input type="text" class="form-control" id="precioItem" name="precioItem" readonly="true" value="<?php echo $fila[10]; ?>"  />
			</div>
			<div class="form-group">
				<b>Stock:(*)</b>
				<input type="text" class="form-control" id="stock" name="stock" readonly="true" value="<?php echo $fila[3]; ?>" />
			</div>
			<div class="form-group">
				<b>URL Portada:(*)</b>
				<input type="text" class="form-control" id="urlPortada" name="urlPortada" readonly="true" value="<?php echo $fila[8]; ?>" />
			</div>
			<div class="form-group">
				<b>Habilitado:(*)</b>
				<input type="checkbox" class="checkbox" id="habilitado" name="habilitado" readonly="true" checked="checked" />
			</div>
			<br />
			<div class="form-group" align="center">
				<input class="btn btn-danger" type="submit" value="Eliminar" id="event" name="event" /> 
				<a class="btn btn-secondary" href="item.php">Cancelar</a>
			</div>
		</form>
		
		<br /> <br /> <br />
	
		<form role="form" action="itemONE.php" method="post" id="busqueda" name="busqueda" onClick="return busqueda()">
			<table>
				<tr>
					<td><b>Buscar</b></td>
					<td>&nbsp;</td>
					<td>
						<input type="text" class="form-control" id="buscar" name="buscar" placeholder = "Buscar" />
					</td>
					<td>&nbsp;</td>
					<td>
						<input class="btn btn-success btn-sm" type="submit" value="Buscar" id="event" name="event" />
					</td>
					<td>&nbsp;</td>
					<td>
						<input class="btn btn-default btn-sm" type="submit" value="Reiniciar" id="event" name="event" <?php if(!isset($_COOKIE['busqueda'])){ ?>disabled="disabled"<?php }?> />
					</td>
				</tr>
			</table>
		</form>
		</div>
		<br />			
 
		<?php
		include("conexion.inc");
		$Cant_por_Pag = 10;
		$pagina = isset ( $_GET['pagina']) ? $_GET['pagina'] : null ;

		if (!$pagina) {
			$inicio = 0;
			$pagina=1;
		}
		else {
			$inicio = ($pagina - 1) * $Cant_por_Pag;
		}// total de páginas
		if(isset($_COOKIE['busqueda'])) { 
			unset($link);
			$vBuscar = $_COOKIE['busqueda'];
			setcookie("busqueda", '', time()-3600, "/");
			$vSql = "CALL ItemsBusqueda('$vBuscar')"; 
			include("conexion.inc");
			$vResultado = mysqli_query($link, $vSql) or die("Falla la busqueda");
			
			$total_registros=mysqli_num_rows($vResultado);
			$total_paginas = ceil($total_registros/ $Cant_por_Pag);
			unset($link, $vResultado);
		
			include("conexion.inc");
			$vSql = "CALL ItemsGetAllLimitBusqueda('$inicio', '$Cant_por_Pag', '$vBuscar')";
			$vResultado = mysqli_query($link, $vSql) or die(mysqli_error());
		} else {
			$vSql = "CALL ItemsGetAll";
			$vResultado = mysqli_query($link, $vSql) or die("Falla la busqueda");
			
			$total_registros=mysqli_num_rows($vResultado);
			$total_paginas = ceil($total_registros/ $Cant_por_Pag);
			unset($link, $vResultado);
		
			include("conexion.inc");
			$vSql = "CALL ItemsGetAllLimit('$inicio', '$Cant_por_Pag')";
			$vResultado = mysqli_query($link, $vSql) or die(mysqli_error());
		}
#		else $vSql = "select * from items";
		
		
#		$total_registros=mysqli_num_rows($vResultado);
	?>
	<table class="table table-hover">
		<thead>
			<th>C&oacute;digo</th>
			<th>T&iacute;tulo</th>
			<th>Autor</th>
			<th>A&ntilde;o Lanzamiento</th>
			<th>G&eacute;nero</th>
			<th>Precio</th>
			<th>Stock</th>
			<th>Habilitado</th>
			<th></th>
			<th></th>
		</thead>

		<?php
			while ($fila = mysqli_fetch_array($vResultado))
			{
		?>
		<tr>
			<td><?php echo $fila['id_item']; ?></td>
			<td><?php echo $fila['titulo']; ?></td>
			<td><?php echo $fila['nombre_artista']; ?></td>
			<td><?php echo $fila['anio_lanzamiento']; ?></td>
			<td><?php echo $fila['desc_genero']; ?></td>
			<td><?php echo $fila['monto']; ?></td>
			<td><?php echo $fila['stock']; ?></td>
			<td style="vertical-olign: middle">
				<input type="checkbox" readonly disabled <?php if($fila['habilitado']){ ?>  checked <?php } ?> > 
			</td>
			<td></td>
			<form role="form" action="itemONE.php" method="post" id="botonera" name="botonera">
				<td style="vertical-align: middle">
					<input type="hidden" name="idSelect" id="idSelect" value="<?php echo $fila['id_item']; ?>" /> 
					<input class="btn btn-success btn-sm" type="submit" value="Modificar" id="event" name="event" /> 
					<input class="btn btn-danger btn-sm" type="submit" <?php if(!$fila['habilitado']){ ?>  disabled="disabled" <?php } ?> value="Eliminar" id="event" name="event" />
				</td>
			</form>
		</tr>
	<?php } ?>
		<tr>
			<td colspan="10" style="text-align:center">
				<?php echo "Pagina ". $pagina . " de " . $total_paginas ; ?>
			</td>
		</tr>
		<tr>
			<td colspan="10" style="text-align:center">
	<?php
		// Liberar conjunto de resultados
		mysqli_free_result($vResultado);
		unset($vSql);
		// Cerrar la conexion
		mysqli_close($link);
		if ($total_paginas > 1){
			for ($i=1;$i<=$total_paginas;$i++){
				if ($pagina == $i){
					//si muestro el índice de la página actual, no coloco enlace
					echo $pagina . " ";
				} else{
					//si la página no es la actual, coloco el enlace para ir a esa página
					echo "<a href='itemEliminar.php?pagina=" . $i ."'>" . $i . "</a> ";
				}
			}
		}
	?>
		</td>
	</tr>
	</table>

<?php include("pie.php"); ?>
</body>
</html>
<?php 
		} else header("Location:login.php");
	} else header("location:item.php");
?>