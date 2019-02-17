<?php 
	session_start();
	if(!isset($_SESSION["usuario"])){
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>

<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title>Login</title>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous" type="text/css" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
</head>
<body>
<script type="text/javascript">
	function validar(){
		usuario = document.formReg.userCreate.value
		contrasenia = document.formReg.passCreate.value
		confirmar = document.formReg.passConfirm.value
		nombre = document.formReg.nombre.value
		apellido = document.formReg.apellido.value
		dni = document.formReg.dni.value
		email = document.formReg.email.value
		emailReg = /^[-\w.%+]{1,64}@(?:[A-Z0-9-]{1,63}\.){1,125}[A-Z]{2,63}$/i;	

		if (isNaN(dni)){
			alert("El DNI no es un número"); return false;
		} else if (!isNaN(nombre)){
			alert("El Nombre no puede ser un número"); return false;
		} else if (!isNaN(apellido)){
			alert("El Apellido no puede ser un número"); return false;
		} else if(contrasenia != confirmar){
			alert("Las contraseñas son distintas"); return false;
 		} else if(emailReg.test(email)==false){
			alert("El mail no posee el formato adecuado"); return false;
		} else return true;
	}
</script>
	<?php include("cabecera.php"); ?>
	
	<div class="container">
	<div class="row">
		<div class="col-6">
			<div class="card">
		       	<div class="card-body">
					<h4 class="card-title text-center">Iniciar Sesi&oacute;n</h4>
					<form role="formLog" action="loginout.php" method="post" id="login" name="login">
						<div class="form-group">
							<label for="userregister">Usuario:</label> 
							<input type="text" class="form-control" id="userLogin" name="userLogin" >
						</div>
						<div class="form-group">
							<label for="password">Contrase&ntilde;a:</label>
							<input type="password" class="form-control" id="passLogin" name="passLogin">
						</div>
						<div class="form-group">
							<input class="btn btn-success btn-block" type="submit" value="Ingresar" id="event" name="event" />
						</div>
					</form>
				</div>
			</div>          
		</div>
	
		<div class="col-6">
			<div class="card">
    			<div class="card-body">
		        	<h4 class="card-title text-center">Registrarse</h4>
					<form role="form" action="loginout.php" method="post" id="formReg" name="formReg" onSubmit="return validar()" >
						<div class="form-group">
							<label for="user">Usuario:(*)</label>
							<input type="text" class="form-control" id="userCreate" name="userCreate">
						</div>
						<div class="form-group">
							<label for="password">Contrase&ntilde;a:(*)</label> 
							<input type="password" class="form-control" id="passCreate" name="passCreate">
						</div>
						<div class="form-group">
							<label for="password">Confirmar Contrase&ntilde;a:(*)</label> 
							<input type="password" class="form-control" id="passConfirm" name="passConfirm">
						</div>
						<div class="form-group">
							<label for="nombre">Nombre:(*)</label>
							<input type="text" class="form-control" id="nombre" name="nombre" <?php if(isset($_COOKIE["nombre"])) { ?> value="<?php echo $_COOKIE["nombre"]; ?>" <?php } ?> >
						</div>
						<div class="form-group">
							<label for="apellido">Apellido:(*)</label> <input type="text" class="form-control" id="apellido" name="apellido"<?php if(isset($_COOKIE["apellido"])) { ?> value="<?php echo $_COOKIE["apellido"]; ?>" <?php } ?> >
						</div>
						<div class="form-group">
							<label for="dni">DNI:(*)</label> 
							<input type="text" class="form-control" id="dni" name="dni" <?php if(isset($_COOKIE["dni"])) { ?> value="<?php echo $_COOKIE["dni"]; ?>" <?php } ?> >
						</div>
						<div class="form-group">
							<label for="dni">Email:(*)</label>
							<input type="email" class="form-control" id="email" name="email" <?php if(isset($_COOKIE["email"])) { ?> value="<?php echo $_COOKIE["email"]; ?>" <?php } ?> >
						</div>
						<div class="form-group">
							<input class="btn btn-success btn-block" type="submit" value="Registrar" id="event" name="event" onClick="return validar()" />
						</div>
					</form>
				</div>
			</div>
		</div>	
		</div>
	<?php 
		if (isset($_COOKIE["email"]))setcookie("email", '', time()-3600, "/");
		if (isset($_COOKIE["dni"]))setcookie("dni", '', time()-3600, "/");
		if (isset($_COOKIE["apellido"]))setcookie("apellido", '', time()-3600, "/");
		if (isset($_COOKIE["nombre"]))setcookie("nombre", '', time()-3600, "/");
	?>
	</div>
	<?php include("pie.php"); ?>
</body>
</html>
<?php
	} else header('Location: index.php');
?>