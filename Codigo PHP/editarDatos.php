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
<title>Editar Datos</title>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous" type="text/css" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
</head>
<body>
	<?php include("cabecera.php"); ?>
	
	<script>
		function validar(){
			dni = document.formTabla.dni.value
			nombre = document.formTabla.nombre.value
			apellido = document.formTabla.apellido.value
			email = document.formTabla.email.value
			clave = document.formTabla.clave.value
			cClave = document.formTabla.confirmarClave.value
			
			if (!isNaN(nombre)){
				alert("El Nombre no puede ser un número"); return false;
			} else if (!isNaN(apellido)){
				alert("El Apellido no puede ser un número"); return false;		
			} else if (isNaN(dni)){
				alert("El dni no es un número"); return false;
			} else if(/\w+([-+.']\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)/.test(email)){
				alert("El mail no posee el formato adecuado"); return false;
			} else if(clave != cClave){
				alert("Las claves son distintas"); return false;
			} else return true
		}
	</script>
	<div class="col-sm-5 col-md-5">

		<h2 class="page-header">Editar Datos</h2>

		<br>

		<form role="form" action="usuario.php" method="post" id="formTabla" name="formTabla" onSubmit="return validar()">
			<div class="form-group">
				<b>C&oacute;digo:(*)</b>
				<input type="text" readonly class="form-control" id="idUsuario" name="idUsuario" value="<?php echo $_SESSION['usuario']['Id']?>"  />
			</div>
			<div class="form-group">
				<b>Nombre de Usuario:(*)</b>
				<input type="text" class="form-control" id="nombreUsuario" name="nombreUsuario" readonly value="<?php echo $_SESSION['usuario']['Usuario']?>" />
			</div>
			<div class="form-group">
				<b>Nombre:(*)</b>
				<input type="text" class="form-control" id="nombre" name="nombre" required="required" value="<?php echo $_SESSION['usuario']['Nombre']?>" />
			</div>
			<div class="form-group">
				<b>Apellido:(*)</b>
				<input type="text" class="form-control" id="apellido" name="apellido" required="required" value="<?php echo $_SESSION['usuario']['Apellido']?>"  />
			</div>
			<div class="form-group">
				<b>DNI:(*)</b>
				<input type="text" class="form-control" id="dni" name="dni" required="required" value="<?php echo $_SESSION['usuario']['DNI'] ?>" />
			</div>
			<div class="form-group">
				<b>Email:(*)</b>
				<input type="text" class="form-control" id="email" name="email" required="required" value="<?php echo $_SESSION['usuario']['Email'] ?>" />
			</div>
			<div class="form-group">
				<b>Clave:(*)</b>
				<input type="password" class="form-control" id="clave" name="clave" required="required" />
			</div>
			<div class="form-group">
				<b>Confirmar Clave:(*)</b>
				<input type="password" class="form-control" id="confirmarClave" name="confirmarClave" required="required" />
			</div>
			<br />
			<div class="form-group" align="center">
				<input class="btn btn-success" type="submit" value="Editar" id="event" name="event" /> 
				<input class="btn btn-default" type="submit" value="Cancelar" id="event" name="event" />
			</div>
		</form>
	</div>

	<?php include("pie.php"); ?>
</body>
</html>
<?php } else header("location:login.php"); ?>