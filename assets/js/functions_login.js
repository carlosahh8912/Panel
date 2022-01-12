const notyf = new Notyf({
	position: {
				x: "right",
				y: "top",
			},
	dismissible: true
});

document.addEventListener('DOMContentLoaded', function(){

    if(document.querySelector('#loginForm')){
        $('#loginForm').validate({
            rules: {
                user: {
                    required: true,
                    email: true
                },
                password: {
                    required: true,
                    minlength: 4
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
    }

    if(document.querySelector('#forgotPasswordForm')){
        $('#forgotPasswordForm').validate({
            rules: {
                userEmail: {
                    required: true,
                    email: true
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


        $('#forgotPasswordForm').on('submit', forgotPassword);
        function forgotPassword(event) {
            event.preventDefault();

            let form    = $('#forgotPasswordForm'),
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
            url: `${Bee.url}ajax/forgot_password`,
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
                setTimeout(function(){
                    window.location.href = "./login";
                },200);
                
            } else {
                notyf.error(res.msg);
            }
            }).fail(function(err) {
            notyf.error('Hubo un error en la petición');
            }).always(function() {
            form.waitMe('hide');
            })
        }
    }

    if(document.querySelector('#resetPasswordForm')){
        $('#resetPasswordForm').validate({
            rules: {
                userEmail: {
                    required: true,
                    email: true
                },
                userToken: {
                    required: true,
                    minlength: 32,
                    maxLength: 32
                },
                newPassword: {
                    required: true,
                    minlength: 4
                },
                confirm_password: {
                    required: true,
                    minlength: 4,
                    equalTo: "#newPassword"
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

        $('#resetPasswordForm').on('submit', forgotPassword);
        function forgotPassword(event) {
            event.preventDefault();

            let form    = $('#resetPasswordForm'),
            hook        = 'bee_hook',
            action      = 'post',
            data        = new FormData(form.get(0)),
            retypePassword = $("#retypePassword").val(),
            newPassword = $("#newPassword").val();
            data.append('hook', hook);
            data.append('action', action);

            // Campos Invalidos
            if(document.querySelector('.is-invalid')) {
                notyf.error('Hay campos que son invalidos en el formulario.');
                return;
            }

            // AJAX
            $.ajax({
            url: `${Bee.url}ajax/recovery_password`,
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
                setTimeout(function(){
                    window.location.href = "./login";
                },200);
            } else {
                notyf.error(res.msg, '¡Upss!');
            }
            }).fail(function(err) {
            notyf.error('Hubo un error en la petición', '¡Upss!');
            }).always(function() {
            form.waitMe('hide');
            })
        }
    }
    
});