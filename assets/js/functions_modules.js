// Initializes the plugin with options
const moduleModal = new bootstrap.Modal(document.getElementById('moduleModal'));
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
    $('#modulesTable').DataTable({
		"aProcessing":true,
		"aServerSide":true,
		"ajax":{
			"url": `ajax/get_modules`,
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
				"className": "btn btn-primary btn-sm"
			},{
				"extend": "excelHtml5",
				"text": "<i class='fas fa-file-excel'></i> Excel",
				"titleAttr":"Esportar a Excel",
				"className": "btn btn-success btn-sm"
			},{
				"extend": "pdfHtml5",
				"text": "<i class='fas fa-file-pdf'></i> PDF",
				"titleAttr":"Esportar a PDF",
				"className": "btn btn-danger btn-sm"
			},{
				"extend": "csvHtml5",
				"text": "<i class='fas fa-file-csv'></i> CSV",
				"titleAttr":"Esportar a CSV",
				"className": "btn btn-info btn-sm"
			},{
				"extend": "colvis",
				"text": "<i class='fas fa-columns'></i> Columnas",
				"titleAttr":"Columnas visibles",
				"className": "btn btn-warning btn-sm"
			}
		],
		'dom': 'lBfrtip',
		"language":{
			"url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
		}

	}).buttons().container().appendTo('#tableRoles_wrapper .col-md-6:eq(0)');

	$('#moduleForm').validate({
		rules: {
			moduleName: {
				required: true,
				minlength: 3
			},
			selectModuleStatus: {
				required: true
			}
		},
		messages: {
			moduleName: {
				required: "Nombre del Modulo requerido.",
				minlength: "El Nombre del Modulo debe ser mayor a 3 caracteres."
			},
			selectModuleStatus: {
				required: "Selecciona el estatus del Modulo."
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

	$('#moduleForm').on('submit', add_module);
	function add_module(event) {
		event.preventDefault();

		let form    = $('#moduleForm'),
		hook        = 'bee_hook',
		action      = 'post',
		data        = new FormData(form.get(0)),
		idModule = $("#idModule").val();
		data.append('hook', hook);
		data.append('action', action);

		// Campos Invalidos
		if(document.querySelector('.is-invalid')) {
			notyf.error('Hay campos que son invalidos en el formulario.', '¡Upss!');
			return;
		}


		// AJAX
		$.ajax({
		url: `ajax/add_module`,
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
			form.trigger('reset');
			$('#moduleModal').modal("hide");
			$('#modulesTable').DataTable().ajax.reload();
		} else {
			notyf.error(res.msg, '¡Upss!');
		}
		}).fail(function(err) {
            notyf.error('Hubo un error en la petición', '¡Upss!');
		}).always(function() {
            form.waitMe('hide');
		})
	}
});

function openModal(){

	document.querySelector("#idModule").value = "";
	document.querySelector('#titleModal').innerHTML = "Nuevo Modulo";
	document.getElementById('modalColor').classList.replace("bg-success", "bg-dark");
	document.querySelector('#btnActionForm').classList.replace("btn-dark", "btn-success");
	document.querySelector('#btnText').innerHTML = "Guardar";
	document.querySelector("#moduleForm").reset();
	$(".select2bs4").change();
	$('#moduleModal').modal('show');
};

function editModule(idmodule) {
	// rowTable = element.parentNode.parentNode.parentNode; 
	$('#titleModal').html("Editar Modulo");
	$('#modalColor').removeClass("bg-dark").addClass('bg-success');
	$("#moduleForm").trigger('reset');
	$('#btnActionForm').removeClass("btn-success").addClass("btn-dark");
	$('#btnText').html("Actualizar");

	let hook    = 'bee_hook',
	action      = 'get',
	idModule = idmodule
	wrapper     = $('#moduleModal');

	$.ajax({
		url: `ajax/get_module`,
		type: 'POST',
		dataType: 'json',
		cache: false,
		data: {
		hook, action, idModule
	},
	beforeSend: function() {
		wrapper.waitMe({effect : 'win8'});
	}
	}).done(function(res) {
	if(res.status === 200) {

		$("#idModule").val(res.data.id);
		$("#moduleName").val(res.data.name);
		choices.setChoiceByValue(res.data.status);

		$('#moduleModal').modal('show');
	} else {
		notyf.error(res.msg, '¡Upss!');
	}
	}).fail(function(err) {
		notyf.error('Hubo un error en la petición', '¡Upss!');
	}).always(function() {
		wrapper.waitMe('hide');
	})
}

function deleteModule(idmodule) {
	Swal.fire({
		title: 'Eliminar Modulo',
		text: "¿Realmente quieres eliminar este Modulo?",
		icon: 'warning',
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
			idModule = idmodule;
			// AJAX
			$.ajax({
				url: `ajax/delete_module`,
				type: 'POST',
				dataType: 'json',
				cache: false,
				data: {
					hook, action , idModule, csrf
				}
			}).done(function(res) {
				if(res.status === 201) {
					notyf.success(res.msg);
					$('#modulesTable').DataTable().ajax.reload();
				} else {
					notyf.error("¡Atención!", res.msg , "error");
				}
			}).fail(function(err) {
				notyf.error('Hubo un error en la petición', '¡Upss!');
			});
		}
	});
}