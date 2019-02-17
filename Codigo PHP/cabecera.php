
	<div style="text-align:center">
		<div>
			<a href="index.php"><img src="top700.png" style="max-width:100%" class="img-responsive" alt="titulo" /></a>
		</div>
	</div>
	
	<br />
	
	<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#cabecera" aria-controls="cabecera" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>

		<div class="collapse navbar-collapse" id="cabecera">
			<ul class="navbar-nav mr-auto">
				<li class="nav-item">
					<a class="nav-link" href="index.php">Home</a>
				</li>
	<?php 	if(isset($tipoUsuario)){	
				if ($tipoUsuario == 3){ ?>
					<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle" id="dropdown02" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Compras</a>
            			<div class="dropdown-menu" aria-labelledby="dropdown02">
							<a class="dropdown-item" href="resumenCompras.php">Listado de Compras</a>
							<a class="dropdown-item" href="itemsComprados.php">Calificar</a>
    	    		    </div>
					</li>
					<li class="nav-item"><a class="nav-link" href="carrito.php"> <img alt="Carrito" src="carrito25.png"> Carrito de compras <span clase="badge">(<?php  echo ($vNRO); ?>)</span></a></li>
			<?php } ?>
	<?php if ($tipoUsuario != 3){ ?>
        <li class="nav-item dropdown">
			<a class="nav-link dropdown-toggle" id="dropdown03" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Editar</a>
    		<div class="dropdown-menu" aria-labelledby="dropdown03">
				<?php if($tipoUsuario == 1) { ?>
					<a class="dropdown-item" href="artistas.php">Artistas</a>
					<a class="dropdown-item" href="generos.php">G&eacute;neros</a>
					<a class="dropdown-item"href="item.php">Productos</a>
					<a class="dropdown-item" href="usuarios.php">Usuarios</a>
				<?php } ?>																		 
					<a class="dropdown-item" href="remarcar.php">Remarcar</a>
	    	</div>
	     </li>
			<?php } else { ?>
				<li class="nav-item">
					<a class="nav-link" href="contacto.php">Contacto</a>
				</li>
			<?php } } 
				if(!isset($_SESSION["usuario"])){
			?>
				<li class="nav-item">
					<a class="nav-link" href="contacto.php">Contacto</a>
				</li>
			<?php } ?>
    		    </ul>
	    	    <form action="../pages/busqueda.php" method="post" class="form-inline my-2 my-md-0" >
					<input type="text" class="form-control" id="buscar" name="buscar" placeholder="Que est&aacute;s buscando?">
				</form>
				<ul class="navbar-nav my-2 my-md-0">
					<?php if (isset($tipoUsuario)){ ?>
					<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle" id="dropdown04" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php echo ("Hola ".$nombreUsuario); ?></a>
    					<div class="dropdown-menu" aria-labelledby="dropdown04">
							<a class="dropdown-item" href="editarDatos.php">Editar Datos</a>
							<a class="dropdown-item" href="loginout.php">Cerrar Sesi&oacute;n</a>
				    	</div>
				     </li>
					<?php  } else { ?>
					<li class="nav-item"><a class="nav-link" data-toggle="modal" data-target="#dialogo">Iniciar Sesi&oacute;n</a></li>
					<?php } ?>
				</ul>
			</div>
	</nav>
	
	<br />
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous" type="text/javascript"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous" type="text/javascript"></script>  