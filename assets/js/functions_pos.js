const notyf = new Notyf({
	position: {
				x: "right",
				y: "top",
			},
	dismissible: true
});

const formatterPeso = new Intl.NumberFormat('en-US', {
	style: 'currency',
	currency: 'MXN',
	minimumFractionDigits: 2
});

let select = document.querySelector('.selectChoices');

document.addEventListener('DOMContentLoaded', function(){
    
	$('#posForm').validate({
		rules: {
			selectUser: {
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

	$('#posForm').on('submit', add_new_sale);
	function add_new_sale(event) {
		event.preventDefault();

		Swal.fire({
			title: 'Guardar pedido',
			text: "¿Todos los datos son correctos?",
			icon: 'question',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Si, Guardar',
			cancelButtonText: 'No, Cancelar'
		}).then((result) => {
			
			if (result.isConfirmed) {

				let form    = $('#posForm'),
				hook        = 'bee_hook',
				action      = 'post',
				data        = new FormData(form.get(0));
				data.append('hook', hook);
				data.append('action', action);

				// Campos Invalidos
				if(document.querySelector('.is-invalid')) {
					notyf.error('Hay campos que son invalidos en el formulario.');
					return;
				}


				// AJAX
				$.ajax({
				url: `ajax/add_sale`,
				type: 'post',
				dataType: 'json',
				contentType: false,
				processData: false,
				cache: false,
				data : data,
				beforeSend: function() {
					$('body').waitMe({effect : 'win8'});
				}
				}).done(function(res) {
				if(res.status === 201) {
					notyf.success(res.msg);
					form.trigger('reset');
					get_products_in_detail();
					get_pos_totals();
					$('#pos_discount').html('');
					$('#pos_discount_label').html('Descuento:');

					window.open(`${Bee.url}orders/pdf/${res.data}`, '_blank');
				} else {
					notyf.error(res.msg);
				}
				}).fail(function(err) {
					notyf.error('Hubo un error en la petición');
				}).always(function() {
					$('body').waitMe('hide');
				})
			}
		});
	}

	$('#massimport_form').validate({
		rules: {
			inputQty: {
				required: true
			},
			inputSku: {
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

	$('#massimport_form').on('submit', add_massimport);
	function add_massimport(event) {
		event.preventDefault();

		let form    = $('#massimport_form'),
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
		url: `ajax/massimport`,
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
			$('#massimport_result').html(res.data);
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
	get_users_pos();
	get_products_in_detail();
	get_pos_totals();
}, false);


$('#newCustomer').on('change', ()=>{
	
	if ($('#selectUser').attr('disabled', '')) {
		$('#selectUser').removeAttr('disabled');
		// $('.selectCustomer').addClass('d-none');
	}else{
		$('#selectUser').attr('disabled', '');
		// $('.selectCustomer').removeClass('d-none');
	}

	if ($('#customerSaePos').attr('readonly')) {
		$('#customerSaePos').removeAttr('readonly')
		$('#customerSaePos').attr('placeholder', 'N° SAE')
	}else{
		$('#customerSaePos').attr('readonly', '')
		$('#customerSaePos').removeAttr('placeholder')
	}
	
	if ($('#customerEmailPos').attr('readonly')) {
		$('#customerEmailPos').removeAttr('readonly')
		$('#customerEmailPos').attr('placeholder', 'Ingresa un correo')
	}else{
		$('#customerEmailPos').attr('readonly', '')
		$('#customerEmailPos').removeAttr('placeholder')
	}
})

function get_users_pos() {
	let wrapper = $('#selectUser'),
	hook        = 'bee_hook',
	action      = 'get'
	csrf = Bee.csrf;

	$.ajax({
		url: 'ajax/get_users_pos',
		type: 'POST',
		dataType: 'json',
		cache: false,
		data: {
		hook, action, csrf
	}
	}).done(function(res) {
		if(res.status === 200) {
			wrapper.html(res.data);
			const choices = new Choices(select);
		} else {
			notyf.error(res.msg);
			wrapper.html('');
		}
	}).fail(function(err) {
		notyf.error('Hubo un error en la petición');
		wrapper.html('');
	})
}


$('#selectUser').on('change', get_customer_data);
function get_customer_data() {

	let hook    = 'bee_hook',
	action      = 'get',
	idCustomer = $('#selectUser').val(),
	wrapper     = $('#posForm');

	$.ajax({
		url: `ajax/get_customer`,
		type: 'POST',
		dataType: 'json',
		cache: false,
		data: {
		hook, action, idCustomer
	},
	beforeSend: function() {
		wrapper.waitMe({effect : 'win8'});
	}
	}).done(function(res) {
	if(res.status === 201) {
		$("#customerSaePos").val(res.data.customer.sae);
		$("#customerNamePos").val(`${res.data.customer.name} ${res.data.customer.lastname}`);
		$("#customerEmailPos").val(res.data.customer.email);
		$("#customerRsPos").val(res.data.customer_sae.NOMBRE);
		$("#customerRfcPos").val(res.data.customer_sae.RFC);

	} else {
		notyf.error(res.msg);
	}
	}).fail(function(err) {
		notyf.error('Hubo un error en la petición');
	}).always(function() {
		wrapper.waitMe('hide');
	})
}

$('#productSearchPos').on('change', get_products);
function get_products() {

	let hook    = 'bee_hook',
	action      = 'get',
	csrf = Bee.csrf,
	productData = $('#productSearchPos').val(),
	wrapper     = $('#product-content');

	$.ajax({
		url: `ajax/get_products_pos`,
		type: 'POST',
		dataType: 'json',
		cache: false,
		data: {
		hook, action, productData, csrf
	},
	beforeSend: function() {
		wrapper.waitMe({effect : 'win8'});
	}
	}).done(function(res) {
	if(res.status === 200) {
		wrapper.html(res.data);
		$('#productSearchPos').val('');
	} else {
		notyf.error(res.msg);
		wrapper.html('');
	}
	}).fail(function(err) {
		notyf.error('Hubo un error en la petición');
	}).always(function() {
		wrapper.waitMe('hide');
	})
}

function get_pos_totals() {

	let hook    = 'bee_hook',
	action      = 'get',
	csrf = Bee.csrf,
	wrapper     = $('#pos_detail_totals');

	$.ajax({
		url: `ajax/get_totals_in_pos_detail`,
		type: 'POST',
		dataType: 'json',
		cache: false,
		data: {
		hook, action, csrf
	},
	beforeSend: function() {
		wrapper.waitMe({effect : 'win8'});
	}
	}).done(function(res) {
	if(res.status === 200) {

		let discount = 0,
		subtotal = 0,
		discount_type = $('#posDiscountType').val(),
		discount_amount = $('#posDiscountAmount').val();

		if (res.data != '') {
			subtotal = res.data[0].subtotal;
		}

		if (discount_amount !== '') {
			discount = discount_amount;

			if (discount_type == 'percent') {
				discount = discount_amount * subtotal; 
				$('#pos_discount').html('- '+formatterPeso.format(discount));
			}
			
		}

		$("#pos_subtotal").html(formatterPeso.format(subtotal));
		$("#pos_tax").html(formatterPeso.format(((subtotal - discount) * 0.16)));
		$("#pos_total").html(formatterPeso.format(((subtotal - discount) * 1.16)));

	} else {
		notyf.error(res.msg);
	}
	}).fail(function(err) {
		notyf.error('Hubo un error en la petición');
	}).always(function() {
		wrapper.waitMe('hide');
	})
}


$('.btn_apply_discount').on('click', apply_discount);
function apply_discount(){
	let type = $('.discount_type').val(),
		amount = $('.discount_amount').val(),
		discount_field = $('#pos_discount'),
		discount_label = $('#pos_discount_label'),
		discount_type_form = $('#posDiscountType'),
		discount_amount_form = $('#posDiscountAmount');

	if(type == '' || amount == ''){
		notyf.error('No puede haber campos vacios');
		return;
	}

	if (type == 'percent') {
		if (amount > 15){
			notyf.error('El descuento no puede ser mayor al 15%');
			return;
		}

		discount_label.html(`Desc (${amount}%):`);
		discount_type_form.val(type);
		discount_amount_form.val(amount / 100);

	}else if (type == 'amount'){
		if (amount > 3000){
			notyf.error('El descuento no puede ser mayor a $3,000');
			return;
		}

		discount_label.html(`Descuento:`);
		discount_field.html('- '+formatterPeso.format(amount));
		discount_type_form.val(type);
		discount_amount_form.val(amount);
	}else{
		notyf.error('Hubo un error en la petición');
	}

	get_pos_totals();

}


function get_products_in_detail() {

	let hook    = 'bee_hook',
	action      = 'get',
	csrf = Bee.csrf,
	wrapper     = $('#pos_detail');

	$.ajax({
		url: `ajax/get_products_in_pos_detail`,
		type: 'POST',
		dataType: 'json',
		cache: false,
		data: {
		hook, action, csrf
	},
	beforeSend: function() {
		wrapper.waitMe({effect : 'win8'});
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
	}).always(function() {
		wrapper.waitMe('hide');
	})
}

// $('.btn_add_product').on('click',  add_product_pos_detail);
function add_product_pos_detail(idProduct) {
		
	let hook   	= 'bee_hook',
	action      = 'post',
	csrf = Bee.csrf,
	wrapper = $('#btn_'+idProduct),
	quantity = $('#qty'+idProduct).val();

	if(quantity <= 0){
		notyf.error('Ingresa una cantidad valida.');
		return;
	}

	// AJAX
	$.ajax({
		url: `ajax/add_product_to_pos_detail`,
		type: 'POST',
		dataType: 'json',
		cache: false,
		data: {
		hook, action, csrf, idProduct, quantity
	},
	beforeSend: function() {
		wrapper.waitMe({effect : 'win8'});
	}
	}).done(function(res) {
		if(res.status === 201) {
			notyf.success(res.msg);
			$('#qty'+idProduct).val('');
			get_products_in_detail();
			get_pos_totals();
		} else {
			notyf.error(res.msg);
		}
	}).fail(function(err) {
		notyf.error('Hubo un error en la petición');
	}).always(function() {
		wrapper.waitMe('hide');
	});
}

function delete_product_detail(idproduct) {
	Swal.fire({
		title: 'Eliminar Producto',
		text: "¿Realmente quieres quitar este producto del pedido?",
		icon: 'warning',
		showCancelButton: true,
		confirmButtonColor: '#3085d6',
		cancelButtonColor: '#d33',
		confirmButtonText: 'Si, Quitar',
		cancelButtonText: 'No, Cancelar'
	}).then((result) => {
		
		if (result.isConfirmed) {
			let hook        = 'bee_hook',
			action      = 'delete',
			csrf = Bee.csrf,
			idProduct = idproduct;
			// AJAX
			$.ajax({
				url: `ajax/delete_product_detail_pos`,
				type: 'POST',
				dataType: 'json',
				cache: false,
				data: {
					hook, action , idProduct, csrf
				}
			}).done(function(res) {
				if(res.status === 201) {
					notyf.success(res.msg);
					get_products_in_detail();
					get_pos_totals();
				} else {
					notyf.error(res.msg);
				}
			}).fail(function(err) {
				notyf.error('Hubo un error en la petición');
			});
		}
	});
}


$('.delete_all_products').on('click', delete_all_products_detail);
function delete_all_products_detail() {
	Swal.fire({
		title: 'Eliminar Pedido',
		text: "¿Realmente quieres vaciar el pedido?",
		icon: 'warning',
		showCancelButton: true,
		confirmButtonColor: '#3085d6',
		cancelButtonColor: '#d33',
		confirmButtonText: 'Si, Quitar todo',
		cancelButtonText: 'No, Cancelar'
	}).then((result) => {
		
		if (result.isConfirmed) {
			let hook        = 'bee_hook',
			action      = 'delete',
			csrf = Bee.csrf;
			// AJAX
			$.ajax({
				url: `ajax/delete_all_products_detail_pos`,
				type: 'POST',
				dataType: 'json',
				cache: false,
				data: {
					hook, action, csrf
				}
			}).done(function(res) {
				if(res.status === 201) {
					notyf.success(res.msg);
					get_products_in_detail();
					get_pos_totals();
				} else {
					notyf.error(res.msg);
				}
			}).fail(function(err) {
				notyf.error('Hubo un error en la petición');
			});
		}
	});
}