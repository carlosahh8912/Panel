<?php

/**
 * Plantilla general de controladores
 * Versión 1.0.2
 *
 * Controlador de pos
 */
class posController extends Controller {
  function __construct()
  {
    // Validación de sesión de usuario, descomentar si requerida
    
    if (!Auth::validate()) {
      Flasher::new('Debes iniciar sesión primero.', 'danger');
      Redirect::to('login');
    }

    if ($_SESSION['permissions'][11]['r'] != 1) {
      Flasher::new('Notienes permisos para acceder a este modulo.', 'danger');
      Redirect::to('home');
    }

    register_scripts([JS.'functions_pos.js'], 'Archivo con las funciones de la página pos');

  
  }
  
  function index()
  {
    $data = 
    [
      'title' => 'Punto de Venta',
    ];
    // Descomentar vista si requerida
    View::render('index', $data);
  }

  function massimport(){
    $data = 
    [
      'title' => 'Carga masiva POS',
    ];
    View::render('massimport', $data);
  }

}