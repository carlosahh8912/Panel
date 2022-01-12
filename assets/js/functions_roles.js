let rolesTable;
// Initializes the plugin with options
const roleModal = new bootstrap.Modal(document.getElementById('roleModal'));
const notyf = new Notyf({
	position: {
				x: "right",
				y: "top",
			},
	dismissible: true
});

let select = document.querySelector('.selectChoices');
const choices = new Choices(select);


document.addEventListener('DOMContentLoaded', function(){
    rolesTable = $('#rolesTable').DataTable({
		"aProcessing":true,
		"aServerSide":true,
		"ajax":{
			"url": `ajax/get_roles`,
			"type": "post",
			"data":{
				"action" : "get",
				"hook" : "bee_hook"
			},
			"dataSrc":"data"
		},
		"columns":[
			{"data":"id"},
			{"data":"name"},
			{"data":"description"},
			{"data":"status"},
			{"data":"options"}
		],
		"responsive": true, 
		"lengthChange": false, 
		"autoWidth": false,
		"bDestroy":true,
		'buttons': [
			{
				"extend": "copyHtml5",
				"text": "<i class='far fa-copy'></i> Copiar",
				"titleAttr":"Copiar",
				"className": "btn btn-sm btn-primary"
			},{
				"extend": "excelHtml5",
				"text": "<i class='fas fa-file-excel'></i> Excel",
				"titleAttr":"Esportar a Excel",
				"className": "btn btn-sm btn-success"
			},{
				"extend": "pdfHtml5",
				"text": "<i class='fas fa-file-pdf'></i> PDF",
				"titleAttr":"Esportar a PDF",
				"className": "btn btn-sm btn-danger"
			},{
				"extend": "csvHtml5",
				"text": "<i class='fas fa-file-csv'></i> CSV",
				"titleAttr":"Esportar a CSV",
				"className": "btn btn-sm btn-info"
			},{
				"extend": "colvis",
				"text": "<i class='fas fa-columns'></i> Columnas",
				"titleAttr":"Columnas visibles",
				"className": "btn btn-sm btn-warning"
			}
		],
		'dom': 'lBfrtip',
		"language":{
			"url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
		}

	}).buttons().container().appendTo('#rolesTable_wrapper .col-md-6:eq(0)');

	$('#roleForm').validate({
		rules: {
			roleName: {
				required: true,
				minlength: 3
			},
			roleDescription: {
				required: true,
				minlength: 5
			},
			selectRoleStatus: {
				required: true
			}
		},
		errorElement: 'span',
		errorPlacement: function (error, element) {
			error.addClass('invalid-feedback');
			element.closest('.form-group').append(error);
		},
		highlight: function (element, errorClass, validClass) {
			$(element).addClass('is-invalid');
		},
		unhighlight: function (element, errorClass, validClass) {
			$(element).removeClass('is-invalid');
		}
	});

	$('#roleForm').on('submit', addRol);
	function addRol(event) {
		event.preventDefault();

		let form    = $('#roleForm'),
		hook        = 'bee_hook',
		action      = 'post',
		data        = new FormData(form.get(0)),
		intRol = $("#idRole").value;
		data.append('hook', hook);
		data.append('action', action);

		// Campos Invalidos
		if(document.querySelector('.is-invalid')) {
			notyf.error('Hay campos que son invalidos en el formulario.');
			return;
		}

		// AJAX
		$.ajax({
		url: `ajax/add_role`,
		type: 'post',
		dataType: 'json',
		contentType: false,
		processData: false,
		cache: false,
		data : data,
		beforeSend: function() {
			form.waitMe({effect : 'win8'});
		}
		}).done(function(res) {
		if(res.status === 201) {
			notyf.success(res.msg);
			form.trigger('reset');
			roleModal.hide();
			$('#rolesTable').DataTable().ajax.reload();
		} else {
			notyf.error(res.msg);
		}
		}).fail(function(err) {
		notyf.error('Hubo un error en la petición');
		}).always(function() {
		form.waitMe('hide');
		})
	}
});

function openModal(){

	document.querySelector("#idRole").value = "";
	document.querySelector('#titleModal').innerHTML = "Nuevo Rol";
	document.getElementById('modalColor').classList.replace("bg-success", "bg-dark");
	document.querySelector('#btnActionForm').classList.replace("btn-dark", "btn-success");
	document.querySelector('#btnText').innerHTML = "Guardar";
	document.querySelector("#roleForm").reset();
	// $(".select2bs4").change();
	choices;
	roleModal.show();
};

function editRole(idrole) {
	$('#titleModal').html("Editar Rol");
	$('#modalColor').removeClass("bg-dark").addClass('bg-success');
	$("#roleForm").trigger('reset');
	$('#btnActionForm').removeClass("btn-success").addClass("btn-dark");
	$('#btnText').html("Actualizar");

	let hook    = 'bee_hook',
	action      = 'get',
	idRole = idrole,
	wrapper     = $('roleForm');

	$.ajax({
		url: `ajax/get_role`,
		type: 'POST',
		dataType: 'json',
		cache: false,
		data: {
		hook, action, idRole
	},
	beforeSend: function() {
		wrapper.waitMe({effect : 'win8'});
	}
	}).done(function(res) {
	if(res.status === 200) {

		$("#idRole").val(res.data.id);
		$("#roleName").val(res.data.name);
		$("#roleDescription").val(res.data.description);
		// $("#selectRoleStatus").val(res.data.status);
		choices.setChoiceByValue(res.data.status);
		// $(".select2bs4").change();
		roleModal.show();
	} else {
		notyf.error(res.msg);
	}
	}).fail(function(err) {
		notyf.error('Hubo un error en la petición');
	}).always(function() {
		wrapper.waitMe('hide');
	})
}

function deleteRole(idrole) {
	Swal.fire({
		title: 'Eliminar Rol',
		text: "¿Realmente quieres eliminar este Rol?",
		icon: 'question',
		showCancelButton: true,
		confirmButtonColor: '#3085d6',
		cancelButtonColor: '#d33',
		confirmButtonText: 'Si, Eliminar',
		cancelButtonText: 'No, Cancelar'
	}).then((result) => {
		
		if (result.isConfirmed) {
			let hook        = 'bee_hook',
			action      = 'delete',
			csrf = Bee.csrf,
			idRole = idrole;
			// AJAX
			$.ajax({
				url: `ajax/delete_role`,
				type: 'POST',
				dataType: 'json',
				cache: false,
				data: {
					hook, action , idRole, csrf
				}
			}).done(function(res) {
				if(res.status === 201) {
					notyf.success(res.msg, '¡Bien!');
					$('#rolesTable').DataTable().ajax.reload();
				} else {
					notyf.error(res.msg, '¡Upsss!');
				}
			}).fail(function(err) {
				notyf.error('Hubo un error en la petición', '¡Upss!');
			});
		}
	});
}

function permissionsRole(idrole){

	let hook    = 'bee_hook',
	action      = 'get',
	csrf = Bee.csrf,
	idRole = idrole,
	wrapper     = $('#permissionTable');

	$.ajax({
		url: `ajax/get_permissions_role`,
		type: 'POST',
		dataType: 'json',
		cache: false,
		data: {
		hook, action, idRole, csrf
	},
	beforeSend: function() {
		wrapper.waitMe({effect : 'win8'});
	}
	}).done(function(res) {
	if(res.status === 200) {

		wrapper.html(res.data);
		$('#modalPermisos').modal('show');
		// document.querySelector('#formPermisos').addEventListener('submit',addPermissions,false);
	} else {
		notyf.error(res.msg, '¡Upss!');
	}
	}).fail(function(err) {
		notyf.error('Hubo un error en la petición', '¡Upss!');
	}).always(function() {
		wrapper.waitMe('hide');
	})
};

$('#formPermisos').on('submit', addPermissions);
function addPermissions(event) {
	event.preventDefault();

	let form    = $('#formPermisos'),
	hook        = 'bee_hook',
	action      = 'post',
	data        = new FormData(form.get(0));
	data.append('hook', hook);
	data.append('action', action);

	// AJAX
	$.ajax({
	url: `ajax/add_permissions`,
	type: 'post',
	dataType: 'json',
	contentType: false,
	processData: false,
	cache: false,
	data : data,
	beforeSend: function() {
		form.waitMe({effect : 'win8'});
	}
	}).done(function(res) {
	if(res.status === 201) {
		notyf.success(res.msg, '¡Bien!');
		// form.trigger('reset');
		$('#modalPermisos').modal("hide");
	} else {
		notyf.error(res.msg, '¡Upss!');
	}
	}).fail(function(err) {
		notyf.error('Hubo un error en la petición', '¡Upss!');
	}).always(function() {
		form.waitMe('hide');
	})
};
