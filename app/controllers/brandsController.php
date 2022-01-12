<?php

/**
 * Plantilla general de controladores
 * Versión 1.0.2
 *
 * Controlador de brands
 */
class brandsController extends Controller {
  function __construct()
  {
    // Validación de sesión de usuario, descomentar si requerida
  
    if (!Auth::validate()) {
      Flasher::new('Debes iniciar sesión primero.', 'danger');
      Redirect::to('login');
    }

    if ($_SESSION['permissions'][7]['r'] != 1) {
      Flasher::new('Notienes permisos para acceder a este modulo.', 'danger');
      Redirect::to('home');
    }
  
  }
  
  function index()
  {
    $data = 
    [
      'title' => 'Marcas',
    ];

    register_scripts([JS.'functions_brands.js'], 'Archivo con las funciones de la página brands');
    
    // Descomentar vista si requerida
    View::render('index', $data);
  }
}