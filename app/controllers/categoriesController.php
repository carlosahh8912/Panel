<?php

/**
 * Plantilla general de controladores
 * Versión 1.0.2
 *
 * Controlador de categories
 */
class categoriesController extends Controller {
  function __construct()
  {
    // Validación de sesión de usuario, descomentar si requerida
    
    if (!Auth::validate()) {
      Flasher::new('Debes iniciar sesión primero.', 'danger');
      Redirect::to('login');
    }

    if ($_SESSION['permissions'][8]['r'] != 1) {
      Flasher::new('Notienes permisos para acceder a este modulo.', 'danger');
      Redirect::to('home');
    }

  
  }
  
  function index()
  {
    $data = 
    [
      'title' => 'Categorías',
      'msg'   => 'Bienvenido al controlador de "categories", se ha creado con éxito si ves este mensaje.'
    ];
    register_scripts([JS.'functions_categories.js'], 'Archivo con las funciones de la página categories');
    // Descomentar vista si requerida
    View::render('index', $data);
  }
}