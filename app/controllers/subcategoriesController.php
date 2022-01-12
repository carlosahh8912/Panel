<?php

/**
 * Plantilla general de controladores
 * Versión 1.0.2
 *
 * Controlador de subcategories
 */
class subcategoriesController extends Controller {
  function __construct()
  {
    // Validación de sesión de usuario, descomentar si requerida
    
    if (!Auth::validate()) {
      Flasher::new('Debes iniciar sesión primero.', 'danger');
      Redirect::to('login');
    }

    if ($_SESSION['permissions'][9]['r'] != 1) {
      Flasher::new('Notienes permisos para acceder a este modulo.', 'danger');
      Redirect::to('home');
    }
  
  }
  
  function index()
  {
    $data = 
    [
      'title' => 'Subcategorías',
      'msg'   => 'Bienvenido al controlador de "subcategories", se ha creado con éxito si ves este mensaje.'
    ];
    register_scripts([JS.'functions_subcategories.js'], 'Archivo con las funciones de la página subcategories');
    // Descomentar vista si requerida
    View::render('index', $data);
  }
}