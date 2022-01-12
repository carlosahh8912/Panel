<?php 

class errorController extends Controller {
  function __construct()
  {
    // Validación de sesión de usuario, descomentar si requerida
  
    if (!Auth::validate()) {
      Flasher::new('Debes iniciar sesión primero.', 'danger');
      Redirect::to('login');
    }
  }
  
  function index() {
    $data =
    [
      'title' => 'Página no encontrada',
      'bg'    => 'dark'
    ];
    View::render('404', $data);
  }
}