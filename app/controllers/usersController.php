<?php

/**
 * Plantilla general de controladores
 * Versión 1.0.2
 *
 * Controlador de users
 */
class usersController extends Controller {
  function __construct()
  {
    // Validación de sesión de usuario, descomentar si requerida
    
    if (!Auth::validate()) {
      Flasher::new('Debes iniciar sesión primero.', 'danger');
      Redirect::to('login');
    }
  }
  
  function index()
  {

    if ($_SESSION['permissions'][4]['r'] != 1) {
      Flasher::new('Notienes permisos para acceder a este modulo.', 'danger');
      Redirect::to('home');
    }

    $data = 
    [
      'title' => 'Usuarios',
    ];

    register_scripts([JS.'functions_users.js'], 'Archivo con las funciones de la página users');

    // Descomentar vista si requerida
    View::render('index', $data);
  }

  function profile(){

    $user = usersModel::by_id($_SESSION['user_session']['user']['id']);

    $sessions = usersModel::session($_SESSION['user_session']['user']['id']);

    $data = 
    [
      'title' => 'Perfil de usuario',
      'sessions' => $sessions,
      'user' => $user
    ];

    register_scripts([JS.'functions_users.js'], 'Archivo con las funciones de la página users');

    // Descomentar vista si requerida
    View::render('profile', $data);
  }
}