<?php 

/**
 * Controlador para generar modelos y controladores de forma dinámica
 */
class creatorController extends Controller {
  function __construct()
  {
    // Validación de sesión de usuario, descomentar si requerida
  
    if (!Auth::validate()) {
      Flasher::new('Debes iniciar sesión primero.', 'danger');
      Redirect::to('login');
    }

    if (get_user('id_role' !== 1)){
      Flasher::new('No tienes permisos para accesar a este recurso.', 'danger');
      Redirect::to('home');
    }
  }
  
  function index() {
    View::render('index', ['title' => 'Crea un nuevo archivo']);
  }

  function controller()
  {
    View::render('controller', ['title' => 'Nuevo controlador']);
  }

  function model()
  {
    View::render('model', ['title' => 'Nuevo modelo']);
  }

  function post_controller()
  {
    if (!Csrf::validate($_POST['csrf'])) {
      Flasher::deny();
      Redirect::back();
    }

    // Validar nombre de archivo
    $filename = clean($_POST['filename']);
    $filename = strtolower($filename);
    $filename = str_replace(' ', '_', $filename);
    $filename = str_replace('.php', '', $filename);
    $keyword  = 'Controller';
    $template = MODULES.'controllerTemplate.txt';

    // Validar la existencia del controlador para prevenir remover un archivo existente
    if (is_file(CONTROLLERS.$filename.$keyword.'.php')) {
      Flasher::new(sprintf('Ya existe el controladores %s.', $filename.$keyword), 'danger');
      Redirect::back();
    }

    // Validar la existencia de la plantilla .txt para crear el controlador
    if (!is_file($template)) {
      Flasher::new(sprintf('No existe la plantilla %s.', $template), 'danger');
      Redirect::back();
    }
    
    // Cargar contenido del archivo
    $php = @file_get_contents($template);
    $php = str_replace('[[REPLACE]]', $filename, $php);
    if (file_put_contents(CONTROLLERS.$filename.$keyword.'.php', $php) === false)  {
      Flasher::new(sprintf('Ocurrió un problema al crear el controlador %s.', $template), 'danger');
      Redirect::back();
    }

    // Crear el folder en carpeta vistas
    if (!is_dir(VIEWS.$filename)) {
      mkdir(VIEWS.$filename);

      $body = 
      '<?php require_once INCLUDES.\'inc_header.php\'; ?>

      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-4">
          <div class="d-block mb-4 mb-md-0">
              <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
                  <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
                      <li class="breadcrumb-item">
                          <a href="./"><span class="fas fa-tachometer-alt"></span></a>
                      </li>
                      <!-- <li class="breadcrumb-item"><a href="#">ant Page</a></li> -->
                      <li class="breadcrumb-item active" aria-current="page"><?= $d->title; ?></li>
                  </ol>
              </nav>
              <h2 class="h4"><?= $d->title; ?></h2>
              <p class="mb-0">Your web analytics dashboard template.</p>
          </div>
          <div class="btn-toolbar mb-2 mb-md-0">
              <button href="#" class="btn btn-sm btn-dark"><span class="fas fa-plus me-2"></span> Action button</button>
              <div class="btn-group ms-2 ms-lg-3"><button type="button" class="btn btn-sm btn-outline-primary">Share</button> <button type="button" class="btn btn-sm btn-outline-primary">Export</button></div>
          </div>
      </div>
      
      <div class="card card-body shadow-sm table-wrapper table-responsive">
      <h1><?php echo $d->msg; ?></h1>
      </div>
      
      <?php require_once INCLUDES.\'inc_footer.php\'; ?>';
      
      @file_put_contents(VIEWS.$filename.DS.'indexView.php', $body);
    }

    // Crear una vista por defecto
    Redirect::to($filename);
  }

  function post_model()
  {
    if (!Csrf::validate($_POST['csrf'])) {
      Flasher::deny();
      Redirect::back();
    }

    // Validar nombre de archivo
    $filename = clean($_POST['filename']);
    $filename = strtolower($filename);
    $filename = str_replace(' ', '_', $filename);
    $filename = str_replace('.php', '', $filename);
    $keyword  = 'Model';
    $template = MODULES.'modelTemplate.txt';

    if (is_file(CONTROLLERS.$filename.$keyword.'.php')) {
      Flasher::new(sprintf('Ya existe el modelo %s.', $filename.$keyword), 'danger');
      Redirect::back();
    }

    if (!is_file($template)) {
      Flasher::new(sprintf('No existe la plantilla %s.', $template), 'danger');
      Redirect::back();
    }
    
    // Cargar contenido del archivo
    $php = @file_get_contents($template);
    $php = str_replace('[[REPLACE]]', $filename, $php);
    if (file_put_contents(MODELS.$filename.$keyword.'.php', $php) === false)  {
      Flasher::new(sprintf('Ocurrió un problema al crear el modelo %s.', $template), 'danger');
      Redirect::back();
    }

    Flasher::new(sprintf('Modelo %s creado con éxito.', $filename.$keyword));
    Redirect::back();
  }
}