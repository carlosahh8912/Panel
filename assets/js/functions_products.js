// Initializes the plugin with options
const productModal = new bootstrap.Modal(document.getElementById('productModal'));
const notyf = new Notyf({
	position: {
				x: "right",
				y: "top",
			},
	dismissible: true
});

const el = document.querySelector('.tagin');
tagin(el);


document.addEventListener('DOMContentLoaded', function(){
    $('#productsTable').DataTable({
		"aProcessing":true,
		"aServerSide":true,
		"ajax":{
			"url": `ajax/get_products`,
			"type": "post",
			"data":{
				"action" : "get",
				"hook" : "bee_hook"
			},
			"dataSrc":"data"
		},
		"columns":[
			{"data":"id"},
			{"data":"title"},
			{"data":"ean"},
			{"data":"standard_price"},
			{"data":"stock"},
			{"data":"newness"},
			{"data":"top_seller"},
			{"data":"offer"},
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

	}).buttons().container().appendTo('#productsTable_wrapper .col-md-6:eq(0)');

	$('#productForm').validate({
		rules: {
			productSku: {
				required: true,
				minlength: 3
			},
			productEan: {
				required: true,
				number: true,
				minlength: 12,
				maxlength: 13
			},
			productTitle: {
				required: true,
				minlength: 10
			},
			productStock: {
				required: true,
				number: true
			},
			productPrice: {
				required: true,
				number: true
			},
			selectProductBrand: {
				required: true
			},
			selectPeroductSubcategory: {
				required: true
			},
			selectProductCategory: {
				required: true
			},
			selectProductImg: {
				required: true
			},
			selectPeroductStatus: {
				required: true
			},
			productHeight: {
				required: true,
				number: true
			},
			productWidth: {
				required: true,
				number: true
			},
			productLength: {
				required: true,
				number: true
			},
			selectProductDimensionsUnit: {
				required: true
			},
			selectProductWeight: {
				required: true,
				number: true
			},
			selectProductWeightUnit: {
				required: true
			},
			productDescription: {
				required: true,
				minlength: 15
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

	$('#productForm').on('submit', add_product);
	function add_product(event) {
		event.preventDefault();

		let form    = $('#productForm'),
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
		url: `ajax/add_product`,
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
			productModal.hide();
			$('#productsTable').DataTable().ajax.reload();
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
	get_product_brands();
}, false);

function get_product_brands() {
	let wrapper = $('#selectProductBrand'),
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



function get_product_category() {
	let wrapper = $('#selectProductCategory'),
	hook        = 'bee_hook',
	action      = 'get',
	idBrand = $('#selectProductBrand').val(),
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

function get_product_subcategory() {
	let wrapper = $('#selectPeroductSubcategory'),
	hook        = 'bee_hook',
	action      = 'get',
	idCategory = $('#selectProductCategory').val(),
	csrf = Bee.csrf;

	$.ajax({
		url: `ajax/get_product_subcategory/${idCategory}`,
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

function load_subcategory(){
	get_product_category();
	setTimeout(function(){
		get_product_subcategory();
	},200);
}

function openModal(){
	document.querySelector("#idProduct").value = "";
	document.querySelector('#titleModal').innerHTML = "Nuevo Producto";
	document.querySelector('.modal-header').classList.replace("bg-success", "bg-dark");
	document.querySelector('#btnActionForm').classList.replace("btn-dark", "btn-success");
	document.querySelector('#btnText').innerHTML = "Guardar";
	document.querySelector("#productForm").reset();
	$("#productNewness").removeAttr('checked');
	$("#productBestSeller").removeAttr('checked');
	$("#productOffer").removeAttr('checked');
	$(".select2").change();
	$('.summernote').summernote('code','');
	$('.tagin-wrapper span').remove();
	productModal.show();
};

function viewProduct(idproduct){
	console.log(idproduct);
}

function editProduct(idproduct) {
	$('#titleModal').html("Editar Producto");
	$('.modal-header').removeClass("bg-dark").addClass('bg-success');
	$("#productForm").trigger('reset');
	$('#btnActionForm').removeClass("btn-success").addClass("btn-dark");
	$('#btnText').html("Actualizar");
	$("#productNewness").removeAttr('checked');
	$("#productBestSeller").removeAttr('checked');
	$("#productOffer").removeAttr('checked');
	$('.tagin-wrapper span').remove();

	let hook    = 'bee_hook',
	action      = 'get',
	idProduct = idproduct
	wrapper     = $('#productModal');

	$.ajax({
		url: `ajax/get_product`,
		type: 'POST',
		dataType: 'json',
		cache: false,
		data: {
		hook, action, idProduct
	},
	beforeSend: function() {
		wrapper.waitMe({effect : 'win8'});
	}
	}).done(function(res) {
	if(res.status === 200) {
		$("#idProduct").val(res.data.id);
		$("#productSku").val(res.data.id);
		$("#productEan").val(res.data.ean);
		$("#productTitle").val(res.data.title);
		$("#productDescription").summernote("code", res.data.description);
		$("#productStock").val(res.data.stock);
		$("#productPrice").val(res.data.standard_price);
		$("#productOfferPrice").val(res.data.extended_price);
		$("#productKeywords").val(res.data.keywords);
		$("#selectProductBrand").val(res.data.id_brand);
		$("#selectProductImg").val(res.data.images);
		$("#selectPeroductStatus").val(res.data.status);
		$("#productHeight").val(res.data.height);
		$("#productWidth").val(res.data.width);
		$("#productLength").val(res.data.length);
		$("#selectProductDimensionsUnit").val(res.data.dimensions_unit);
		$("#selectProductWeight").val(res.data.weight);
		$("#selectProductWeightUnit").val(res.data.weight_unit);
		$(".select2").change();
		setTimeout(function(){
			$("#selectProductCategory").val(res.data.id_category);
			$("#selectProductCategory").change();
		},300);
		setTimeout(function(){
			$("#selectPeroductSubcategory").val(res.data.id_subcategory);
			$("#selectPeroductSubcategory").change();
		},400);

		if (res.data.newness == 'on') {
			$("#productNewness").attr('checked','');
		}

		if (res.data.top_seller == 'on') {
			$("#productBestSeller").attr('checked','');
		}

		if (res.data.offer == 'on') {
			$("#productOffer").attr('checked','');
		}

		let keywords = res.data.keywords.split(',');
		let tags = '';
		for (let index = 0; index < keywords.length; index++) {
			tags += `<span class="tagin-tag">${keywords[index]}<span class="tagin-tag-remove"></span></span>`;
		}

		$('.tagin-wrapper input').before(tags);

		productModal.show();
	} else {
		notyf.error(res.msg);
	}
	}).fail(function(err) {
		notyf.error('Hubo un error en la petición');
	}).always(function() {
		wrapper.waitMe('hide');
	})
}

function deleteProduct(idproduct) {
	Swal.fire({
		title: 'Eliminar Producto',
		text: "¿Realmente quieres eliminar este Producto?",
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
			idProduct = idproduct;
			// AJAX
			$.ajax({
				url: `ajax/delete_product`,
				type: 'POST',
				dataType: 'json',
				cache: false,
				data: {
					hook, action , idProduct, csrf
				}
			}).done(function(res) {
				if(res.status === 201) {
					notyf.success(res.msg);
					$('#productsTable').DataTable().ajax.reload();
				} else {
					notyf.error(res.msg);
				}
			}).fail(function(err) {
				notyf.error('Hubo un error en la petición');
			});
		}
	});
}

function viewProduct(idproduct){

	let hook    = 'bee_hook',
	action      = 'get',
	idProduct = idproduct,
	wrapper     = $('#viewUserModal');

	$.ajax({
		url: `ajax/get_product`,
		type: 'POST',
		dataType: 'json',
		cache: false,
		data: {
		hook, action, idProduct
	},
	beforeSend: function() {
		wrapper.waitMe();
	}
	}).done(function(res) {
		if(res.status === 200) {
			let productStatus = res.data.status == 'active' ? 
			'<span class="badge badge-lg bg-success">Activo</span>' : 
			'<span class="badge badge-lg bg-danger">Inactivo</span>';

			$("#celSku").html(res.data.id);
			$("#celTitle").html(res.data.title);
			$("#celStock").html(res.data.stock);
			$("#celEan").html(res.data.ean);
			$("#celDescription").html(res.data.description);
			$("#celPrice").html(res.data.standard_price);
			$("#celPriceOffer").html(res.data.extended_price);
			$("#celBrand").html(res.data.brand); 
			$("#celCategory").html(res.data.category);  
			$("#celSubcategory").html(res.data.subcategory); 
			$("#celKeywords").html(res.data.keywords); 
			$("#celWidth").html(res.data.width); 
			$("#celHeight").html(res.data.height); 
			$("#celLength").html(res.data.length); 
			$("#celDimensionsUnit").html(res.data.dimensions_unit); 
			$("#celWeight").html(res.data.weight); 
			$("#celWeightUnit").html(res.data.weight_unit); 
			$("#celSales").html(res.data.Sales); 
			$("#celNewness").html(res.data.newness); 
			$("#celTopSeller").html(res.data.top_seller); 
			$("#celOffer").html(res.data.offer); 
			$("#celStatus").html(productStatus);
			$("#celImages").html(res.data.images);
			$("#celDate").html(res.data.updated_at);
			$("#celSales").html(res.data.sales);
			
			$('#viewProductModal').modal('show');
		} else {
			notyf.error(res.msg, '¡Upss!');
			// wrapper.html('');
		}
	}).fail(function(err) {
		notyf.error('Hubo un error en la petición', '¡Upss!');
	}).always(function() {
		wrapper.waitMe('hide');
	})
}

$('input#productEan')
	.keypress(function (event) {
	// El código del carácter 0 es 48
	// El código del carácter 9 es 57
	if (event.which < 48 || event.which > 57 || this.value.length === 13) {
		return false;
	}
});