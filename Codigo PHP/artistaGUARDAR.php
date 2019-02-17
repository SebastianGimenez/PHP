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
		echo "<script type=\"text/javascript\">location.href='artistas.php';</script>";
	}
 	function error($texto){
		echo "<script type=\"text/javascript\">alert('$texto');</script>";
		echo "<script type=\"text/javascript\">window.history.back();</script>";
	}
	
	if(isset($_POST['idArtista'])) $vID = $_POST['idArtista'];
	if(isset($_POST['nombreArtista'])) $vNombreArtista = $_POST['nombreArtista'];
	if(isset($_POST['habilitado'])) $vHabilitado = TRUE;
	else $vHabilitado = FALSE;
	
	if($_POST['event'] == 'Cancelar'){
		header("location:artistas.php");	
	} 
	
	if($_POST['event'] == 'Eliminar'){
		include("conexion.inc");
		$vSql = "CALL ArtistasDelete('$vID')";	
		mysqli_query($link, $vSql) or die (error(mysqli_error($link)));
		mysqli_close($link);
		setcookie("idArtista", '', time()-3600, "/");
		correcto("Artista eliminado correctamente");
	} 
	
	if($_POST['event'] == 'Modificar'){
		include("conexion.inc");
		$vSql = "CALL ArtistasUpdate('$vNombreArtista', '$vHabilitado', '$vID')";	
		mysqli_query($link, $vSql) or die (error(mysqli_error($link)));
		mysqli_close($link);
		unset($link);
		correcto("Artista modificado correctamente");
	}
	
	if($_POST['event'] == 'Guardar'){
		include("conexion.inc"); //Arma la instrucción SQL y luego la ejecuta
		$vSql = "CALL ArtistasGetAll()";
		$vResultado = mysqli_query($link, $vSql) or die (error(mysqli_error($link)));
		$validar = TRUE;
		while($fila = mysqli_fetch_array($vResultado)){		
			if($fila['nombre_artista']==$vNombreArtista){
				$validar = FALSE;
			}
		}
		unset($vResultado, $link);
	
		if(!$validar){
			error("Ese Artista ya fue agregado"); 						
		} else {
			include("conexion.inc");
			$vSql = "CALL ArtistasInsert('$vNombreArtista', '$vHabilitado')";	
			mysqli_query($link, $vSql) or die (error(mysqli_error($link)));
			unset($link);
				
			correcto("Artista agregado correctamente");	
		}
	}
	?>

</body>
</html>