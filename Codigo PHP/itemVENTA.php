<?php 
	session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title></title>
</head>
<body>

<?php
	$titulo = "";
	
	function correcto($texto){
		echo "<script type=\"text/javascript\">alert('$texto');</script>";
		echo "<script type=\"text/javascript\">location.href='index.php';</script>";
	}
	function error($texto){
		echo "<script type=\"text/javascript\">alert('$texto');</script>";
		echo "<script type=\"text/javascript\">window.history.back();</script>";
	}
	function hayStock($id){
			include("conexion.inc");
			$vSql = "CALL ItemsGetOne('$id')";	
			$vResultado = mysqli_query($link, $vSql) or die (error(mysqli_error($link)));
			$fila = mysqli_fetch_row($vResultado);
			mysqli_close($link); unset($vResultado);
			if($fila[3]>0){ 
				return true;
			} else{
				$titulo = $fila[1]; include("conexion.inc");
				if($fila[3]==0){
					include("conexion.inc");
					$vSql = "CALL ItemsDelete('$id')";	
					mysqli_query($link, $vSql) or die (error(mysqli_error($link)));
					mysqli_close($link);
				}
				return false;
			}
	}

	if($_POST['event'] == 'Agregar'){
		if(hayStock($_POST['idSelect'])){
			if(isset($_SESSION["carro"])) $carro = $_SESSION["carro"];
			$id = $_POST['idSelect'];
			$cant = $_POST['cmbCantidad'];
			$stock = $_POST['stock'];
			$carro[$id] = array('Id'=>$id, 'Cantidad'=>$cant, 'Stock'=>$stock);
			$_SESSION["carro"] = $carro;
			correcto("Item agregado correctamente");
		} else error("El item ".$titulo." no se encuentra en el stock solicitado. Serás redirigido a la página anterior");
	} 
	if($_POST['event'] == 'Eliminar'){
		$id = $_POST['idSelected'];
		$carro = $_SESSION["carro"];
		unset($carro[$id]);
		if(count($carro)==0) {unset($_SESSION["carro"]);} else {$_SESSION["carro"] = $carro;}
		header("location:carrito.php");
	}
	if($_POST['event'] == 'Confirmar'){
		if(isset($_SESSION["carro"])){
			$usuario = $_SESSION["usuario"];
			$carro = $_SESSION["carro"];
			$idUsuario = $usuario['Id']; 
			$nroTarjeta = $_POST['nroTarjeta']; 
			$titTarjeta = $_POST['titTarjeta'];
			$cmbProvincia = $_POST['cmbProvincia']; 
			$localidad = $_POST['localidad'];
			$calle = $_POST['calle'];
			$nroCalle = $_POST['nroCalle'];
			$piso = $_POST['piso']; 
			$nroDpto = $_POST['nroDpto'];
			
			include("conexion.inc");
			$vSql = "INSERT INTO ventas(id_usuario, nro_tarjeta, titular_tarjeta, habilitado, fecha, id_provincia, localidad, calle, numero, piso, dpto) VALUES('$idUsuario', '$nroTarjeta', '$titTarjeta', true, CURDATE(), '$cmbProvincia', '$localidad', '$calle', '$nroCalle', '$piso', '$nroDpto')";
			mysqli_query($link, $vSql) or die (error(mysqli_error($link)));
			mysqli_close($link);
			
			include("conexion.inc");
			$vSql = "SELECT MAX(id_venta) as id_venta FROM ventas";
			$vRest = mysqli_query($link, $vSql) or die (error("Error al recuperar la compra"));
			$vID = mysqli_fetch_row($vRest);						 #OBTENGO EL ID DE LA ULTIMA VENTA INSERTADO
			$idVenta = $vID[0];
			unset($link);
				
			foreach($carro as $item){
#				INSERTO RELECION VENTA-ITEM
				include("conexion.inc");
				$cantidad = $item['Cantidad'];
				$idItem = $item['Id'];
				$vSql = "CALL VentaItemInsert('$cantidad', '$idItem', '$idVenta')";
				mysqli_query($link, $vSql) or die (error("Error al armar las tablas intermedias"));
				mysqli_close($link);

#				RECUPERO ITEM
				include("conexion.inc");
				$vSql = "CALL ItemsGetOne('$idItem')";
				$vRest = mysqli_query($link, $vSql) or die (error("Error al recuperar el Item"));
				$vItem = mysqli_fetch_row($vRest);
				$stock = $vItem[3];
				unset($link);
				$stock = $stock - $cantidad;
				
#				ACTUALIZO STOCK				
				include("conexion.inc");
				$vSql = "CALL ItemsUpdateStock($idItem, '$stock')";
				mysqli_query($link, $vSql) or die (error("Error al actualizar el Stock"));
				mysqli_close($link);		
				
#				SI EL STOCK SE PONE EN 0, DESHABILITO EL ITEM
				if($stock==0){
					include("conexion.inc");
					$vSql = "CALL ItemsDelete('$idItem')";	
					mysqli_query($link, $vSql) or die (error("Error al deshabilitar el Producto"));
					mysqli_close($link);
				}
			}
			unset($_SESSION["carro"]);
			$mail = $usuario['Email']; 
			$email = mail($mail,"Luzbelito informa","La compra fue realizada con éxito");
			if($email==TRUE) correcto("Compra exitosa. Pronto recibirá un mail con a confirmación de la misma");
			else error("Error al enviar el mail");
		}
	}
					

?>

</body>
</html>
