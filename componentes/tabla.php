<?php 
	require_once "../php/conexion.php";
	$conexion = conexion();
?>

<div class="row">
	<div class="col-sm-12">
		<h2>Tipo Usuarios</h2>
		<caption>
			<button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#ModalNuevo">
				Agregar tipo de usuario
				<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-lg" viewBox="0 0 16 16">
					<path fill-rule="evenodd" d="M8 2a.5.5 0 0 1 .5.5v5h5a.5.5 0 0 1 0 1h-5v5a.5.5 0 0 1-1 0v-5h-5a.5.5 0 0 1 0-1h5v-5A.5.5 0 0 1 8 2"/> 
				</svg>
			</button>
		</caption>
		<h2></h2>
		<table class="table table-hover table-condensed table-bordered">
			<tr>
				<td>Tipo de usuario</td>
				<td>Estado</td>
				<td>Editar</td>
				<td>Eliminar</td>
			</tr>	

			<?php 
				$sql = "SELECT id_tipo_usuario, nombre_tipo, estado FROM tipo_usuarios";
				$result = mysqli_query($conexion, $sql);
				
				while ($ver = mysqli_fetch_row($result)) {
					// Pasar todos los datos a la función para cargar el formulario
					$datos = $ver[0] . "||" . $ver[1] . "||" . $ver[2];
			?>

			<tr>
				<td><?php echo $ver[1]; ?></td> <!-- nombre_tipo -->
				<td><?php echo $ver[2] == 'A' ? 'A' : 'I'; ?></td> <!-- estado -->
				<td>
					<button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#ModalEdicion" onclick="agregaform('<?php echo $datos; ?>')">
						<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
							<path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
							<path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
						</svg>
					</button>
				</td>
				<td>
					<button class="btn btn-danger bi bi-trash3" onclick="preguntarSiNo('<?php echo $ver[0]; ?>')">
						<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash3" viewBox="0 0 16 16">
							<path d="M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5M11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47M8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5"/>
						</svg>
					</button>
				</td>
			</tr>

			<?php  
				}
			?>			
		</table>
	</div>
</div>
