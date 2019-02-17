<div class="modal fade" id="dialogo">
	<div class="modal-dialog modal-lg modal-dialog-centered" style="width:400PX; max-width:100%; text-align:center">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Ingresar</h4>
				<button type="button" class="close" data-dismiss="modal">X</button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">   
                    <form role="form" action="loginout.php" method="post" id="login" name="login">
						<div class="form-group">
							<label for="userregister">Usuario:</label> 
							<input type="text" class="form-control" id="userLogin" name="userLogin" >
						</div>
						<div class="form-group">
							<label for="password">Contrase&ntilde;a:</label>
							<input type="password" class="form-control" id="passLogin" name="passLogin">
						</div>
						<div class="form-group">
							<input class="btn btn-success btn-block" type="submit" value="Ingresar" id="event" name="event" />
							<input type="submit" class="btn btn-link" value="No poseo cuenta" id="event" name="event" />
 						</div>
					</form>                  
				</div>            
			</div>
		</div>
	</div>		
</div> 