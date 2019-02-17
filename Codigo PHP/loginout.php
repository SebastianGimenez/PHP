<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" >
<html>
<head>
<title>Subir Item</title>
</head>
<body>
	<?php
		function correcto($texto){
			echo "<script type=\"text/javascript\">alert('$texto');</script>";
			echo "<script type=\"text/javascript\">location.href='index.php';</script>";
		}
		function error($texto){
			echo "<script type=\"text/javascript\">alert('$texto');</script>";
			echo "<script type=\"text/javascript\">window.history.back();</script>";
		}
		
		if($_POST['event']=='Ingresar'){
			session_start();
			$vUser = $_POST['userLogin'];
			$vPass = $_POST['passLogin'];
			
			include("conexion.inc");
			$vSql = "CALL UsuariosLogin('$vUser', '$vPass')";
			$vResultado = mysqli_query($link, $vSql) or die (error($link));
			
			if($fila = mysqli_fetch_array($vResultado)){
					$user = array('Id'=>$fila['id_usuario'],'Usuario'=>$fila['nombre_usuario'],'Nombre'=>$fila['nombre'], 'Apellido'=>$fila['apellido'], 'TipoUsuario'=>$fila['id_tipo_usuario'], 'Email'=>$fila['email'], 'DNI'=>$fila['dni']);
					$_SESSION['usuario'] = $user;
					if(isset($_COOKIE["elegido"])) header('Location:elegido.php');
					else header('Location:index.php');
			} else { 
				error("Usuario o Contraseña incorrecto");
			}
		} else if($_POST['event']=='Registrar'){
				$vUser= $_POST['userCreate'];
				$vPass = $_POST['passCreate'];
				$vNombre = $_POST['nombre'];
				$vApellido = $_POST['apellido'];
				$vDNI= $_POST['dni'];
				$vEmail = $_POST['email'];
			
				include("conexion.inc"); //Arma la instrucción SQL y luego la ejecuta
				$vSql = "select * from usuarios";
				$vResultado = mysqli_query($link, $vSql) or die (error("Error al recuperar los usuarios"));
				$validar = TRUE;
				while($fila = mysqli_fetch_array($vResultado)){		
					if($fila['nombre_usuario']==$vUser){
						$validar = FALSE;
					}
				}
				unset($vResultado, $link);
	
				if(!$validar){
					setcookie("email", $vEmail, time()+3600, "/");
					setcookie("dni", $vDNI, time()+3600, "/");
					setcookie("apellido", $vApellido, time()+3600, "/");
					setcookie("nombre", $vNombre, time()+3600, "/");
					error("Ese Nombre de Usuario ya fue agregado"); 						
				} else {
					include("conexion.inc");
					$vSql = "INSERT INTO usuarios(apellido, clave, email, nombre, nombre_usuario, id_tipo_usuario, habilitado, dni) VALUES ('$vApellido', '$vPass', '$vEmail', '$vNombre', '$vUser', '3', '1', '$vDNI')";
					mysqli_query($link, $vSql) or die (error("Error al agregar el Usuario"));	
					mysqli_close($link);				
					correcto("Usuario agregado correctamente");	
				}
			} else if($_POST['event'] == 'No poseo cuenta'){
				header('Location: login.php');
			} else {
				session_start();
				session_destroy();
				if(isset($_COOKIE["buscar"])) setcookie("buscar", '', time()-3600, "/");
				header('Location:index.php');
			}
		
	?>
</body>
</html>