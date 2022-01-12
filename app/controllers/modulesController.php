<?php

/**
 * Plantilla general de controladores
 * Versión 1.0.2
 *
 * Controlador de modules
 */
class modulesController extends Controller {
  function __construct()
  {
    // Validación de sesión de usuario, descomentar si requerida

    if (!Auth::validate()) {
      Flasher::new('Debes iniciar sesión primero.', 'danger');
      Redirect::to('login');
    }

    if ($_SESSION['permissions'][2]['r'] != 1) {
      Flasher::new('Notienes permisos para acceder a este modulo.', 'danger');
      Redirect::to('home');
    }

  }
  
  function index()
  {
    $data = 
    [
      'title' => 'Modulos',
    ];

    register_scripts([JS.'functions_modules.js'], 'Archivo con las funciones de la página modules');
    
    // Descomentar vista si requerida
    View::render('index', $data);
  }

}