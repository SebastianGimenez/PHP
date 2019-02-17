<?php 
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
<title>Remarcar</title>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous" type="text/css">
<meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
<script type="text/javascript">
		function validar(){
			precio = document.form.precioNuevo.value
			stock = document.form.stockNuevo.value
					
			if (isNaN(stock)){
				alert("El stock no es un número"); return false;
			} else if(isNaN(precio)){
				alert("El precio no es un número"); return false;
			} else if((precio == null || precio.length == 0) && (stock == null || stock.length == 0)){ 
				alert("Ingrese stock o precio a modificar"); return false;
			} else return true
		}
		
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
		include_once("cabecera.php");
	?>
	

	<div class="col-sm-5 col-md-5">
		<h2 class="page-header">Remarcar Precio - Stock</h2>
		<br />

		<form role="form" action="remarcar_event.php" method="post" id="form" name="form" onSubmit="return validar()">
			<div class="form-group">
				<b>C&oacute;digo:</b>
				<input type="text" class="form-control" id="idItem" name="idItem" <?php if(isset($_COOKIE["id_item"])) { ?> value="<?php echo $_COOKIE["id_item"]; ?>" <?php } ?> readonly="true"/>
			</div>
			<div class="form-group">
				<b>T&iacute;tulo:</b>
				<input type="text" class="form-control" id="tituloItem" name="tituloItem" readonly="true" <?php if(isset($_COOKIE["titulo"])) { ?> value="<?php echo $_COOKIE["titulo"]; ?>" <?php } ?> />
			</div>
			<div class="form-group">
				<b>Autor:</b>
				<select class="form-control" id="cmbArtista" name="cmbArtista" readonly="true">
					<option>Seleccion Artista</option>
					<?php include("conexion.inc"); $vSql = 'CALL ArtistasGetAllHabilitado'; $vResultado = mysqli_query($link, $vSql) or die (error()); while($artista = mysqli_fetch_array($vResultado)){?>
					<option <?php if(isset($_COOKIE["id_artista"])) { if($_COOKIE["id_artista"]==$artista['id_artista']) { ?> selected="selected" <?php } } ?> value="<?php echo $artista['id_artista']; ?>"><?php echo $artista['nombre_artista']; ?></option><?php } ?>
				</select>
			</div>
			<div class="form-group">
				<b>G&eacute;nero:</b>
				<select class="form-control" id="cmbGenero" name="cmbGenero" readonly="true" >
					<option>Seleccione Género</option>
					<?php include("conexion.inc"); $vSql = 'CALL GenerosGetAllHabilitado'; $vResultado = mysqli_query($link, $vSql) or die (error()); while($genero = mysqli_fetch_array($vResultado)){?>
					<option <?php if(isset($_COOKIE["id_genero"])) { if($_COOKIE["id_genero"]==$genero['id_genero']) { ?> selected="selected" <?php } } ?> value="<?php echo $genero['id_genero']; ?>"> <?php echo $genero['desc_genero']; ?></option><?php } ?>
				</select>
			</div>
			<div class="form-group">
				<b>Tipo de Disco:</b>
				<select class="form-control" id="cmbTipoDisco" name="cmbTipoDisco" readonly="true" >
					<option>Seleccione Tipo de Disco</option>
						<?php include("conexion.inc"); $vSql = 'CALL TiposItemGetAllHabilitados'; $vResultado = mysqli_query($link, $vSql) or die (error()); while($tipos = mysqli_fetch_array($vResultado)){?>
					<option <?php if(isset($_COOKIE["id_tipo_item"])) { if($_COOKIE["id_tipo_item"]==$tipos['id_tipo_item']) { ?> selected="selected" <?php } } ?> value="<?php echo $tipos['id_tipo_item']; ?>"><?php echo $tipos['desc_tipo_item']; ?></option><?php } ?>
					</select>
			</div>
			<div class="form-group">
				<b>A&ntilde;o Lanzamiento: </b>
				<input type="text" class="form-control" id="anioLanzamiento" name="anioLanzamiento" readonly="true" <?php if(isset($_COOKIE["anio"])) { ?> value="<?php echo $_COOKIE["anio"]; ?>" <?php } ?> />
			</div>
			<div class="form-group">
				<b>URL Portada:</b>
				<input type="text" class="form-control" id="urlPortada" name="urlPortada" readonly="true" <?php if(isset($_COOKIE["url"])) { ?> value="<?php echo $_COOKIE["url"]; ?>" <?php } ?> />
			</div>
			<div class="form-group">
				<div class="row">
					<div class="col-5">
						<b>Precio:</b>
						<input type="text" class="form-control" id="precioItem" name="precioItem" readonly="true" <?php if(isset($_COOKIE["precio"])) { ?> value="<?php echo $_COOKIE["precio"]; ?>" <?php } ?> />
					</div>
					<div class="col-5">
						<b>Nuevo Precio:(*)</b>
						<input type="text" class="form-control" id="precioNuevo" name="precioNuevo" />
					</div>
				</div>
			</div>
			<div class="form-group">
				<div class="row">
					<div class="col-5">
						<b>Stock:</b>
						<input type="text" class="form-control" id="stock" name="stock" readonly="true" <?php if(isset($_COOKIE["stock"])) { ?> value="<?php echo $_COOKIE["stock"]; ?>" <?php } ?> />
					</div>
					<div class="col-5">
						<b>Nuevo Stock:(*)</b>
						<input type="text" class="form-control" id="stockNuevo" name="stockNuevo" />
					</div>
				</div>
			</div>
			<div class="form-group">
				<b>Habilitado:(*)</b>
				<input type="checkbox" class="checkbox" id="habilitado" name="habilitado" <?php if(isset($_COOKIE["habilitado"])) { if($_COOKIE["habilitado"]) { ?> checked="checked" <?php } } ?> readonly="true" />
			</div><br />
			<div class="form-group" align="center">
				<input class="btn btn-success" type="submit" value="Remarcar" id="event" name="event" <?php if(!isset($_COOKIE['id_item'])){ ?> disabled="disabled"<?php } ?> /> 
				<a class="btn btn-secondary" href="remarcar.php">Cancelar</a>
			</div>
		</form>
		
		<?php 
			#elimnar las cookies
			if(isset($_COOKIE['id_item'])) setcookie("id_item", '', time()-3600, "/");
			if(isset($_COOKIE['titulo'])) setcookie("titulo", '', time()-3600, "/");
			if(isset($_COOKIE['anio'])) setcookie("anio", '', time()-3600, "/");
			if(isset($_COOKIE['stock'])) setcookie("stock", '', time()-3600, "/");
			if(isset($_COOKIE['habilitado'])) setcookie("habilitado", '', time()-3600, "/");
			if(isset($_COOKIE['id_artista'])) setcookie("id_artista", '', time()-3600, "/");
			if(isset($_COOKIE['id_genero'])) setcookie("id_genero", '', time()-3600, "/");
			if(isset($_COOKIE['id_tipo_item'])) setcookie("id_tipo_item", '', time()-3600, "/");
			if(isset($_COOKIE['url'])) setcookie("url", '', time()-3600, "/");
			if(isset($_COOKIE['precio'])) setcookie("precio", '', time()-3600, "/");
			if(isset($_COOKIE['modificar'])) setcookie("modificar", '', time()-3600, "/");
		?>
		
		<br /> <br /> <br />
	
		<form role="form" action="remarcar_event.php" method="post" id="busqueda" name="busqueda" onClick="return busqueda()">
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
			<form role="form" action="remarcar_event.php" method="post" id="botonera" name="botonera">
				<td style="vertical-align: middle">
					<input type="hidden" name="idSelect" id="idSelect" value="<?php echo $fila['id_item']; ?>" /> 
					<input class="btn btn-success btn-sm" type="submit" value="Modificar" id="event" name="event" /> 
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
					echo "<a href='remarcar.php?pagina=" . $i ."'>" . $i . "</a> ";
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
<?php } else header("location:login.php");