// Initializes the plugin with options
// const subcategoryModal = new bootstrap.Modal(document.getElementById('subcategoryModal'));
const notyf = new Notyf({
	position: {
				x: "right",
				y: "top",
			},
	dismissible: true
});

document.addEventListener('DOMContentLoaded', function(){
    $('#subcategoriesTable').DataTable({
		"aProcessing":true,
		"aServerSide":true,
		"ajax":{
			"url": `ajax/get_subcategories`,
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
			{"data":"category"},
			{"data":"brand"},
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

	}).buttons().container().appendTo('#subcategoriesTable_wrapper .col-md-6:eq(0)');

	$('#subcategoryForm').validate({
		rules: {
			subcategoryName: {
				required: true,
				minlength: 3
			},
			selectsubCategoryStatus: {
				required: true
			},
			selectCategoryCategories: {
				required: true
			},
			selectSubcategoryBrand: {
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

	$('#subcategoryForm').on('submit', add_subcategory);
	function add_subcategory(event) {
		event.preventDefault();

		let form    = $('#subcategoryForm'),
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
		url: `ajax/add_subcategory`,
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
			subcategoryModal.hide();
			$('#subcategoriesTable').DataTable().ajax.reload();
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
	get_category_brands();
	// get_subcategory_categories(document.querySelector('#selectSubcategoryBrands').value);
}, false);

function get_category_brands() {
	let wrapper = $('#selectSubcategoryBrands'),
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



function get_subcategory_categories() {
	let wrapper = $('#selectSubcategoryCategories'),
	hook        = 'bee_hook',
	action      = 'get',
	idBrand = $('#selectSubcategoryBrands').val(),
	csrf = Bee.csrf;

	$.ajax({
		url: `ajax/get_subcategory_categories/${idBrand}`,
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
	document.querySelector("#idSubcategory").value = "";
	document.querySelector('#titleModal').innerHTML = "Nueva Subcategoría";
	document.getElementById('modalColor').classList.replace("bg-success", "bg-dark");
	document.querySelector('#btnActionForm').classList.replace("btn-dark", "btn-success");
	document.querySelector('#btnText').innerHTML = "Guardar";
	document.querySelector("#subcategoryForm").reset();
	$(".select2").change();
	subcategoryModal.show();
};

function editSubcategory(idsubcategory) {
	// rowTable = element.parentNode.parentNode.parentNode; 
	$('#titleModal').html("Editar Marca");
	$('#modalColor').removeClass("bg-dark").addClass('bg-success');
	$("#subcategoryForm").trigger('reset');
	$('#btnActionForm').removeClass("btn-success").addClass("btn-dark");
	$('#btnText').html("Actualizar");

	let hook    = 'bee_hook',
	action      = 'get',
	idSubcategory = idsubcategory
	wrapper     = $('#subcategoryModal');

	$.ajax({
		url: `ajax/get_subcategory`,
		type: 'POST',
		dataType: 'json',
		cache: false,
		data: {
		hook, action, idSubcategory
	},
	beforeSend: function() {
		wrapper.waitMe({effect : 'win8'});
	}
	}).done(function(res) {
	if(res.status === 200) {
		$("#idSubcategory").val(res.data.id);
		$("#subcategoryName").val(res.data.name);
		$("#selectSubcategoryBrands").val(res.data.id_brand);
		$("#selectSubcategoryStatus").val(res.data.status);
		$(".select2").change();

		setTimeout(function(){
			$("#selectSubcategoryCategories").val(res.data.id_category);
			$("#selectSubcategoryCategories").change();
		},500);

		subcategoryModal.show();
	} else {
		notyf.error(res.msg);
	}
	}).fail(function(err) {
		notyf.error('Hubo un error en la petición');
	}).always(function() {
		wrapper.waitMe('hide');
	})
}

function deleteSubcategory(idsubcategory) {
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
			idSubcategory = idsubcategory;
			// AJAX
			$.ajax({
				url: `ajax/delete_category`,
				type: 'POST',
				dataType: 'json',
				cache: false,
				data: {
					hook, action , idSubcategory, csrf
				}
			}).done(function(res) {
				if(res.status === 201) {
					notyf.success(res.msg);
					$('#subcategoriesTable').DataTable().ajax.reload();
				} else {
					notyf.error(res.msg);
				}
			}).fail(function(err) {
				notyf.error('Hubo un error en la petición');
			});
		}
	});
}