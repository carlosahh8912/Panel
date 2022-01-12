<?php 

class loginController extends Controller {
  function __construct()
  {
    if (Auth::validate()) {
      Flasher::new('Ya hay una sesión abierta.');
      Redirect::to('home/flash');
    }

    register_scripts([JS.'functions_login.js'], 'Archivo con las funciones de la página login');
  }

  function index()
  {
    $data =
    [
      'title'   => 'Login',
    ];

    View::render('index', $data);
  }

  function post_login()
  {
    if (!Csrf::validate($_POST['csrf']) || !check_posted_data(['email','csrf','password'], $_POST)) {
      Flasher::new('Acceso no autorizado.', 'danger');
      Redirect::back();
    }

    // Data pasada del formulario
    $usuario  = strtolower(clean($_POST['email']));
    $password = clean($_POST['password']);

    // Información del usuario loggeado, simplemente se puede reemplazar aquí con un query a la base de datos
    // para cargar la información del usuario si es existente

    $user = usersModel::login_user($usuario);

    if ($usuario !== $user['email'] || !password_verify($password.AUTH_SALT, $user['password'])) {
      Flasher::new('Las credenciales no son correctas.', 'danger');
      Redirect::back();
    }

    if ($user['status'] == 'inactive') {
      Flasher::new('El usuario se encuentra inactivo, contactar al administrador.', 'danger');
      Redirect::back();
    }

    //Obtine los inicios de session anteriores
    $last_login = Model::list('sessions', ['id_user' => $user['id']]);
    set_session('sessions', $last_login);

    //Obtenemos la IP del equipo
    $ip_info = ip_info($_SERVER['REMOTE_ADDR']);

    //Guarda el Login en bitacora
    $session = [
      'id_user' => $user['id'],
      'ip_address' => $_SERVER['REMOTE_ADDR'],
      'device' => get_user_device(),
      'location' => $ip_info['state'].', '.$ip_info['country'],
      'system' => $_SERVER['HTTP_USER_AGENT'],
      'date_login' => now()
    ];

    $ant_session = Model::list('sessions', ['id_user' => $user['id'],  'ip_address' => $_SERVER['REMOTE_ADDR'], 'device' => get_user_device()], 1);

    if ($ant_session == '') {
      //Guardamos las sesiones en sesión
      Model::add('sessions', $session);
    }

    // Loggear al usuario
    Auth::login($user[0]['id'], $user);

    set_session('permissions', get_permission_role($_SESSION['user_session']['user']['id_role']));

    if (empty($last_login)) {
      Redirect::to('users/profile');
    }else{
      Redirect::to('home');
    }
  }

  function forgot_password(){

    $data =
    [
      'title'   => 'Olvide mi contraseña',
    ];

    View::render('forgotPassword', $data);
  }

  function recovery_password($email, $token){

    $data =
    [
      'title'   => 'Recuperar contraseña',
      'email'   => $email,
      'token'   => $token
    ];

    View::render('recoveryPassword', $data);
  }
}