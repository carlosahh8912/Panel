<?php 

class homeController extends Controller {
  function __construct()
  {
    // Validación de sesión de usuario, descomentar si requerida
  
    if (!Auth::validate()) {
      Flasher::new('Debes iniciar sesión primero.', 'danger');
      Redirect::to('login');
    }

    // if ($_SESSION['permissions'][1]['r'] != 1) {
    //   Flasher::new('Notienes permisos para acceder a este modulo.', 'danger');
    //   Redirect::back();
    // }
  }

  function index()
  {
    $data =
    [
      'title' => 'Dashboard',
      'products' => productsModel::all_by_sale(),
      'customers' => Model::list('users', ['id_role' => '3','status' => 'active']),
      'orders' => orderModel::all(),
      'stock' => Model::list('products', ['status' => 'active'], 10, 'stock', 'desc')
    ];

    View::render('index', $data);
  }

  // function flash()
  // {
  //   parent::auth();

  //   View::render('flash', ['title' => 'Flash', 'user' => User::profile()]);
  // }

}