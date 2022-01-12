// Initializes the plugin with options
const brandModal = new bootstrap.Modal(document.getElementById('brandModal'));
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
    $('#brandsTable').DataTable({
		"aProcessing":true,
		"aServerSide":true,
		"ajax":{
			"url": `ajax/get_brands`,
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
			{"data":"url"},
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

	$('#brandForm').validate({
		rules: {
			brandName: {
				required: true,
				minlength: 3
			},
			selectBrandStatus: {
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

	$('#brandForm').on('submit', add_brand);
	function add_brand(event) {
		event.preventDefault();

		let form    = $('#brandForm'),
		hook        = 'bee_hook',
		action      = 'post',
		data        = new FormData(form.get(0));
		data.append('hook', hook);
		data.append('action', action);

		// Campos Invalidos
		if(document.querySelector('.is-invalid')) {
			notyf.error('Hay campos que son invalidos en el formulario.', '¡Upss!');
			return;
		}


		// AJAX
		$.ajax({
		url: `ajax/add_brand`,
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
			brandModal.hide();
			$('#brandsTable').DataTable().ajax.reload();
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
	document.querySelector("#idBrand").value = "";
	document.querySelector('#titleModal').innerHTML = "Nueva Marca";
	document.getElementById('modalColor').classList.replace("bg-success", "bg-dark");
	document.querySelector('#btnActionForm').classList.replace("btn-dark", "btn-success");
	document.querySelector('#btnText').innerHTML = "Guardar";
	document.querySelector("#brandForm").reset();
	// $(".select2bs4").change();
	brandModal.show();
};

function editBrnad(idbrand) {
	// rowTable = element.parentNode.parentNode.parentNode; 
	$('#titleModal').html("Editar Marca");
	$('#modalColor').removeClass("bg-dark").addClass('bg-success');
	$("#brandForm").trigger('reset');
	$('#btnActionForm').removeClass("btn-success").addClass("btn-dark");
	$('#btnText').html("Actualizar");

	let hook    = 'bee_hook',
	action      = 'get',
	idBrand = idbrand
	wrapper     = $('#brandModal');

	$.ajax({
		url: `ajax/get_brand`,
		type: 'POST',
		dataType: 'json',
		cache: false,
		data: {
		hook, action, idBrand
	},
	beforeSend: function() {
		wrapper.waitMe({effect : 'win8'});
	}
	}).done(function(res) {
	if(res.status === 200) {

		$("#idBrand").val(res.data.id);
		$("#brandName").val(res.data.name);
		choices.setChoiceByValue(res.data.status);

		brandModal.show();
	} else {
		notyf.error(res.msg);
	}
	}).fail(function(err) {
		notyf.error('Hubo un error en la petición');
	}).always(function() {
		wrapper.waitMe('hide');
	})
}

function deleteBrand(idbrand) {
	Swal.fire({
		title: 'Eliminar Marca',
		text: "¿Realmente quieres eliminar esta Marca?",
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
			idBrand = idbrand;
			// AJAX
			$.ajax({
				url: `ajax/delete_brand`,
				type: 'POST',
				dataType: 'json',
				cache: false,
				data: {
					hook, action , idBrand, csrf
				}
			}).done(function(res) {
				if(res.status === 201) {
					notyf.success(res.msg);
					$('#brandsTable').DataTable().ajax.reload();
				} else {
					notyf.error(res.msg);
				}
			}).fail(function(err) {
				notyf.error('Hubo un error en la petición');
			});
		}
	});
}