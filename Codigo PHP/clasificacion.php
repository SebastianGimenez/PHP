<?php

	function correcto($texto){
		echo "<script type=\"text/javascript\">alert('$texto');</script>";
		echo "<script type=\"text/javascript\">location.href='itemsComprados.php';</script>";
	}
 	function error($texto){
		echo "<script type=\"text/javascript\">alert('$texto');</script>";
		echo "<script type=\"text/javascript\">location.href='itemsComprados.php';</script>";
	}
	
	session_start();
	$usuario = $_SESSION['usuario'];	
	
	if($_POST['event'] == 'Cancelar') {
		header("Location:itemsComprados");
	} else
	if($_POST['event'] == 'Calificar'){

		if(isset($_POST['messageAdd'])) $mensaje = $_POST['messageAdd']; else $mensaje = "";
		if(isset($_POST['estrellas'])) $valor = $_POST['estrellas']; else $valor = 0;
		$idUsuario = $usuario['Id'];
		$idItem = $_POST['idSelect'];
		
		include("conexion.inc");
		$vSql = "CALL ClasificacionesGetOne('$idItem', '$idUsuario')";
		$resultado = mysqli_query($link, $vSql) or die (error(mysqli_error($link)));
		mysqli_close($link);
		$res = mysqli_fetch_row($resultado);
		if($res == NULL){		
			include("conexion.inc");
			$vSql = "CALL ClasificacionesInsert('$idItem', '$idUsuario', '$valor', '$mensaje')";
			mysqli_query($link, $vSql) or die (error(mysqli_error($link)));
			mysqli_close($link);
		} else{
			$vIDR = $res[0];
			include("conexion.inc");
			$vSql = "CALL ClasificacionesUpdate('$idItem', '$idUsuario', '$valor', '$mensaje', '$vIDR')";
			mysqli_query($link, $vSql) or die (error(mysqli_error($link)));
			mysqli_close($link);
		}
		correcto("Item calificado correctamente");
	}
	
?>