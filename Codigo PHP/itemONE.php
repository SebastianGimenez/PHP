<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Editar</title>
</head>
<body>

<?php 
	setcookie("idItem", $_POST['idSelect'], time()+10, "/");
	
	if($_POST['event'] == 'Modificar'){
		header("location:itemModificacion.php");
	}
	if($_POST['event'] == 'Eliminar'){
		header("location:itemEliminar.php");
	}	
	if($_POST['event'] == 'Buscar'){
		setcookie("busqueda", '%'.$_POST['buscar'].'%', time()+3600, "/");
		echo "<script type=\"text/javascript\">window.history.back();</script>";
	}
	if($_POST['event'] == 'Reiniciar'){
		setcookie("busqueda", '', time()-3600, "/");
		echo "<script type=\"text/javascript\">window.history.back();</script>";
	}
?>

</body>
</html>
