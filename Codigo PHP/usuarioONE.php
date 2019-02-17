<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Remarcar</title>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous" type="text/css" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
</head>
<body>
<?php
	setcookie("idUsuario", $_POST['idSelect'], time()+10, "/");	

	if($_POST['event'] == 'Modificar'){
		header("location:usuarioModificacion.php");
	}
	if($_POST['event'] == 'Eliminar'){
		header("location:usuariosEliminar.php");
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
