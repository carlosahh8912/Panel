// Initializes the plugin with options
const categoryModal = new bootstrap.Modal(document.getElementById('categoryModal'));
const notyf = new Notyf({
	position: {
				x: "right",
				y: "top",
			},
	dismissible: true
});

document.addEventListener('DOMContentLoaded', function(){
    $('#categoriesTable').DataTable({
		"aProcessing":true,
		"aServerSide":true,
		"ajax":{
			"url": `ajax/get_categories`,
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
			{"data":"brandname"},
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

	}).buttons().container().appendTo('#categoriesTable_wrapper .col-md-6:eq(0)');

	$('#categoryForm').validate({
		rules: {
			categoryName: {
				required: true,
				minlength: 3
			},
			selectCategoryStatus: {
				required: true
			},
			selectCategoryBrand: {
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

	$('#categoryForm').on('submit', add_category);
	function add_category(event) {
		event.preventDefault();

		let form    = $('#categoryForm'),
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
		url: `ajax/add_category`,
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
			categoryModal.hide();
			$('#categoriesTable').DataTable().ajax.reload();
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

window.addEventListener('load', function(){
	get_category_brand();
}, false);

function get_category_brand() {
	let wrapper = $('#selectCategoryBrand'),
	hook        = 'bee_hook',
	action      = 'get'
	csrf = Bee.csrf;

	$.ajax({
		url: 'ajax/get_category_brand',
		type: 'POST',
		dataType: 'json',
		cache: false,
		data: {
		hook, action, csrf
	}
	}).done(function(res) {
		if(res.status === 200) {
			wrapper.html(res.data);
		} else {
			notyf.error(res.msg);
			wrapper.html('');
		}
	}).fail(function(err) {
		notyf.error('Hubo un error en la petición');
		wrapper.html('');
	})
}

function openModal(){
	document.querySelector("#idCategory").value = "";
	document.querySelector('#titleModal').innerHTML = "Nueva Categoría";
	document.getElementById('modalColor').classList.replace("bg-success", "bg-dark");
	document.querySelector('#btnActionForm').classList.replace("btn-dark", "btn-success");
	document.querySelector('#btnText').innerHTML = "Guardar";
	document.querySelector("#categoryForm").reset();
	$(".select2").change();
	categoryModal.show();
};

function editCategory(idcategory) {
	// rowTable = element.parentNode.parentNode.parentNode; 
	$('#titleModal').html("Editar Marca");
	$('#modalColor').removeClass("bg-dark").addClass('bg-success');
	$("#categoryForm").trigger('reset');
	$('#btnActionForm').removeClass("btn-success").addClass("btn-dark");
	$('#btnText').html("Actualizar");

	let hook    = 'bee_hook',
	action      = 'get',
	idCategory = idcategory
	wrapper     = $('#categoryModal');

	$.ajax({
		url: `ajax/get_category`,
		type: 'POST',
		dataType: 'json',
		cache: false,
		data: {
		hook, action, idCategory
	},
	beforeSend: function() {
		wrapper.waitMe({effect : 'win8'});
	}
	}).done(function(res) {
	if(res.status === 200) {

		$("#idCategory").val(res.data.id);
		$("#categoryName").val(res.data.name);
		$("#selectCategoryBrand").val(res.data.id_brand);
		$("#selectCategoryStatus").val(res.data.status);
		$(".select2").change();
		categoryModal.show();
	} else {
		notyf.error(res.msg);
	}
	}).fail(function(err) {
		notyf.error('Hubo un error en la petición');
	}).always(function() {
		wrapper.waitMe('hide');
	})
}

function deleteCategory(idcategory) {
	Swal.fire({
		title: 'Eliminar Marca',
		text: "¿Realmente quieres eliminar esta Categoría?",
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
			idCategory = idcategory;
			// AJAX
			$.ajax({
				url: `ajax/delete_category`,
				type: 'POST',
				dataType: 'json',
				cache: false,
				data: {
					hook, action , idCategory, csrf
				}
			}).done(function(res) {
				if(res.status === 201) {
					notyf.success(res.msg);
					$('#categoriesTable').DataTable().ajax.reload();
				} else {
					notyf.error(res.msg);
				}
			}).fail(function(err) {
				notyf.error('Hubo un error en la petición');
			});
		}
	});
}