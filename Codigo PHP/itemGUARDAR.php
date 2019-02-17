<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Guardar Item</title>
</head>
<body>
<?php
	function correcto($texto){
		echo "<script type=\"text/javascript\">alert('$texto');</script>";
		echo "<script type=\"text/javascript\">location.href='item.php';</script>";
	}
 	function error($texto){
		echo "<script type=\"text/javascript\">alert('$texto');</script>";
		echo "<script type=\"text/javascript\">window.history.back();</script>";
	}
	
	if(isset($_POST['idItem'])) $vID = $_POST['idItem']; 
	if(isset($_POST['tituloItem'])) $vTitulo = $_POST['tituloItem']; 
	if(isset($_POST['cmbArtista'])) $vIdArtista = $_POST['cmbArtista']; 
	if(isset($_POST['cmbGenero'])) $vIdGenero = $_POST['cmbGenero']; 
	if(isset($_POST['cmbTipoDisco'])) $vIdTipoDisco = $_POST['cmbTipoDisco']; 
	if(isset($_POST['anioLanzamiento'])) $vAnioLanzamiento = $_POST['anioLanzamiento']; 
	if(isset($_POST['precioItem'])) $vPrecioItem = $_POST['precioItem']; 
	if(isset($_POST['stock'])) $vStock = $_POST['stock']; 
	if(isset($_POST['urlPortada'])) $vImagen = $_POST['urlPortada']; 
	if(isset($_POST['habilitado'])) $vHabilitado = TRUE;
	else $vHabilitado = FALSE;
	
	if($_POST['event'] == 'Cancelar'){
		header("location:item.php");	
	} else if($_POST['event'] == 'Eliminar'){
		include("conexion.inc");
		$vSql = "CALL ItemsDelete('$vID')";	
		mysqli_query($link, $vSql) or die (error(mysqli_error($link)));
		mysqli_close($link);
		setcookie("id_item", '', time()-3600, "/");
		correcto("Item eliminado correctamente");
	} else if($_POST['event'] == 'Modificar'){
		include("conexion.inc");
		$vSql = "CALL ItemsUpdate('$vAnioLanzamiento', '$vHabilitado', '$vIdArtista', '$vIdGenero', '$vStock', '$vTitulo', '$vIdTipoDisco', '$vID', '$vImagen')";	
		mysqli_query($link, $vSql) or die (error(mysqli_error($link)));
		mysqli_close($link);
		unset($link);
			
		include("conexion.inc");
		$vSql = "CALL ItemsGetOne('$vID')";	
		$vResultado = mysqli_query($link, $vSql) or die (error(mysqli_error($link)));
		$fila = mysqli_fetch_row($vResultado);
		mysqli_close($link);
		unset($link);
		if($fila[9] != $vPrecioItem){
			include("conexion.inc");
			$vSql = "CALL PrecioInsert('$vID','$vPrecioItem')";																#INSTERTO EL VALOR DEL ITEM
			mysqli_query($link, $vSql) or die (error(mysqli_error($link)));
			
			// Cerrar la conexion
			mysqli_close($link);		
			unset($link);
		}
		correcto("Item modificado correctamente");

	} else if($_POST['event'] == 'Guardar'){
		include("conexion.inc"); //Arma la instrucción SQL y luego la ejecuta
		$vSql = "CALL ItemsGetAllForArtista('$vIdArtista')";
		$vResultado = mysqli_query($link, $vSql) or die (error(mysqli_error($link)));
		$validar = TRUE;
		while($fila = mysqli_fetch_array($vResultado)){		
			if($fila['titulo']==$vTitulo){
				$validar = FALSE;
			}
		}
		unset($vResultado, $link);
	
		if(!$validar){
			error("Ese disco ya fue agregado"); 						
		} else {
			include("conexion.inc");
			$vSql = "INSERT INTO items(anio_lanzamiento, habilitado, id_artista, id_genero, stock, titulo, id_tipo_disco, url_portada) VALUES('$vAnioLanzamiento', true, '$vIdArtista', '$vIdGenero', '$vStock', '$vTitulo', '$vIdTipoDisco', '$vImagen')";
			mysqli_query($link, $vSql) or die (mysqli_query($link));
			unset($link);
				
			include("conexion.inc");
			$vSql = "SELECT MAX(id_item) as id_item FROM items";
			$vRest = mysqli_query($link, $vSql) or die ("No recupera el último item");
			$vID = mysqli_fetch_row($vRest);						 #OBTENGO EL ID DEL ULTIMO ITEM INSERTADO
			unset($link);
		
			$id = $vID[0];
			include("conexion.inc");
			$vSql = "CALL PrecioInsert('$id','$vPrecioItem')";																#INSTERTO EL VALOR DEL ITEM
			mysqli_query($link, $vSql) or die ("No inserta precio");	
			mysqli_close($link);
				
			correcto("Item agregado correctamente");	
		}
	}
	?>
</body>
</html>