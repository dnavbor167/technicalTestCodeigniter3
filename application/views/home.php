<div style="padding-bottom: 10rem;"></div>
<div class="row">
	<button name="btnNuevoEmpleado" class="btn btn-success btn-md" data-toggle="modal" data-target="#myModal"
		style="margin: 0 0 3rem 7rem; background: #ffd777; border: solid 1px #ffd777;"> Añadir Empleado </button>
</div>
<div style="width: 90%; margin: 0 auto;">
	<table id="empleados" class="display" style="width: 100%; border: solid 1px gray;">
		<thead>
			<tr>
				<th>Nombre</th>
				<th>Apellidos</th>
				<th>Dirección</th>
				<th>Acciones</th>
			</tr>
		</thead>
		<tbody>
			<?php
			foreach ($empleados as $value) {
				$id_empleado = $value->id_empleado;
				$nombre = $value->nombre;
				?>
				<tr id="rowEmpleado<?php echo $id_empleado ?>">
					<td>
						<?php echo $nombre ?>
					</td>
					<td>
						<?php echo $value->apellido1 . " " . $value->apellido2 ?>
					</td>
					<td>
						<?php echo $value->direccion ?>
					</td>
					<td>
						<button id="<?php echo $nombre . "-" . $id_empleado ?>" name="btnEditar"
							class="btn btn-success btn-sm editar" data-target="#myModal"> Editar
						</button>
						<button id="<?php echo $nombre . "-" . $id_empleado ?>"
							class="btn btn-success btn-sm eliminar-empleado" data-target="#myModal"
							style="background: red;"> Eliminar </button>
					</td>
				</tr>
				<?php
			}
			?>
		</tbody>
	</table>
</div>

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"
	style="display: none;">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header" id="modal-header-error">
				<button id="cross-close" type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<h4 class="modal-title" id="myModalLabel">Añadir Empleado</h4>
			</div>
			<div class="modal-body">
				<form action="<?php echo base_url("DashBoard/agregarEmpleado"); ?>" method="post">
					<div class="form-group">
						<label class="col-sm-2 col-sm-2 control-label" for="nombre_empleado">Nombre</label>
						<div class="col-sm-10">
							<input class="form-control" type="text" name="nombre_empleado" id="nombre_empleado">
							<br>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 col-sm-2 control-label" for="apellido1_empleado">Apellido 1</label>
						<div class="col-sm-10">
							<input class="form-control" type="text" name="apellido1_empleado" id="apellido1_empleado">
							<br>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 col-sm-2 control-label" for="apellido2_empleado">Apellido 2</label>
						<div class="col-sm-10">
							<input class="form-control" type="text" name="apellido2_empleado" id="apellido2_empleado">
							<br>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 col-sm-2 control-label" for="direccion_empleado">Dirección</label>
						<div class="col-sm-10">
							<input class="form-control" type="text" name="direccion_empleado" id="direccion_empleado">
							<br>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 col-sm-2 control-label"></label>
						<div class="col-sm-10">
							<input class="form-control" type="submit" value="Enviar" id="insertarEmpleado">
						</div>
					</div><br><br><br><br><br><br><br><br><br><br><br><br>
				</form> <br>
			</div>
			<div class="modal-footer" style="margin-top: 25px;">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="myEliminar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"
	style="display: none;">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header" id="modal-header-error">
				<button id="cross-close" type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<h4 class="modal-title" id="myModalLabel">Eliminar Empleado</h4>
			</div>
			<div class="modal-body">
				<p></p>
				<form action="" method="post">
					<button class="btn btn-success btn-sm" data-target="#myModal"> No </button>
					<button class="btn btn-success btn-sm eliminarDef" data-target="#myModal" style="background: red;">
						Sí </button>
				</form>
			</div>
			<div class="modal-footer" style="margin-top: 25px;">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
			</div>
		</div>
	</div>
</div>

<script>

	$(document).ready(function () {
		//Añadir
		$("button[name='btnNuevoEmpleado']").on("click", function () {
			$("#myModalLabel").text("Añadir Empleado");
			$("#modal-header-error").css("background", "#67dff0");
			$("#nombre_empleado").attr("placeholder", "");
			$("#apellido1_empleado").attr("placeholder", "");
			$("#apellido2_empleado").attr("placeholder", "");
			$("#direccion_empleado").attr("placeholder", "");
			$("form").attr("action", "<?php echo base_url('Dashboard/agregarEmpleado'); ?>");
			$("#insertarEmpleado").val("Insertar Empleado");
			$("#insertarEmpleado").attr("id", "insertarEmpleado");
		});

		//Editar
		$(".editar").on("click", function () {
			let idEmpleado = this.id
			let res = idEmpleado.split("-")
			let id = res[1]

			$.post("<?php echo base_url(); ?>DashBoard/obtenerEmpleado", { idEmpleado: id })
				.done(function (response) {
					let data = JSON.parse(response);
					if (data) {
						$("#nombre_empleado").val(data.empleado.nombre);
						$("#apellido1_empleado").val(data.empleado.apellido1);
						$("#apellido2_empleado").val(data.empleado.apellido2);
						$("#direccion_empleado").val(data.empleado.direccion);

						$("form").append('<input type="hidden" name="idEmpleadoUpdate" value="' + id + '">');

						// Cambiar el título y el fondo del modal
						$("#myModalLabel").text("Editar Empleado");
						$("#modal-header-error").css("background", "#5cb85b");

						$("form").attr("action", "<?php echo base_url(); ?>DashBoard/actualizarEmpleado");
						$("#insertarEmpleado").attr("id", "actualizarEmpleado");
						$("#insertarEmpleado").val("Actualizar Empleado");

						$("input[name='idEmpleado']").remove();
						$("#myModal").modal("show");

						if (data.status == 'error') {
							if (data.message.includes('Sesión Expirada')) {
								window.location.href = '<?php echo base_url("DashBoard/login") ?>';
							} else {
								$('#myModalLabel').text('Error interno (No se encuentra la id)');
								$('#modal-header-error').css('background', 'red');
							}
						} else if (data.status == 'success') {
							location.reload();
						}
					}
				}).fail(function () {
					alert("Error")
				})
		});

		$(".eliminar-empleado").on("click", function (e) {
			$("#myEliminar").modal("show");

			let idEmpleado = this.id
			let res = idEmpleado.split("-")
			let id = res[1]

			$.post("<?php echo base_url(); ?>DashBoard/obtenerEmpleado", { idEmpleado: id })
				.done(function (response) {
					console.log(id)
					let data = JSON.parse(response);
					if (data.error) {
						$("#myEliminar p").html("Empleado no encontrado");
					} else {
						$("#myEliminar p").html("¿Seguro desea borrar al Empleado " + data.empleado.nombre + " " + data.empleado.apellido1 + " " + data.empleado.apellido2 + "?");
						$(".eliminarDef").on("click", function (e) {
							e.preventDefault();
							$.post("<?php echo base_url(); ?>DashBoard/eliminarEmpleado", { idEmpleado: id })
								.done(function (response) {
									$("#myEliminar").modal("hide");
									$("#rowEmpleado" + id).fadeOut();
								})
						})
					}

				})


		})
	})

	$("button[name='btnNuevoEmpleado']").on("click", function () {
		$("#myModalLabel").text("Añadir Empleado");
		$("#modal-header-error").css("background", "#67dff0");

		// Vaciar los campos
		$("#nombre_empleado").val("");
		$("#apellido1_empleado").val("");
		$("#apellido2_empleado").val("");
		$("#direccion_empleado").val("");

		let botonSubmit = $("#insertarEmpleado, #actualizarEmpleado");
		botonSubmit.attr("id", "insertarEmpleado").val("Insertar Empleado");

		// Restaurar la acción del formulario
		$("form").attr("action", "<?php echo base_url('Dashboard/agregarEmpleado'); ?>");

		// Eliminar cualquier input oculto de edición
		$("input[name='idEmpleado']").remove();
	});


	$(document).on("click", "#insertarEmpleado", function (e) {
		e.preventDefault();
		let formData = $('form').serialize();
		let actionUrl = $("form").attr("action");

		$.post(actionUrl, formData, function (response) {
			let respuesta = JSON.parse(response);

			if (respuesta.status == 'error') {
				if (respuesta.message.includes('Sesión Expirada')) {
					window.location.href = '<?php echo base_url("DashBoard/login") ?>';
				} else {


					$('#myModalLabel').text('Rellene todos los campos');
					$('#modal-header-error').css('background', 'red');
				}
			} else if (respuesta.status == 'success') {
				$('#myModalLabel').text("Añadir Empleado");
				$('#modal-header-error').css('background', '#67dff0');
				$('#myModal').modal('hide');
				location.reload();
			}
		}).fail(function () {
			alert('Hubo un error al enviar los datos.');
		});
	});

</script>

<script>
	$(function () {
		$('#empleados').DataTable({
			columsDefs: [{
				targets: [0],

				orderData: [0, 1]
			}, {
				targets: [1],
				orderData: [1, 0]
			}, {
				targets: [2],
				orderData: [2, 1]
			}]
		});
	});
</script>