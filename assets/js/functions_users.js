let usersTable;
// Initializes the plugin with options
const userModal = new bootstrap.Modal(document.getElementById('userModal'));
const modal_two_factor_authentication = new bootstrap.Modal(document.getElementById('modal_two_factor_authentication'));
const notyf = new Notyf({
	position: {
				x: "right",
				y: "top",
			},
	dismissible: true
});

document.addEventListener('DOMContentLoaded', function(){
    usersTable = $('#usersTable').DataTable({
		"aProcessing":true,
		"aServerSide":true,
		"ajax":{
			"url": `ajax/get_users`,
			"type": "post",
			"data":{
				"action" : "get",
				"hook" : "bee_hook"
			},
			"dataSrc":"data"
		},
		"columns":[
			{"data":"id"},
			{data:"name",
			render: function ( data, type, row ) {
                return row.name+' '+row.lastname;
            }},
			{"data":"email"},
			{"data":"rolename"},
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

	$('#userForm').validate({
		rules: {
			userName: {
				required: true,
				minlength: 2
			},
			userLastname: {
				required: true,
				minlength: 3
			},
			userPassword: {
				// required: true,
				// minlength: 4
			},
			userEmail: {
				required: true,
				email: true
			},
			selectUserRole: {
				required: true
			},
			selectUserStatus: {
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

	$('#userForm').on('submit', addUser);
	function addUser(event) {
		event.preventDefault();

		let form    = $('#userForm'),
		hook        = 'bee_hook',
		action      = 'post',
		data        = new FormData(form.get(0)),
		idUser = $("#idUser").val();
		data.append('hook', hook);
		data.append('action', action);

		// Campos Invalidos
		if(document.querySelector('.is-invalid')) {
			notyf.error('Hay campos que son invalidos en el formulario.', '¡Upss!');
			return;
		}

		// AJAX
		$.ajax({
		url: `ajax/add_user`,
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
			userModal.hide();
			$('#usersTable').DataTable().ajax.reload();
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
	get_user_roles();
}, false);

function openModal(){
	document.querySelector("#idUser").value = "";
	document.querySelector('#titleModal').innerHTML = "Nuevo Usuario";
	document.getElementById('modalColor').classList.replace("bg-success", "bg-dark");
	document.querySelector('#btnActionForm').classList.replace("btn-dark", "btn-success");
	document.querySelector('#btnText').innerHTML = "Guardar";
	document.querySelector("#userForm").reset();
	$(".select2").change();
	userModal.show();
};


function get_user_roles() {
	let wrapper = $('#selectUserRole'),
	hook        = 'bee_hook',
	action      = 'get'
	csrf = Bee.csrf;

	$.ajax({
		url: 'ajax/get_user_roles',
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

// $('#selectUserRole').on('change', get_customer_data);



function viewUser(iduser){

	let hook    = 'bee_hook',
	action      = 'get',
	idUser = iduser,
	wrapper     = $('#viewUserModal');

	$.ajax({
		url: `ajax/get_user`,
		type: 'POST',
		dataType: 'json',
		cache: false,
		data: {
		hook, action, idUser
	},
	beforeSend: function() {
		wrapper.waitMe();
	}
	}).done(function(res) {
		if(res.status === 201) {
			let userStatus = res.data.status == 'active' ? 
			'<span class="badge badge-lg bg-success">Activo</span>' : 
			'<span class="badge badge-lg bg-danger">Inactivo</span>';

			$("#celId").html(res.data.id);
			$("#celName").html(`${res.data.name} ${res.data.lastname}`);
			$("#celEmail").html(res.data.email);
			$("#celRole").html(res.data.rolename);
			$("#celStatus").html(userStatus);
			$("#celCreated").html(res.data.created);
			$("#celIp").html(res.data.ip_address); 
			$("#celDevice").html(res.data.device);  
			$("#celOs").html(res.data.system); 
			$("#celLocation").html(res.data.location); 
			$("#celLogin").html(res.data.date_login); 

			$('#viewUserModal').modal('show');
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




function editUser(iduser) {
	// rowTable = element.parentNode.parentNode.parentNode; 
	$('#titleModal').html("Editar Usuario");
	$('#modalColor').removeClass("bg-dark").addClass('bg-success');
	$('#btnActionForm').removeClass("btn-success").addClass("btn-dark");
	$('#btnText').html("Actualizar");

	let hook    = 'bee_hook',
	action      = 'get',
	csrf = Bee.csrf,
	idUser = iduser,
	wrapper     = $('#userModal');

	$.ajax({
		url: `ajax/get_user`,
		type: 'POST',
		dataType: 'json',
		cache: false,
		data: {
		hook, action, idUser, csrf
	},
	beforeSend: function() {
		wrapper.waitMe({effect : 'win8'});
	}
	}).done(function(res) {
	if(res.status === 201) {

		$("#idUser").val(res.data.id);
		$("#userName").val(res.data.name);
		$("#userLastname").val(res.data.lastname);
		$("#userEmail").val(res.data.email);
		$("#selectUserRole").val(res.data.id_role);
		$("#selectUserStatus").val(res.data.status);

		$(".select2").change();
		$('#userModal').modal('show');
	} else {
		notyf.error(res.msg);
	}
	}).fail(function(err) {
		notyf.error('Hubo un error en la petición');
	}).always(function() {
		wrapper.waitMe('hide');
	})
}

function deleteUser(iduser) {
	Swal.fire({
		title: 'Eliminar Usuario',
		text: "¿Realmente quieres eliminar este Usuario?",
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
			idUser = iduser;
			// AJAX
			$.ajax({
				url: `ajax/delete_user`,
				type: 'POST',
				dataType: 'json',
				cache: false,
				data: {
					hook, action , idUser
				}
			}).done(function(res) {
				if(res.status === 201) {
					Swal.fire("¡Eliminar!", res.msg , "success");
					$('#usersTable').DataTable().ajax.reload();
				} else {
					Swal.fire("¡Atención!", res.msg , "error");
				}
			}).fail(function(err) {
				notyf.error('Hubo un error en la petición', '¡Upss!');
			});
		}
	});
}

$('input#code')
	.keypress(function (event) {
	// El código del carácter 0 es 48
	// El código del carácter 9 es 57
	if (event.which < 48 || event.which > 57 || this.value.length === 6) {
		return false;
	}
});

$('#codeForm').validate({
	rules: {
		code: {
			required: true,
			number: true,
			minlength: 6,
			maxlength: 6
		},
		idUserCode: {
			required: true,
			number: true
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

$('#codeForm').on('submit', activate_2fa);
function activate_2fa(event) {
	event.preventDefault();

	let form    = $('#codeForm'),
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
	url: `ajax/activate_2fa`,
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
		form.trigger('reset');
		modal_two_factor_authentication.hide();
		notyf.success(res.msg).on('dismiss', function(){location.reload()});
		setTimeout('document.location.reload()',3000);
	} else {
		notyf.error(res.msg);
	}
	}).fail(function(err) {
		notyf.error('Hubo un error en la petición');
	}).always(function() {
		form.waitMe('hide');
	})
}

function desactive_2fa(iduser) {
	Swal.fire({
		title: 'Cancelar',
		text: "¿Realmente quieres cancelar la autenticación de 2 factores?",
		icon: 'question',
		showCancelButton: true,
		confirmButtonColor: '#3085d6',
		cancelButtonColor: '#d33',
		confirmButtonText: 'Si',
		cancelButtonText: 'No'
	}).then((result) => {
		
		if (result.isConfirmed) {
			let hook        = 'bee_hook',
			action      = 'post',
			csrf = Bee.csrf,
			idUser = iduser;
			// AJAX
			$.ajax({
				url: `ajax/desactive_2fa`,
				type: 'POST',
				dataType: 'json',
				cache: false,
				data: {
					hook, action , idUser, csrf
				}
			}).done(function(res) {
				if(res.status === 201) {
					notyf.success(res.msg).on('dismiss', function(){location.reload()});
					setTimeout('document.location.reload()',3000);
				} else {
					notyf.error(res.msg);
				}
			}).fail(function(err) {
				notyf.error('Hubo un error en la petición');
			});
		}
	});
}



