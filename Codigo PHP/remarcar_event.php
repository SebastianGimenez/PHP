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
		echo "<script type=\"text/javascript\">location.href='remarcar.php';</script>";
	}
 	function error($texto){
		echo "<script type=\"text/javascript\">alert('$texto');</script>";

	}
	
	if(isset($_POST['idSelect'])){
		include("conexion.inc");
		$fila = "NO ME ANDA";
		$vID = $_POST['idSelect']; //Captura datos desde el Form anterior
		$vSql = "CALL ItemsGetOne('$vID')"; //Arma la instrucción SQL y luego la ejecuta

		$vResultado = mysqli_query($link, $vSql) or die (error(mysqli_error($link)));
		$fila = mysqli_fetch_row($vResultado);
	
		$vHab = FALSE;
		setcookie("id_item", $fila[0], time()+3600, "/");
		setcookie("titulo", $fila[1], time()+3600, "/");
		setcookie("anio", $fila[2], time()+3600, "/");
		setcookie("stock", $fila[3], time()+3600, "/");
		if($fila[4]==1) $vHab = TRUE; 
		setcookie("habilitado", $vHab, time()+3600, "/");
		setcookie("id_artista", $fila[5], time()+3600, "/");
		setcookie("id_genero", $fila[6], time()+3600, "/");
		setcookie("id_tipo_item", $fila[7], time()+3600, "/");
		setcookie("url", $fila[8], time()+3600, "/");
		setcookie("precio", $fila[10], time()+3600, "/");		
		
		header("location:remarcar.php");
	}
	
	if($_POST['event'] == 'Buscar'){
		setcookie("busqueda", '%'.$_POST['buscar'].'%', time()+3600, "/");
		header("location:remarcar.php");
	}
	
	if($_POST['event'] == 'Remarcar'){
		$id = $_POST['idItem'];
		$stock = $_POST['stockNuevo'];
		$precio = $_POST['precioNuevo'];
		
		include("conexion.inc");
		if($stock != "" && $precio != ""){
			
			$vSql = "CALL ItemsUpdateStock('$id', '$stock')";	
			mysqli_query($link, $vSql) or die (error(mysqli_error($link)));
			mysqli_close($link);
			
			include("conexion.inc");
			$vSql = "CALL PrecioInsert('$id', '$precio')";	
			mysqli_query($link, $vSql) or die (mysqli_error($link));
			mysqli_close($link);
			
			correcto("Item modificado correctamente");
		} else if($precio == ""){		
	
			$vSql = "CALL ItemsUpdateStock('$id', '$stock')";	
			mysqli_query($link, $vSql) or die (error(mysqli_error($link)));
			mysqli_close($link);
			
			correcto("Item modificado correctamente");
		} else{

			$vSql = "CALL PrecioInsert('$id', '$precio')";	
			mysqli_query($link, $vSql) or die (error(mysqli_error($link)));
			mysqli_close($link);
			
			correcto("Item modificado correctamente");
		}
	}
	
	if($_POST['event'] == 'Cancelar'){
		header("location:remarcar.php");	
	}

?>
</body>
</html>
