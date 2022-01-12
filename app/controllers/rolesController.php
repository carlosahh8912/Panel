<?php

/**
 * Plantilla general de controladores
 * Versión 1.0.2
 *
 * Controlador de roles
 */
class rolesController extends Controller {
  function __construct()
  {
    // Validación de sesión de usuario, descomentar si requerida
    
    if (!Auth::validate()) {
      Flasher::new('Debes iniciar sesión primero.', 'danger');
      Redirect::to('login');
    }
    
    if ($_SESSION['permissions'][3]['r'] != 1) {
      Flasher::new('Notienes permisos para acceder a este modulo.', 'danger');
      Redirect::to('home');
    }
  }
  
  function index()
  {
    $data = 
    [
      'title' => 'Roles',
    ];

    register_scripts([JS.'functions_roles.js'], 'Archivo con las funciones de la página roles');
    
    // Descomentar vista si requerida
    View::render('index', $data);
  }
}