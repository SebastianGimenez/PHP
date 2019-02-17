<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin t&iacute;tulo</title>
</head>
<body>
<?php
	function correcto($texto){
		echo "<script type=\"text/javascript\">alert('$texto');</script>";
		echo "<script type=\"text/javascript\">location.href='generos.php';</script>";
	}
 	function error($texto){
		echo "<script type=\"text/javascript\">alert('$texto');</script>";
		echo "<script type=\"text/javascript\">window.history.back();</script>";
	}
	
	if(isset($_POST['idGenero'])) $vID = $_POST['idGenero'];
	if(isset($_POST['descGenero'])) $vDescripcionGenero = $_POST['descGenero'];
	if(isset($_POST['habilitado'])) $vHabilitado = TRUE;
	else $vHabilitado = FALSE;
	
	if($_POST['event'] == 'Cancelar'){
		header("location:genero.php");	
	} else if($_POST['event'] == 'Eliminar'){
		include("conexion.inc");
		$vSql = "CALL GenerosDelete('$vID')";	
		mysqli_query($link, $vSql) or die (error(mysqli_error($link)));
		mysqli_close($link);
		setcookie("idGenero", '', time()-3600, "/");
		correcto("Genero eliminado correctamente");
	} else if($_POST['event'] == 'Modificar'){
		include("conexion.inc");
		$vSql = "CALL GenerosUpdate('$vDescripcionGenero', '$vHabilitado', '$vID')";	
		mysqli_query($link, $vSql) or die (error(mysqli_error($link)));
		mysqli_close($link);
		unset($link);
		correcto("Genero modificado correctamente");
	} else if($_POST['event'] == 'Guardar'){
		include("conexion.inc"); //Arma la instrucción SQL y luego la ejecuta
		$vSql = "CALL GenerosGetAll()";
		$vResultado = mysqli_query($link, $vSql) or die (error(mysqli_error($link)));
		$validar = TRUE;
		while($fila = mysqli_fetch_array($vResultado)){		
			if($fila['desc_genero']==$vDescripcionGenero){
				$validar = FALSE;
			}
		}
		unset($vResultado, $link);
	
		if(!$validar){
			error("Ese Genero ya fue agregado"); 						
		} else {
			include("conexion.inc");
			$vSql = "CALL GenerosInsert('$vDescripcionGenero', '$vHabilitado')";	
			mysqli_query($link, $vSql) or die (error(mysqli_error($link)));
			unset($link);
				
			correcto("Genero agregado correctamente");	
		}
	}
	?>

</body>
</html>
