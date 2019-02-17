<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title></title>
</head>
<body>
<?php
	function correcto($texto){
		echo "<script type=\"text/javascript\">alert('$texto');</script>";
		echo "<script type=\"text/javascript\">location.href='usuarios.php';</script>";
	}
	function edicion_correcta($texto){
		echo "<script type=\"text/javascript\">alert('$texto');</script>";
		echo "<script type=\"text/javascript\">location.href='index.php';</script>";
	}
	function error($texto){
		echo "<script type=\"text/javascript\">alert('$texto');</script>";
		echo "<script type=\"text/javascript\">window.history.back();</script>";
	}
	
	if($_POST['event']=='Editar'){
		$Usuario = $_POST['nombreUsuario'];
		$Apellido = $_POST['apellido'];
		$IdUsuario = $_POST['idUsuario'];
		$Email = $_POST['email'];
		$Nombre = $_POST['nombre'];
		$Clave = $_POST['clave'];
		$Dni = $_POST['dni'];
		
		include("conexion.inc");
		$vSql = "CALL UsuariosUpdateData('$IdUsuario', '$Apellido', '$Nombre', '$Email', '$Clave', '$Dni')";
		mysqli_query($link, $vSql) or die (error(mysqli_error($link)));
		mysqli_close($link);
		
		session_start();
		$_SESSION['usuario']['Apellido'] = $Apellido;
		$_SESSION['usuario']['Nombre'] = $Nombre;
		$_SESSION['usuario']['Email'] = $Email;
		$_SESSION['usuario']['DNI'] = $Dni;
		
		edicion_correcta("Sus datos fueron editados correctamente");
	}
		
	if($_POST['event'] == 'Cancelar'){
		header("location:usuarios.php");	
	}
	
	if($_POST['event'] == 'Eliminar'){
		$vID = $_POST['idUsuario'];
		include("conexion.inc");
		$vSql = "CALL UsuariosDelete('$vID')";	
		mysqli_query($link, $vSql) or die (error("Error al ejecutar la sentencia"));
		mysqli_close($link);
		correcto("Usuario eliminado correctamente");
	}
	
	if(isset($_POST['nombre'])) $vNombre = $_POST['nombre'];
	if(isset($_POST['apellido'])) $vApellido = $_POST['apellido'];
	if(isset($_POST['cmbTipo'])) $vTipo = $_POST['cmbTipo'];
	if(isset($_POST['email'])) $vEmail = $_POST['email'];
	if(isset($_POST['clave'])) $vClave = $_POST['clave'];
	if(isset($_POST['dni'])) $vDNI = $_POST['dni'];
	if(isset($_POST['habilitado'])) $vHabilitado = TRUE;
	else $vHabilitado = FALSE;
	
	if($_POST['event'] == 'Modificar'){
		$vID = $_POST['idUsuario'];
		include("conexion.inc");
		$vSql = "CALL UsuariosUpdate('$vApellido', '$vClave', '$vEmail', '$vNombre', '$vTipo', '$vHabilitado', '$vDNI', '$vID')";	
		mysqli_query($link, $vSql) or die (error(mysqli_error($link)));
		mysqli_close($link);
		unset($link);
		correcto("Usuario modificado correctamente");
	}
	
	if($_POST['event'] == 'Guardar'){
		if(isset($_POST['nombreUsuario'])) $vNombreUsuario = $_POST['nombreUsuario'];
		include("conexion.inc"); //Arma la instrucción SQL y luego la ejecuta
		$vSql = "CALL UsuariosGetAll()";
		$vResultado = mysqli_query($link, $vSql) or die (error("Error al recuperar los usuarios"));
		$validar = TRUE;
		while($fila = mysqli_fetch_array($vResultado)){		
			if($fila['nombre_usuario']==$vNombreUsuario){
				$validar = FALSE;
			}
		}
		unset($vResultado, $link);
	
		if(!$validar){
			error("Ese Nombre de Usuario ya fue agregado"); 						
		} else {
			include("conexion.inc");
			$vSql = "CALL UsuariosInsert('$vApellido', '$vClave', '$vEmail', '$vNombre', '$vNombreUsuario', '$vTipo', '$vHabilitado', '$vDNI')";	
			mysqli_query($link, $vSql) or die (error("Error al agregar el usuario"));
			unset($link);
				
			correcto("Usuario agregado correctamente");	
		}
	}
?>
</body>
</html>
