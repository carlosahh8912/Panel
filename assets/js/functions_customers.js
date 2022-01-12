let customersTable;
// Initializes the plugin with options
const customerModal = new bootstrap.Modal(document.getElementById('customerModal'));
const notyf = new Notyf({
	position: {
				x: "right",
				y: "top",
			},
	dismissible: true
});

const formatterPeso = new Intl.NumberFormat('es-MX', {
	style: 'currency',
	currency: 'MXN',
	minimumFractionDigits: 0
});

document.addEventListener('DOMContentLoaded', function(){
    customersTable = $('#customersTable').DataTable({
		"aProcessing":true,
		"aServerSide":true,
		"ajax":{
			"url": `ajax/get_customers`,
			"type": "post",
			"data":{
				"action" : "get",
				"hook" : "bee_hook"
			},
			"dataSrc":"data"
		},
		"columns":[
			{"data":"sae"},
			{data:"name",
			render: function ( data, type, row ) {
                return row.name+' '+row.lastname;
            }},
			{"data":"email"},
			{"data":"b2b"},
			{"data":"dropshipping"},
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

	$('#customerForm').validate({
		rules: {
			customerName: {
				required: true,
				minlength: 3
			},
			customerLastname: {
				required: true,
				minlength: 3
			},
			customerPassword: {
				// required: true,
				// minlength: 4
			},
			customerEmail: {
				required: true,
				email: true
			},
			customerSAE: {
				required: true,
				number: true
			},
			selectCustomerStatus: {
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

	$('#customerForm').on('submit', add_customer);
	function add_customer(event) {
		event.preventDefault();

		let form    = $('#customerForm'),
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
		url: `ajax/add_customer`,
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
			customerModal.hide();
			$('#customersTable').DataTable().ajax.reload();
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
	document.querySelector("#idCustomer").value = "";
	document.querySelector('#titleModal').innerHTML = "Nuevo Cliente";
	document.querySelector('.modal-header').classList.replace("bg-success", "bg-dark");
	document.querySelector('#btnActionForm').classList.replace("btn-dark", "btn-success");
	document.querySelector('#btnText').innerHTML = "Guardar";
	document.querySelector("#customerForm").reset();
	$("#customerB2b").removeAttr('checked');
	$("#customerDs").removeAttr('checked');
	$("#customerShipping").removeAttr('checked');
	$(".select2").change();
	customerModal.show();
};


function viewCustomer(idcustomer){

	let hook    = 'bee_hook',
	action      = 'get',
	idCustomer = idcustomer,
	wrapper     = $('#viewCustomerModal');

	$.ajax({
		url: `ajax/get_customer`,
		type: 'POST',
		dataType: 'json',
		cache: false,
		data: {
		hook, action, idCustomer
	},
	beforeSend: function() {
		wrapper.waitMe();
	}
	}).done(function(res) {
		if(res.status === 201) {
			let userStatus = res.data.customer.status == 'active' ? 
			'<span class="badge badge-lg bg-success">Activo</span>' : 
			'<span class="badge badge-lg bg-danger">Inactivo</span>';

			$("#celSae").html(res.data.customer.sae);
			$("#celName").html(`${res.data.customer.name} ${res.data.customer.lastname}`);
			$("#celEmail").html(res.data.customer.email);
			$("#celRole").html(res.data.customer.rolename);
			$("#celStatus").html(userStatus);
			$("#celB2b").html(res.data.customer.b2b);
			$("#celRfc").html(res.data.customer_sae.RFC);
			$("#celRs").html(res.data.customer_sae.NOMBRE);
			$("#celSaldo").html(formatterPeso.format(res.data.customer_sae.SALDO));
			$("#celDropshipping").html(res.data.customer.dropshipping);
			$("#celShipping").html(res.data.customer.shipping);
			$("#celphone").html(res.data.customer.phone);
			$("#celWhatsapp").html(res.data.customer.whatsapp);
			$("#celCreated").html(res.data.customer.created);
			$("#celIp").html(res.data.customer.ip_address); 
			$("#celDevice").html(res.data.customer.device);  
			$("#celOs").html(res.data.customer.system); 
			$("#celLocation").html(res.data.customer.location); 
			$("#celLogin").html(res.data.customer.date_login); 

			$('#viewCustomerModal').modal('show');
		} else {
			notyf.error(res.msg);
			// wrapper.html('');
		}
	}).fail(function(err) {
		notyf.error('Hubo un error en la petición', '¡Upss!');
	}).always(function() {
		wrapper.waitMe('hide');
	})
}

function editCustomer(idcustomer) {
	// rowTable = element.parentNode.parentNode.parentNode; 
	$('#titleModal').html("Editar Cliente");
	$('#modal-header').removeClass("bg-dark").addClass('bg-success');
	$('#btnActionForm').removeClass("btn-success").addClass("btn-dark");
	$('#btnText').html("Actualizar");
	$("#customerB2b").removeAttr('checked');
	$("#customerDs").removeAttr('checked');
	$("#customerShipping").removeAttr('checked');

	let hook    = 'bee_hook',
	action      = 'get',
	csrf = Bee.csrf,
	idCustomer = idcustomer,
	wrapper     = $('#customerModal');

	$.ajax({
		url: `ajax/get_customer`,
		type: 'POST',
		dataType: 'json',
		cache: false,
		data: {
		hook, action, idCustomer, csrf
	},
	beforeSend: function() {
		wrapper.waitMe({effect : 'win8'});
	}
	}).done(function(res) {
	if(res.status === 201) {

		$("#idCustomer").val(res.data.customer.id);
		$("#customerSae").val(res.data.customer.sae);
		$("#customerName").val(res.data.customer.name);
		$("#customerLastname").val(res.data.customer.lastname);
		$("#customerEmail").val(res.data.customer.email);
		$("#selectCustomerStatus").val(res.data.customer.status);

		if (res.data.customer.b2b == 'on') {
			$("#customerB2b").attr('checked','');
		}

		if (res.data.customer.dropshipping == 'on') {
			$("#customerDs").attr('checked','');
		}

		if (res.data.customer.shipping == 'on') {
			$("#customerShipping").attr('checked','');
		}

		$(".select2").change();
		$('#customerModal').modal('show');
	} else {
		notyf.error(res.msg);
	}
	}).fail(function(err) {
		notyf.error('Hubo un error en la petición');
	}).always(function() {
		wrapper.waitMe('hide');
	})
}

function deleteCustomer(idcustomer) {
	Swal.fire({
		title: 'Eliminar Cliente',
		text: "¿Realmente quieres eliminar este Cliente?",
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
			idCustomer = idcustomer;
			// AJAX
			$.ajax({
				url: `ajax/delete_customer`,
				type: 'POST',
				dataType: 'json',
				cache: false,
				data: {
					hook, action, idCustomer, csrf
				}
			}).done(function(res) {
				if(res.status === 201) {
					notyf.success(res.msg );
					$('#customersTable').DataTable().ajax.reload();
				} else {
					notyf.error(res.msg);
				}
			}).fail(function(err) {
				notyf.error('Hubo un error en la petición');
			});
		}
	});
}

// $('input#code')
// 	.keypress(function (event) {
// 	// El código del carácter 0 es 48
// 	// El código del carácter 9 es 57
// 	if (event.which < 48 || event.which > 57 || this.value.length === 6) {
// 		return false;
// 	}
// });


