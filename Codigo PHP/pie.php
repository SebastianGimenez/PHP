<style>
		.footer {

		  bottom: 0;
		  width: 100%;

		  line-height: 60px; /* Vertically center the text there */
		  background-color: #f5f5f5;
		}
	</style>
	<br /><br />
	
	<?php if(!isset($tipoUsuario)) $tipoUsuario = 0; ?>
	
	<div class="footer">
		<div class="row">
			<div class="col-md-4" style="margin-left:20px;">
			<a href="index.php">Home</a><br />
			<a href="contacto.php">Contacto</a><br />
			<?php if(!isset($_SESSION["usuario"])){ ?>
			<a href="login.php">Login</a><br />
			<?php } else { ?> 
			<a href="editarDatos.php">Configuracion de usuario</a><br />
			<?php } ?>
			<a href="quienes.php">Quienes Somos?</a><br />
			</div>
			<div class="col-md-4">
			<?php if ($tipoUsuario==1) { ?>
			<a href="artistas.php">Artistas</a><br />
			<a href="generos.php">Generos</a><br />
			<a href="item.php">Productos</a><br />
			<a href="usuarios.php">Usuarios</a><br />
			<?php } if ($tipoUsuario==1 || $tipoUsuario==2) { ?>
			<a href="remarcar.php">Remarcar Precios y/o Stock</a><br />
			<?php } if ($tipoUsuario==3) { ?>
			<a href="carrito.php">Carrito de Compras</a><br />
			<a href="itemsComprados.php">Listados de Compras</a><br />
			<a href="resumenCompras.php">Resumen de Compras</a><br />
			<?php }?>
			</div>
		</div>
	</div>