<?php

/**
 * Plantilla general de controladores
 * Versión 1.0.2
 *
 * Controlador de products
 */
class productsController extends Controller {
  function __construct()
  {
    // Validación de sesión de usuario, descomentar si requerida
    
    if (!Auth::validate()) {
      Flasher::new('Debes iniciar sesión primero.', 'danger');
      Redirect::to('login');
    }

    if ($_SESSION['permissions'][6]['r'] != 1) {
      Flasher::new('Notienes permisos para acceder a este modulo.', 'danger');
      Redirect::to('home');
    }
  
  }
  
  function index()
  {
    $data = 
    [
      'title' => 'Productos',
      'msg'   => 'Bienvenido al controlador de "products", se ha creado con éxito si ves este mensaje.'
    ];
    register_styles([PLUGINS.'tagin/css/tagin.min.css'], 'Tagin CSS');
    register_scripts([PLUGINS.'tagin/js/tagin.min.js'], 'Tagin Js');
    register_scripts([JS.'functions_products.js'], 'Archivo con las funciones de la página products');
    use_summernote();
    // Descomentar vista si requerida
    View::render('index', $data);
  }
}