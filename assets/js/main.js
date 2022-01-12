$(document).ready(function() {

  /**
   * Alerta para confirmar una acción establecida en un link o ruta específica
   */
  $('body').on('click', '.confirmar', function(e) {
    e.preventDefault();

    let url = $(this).attr('href');

    Swal.fire({
      title: 'Salir de la página',
      text: "¿Realmente quieres salir?",
      icon: 'question',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Si, Salir',
      cancelButtonText: 'No, Continuar'
    }).then((result) => {
      
      if (result.isConfirmed) {
        window.location = url;
        return true;
      }
    });
    return true;
  });

  /**
   * Inicializa summernote el editor de texto avanzado para textareas
   */
  function init_summernote() {
    if ($('.summernote').length == 0) return;

    $('.summernote').summernote({
      placeholder: 'Escribe en este campo...',
      tabsize: 2,
      height: 300
    });
  }

  // Init Select2

  $(".select2").select2({
    theme: "bootstrap-5",
  });
  $.fn.modal.Constructor.prototype._enforceFocus = function() {};

  /**
   * Inicializa tooltips en todo el sitio
   */
  function init_tooltips() {
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
      return new bootstrap.Tooltip(tooltipTriggerEl)
    });
  }
  
  // Inicialización de elementos
  init_summernote();
  init_tooltips();


   // Cargar Sidebar
  get_sidebar_menu();
  function get_sidebar_menu() {
    var wrapper = $('#show_menu'),
    hook        = 'bee_hook',
    action      = 'get';

    if (wrapper.length === 0) {
      return;
    }

    $.ajax({
      url: 'ajax/get_sidebar_menu',
      type: 'POST',
      dataType: 'json',
      cache: false,
      data: {
        hook, action
      },
      beforeSend: function() {
        wrapper.waitMe();
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
    }).always(function() {
      wrapper.waitMe('hide');
    })
  }

});