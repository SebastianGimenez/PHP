<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Documento sin título</title>
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
	
	$destino="luzbelito.discos@gmail.com"; /*"micorreo@dominio.com";*/
	$asunto="Contacto luzbelito";
	$desde='From:' .$_POST["mail"];
	$comentario= $_POST["tex"];
	$email = mail($destino,$asunto,$comentario,$desde);
	if ($email==true){
		correcto("Su consulta ha sido enviada, en breve recibirá nuestra respuesta.");
	} else {
		error("mensaje no enviado");
	}
	
?>

</body>
</html>