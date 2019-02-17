<?php 
	if(isset($_COOKIE['idUsuario'])){ 
		$vID = $_COOKIE['idUsuario'];
		setcookie("idUsuario", "", time()-3600, "/");
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
<title>Eliminar Usuario</title>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous" type="text/css" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
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

	
	<?php include("cabecera.php"); ?>
	<div class="col-sm-5 col-md-5">

		<h2 class="page-header">Eliminar Usuario</h2><br />
		<?php
			include("conexion.inc");
			$vSql = "select * from usuarios where id_usuario = '$vID'"; //Arma la instrucci?n SQL y luego la ejecuta
			$vResultado = mysqli_query($link, $vSql) or die (mysqli_error());
			$fila = mysqli_fetch_row($vResultado);
		?>
		<form role="form" action="usuario.php" method="post" id="form" name="form" onSubmit="return validar()">
			<div class="form-group">
				<b>C&oacute;digo:(*)</b>
				<input type="text" class="form-control" id="idUsuario" name="idUsuario" value="<?php echo $fila[0]; ?>" readonly="true" />
			</div>
			<div class="form-group">
				<b>Nombre de Usuario:(*)</b>
				<input type="text" class="form-control" id="nombreUsuario" name="nombreUsuario" readonly="true" value="<?php echo $fila[7]; ?>" />
			</div>
			<div class="form-group">
				<b>Nombre:(*)</b>
				<input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo $fila[1]; ?>" readonly="true" />
			</div>
			<div class="form-group">
				<b>Apellido:(*)</b>
				<input type="text" class="form-control" id="apellido" name="apellido" value="<?php echo $fila[2]; ?>" readonly="true" />
			</div>
			<div class="form-group">
				<b>DNI:(*)</b>
				<input type="text" class="form-control" id="dni" name="dni" value="<?php echo $fila[6]; ?>" readonly="true" />
			</div>
			<div class="form-group">
				<b>Email:(*)</b>
				<input type="text" class="form-control" id="email" name="email" value="<?php echo $fila[8]; ?>" readonly="true" />
			</div>
			<div class="form-group">
				<b>Clave:(*)</b>
				<input type="password" class="form-control" id="clave" name="clave" readonly="true" />
			</div>
			<div class="form-group">
				<b>Confirmar Clave:(*)</b>
				<input type="password" class="form-control" id="confirmarClave" name="confirmarClave" readonly="true" />
			</div>
			<div class="form-group">
				<b>Tipo de Usuario:(*)</b>
				<select class="form-control" id="cmbTipo" name="cmbTipo" readonly="true" >
					<option value="0">Seleccione un Tipo</option>
					<?php  
						include("conexion.inc"); 
						$vSql = 'CALL TiposUsuarioGetAll'; 
						$vResultado = mysqli_query($link, $vSql) or die (error()); 
						while($tipo = mysqli_fetch_array($vResultado)){?>

					<option <?php if($fila[4]==$tipo['id_tipo_usuario']) { ?> selected="selected" <?php } ?> value="<?php echo $tipo['id_tipo_usuario']; ?>">
					<?php echo $tipo['desc_tipo_usuario']; ?>
					</option>
					<?php } ?>
				</select>
			</div>
			<div class="form-group">
				<b>Habilitado:(*)</b>
				<input type="checkbox" class="checkbox" id="habilitado"  name="habilitado"  checked="checked" readonly="true" />
			</div><br />
			<div class="form-group" align="center">
				<input class="btn btn-danger" type="submit" value="Eliminar" id="event" name="event" /> 
				<a class="btn btn-secondary" href="usuarios.php">Cancelar</a>
			</div>
		</form>
		
		<br /> <br /> <br />
	
		<form role="form" action="usuarioONE.php" method="post" id="busqueda" name="busqueda" onClick="return busqueda()">
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
			$vSql = "CALL UsuariosBusqueda('$vBuscar')"; 
			include("conexion.inc");
			$vResultado = mysqli_query($link, $vSql) or die("Falla la busqueda");
			
			$total_registros=mysqli_num_rows($vResultado);
			$total_paginas = ceil($total_registros/ $Cant_por_Pag);
			unset($link, $vResultado);
		
			include("conexion.inc");
			$vSql = "CALL UsuariosGetAllLimitBusqueda('$inicio', '$Cant_por_Pag', '$vBuscar')";
			$vResultado = mysqli_query($link, $vSql) or die(mysqli_error());
		} else {
			$vSql = "CALL UsuariosGetAll";
			$vResultado = mysqli_query($link, $vSql) or die("Falla la busqueda");
			
			$total_registros=mysqli_num_rows($vResultado);
			$total_paginas = ceil($total_registros/ $Cant_por_Pag);
			unset($link, $vResultado);
		
			include("conexion.inc");
			$vSql = "CALL UsuariosGetAllLimit('$inicio', '$Cant_por_Pag')";
			$vResultado = mysqli_query($link, $vSql) or die(mysqli_error());
		}
	?>
	<table class="table table-hover">
		<thead>
			<th>C&oacute;digo</th>
			<th>Usuario</th>
			<th>Apellido</th>
			<th>Nombre</th>
			<th>DNI</th>
			<th>Email</th>
			<th>Tipo Usuario</th>
			<th>Habilitado</th>
			<th></th>
			<th></th>
		</thead>

		<?php
			while ($fila = mysqli_fetch_array($vResultado))
			{
		?>
		<tr>
			<td><?php echo $fila['id_usuario']; ?></td>
			<td><?php echo $fila['nombre_usuario']; ?></td>
			<td><?php echo $fila['apellido']; ?></td>
			<td><?php echo $fila['nombre']; ?></td>
			<td><?php echo $fila['dni']; ?></td>
			<td><?php echo $fila['email']; ?></td>
			<td><?php echo $fila['desc_tipo_usuario']; ?></td>
			<td style="vertical-olign: middle">
				<input type="checkbox" readonly="true" disabled="disabled" <?php if($fila['habilitado']==1){ ?> checked="checked" <?php } ?> />
			</td>
			<td></td>
			<form role="form" action="usuarioONE.php" method="post" id="botonera" name="botonera">
				<td style="vertical-align: middle">
					<input type="hidden" name="idSelect" id="idSelect" value="<?php echo $fila['id_usuario']; ?>" /> 
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
					echo "<a href='usuariosEliminar.php?pagina=" . $i ."'>" . $i . "</a> ";
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
		} else header("Location: login.php");
	} else header("location:usuarios.php");
?>