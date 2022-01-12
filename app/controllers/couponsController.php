<?php

/**
 * Plantilla general de controladores
 * Versión 1.0.2
 *
 * Controlador de coupons
 */
class couponsController extends Controller {
  function __construct()
  {
    // Validación de sesión de usuario, descomentar si requerida
    
    if (!Auth::validate()) {
      Flasher::new('Debes iniciar sesión primero.', 'danger');
      Redirect::to('login');
    }

    if ($_SESSION['permissions'][12]['r'] != 1) {
      Flasher::new('Notienes permisos para acceder a este modulo.', 'danger');
      Redirect::to('home');
    }
  
  }
  
  function index()
  {
    $data = 
    [
      'title' => 'Cupones',
      'msg'   => 'Bienvenido al controlador de "coupons", se ha creado con éxito si ves este mensaje.'
    ];
    register_scripts([JS.'functions_coupons.js'], 'Archivo con las funciones de la página coupons');
    // Descomentar vista si requerida
    View::render('index', $data);
  }


}