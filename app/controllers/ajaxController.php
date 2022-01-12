<?php 

class ajaxController extends Controller {


  /**
   * La petición del servidor
   *
   * @var string
   */
  private $r_type = null;

  /**
   * Hook solicitado para la petición
   *
   * @var string
   */
  private $hook   = null;

  /**
   * Tipo de acción a realizar en ajax
   *
   * @var string
   */
  private $action = null;

  /**
   * Token csrf de la sesión del usuario que solicita la petición
   *
   * @var string
   */
  private $csrf   = null;

  /**
   * Todos los parámetros recibidos de la petición
   *
   * @var array
   */
  private $data   = null;

  /**
   * Parámetros parseados en caso de ser petición put | delete | headers | options
   *
   * @var mixed
   */
  private $parsed = null;

  /**
   * Valor que se deberá proporcionar como hook para
   * aceptar una petición entrante
   *
   * @var string
   */
  private $hook_name        = 'bee_hook'; // Si es modificado, actualizar el valor en la función core insert_inputs()
  
  /**
   * parámetros que serán requeridos en TODAS las peticiones pasadas a ajaxController
   * si uno de estos no es proporcionado la petición fallará
   *
   * @var array
   */
  private $required_params  = ['hook', 'action'];

  /**
   * Posibles verbos o acciones a pasar para nuestra petición
   *
   * @var array
   */
  private $accepted_actions = ['get', 'post', 'put', 'delete', 'options', 'headers'];

  function __construct()
  {
    // Parsing del cuerpo de la petición
    $this->r_type = isset($_SERVER['REQUEST_METHOD']) ? $_SERVER['REQUEST_METHOD'] : null;
    $this->data   = in_array($this->r_type, ['PUT','DELETE','HEADERS','OPTIONS']) ? parse_str(file_get_contents("php://input"), $this->parsed) : ($this->r_type === 'GET' ? $_GET : $_POST);
    $this->data   = $this->parsed !== null ? $this->parsed : $this->data;
    $this->hook   = isset($this->data['hook']) ? $this->data['hook'] : null;
    $this->action = isset($this->data['action']) ? $this->data['action'] : null;
    $this->csrf   = isset($this->data['csrf']) ? $this->data['csrf'] : null;

    // Validar que hook exista y sea válido
    if ($this->hook !== $this->hook_name) {
      http_response_code(403);
      json_output(json_build(403));
    }

    // Validar que se pase un verbo válido y aceptado
    if(!in_array($this->action, $this->accepted_actions)) {
      http_response_code(403);
      json_output(json_build(403));
    }
    
    // Validación de que todos los parámetros requeridos son proporcionados
    foreach ($this->required_params as $param) {
      if(!isset($this->data[$param])) {
        http_response_code(403);
        json_output(json_build(403));
      }
    }

    // Validar de la petición post / put / delete el token csrf
    if (in_array($this->action, ['post', 'put', 'delete', 'add', 'headers']) && !Csrf::validate($this->csrf)) {
      http_response_code(403);
      json_output(json_build(403));
    }
  }

  function index()
  {
    /**
    200 OK
    201 Created
    300 Multiple Choices
    301 Moved Permanently
    302 Found
    304 Not Modified
    307 Temporary Redirect
    400 Bad Request
    401 Unauthorized
    403 Forbidden
    404 Not Found
    410 Gone
    500 Internal Server Error
    501 Not Implemented
    503 Service Unavailable
    550 Permission denied
    */
    json_output(json_build(403));
  }


  function get_sidebar_menu()
  {
    try {

      $links = [
        '1' =>[
          'url' => '/',
          'icon' => 'fas fa-tachometer-alt',
          'title' => 'Dashboard',
          'slug' => 'home'
        ],
        '2' =>[
          'url' => 'modules',
          'icon' => 'fas fa-th',
          'title' => 'Modulos',
          'slug' => 'modules'
        ],
        '3' =>[
          'url' => 'roles',
          'icon' => 'fas fa-user-tag',
          'title' => 'Roles',
          'slug' => 'roles'
        ],
        '4' =>[
          'url' => 'users',
          'icon' => 'fas fa-users',
          'title' => 'Usuarios',
          'slug' => 'users'
        ],
        '5' =>[
          'url' => 'customers',
          'icon' => 'fas fa-user-tie',
          'title' => 'Clientes',
          'slug' => 'customers'
        ],
        '6' =>[
          'url' => 'products',
          'icon' => 'fas fa-box',
          'title' => 'Productos',
          'slug' => 'products'
        ],
        '7' =>[
          'url' => 'brands',
          'icon' => 'fas fa-star',
          'title' => 'Marcas',
          'slug' => 'brands'
        ],
        '8' =>[
          'url' => 'categories',
          'icon' => 'fas fa-tag',
          'title' => 'Categorías',
          'slug' => 'categories'
        ],
        '9' =>[
          'url' => 'subcategories',
          'icon' => 'fas fa-tags',
          'title' => 'Subcategorías',
          'slug' => 'subcategories'
        ],
        '10' =>[
          'url' => 'orders',
          'icon' => 'fas fa-file-invoice-dollar',
          'title' => 'Pedidos',
          'slug' => 'orders'
        ],
        '11' =>[
          'url' => 'pos',
          'icon' => 'fas fa-receipt',
          'title' => 'Sistema POS',
          'slug' => 'pos'
        ],
        '12' =>[
          'url' => 'coupons',
          'icon' => 'fas fa-ticket-alt',
          'title' => 'Cupones',
          'slug' => 'coupons'
        ],
        '13' =>[
          'url' => 'reviews',
          'icon' => 'fas fa-ticket-alt',
          'title' => 'Reviews',
          'slug' => 'reviews'
        ],
        '14' =>[
          'url' => 'dropshipping',
          'icon' => 'fas fa-truck',
          'title' => 'Dropshipping',
          'slug' => 'dropshipping'
        ],
      ];

      $menu = get_module('sidebarMenu', $links);
      json_output(json_build(200, $menu));
    } catch (Exception $e) {
      json_output(json_build(400, null, $e->getMessage()));
    }
  }

//////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////     AJAX MODULES      
/////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////

  function get_modules()
  {
    try {
      $data = modulesModel::all();

      if (count($data) == 0) {
        json_output(json_build(200, null, 'No hay datos en la tabla.'));
      }

      for ($i = 0; $i < count($data); $i++) {  
        if ($data[$i]['status'] == 'active') {
          $data[$i]['status'] = '<span class="badge badge-lg bg-success">Activo</span>';
        }else{
          $data[$i]['status'] = '<span class="badge badge-lg bg-danger">Inactivo</span>';
        }

        $btnDelete = '';
        $btnEdit = '';

        if ($_SESSION['permissions'][2]['u'] == 1) {
          $btnEdit = '<button class="dropdown-item rounded-top" onClick="editModule('.$data[$i]['id'].')"><span class="fas fa-edit me-2"></span>Editar</button> ';
        }

        if ($_SESSION['permissions'][2]['d'] == 1) {
          $btnDelete = '<button class="dropdown-item text-danger rounded-bottom" onClick="deleteModule('.$data[$i]['id'].')"><span class="fas fa-trash-alt me-2"></span>Eliminar</button>';
        }

        $data[$i]['options'] = sprintf('
          <div class="btn-group">
            <button class="btn btn-link text-dark dropdown-toggle dropdown-toggle-split m-0 p-0" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="icon icon-sm pt-1">
                  <span class="fas fa-ellipsis-h icon-dark"></span> 
                </span>
                <span class="sr-only">Menu</span>
            </button>
            <div class="dropdown-menu py-0">
                %s
                %s
            </div>
          </div>
        ', $btnEdit, $btnDelete);          
      }

      json_output(json_build(200, $data));
    } catch (Exception $e) {
      json_output(json_build(400, null, $e->getMessage()));
    }
  }

  function get_module()
  {
    try {
      $id = intval(clean($_POST['idModule']));

      if ($id == null) {
        json_output(json_build(400, null, 'No hay datos para mostrar, ingrese un ID valido.'));
      }
      json_output(json_build(200, Model::list('modules', ['id' => $id], 1)));
    } catch (Exception $e) {
      json_output(json_build(400, null, $e->getMessage()));
    }
  }

  function add_module()
  {

    if (!Csrf::validate($_POST['csrf']) || !check_posted_data(['moduleName','selectModuleStatus','csrf'], $_POST)) {
      json_output(json_build(400, null, 'Argumentos insuficientes'));
    }

    try {

      $data = [
        'name' =>clean($_POST['moduleName']),
        'status' => clean($_POST['selectModuleStatus'])
      ];

      
      if(intval(clean($_POST['idModule']))  == 0){
        if(Model::list('modules', ['name' => clean($_POST['moduleName'])]) != null){
          json_output(json_build(400, null, 'El Rol ya existe.'));
        }
        if(!$id = Model::add('modules', $data)) {
          json_output(json_build(400, null, 'Hubo error al guardar el registro'));
        }
        // se guardó con éxito
        json_output(json_build(201, Model::list('modules', ['id' => $id], 1), 'Movimiento agregado con éxito'));
      }else{

        if(empty(modulesModel::unique_name(clean($_POST['moduleName']), intval(clean($_POST['idModule']))))){

          if(!$id = Model::update('modules', ['id' => intval(clean($_POST['idModule']))] ,$data)) {
            json_output(json_build(400, null, 'Hubo error al actualizar el registro'));
          }
          json_output(json_build(201, Model::list('modules', ['id' => $id], 1), 'Modulo actualizado con éxito'));

        }else{

          json_output(json_build(400, null, 'El Modulo ya existe.'));
        }

      }
    } catch (Exception $e) {
      json_output(json_build(400, null, $e->getMessage()));
    }
  }

  function delete_module()
  {
    try {

      if(isset($_POST['idModule']) != null){

        $id = intval(clean(($_POST['idModule'])));

        $data = [
          'status' => 'deleted'
        ];

        if(!$response = Model::update('modules', ['id' => $id] ,$data)) {

          json_output(json_build(400, null, 'Hubo error al borrar el registro.'));
        }

        json_output(json_build(201, null, 'El Modulo ha sido eliminado.'));

      }else{

        json_output(json_build(400, null, 'Argumentos insuficientes.'));
      }
    } catch (Exception $e) {
      json_output(json_build(400, null, $e->getMessage()));
    }
  }



//////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////     AJAX ROLES      
/////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////

  function get_roles()
  {
    try {
      $data = rolesModel::all();

      if (count($data) == 0) {
        json_output(json_build(200, null, 'No hay datos en la tabla.'));
      }

      for ($i = 0; $i < count($data); $i++) {  
        if ($data[$i]['status'] == 'active') {
          $data[$i]['status'] = '<span class="badge badge-lg bg-success">Activo</span>';
        }else{
          $data[$i]['status'] = '<span class="badge badge-lg bg-danger">Inactivo</span>';
        }

        $btnDelete = '';
        $btnEdit = '';

        if ($_SESSION['permissions'][3]['u'] == 1) {
          $btnEdit = '<button class="dropdown-item rounded-top" onClick="editRole('.$data[$i]['id'].')"><span class="fas fa-edit me-2"></span>Editar</button> ';
        }

        if ($_SESSION['permissions'][3]['d'] == 1) {
          $btnDelete = '<button class="dropdown-item text-danger rounded-bottom" onClick="deleteRole('.$data[$i]['id'].')"><span class="fas fa-trash-alt me-2"></span>Eliminar</button>';
        }

        $data[$i]['options'] = sprintf('
          <div class="btn-group">
            <button class="btn btn-link text-dark dropdown-toggle dropdown-toggle-split m-0 p-0" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="icon icon-sm pt-1">
                  <span class="fas fa-ellipsis-h icon-dark"></span> 
                </span>
                <span class="sr-only">Menu</span>
            </button>
            <div class="dropdown-menu py-0">
                <button class="dropdown-item rounded-top" onClick="permissionsRole('.$data[$i]['id'].')"><span class="fas fa-key me-2"></span>Permisos</button> 
                %s
                %s
            </div>
          </div>
        ',$btnEdit, $btnDelete);          
      }

      json_output(json_build(200, $data));
    } catch (Exception $e) {
      json_output(json_build(400, null, $e->getMessage()));
    }
  }

  function get_role()
  {
    try {
      $id = intval(clean($_POST['idRole']));

      if ($id == null) {
        json_output(json_build(400, null, 'No hay datos para mostrar, ingrese un ID valido.'));
      }
      json_output(json_build(200, Model::list('roles', ['id' => $id], 1)));
    } catch (Exception $e) {
      json_output(json_build(400, null, $e->getMessage()));
    }
  }

  function add_role()
  {
    if (!Csrf::validate($_POST['csrf']) || !check_posted_data(['roleName', 'roleDescription', 'selectRoleStatus','csrf'], $_POST)) {
      json_output(json_build(400, null, 'Argumentos insuficientes'));
    }


    try {

      $data = [
        'name' =>clean($_POST['roleName']),
        'description' => clean($_POST['roleDescription']),
        'status' => clean($_POST['selectRoleStatus'])
      ];

      
      if(intval(clean($_POST['idRole']))  == 0){
        if(Model::list('roles', ['name' => clean($_POST['roleName'])]) != null){
          json_output(json_build(400, null, 'El Rol ya existe.'));
        }
        if(!$id = Model::add('roles', $data)) {
          json_output(json_build(400, null, 'Hubo error al guardar el registro'));
        }
        // se guardó con éxito
        json_output(json_build(201, Model::list('roles', ['id' => $id], 1), 'Movimiento agregado con éxito'));
      }else{

        if(empty(rolesModel::unique_name(clean($_POST['roleName']), intval(clean($_POST['idRole']))))){

          if(!$id = Model::update('roles', ['id' => intval(clean($_POST['idRole']))] ,$data)) {
            json_output(json_build(400, null, 'Hubo error al actualizar el registro'));
          }
          json_output(json_build(201, Model::list('roles', ['id' => $id], 1), 'Rol actualizado con éxito'));

        }else{

          json_output(json_build(400, null, 'El Rol ya existe.'));
        }

      }
    } catch (Exception $e) {
      json_output(json_build(400, null, $e->getMessage()));
    }
  }

  function delete_role()
  {
    try {

      if(isset($_POST['idRole']) != null){

        $id = intval(clean(($_POST['idRole'])));

        $data = [
          'status' => 'deleted'
        ];

        if(!$response = Model::update('roles', ['id' => $id] ,$data)) {

          json_output(json_build(400, null, 'Hubo error al borrar el registro.'));
        }

        json_output(json_build(201, null, 'El Rol ha sido eliminado.'));

      }else{

        json_output(json_build(400, null, 'Argumentos insuficientes.'));
      }
    } catch (Exception $e) {
      json_output(json_build(400, null, $e->getMessage()));
    }
  }

  function get_user_roles(){

    try {
      $selectOptions ='';
      $data = rolesModel::get_user_roles();
      if (count($data) > 0) {
        for ($i = 0; $i < count($data); $i++) {
          if ($data[$i]['status'] == 'active'){
            $selectOptions .= '<option value="'.$data[$i]['id'].'">'.$data[$i]['name'].'</option>';
          }
        }
      }
      json_output(json_build(200, $selectOptions));
    } catch (Exception $e) {
      json_output(json_build(400, null, $e->getMessage()));
    }
  }

  function get_permissions_role(){

    try {
      $idRole = intval(clean($_POST['idRole']));
      if ($idRole > 0) {
        $modulos = Model::list('modules', ['status' => 'active']);
        $permisosRol = Model::list('permissions', ['id_role' => $idRole]);
        $permisos = array('r' => 0, 'w' => 0, 'u' => 0, 'd' => 0);
        $permisoRol = array('id_role' => $idRole);

        if(empty($permisosRol))
        {
          for ($i=0; $i < count($modulos) ; $i++) { 

            $modulos[$i]['permisos'] = $permisos;
          }
        }else{
          for ($i=0; $i < count($modulos); $i++) {
            $permisos = array('r' => 0, 'w' => 0, 'u' => 0, 'd' => 0);
            if(isset($permisosRol[$i])){
              $permisos = array(
                          'r' => $permisosRol[$i]['r'], 
                          'w' => $permisosRol[$i]['w'], 
                          'u' => $permisosRol[$i]['u'], 
                          'd' => $permisosRol[$i]['d'] 
                        );
            }
            $modulos[$i]['permisos'] = $permisos;
          }
        }
        $permisoRol['modulos'] = $modulos;
        // $html = getModal("modalPermisos",$permisoRol);
        $data = get_module('permissions', $permisoRol);
        json_output(json_build(200, $data));

      }

      json_output(json_build(400, null, 'Argumentos insuficientes.'));

    } catch (Exception $e) {
      json_output(json_build(400, null, $e->getMessage()));
    }
    
  }

  function add_permissions(){
    try {
      if($_POST)
			{
				$idRole = intval($_POST['idRole']);
				$modulos = $_POST['modulos'];

				Model::remove('permissions', ['id_role' => $idRole],null);
				foreach ($modulos as $modulo) {
          $data = [
              'id_role' => $idRole,
              'id_module' => $modulo['id'],
              'r' => empty($modulo['r']) ? 0 : 1,
              'w' => empty($modulo['w']) ? 0 : 1,
              'u' => empty($modulo['u']) ? 0 : 1,
              'd' => empty($modulo['d']) ? 0 : 1,
          ];
				
					$requestPermiso = Model::add('permissions', $data);
				}
				if($requestPermiso > 0)
				{
					json_output(json_build(201, null, 'Movimiento agregado con éxito'));
				}else{
					json_output(json_build(400, null, 'Hubo error al guardar el registro'));
				}
			}

			json_output(json_build(400, null, 'Argumentos insuficientes.'));

    } catch (Exception $e) {
      json_output(json_build(400, null, $e->getMessage()));
    }
  }

//////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////     AJAX USERS      
/////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////

  function get_users()
  {
    try {
      $data = usersModel::all();

      if (count($data) == 0) {
        json_output(json_build(200, null, 'No hay datos en la tabla.'));
      }

      for ($i = 0; $i < count($data); $i++) {  
        if ($data[$i]['status'] == 'active') {
          $data[$i]['status'] = '<span class="badge badge-lg bg-success">Activo</span>';
        }else{
          $data[$i]['status'] = '<span class="badge badge-lg bg-danger">Inactivo</span>';
        }

        $btnDelete = '';
        $btnEdit = '';

        if ($_SESSION['permissions'][4]['u'] == 1) {
          $btnEdit = ' <button class="dropdown-item rounded-top" onClick="editUser('.$data[$i]['id'].')"><span class="fas fa-edit me-2"></span>Editar</button>';
        }

        if ($_SESSION['permissions'][4]['d'] == 1) {
          $btnDelete = '<button class="dropdown-item text-danger rounded-bottom" onClick="deleteUser('.$data[$i]['id'].')"><span class="fas fa-trash-alt me-2"></span>Eliminar</button>';
        }

        $data[$i]['options'] = sprintf('
          <div class="btn-group">
            <button class="btn btn-link text-dark dropdown-toggle dropdown-toggle-split m-0 p-0" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="icon icon-sm pt-1">
                  <span class="fas fa-ellipsis-h icon-dark"></span> 
                </span>
                <span class="sr-only">Menu</span>
            </button>
            <div class="dropdown-menu py-0">
                <button class="dropdown-item rounded-top" onClick="viewUser('.$data[$i]['id'].')"><span class="fas fa-eye me-2"></span>Detalles</button> 
                %s
                %s
            </div>
          </div>
        ', $btnEdit, $btnDelete);          
      }

      json_output(json_build(200, $data));
    } catch (Exception $e) {
      json_output(json_build(400, null, $e->getMessage()));
    }
  }

  function add_user()
  {
    if (!Csrf::validate($_POST['csrf']) || !check_posted_data(['userName', 'userLastname', 'userPassword', 'userEmail','selectUserRole','selectUserStatus','csrf'], $_POST)) {
      json_output(json_build(400, null, 'Argumentos insuficientes'));
    }


    try {
        if(intval(clean($_POST['idUser'])) == 0){
          $password = empty($_POST['userPassword']) ? password_hash(random_password().AUTH_SALT, PASSWORD_DEFAULT, ['cost' => 10]) : password_hash($_POST['userPassword'].AUTH_SALT, PASSWORD_DEFAULT, ['cost' => 10]);
          $data = [
            'name' => ucwords(strtolower(clean($_POST['userName']))),
            'lastname' => ucwords(strtolower(clean($_POST['userLastname']))),
            'email' => strtolower(clean($_POST['userEmail'])),
            'password' => $password,
            'id_role' => (int) clean($_POST['selectUserRole']),
            'status' => clean($_POST['selectUserStatus']),
          ];
          //Comprobar si ya exste el email
          if(Model::list('users', ['email' => strtolower(clean($_POST['userEmail']))]) != null){
            json_output(json_build(400, null, 'El email ya fue registrado antes por favor ingrese otro.'));
          }
          //Enviar datos al Modelo
          if(!$id = Model::add('users', $data)) {
            json_output(json_build(400, null, 'Hubo error al guardar el registro'));
          }
          // se guardó con éxito
          json_output(json_build(201, Model::list('users', ['id' => $id], 1), 'Movimiento agregado con éxito'));
        }else{
          $password = empty($_POST['userPassword']) ? "" : password_hash($_POST['userPassword'].AUTH_SALT, PASSWORD_DEFAULT, ['cost' => 10]);
          //Comprobar si ya exste el email
          if(usersModel::unique_email(clean($_POST['idUser']), strtolower(clean($_POST['userEmail']))) != null){

            json_output(json_build(400, null, 'El email ya fue registrado antes por favor ingrese otro.'));
            
          }else{
            if($password != ""){
              $data = [
                'name' => ucwords(strtolower(clean($_POST['userName']))),
                'lastname' => ucwords(strtolower(clean($_POST['userLastname']))),
                'email' => strtolower(clean($_POST['userEmail'])),
                'password' => $password,
                'id_role' => (int) clean($_POST['selectUserRole']),
                'status' => clean($_POST['selectUserStatus']),
              ];
            }else{
              $data = [
                'name' => ucwords(clean($_POST['userName'])),
                'lastname' => ucwords(clean($_POST['userLastname'])),
                'email' => strtolower(clean($_POST['userEmail'])),
                'id_role' => (int) clean($_POST['selectUserRole']),
                'status' => clean($_POST['selectUserStatus']),
              ];
            }
            //Enviar datos al Modelo
            if(!$id = Model::update('users', ['id' => clean($_POST['idUser'])] ,$data)) {
              json_output(json_build(400, null, 'Hubo error al guardar el registro'));
            }
            // se guardó con éxito
            json_output(json_build(201, Model::list('users', ['id' => $id], 1), 'Usuario actualizado con éxito'));
          }
        }
      } catch (Exception $e) {
        json_output(json_build(400, null, $e->getMessage()));
      }
  }

  function get_user(){
    try {
      $id = clean(intval($_POST['idUser']));
      if ($id == null) {
        json_output(json_build(400, null, 'No hay datos para mostrar, ingrese un ID valido.'));
      }
      json_output(json_build(201, usersModel::by_id($id)));
    } catch (Exception $e) {
      json_output(json_build(400, null, $e->getMessage()));
    }
  }

  function delete_user()
  {
    try {

      if(isset($_POST['idUser']) != null){

        $id = intval(clean(($_POST['idUser'])));

        $data = [
          'status' => 'deleted'
        ];

        if(!$response = Model::update('users', ['id' => $id] ,$data)) {

          json_output(json_build(400, null, 'Hubo error al borrar el registro.'));
        }

        json_output(json_build(201, null, 'El Usuario ha sido eliminado.'));

      }else{

        json_output(json_build(400, null, 'Argumentos insuficientes.'));
      }
    } catch (Exception $e) {
      json_output(json_build(400, null, $e->getMessage()));
    }
  }


  function activate_2fa(){
    if (!Csrf::validate($_POST['csrf']) || !check_posted_data(['code', 'idUserCode', 'secretKey', 'csrf'], $_POST)) {
      json_output(json_build(400, null, 'Argumentos insuficientes'));
    }
    try {

      $code = clean($_POST['code']);
      $secret = clean($_POST['secretKey']);
      $id = clean($_POST['idUserCode']);

      if(verify_g_code($secret, $code)){

        $data = [
          '2fa_key' => $secret
        ];

        if(!Model::update('users', ['id' => $id] ,$data)) {

          json_output(json_build(400, null, 'Hubo un error al activar el servicio.'));
        }

        json_output(json_build(201, null, 'Se activo correctamente el servico de Google Authenticator.'));

      }else{

        json_output(json_build(400, null, 'El código es incorrecto.'));
      }
    } catch (Exception $e) {
      json_output(json_build(400, null, $e->getMessage()));
    }
  }

  function desactive_2fa(){
    if (!Csrf::validate($_POST['csrf']) || !check_posted_data(['idUser', 'csrf'], $_POST)) {
      json_output(json_build(400, null, 'Argumentos insuficientes'));
    }
    try {

      $id = intval(clean($_POST['idUser']));


      $data = [
        '2fa_key' => null
      ];

      if(!Model::update('users', ['id' => $id] ,$data)) {

        json_output(json_build(400, null, 'Hubo un error al desactivar el servicio.'));
      }

      json_output(json_build(201, null, 'Se desactivo correctamente el servico de Google Authenticator.'));

      
    } catch (Exception $e) {
      json_output(json_build(400, null, $e->getMessage()));
    }
  }

//////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////     AJAX BRANDS      
/////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////

  function get_brands()
  {
    try {
      $data = brandsModel::all();

      if (count($data) == 0) {
        json_output(json_build(200, null, 'No hay datos en la tabla.'));
      }

      for ($i = 0; $i < count($data); $i++) {  
        if ($data[$i]['status'] == 'active') {
          $data[$i]['status'] = '<span class="badge badge-lg bg-success">Activo</span>';
        }else{
          $data[$i]['status'] = '<span class="badge badge-lg bg-danger">Inactivo</span>';
        }

        $btnDelete = '';
        $btnEdit = '';

        if ($_SESSION['permissions'][7]['u'] == 1) {
          $btnEdit = '<button class="dropdown-item rounded-top" onClick="editBrnad('.$data[$i]['id'].')"><span class="fas fa-edit me-2"></span>Editar</button> ';
        }

        if ($_SESSION['permissions'][7]['d'] == 1) {
          $btnDelete = '<button class="dropdown-item text-danger rounded-bottom" onClick="deleteBrand('.$data[$i]['id'].')"><span class="fas fa-trash-alt me-2"></span>Eliminar</button>';
        }

        $data[$i]['options'] = sprintf('
          <div class="btn-group">
            <button class="btn btn-link text-dark dropdown-toggle dropdown-toggle-split m-0 p-0" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="icon icon-sm pt-1">
                  <span class="fas fa-ellipsis-h icon-dark"></span> 
                </span>
                <span class="sr-only">Menu</span>
            </button>
            <div class="dropdown-menu py-0">
                %s
                %s
            </div>
          </div>
        ', $btnEdit, $btnDelete);          
      }

      json_output(json_build(200, $data));
    } catch (Exception $e) {
      json_output(json_build(400, null, $e->getMessage()));
    }
  }

  function get_brand()
  {
    try {
      $id = intval(clean($_POST['idBrand']));

      if ($id == null) {
        json_output(json_build(400, null, 'No hay datos para mostrar, ingrese un ID valido.'));
      }
      json_output(json_build(200, Model::list('brands', ['id' => $id], 1)));
    } catch (Exception $e) {
      json_output(json_build(400, null, $e->getMessage()));
    }
  }

  function add_brand()
  {

    if (!Csrf::validate($_POST['csrf']) || !check_posted_data(['brandName','selectBrandStatus','csrf'], $_POST)) {
      json_output(json_build(400, null, 'Argumentos insuficientes'));
    }

    try {

      $data = [
        'name' => ucfirst(clean($_POST['brandName'])),
        'status' => clean($_POST['selectBrandStatus']),
        'url' => str_replace(' ', '-', strtolower(clear_string(clean($_POST['brandName']))))
      ];

      
      if(intval(clean($_POST['idBrand']))  == 0){
        if(Model::list('brands', ['name' => clean($_POST['brandName'])]) != null){
          json_output(json_build(400, null, 'La Marca ya existe.'));
        }
        if(!$id = Model::add('brands', $data)) {
          json_output(json_build(400, null, 'Hubo error al guardar el registro'));
        }
        // se guardó con éxito
        json_output(json_build(201, Model::list('brands', ['id' => $id], 1), 'Movimiento agregado con éxito'));
      }else{

        if(empty(brandsModel::unique_name(clean($_POST['brandName']), intval(clean($_POST['idBrand']))))){

          if(!$id = Model::update('brands', ['id' => intval(clean($_POST['idBrand']))] ,$data)) {
            json_output(json_build(400, null, 'Hubo error al actualizar el registro'));
          }
          json_output(json_build(201, Model::list('brands', ['id' => $id], 1), 'Marca actualizada con éxito'));

        }else{

          json_output(json_build(400, null, 'La Marca ya existe.'));
        }

      }
    } catch (Exception $e) {
      json_output(json_build(400, null, $e->getMessage()));
    }
  }

  function delete_brand()
  {
    try {

      if(isset($_POST['idBrand']) != null){

        $id = intval(clean(($_POST['idBrand'])));

        $data = [
          'status' => 'deleted'
        ];

        if(!$response = Model::update('brands', ['id' => $id] ,$data)) {

          json_output(json_build(400, null, 'Hubo error al borrar el registro.'));
        }

        json_output(json_build(201, null, 'La Marca ha sido eliminado.'));

      }else{

        json_output(json_build(400, null, 'Argumentos insuficientes.'));
      }
    } catch (Exception $e) {
      json_output(json_build(400, null, $e->getMessage()));
    }
  }

//////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////     AJAX CATEGORIES      
/////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////

  function get_categories()
  {
    try {
      $data = categoriesModel::all();

      if (count($data) == 0) {
        json_output(json_build(200, null, 'No hay datos en la tabla.'));
      }

      for ($i = 0; $i < count($data); $i++) {  
        if ($data[$i]['status'] == 'active') {
          $data[$i]['status'] = '<span class="badge badge-lg bg-success">Activo</span>';
        }else{
          $data[$i]['status'] = '<span class="badge badge-lg bg-danger">Inactivo</span>';
        }

        $btnDelete = '';
        $btnEdit = '';

        if ($_SESSION['permissions'][8]['u'] == 1) {
          $btnEdit = '<button class="dropdown-item rounded-top" onClick="editCategory('.$data[$i]['id'].')"><span class="fas fa-edit me-2"></span>Editar</button> ';
        }

        if ($_SESSION['permissions'][8]['d'] == 1) {
          $btnDelete = '<button class="dropdown-item text-danger rounded-bottom" onClick="deleteCategory('.$data[$i]['id'].')"><span class="fas fa-trash-alt me-2"></span>Eliminar</button>';
        }

        $data[$i]['options'] = sprintf('
          <div class="btn-group">
            <button class="btn btn-link text-dark dropdown-toggle dropdown-toggle-split m-0 p-0" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="icon icon-sm pt-1">
                  <span class="fas fa-ellipsis-h icon-dark"></span> 
                </span>
                <span class="sr-only">Menu</span>
            </button>
            <div class="dropdown-menu py-0">
                %s
                %s
            </div>
          </div>
        ', $btnEdit, $btnDelete);          
      }

      json_output(json_build(200, $data));
    } catch (Exception $e) {
      json_output(json_build(400, null, $e->getMessage()));
    }
  }

  function get_category()
  {
    try {
      $id = intval(clean($_POST['idCategory']));

      if ($id == null) {
        json_output(json_build(400, null, 'No hay datos para mostrar, ingrese un ID valido.'));
      }
      json_output(json_build(200, Model::list('categories', ['id' => $id], 1)));
    } catch (Exception $e) {
      json_output(json_build(400, null, $e->getMessage()));
    }
  }

  function add_category()
  {

    if (!Csrf::validate($_POST['csrf']) || !check_posted_data(['categoryName','selectCategoryStatus', 'selectCategoryBrand','csrf'], $_POST)) {
      json_output(json_build(400, null, 'Argumentos insuficientes'));
    }

    try {

      $data = [
        'name' => ucfirst(clean($_POST['categoryName'])),
        'status' => clean($_POST['selectCategoryStatus']),
        'id_brand' => clean($_POST['selectCategoryBrand']),
        'url' => str_replace(' ', '-', strtolower(clear_string(clean($_POST['categoryName']))))
      ];
      
      if(intval(clean($_POST['idCategory']))  == 0){
        if(Model::list('categories', ['name' => clean($_POST['categoryName']), 'id_brand' => clean($_POST['selectCategoryBrand'])]) != null){
          json_output(json_build(400, null, 'La Categoría ya existe.'));
        }
        if(!$id = Model::add('categories', $data)) {
          json_output(json_build(400, null, 'Hubo error al guardar el registro'));
        }
        // se guardó con éxito
        json_output(json_build(201, Model::list('categories', ['id' => $id], 1), 'Movimiento agregado con éxito'));
      }else{

        if(empty(categoriesModel::unique_name(clean($_POST['categoryName']), intval(clean($_POST['idCategory'])), intval(clean($_POST['selectCategoryBrand']))))){

          if(!$id = Model::update('categories', ['id' => intval(clean($_POST['idCategory']))] ,$data)) {
            json_output(json_build(400, null, 'Hubo error al actualizar el registro'));
          }
          json_output(json_build(201, Model::list('categories', ['id' => $id], 1), 'Categoría actualizada con éxito'));

        }else{

          json_output(json_build(400, null, 'La Categoría ya existe.'));
        }

      }
    } catch (Exception $e) {
      json_output(json_build(400, null, $e->getMessage()));
    }
  }

  function delete_category()
  {
    try {

      if(isset($_POST['idCategory']) != null){

        $id = intval(clean(($_POST['idCategory'])));

        $data = [
          'status' => 'deleted'
        ];

        if(!$response = Model::update('categories', ['id' => $id] ,$data)) {

          json_output(json_build(400, null, 'Hubo error al borrar el registro.'));
        }

        json_output(json_build(201, null, 'La Categoría ha sido eliminado.'));

      }else{

        json_output(json_build(400, null, 'Argumentos insuficientes.'));
      }
    } catch (Exception $e) {
      json_output(json_build(400, null, $e->getMessage()));
    }
  }

  function get_category_brand(){

    try {
      $selectOptions ='';
      $data = Model::list('brands', ['status' => 'active']);
      if (count($data) > 0) {
        for ($i = 0; $i < count($data); $i++) {
          if ($data[$i]['status'] == 'active'){
            $selectOptions .= '<option value="'.$data[$i]['id'].'">'.$data[$i]['name'].'</option>';
          }
        }
      }
      json_output(json_build(200, $selectOptions));
    } catch (Exception $e) {
      json_output(json_build(400, null, $e->getMessage()));
    }
  }

//////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////     AJAX SUBCATEGORIES      
/////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////

  function get_subcategories()
  {
    try {
      $data = subcategoriesModel::all();

      if (count($data) == 0) {
        json_output(json_build(200, null, 'No hay datos en la tabla.'));
      }

      for ($i = 0; $i < count($data); $i++) {  
        if ($data[$i]['status'] == 'active') {
          $data[$i]['status'] = '<span class="badge badge-lg bg-success">Activo</span>';
        }else{
          $data[$i]['status'] = '<span class="badge badge-lg bg-danger">Inactivo</span>';
        }

        $btnDelete = '';
        $btnEdit = '';

        if ($_SESSION['permissions'][9]['u'] == 1) {
          $btnEdit = '<button class="dropdown-item rounded-top" onClick="editSubcategory('.$data[$i]['id'].')"><span class="fas fa-edit me-2"></span>Editar</button> ';
        }

        if ($_SESSION['permissions'][9]['d'] == 1) {
          $btnDelete = '<button class="dropdown-item text-danger rounded-bottom" onClick="deleteSubcategory('.$data[$i]['id'].')"><span class="fas fa-trash-alt me-2"></span>Eliminar</button>';
        }

        $data[$i]['options'] = sprintf('
          <div class="btn-group">
            <button class="btn btn-link text-dark dropdown-toggle dropdown-toggle-split m-0 p-0" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="icon icon-sm pt-1">
                  <span class="fas fa-ellipsis-h icon-dark"></span> 
                </span>
                <span class="sr-only">Menu</span>
            </button>
            <div class="dropdown-menu py-0">
                %s
                %s
            </div>
          </div>
        ', $btnEdit, $btnDelete);          
      }

      json_output(json_build(200, $data));
    } catch (Exception $e) {
      json_output(json_build(400, null, $e->getMessage()));
    }
  }

  function get_subcategory()
  {
    try {
      $id = intval(clean($_POST['idSubcategory']));

      if ($id == null) {
        json_output(json_build(400, null, 'No hay datos para mostrar, ingrese un ID valido.'));
      }
      json_output(json_build(200, subcategoriesModel::by_id($id)));
    } catch (Exception $e) {
      json_output(json_build(400, null, $e->getMessage()));
    }
  }

  function add_subcategory()
  {

    if (!Csrf::validate($_POST['csrf']) || !check_posted_data(['subcategoryName','selectSubcategoryStatus', 'selectSubcategoryCategories','csrf'], $_POST)) {
      json_output(json_build(400, null, 'Argumentos insuficientes'));
    }

    try {

      $data = [
        'name' => ucfirst(clean($_POST['subcategoryName'])),
        'status' => clean($_POST['selectSubcategoryStatus']),
        'id_category' => clean($_POST['selectSubcategoryCategories']),
        'url' => str_replace(' ', '-', strtolower(clear_string(clean($_POST['subcategoryName']))))
      ];
      
      if(intval(clean($_POST['idSubcategory']))  == 0){
        if(Model::list('subcategories', ['name' => clean($_POST['subcategoryName']), 'id_category' => clean($_POST['selectSubcategoryCategories'])]) != null){
          json_output(json_build(400, null, 'La Subcategoría ya existe.'));
        }
        if(!$id = Model::add('subcategories', $data)) {
          json_output(json_build(400, null, 'Hubo error al guardar el registro'));
        }
        // se guardó con éxito
        json_output(json_build(201, Model::list('subcategories', ['id' => $id], 1), 'Movimiento agregado con éxito'));
      }else{

        if(empty(subcategoriesModel::unique_name(clean($_POST['subcategoryName']), intval(clean($_POST['idSubcategory'])), intval(clean($_POST['selectSubcategoryCategories']))))){

          if(!$id = Model::update('subcategories', ['id' => intval(clean($_POST['idSubcategory']))] ,$data)) {
            json_output(json_build(400, null, 'Hubo error al actualizar el registro'));
          }
          json_output(json_build(201, Model::list('subcategories', ['id' => $id], 1), 'Subcategoría actualizada con éxito'));

        }else{

          json_output(json_build(400, null, 'La Subcategoría ya existe.'));
        }

      }
    } catch (Exception $e) {
      json_output(json_build(400, null, $e->getMessage()));
    }
  }

  function delete_subcategory()
  {
    try {

      if(isset($_POST['idSubcategory']) != null){

        $id = intval(clean(($_POST['idSubcategory'])));

        $data = [
          'status' => 'deleted'
        ];

        if(!$response = Model::update('subcategories', ['id' => $id] ,$data)) {

          json_output(json_build(400, null, 'Hubo error al borrar el registro.'));
        }

        json_output(json_build(201, null, 'La Categoría ha sido eliminado.'));

      }else{

        json_output(json_build(400, null, 'Argumentos insuficientes.'));
      }
    } catch (Exception $e) {
      json_output(json_build(400, null, $e->getMessage()));
    }
  }

  function get_subcategory_categories($brand){

    try {
      $selectOptions ='';
      $data = Model::list('categories', ['status' => 'active', 'id_brand' => $brand]);
      if (count($data) > 0) {
        for ($i = 0; $i < count($data); $i++) {
          if ($data[$i]['status'] == 'active'){
            $selectOptions .= '<option value="'.$data[$i]['id'].'">'.$data[$i]['name'].'</option>';
          }
        }
      }
      json_output(json_build(200, $selectOptions));
    } catch (Exception $e) {
      json_output(json_build(400, null, $e->getMessage()));
    }
  }

//////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////     AJAX SUBCATEGORIES      
/////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////

  function get_products()
  {
    try {
      $data = productsModel::all();

      if (count($data) == 0) {
        json_output(json_build(200, null, 'No hay datos en la tabla.'));
      }

      for ($i = 0; $i < count($data); $i++) {  
        if ($data[$i]['status'] == 'active') {
          $data[$i]['status'] = '<span class="badge badge-lg bg-success">Activo</span>';
        }else{
          $data[$i]['status'] = '<span class="badge badge-lg bg-danger">Inactivo</span>';
        }

        $btnDelete = '';
        $btnEdit = '';

        if ($_SESSION['permissions'][6]['u'] == 1) {
          $btnEdit = '<button class="dropdown-item rounded-top" onClick="editProduct(`'.$data[$i]['id'].'`)"><span class="fas fa-edit me-2"></span>Editar</button> ';
        }

        if ($_SESSION['permissions'][6]['d'] == 1) {
          $btnDelete = '<button class="dropdown-item text-danger rounded-bottom" onClick="deleteProduct(`'.$data[$i]['id'].'`)"><span class="fas fa-trash-alt me-2"></span>Eliminar</button>';
        }

        $data[$i]['options'] = sprintf('
          <div class="btn-group">
            <button class="btn btn-link text-dark dropdown-toggle dropdown-toggle-split m-0 p-0" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="icon icon-sm pt-1">
                  <span class="fas fa-ellipsis-h icon-dark"></span> 
                </span>
                <span class="sr-only">Menu</span>
            </button>
            <div class="dropdown-menu py-0">
                <button class="dropdown-item rounded-top" onClick="viewProduct(`'.$data[$i]['id'].'`)"><span class="fas fa-eye me-2"></span>Detalles</button> 
                %s
                %s
            </div>
          </div>
        ', $btnEdit, $btnDelete);          
      }

      json_output(json_build(200, $data));
    } catch (Exception $e) {
      json_output(json_build(400, null, $e->getMessage()));
    }
  }

  function get_product()
  {
    try {
      $id = clean($_POST['idProduct']);

      if ($id == null) {
        json_output(json_build(400, null, 'No hay datos para mostrar, ingrese un ID valido.'));
      }
      json_output(json_build(200, productsModel::by_id($id)));
    } catch (Exception $e) {
      json_output(json_build(400, null, $e->getMessage()));
    }
  }

  function add_product()
  {

    if (!Csrf::validate($_POST['csrf']) || !check_posted_data([ 'productSku',
                                                                'productEan', 
                                                                'productTitle',
                                                                'productStock',
                                                                'productPrice',
                                                                'selectProductBrand',
                                                                'selectProductCategory',
                                                                'selectPeroductSubcategory',
                                                                'selectProductImg',
                                                                'selectPeroductStatus',
                                                                'productHeight',
                                                                'productWidth',
                                                                'productLength',
                                                                'selectProductDimensionsUnit',
                                                                'selectProductWeight',
                                                                'selectProductWeightUnit',
                                                                'productDescription',
                                                                'csrf'], 
                                                                $_POST)) {
      json_output(json_build(400, null, 'Argumentos insuficientes'));
    }

    
    try {

      $newness = 'off';
      $bestSeller = 'off';
      $offert = 'off';
      $offerPrice = 0;

      if(isset($_POST['productNewness'])){
        $newness = 'on';
      }
      if(isset($_POST['productBestSeller'])){
        $bestSeller = 'on';
      }
      if(isset($_POST['productOffer'])){
        $offert = 'on';
      }
      if($_POST['productOfferPrice'] != ''){
        $offerPrice = clean($_POST['productOfferPrice']);
      }

      $data = [
        'id' => strtoupper(clean($_POST['productSku'])),
        'title' => strtoupper(clean($_POST['productTitle'])),
        'description' => $_POST['productDescription'],
        'ean' => clean($_POST['productEan']),
        'stock' => clean($_POST['productStock']),
        'standard_price' => clean($_POST['productPrice']),
        'extended_price' => $offerPrice,
        'keywords' => clean($_POST['productKeywords']),
        'newness' => $newness,
        'top_seller' => $bestSeller,
        'offer' => $offert,
        'length' => clean($_POST['productLength']),
        'width' => clean($_POST['productWidth']),
        'height' => clean($_POST['productHeight']),
        'dimensions_unit' => clean($_POST['selectProductDimensionsUnit']),
        'weight' => clean($_POST['selectProductWeight']),
        'weight_unit' => clean($_POST['selectProductWeightUnit']),
        'id_brand' => clean($_POST['selectProductBrand']),
        'id_category' => clean($_POST['selectProductCategory']),
        'id_subcategory' => clean($_POST['selectPeroductSubcategory']),
        'status' => clean($_POST['selectPeroductStatus'])
      ];
      
      if(clean($_POST['idProduct'])  == ''){
        if(Model::list('products', ['id' => clean($_POST['productSku'])]) != null){
          json_output(json_build(400, null, 'El SKU ya existe.'));
        }
        if(Model::list('products', ['ean' => clean($_POST['productEan'])]) != null){
          json_output(json_build(400, null, 'El EAN ya existe.'));
        }

        if(Model::add('products', $data)) {
          json_output(json_build(400, null, 'Hubo error al guardar el registro'));
        }

        $product = productsModel::by_id($data['id']);
        $brand = strtoupper($product['brand']);
        $cant = intval($_POST['selectProductImg']);

        for ($i=97; $i < (97 + $cant); $i++) { 
          $img = 'products/'.$brand.'/'.$product['id'].'_'.chr($i).'.jpg';
          Model::add('product_images', ['id_product' => $product['id'], 'img' => $img]);
        }
        // se guardó con éxito
        json_output(json_build(201, $product['id'], 'Movimiento agregado con éxito'));

      }else{

        if(empty(productsModel::unique_ean(clean($_POST['productEan']), clean($_POST['idProduct'])))){

          unset($data['id']);

          if(!Model::update('products', ['id' => clean($_POST['idProduct'])] ,$data)) {
            json_output(json_build(400, null, 'Hubo error al actualizar el registro'));
          }
          
          // Inserta nuevamente las imágenes
          $product = productsModel::by_id($_POST['idProduct']);

          if(intval($product['images']) != intval($_POST['selectProductImg'])){

            // Elimina todas las imágenes de la tabla
            Model::remove('product_images', ['id_product' => clean($_POST['idProduct'])]);

            $brand = strtoupper($product['brand']);
            $cant = intval($_POST['selectProductImg']);

            for ($i=97; $i < (97 + $cant); $i++) { 
              $img = 'products/'.$brand.'/'.$product['id'].'_'.chr($i).'.jpg';
              Model::add('product_images', ['id_product' => $product['id'], 'img' => $img]);
            }

          }

          json_output(json_build(201, Model::list('products', ['id' => $product['id']], 1), 'Producto actualizada con éxito'));

        }else{

          json_output(json_build(400, null, 'El EAN ya existe.'));
        }

      }
    } catch (Exception $e) {
      json_output(json_build(400, null, $e->getMessage()));
    }
  }

  function delete_product()
  {
    try {

      if(isset($_POST['idProduct']) != null){

        $id = clean(($_POST['idProduct']));

        $data = [
          'status' => 'deleted'
        ];

        if(!$response = Model::update('products', ['id' => $id] ,$data)) {

          json_output(json_build(400, null, 'Hubo error al borrar el registro.'));
        }

        json_output(json_build(201, null, 'El producto ha sido eliminado.'));

      }else{

        json_output(json_build(400, null, 'Argumentos insuficientes.'));
      }
    } catch (Exception $e) {
      json_output(json_build(400, null, $e->getMessage()));
    }
  }

  function get_product_subcategory($category){

    try {
      $selectOptions ='';
      $data = Model::list('subcategories', ['status' => 'active', 'id_category' => $category]);
      if (count($data) > 0) {
        for ($i = 0; $i < count($data); $i++) {
          if ($data[$i]['status'] == 'active'){
            $selectOptions .= '<option value="'.$data[$i]['id'].'">'.$data[$i]['name'].'</option>';
          }
        }
      }
      json_output(json_build(200, $selectOptions));
    } catch (Exception $e) {
      json_output(json_build(400, null, $e->getMessage()));
    }
  }


//////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////     AJAX USERS      
/////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////

  function get_customers()
  {
    try {
      $data = customersModel::all();

      if (count($data) == 0) {
        json_output(json_build(200, null, 'No hay datos en la tabla.'));
      }

      for ($i = 0; $i < count($data); $i++) {  
        if ($data[$i]['status'] == 'active') {
          $data[$i]['status'] = '<span class="badge badge-lg bg-success">Activo</span>';
        }else{
          $data[$i]['status'] = '<span class="badge badge-lg bg-danger">Inactivo</span>';
        }

        $btnDelete = '';
        $btnEdit = '';

        if ($_SESSION['permissions'][5]['u'] == 1) {
          $btnEdit = ' <button class="dropdown-item rounded-top" onClick="editCustomer('.$data[$i]['id'].')"><span class="fas fa-edit me-2"></span>Editar</button>';
        }

        if ($_SESSION['permissions'][5]['d'] == 1) {
          $btnDelete = '<button class="dropdown-item text-danger rounded-bottom" onClick="deleteCustomer('.$data[$i]['id'].')"><span class="fas fa-trash-alt me-2"></span>Eliminar</button>';
        }

        $data[$i]['options'] = sprintf('
          <div class="btn-group">
            <button class="btn btn-link text-dark dropdown-toggle dropdown-toggle-split m-0 p-0" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="icon icon-sm pt-1">
                  <span class="fas fa-ellipsis-h icon-dark"></span> 
                </span>
                <span class="sr-only">Menu</span>
            </button>
            <div class="dropdown-menu py-0">
                <button class="dropdown-item rounded-top" onClick="viewCustomer('.$data[$i]['id'].')"><span class="fas fa-eye me-2"></span>Detalles</button> 
                %s
                %s
            </div>
          </div>
        ', $btnEdit, $btnDelete);          
      }

      json_output(json_build(200, $data));
    } catch (Exception $e) {
      json_output(json_build(400, null, $e->getMessage()));
    }
  }

  function add_customer()
  {
    if (!Csrf::validate($_POST['csrf']) || !check_posted_data(['customerName', 'customerLastname', 'customerPassword', 'customerEmail','selectCustomerStatus','customerSae','csrf'], $_POST)) {
      json_output(json_build(400, null, 'Argumentos insuficientes'));
    }

    $b2b = 'off';
    $dropshipping = 'off';
    $shipping = 'off';

    if(isset($_POST['customerB2b'])){
      $b2b = 'on';
    }
    if(isset($_POST['customerDs'])){
      $dropshipping = 'on';
    }
    if(isset($_POST['customerShipping'])){
      $shipping = 'on';
    }


    try {
        if(intval(clean($_POST['idCustomer'])) == 0){
          $password = empty($_POST['customerPassword']) ? password_hash(random_password().AUTH_SALT, PASSWORD_DEFAULT, ['cost' => 10]) : password_hash($_POST['customerPassword'].AUTH_SALT, PASSWORD_DEFAULT, ['cost' => 10]);
          $data = [
            'name' => ucwords(strtolower(clean($_POST['customerName']))),
            'lastname' => ucwords(strtolower(clean($_POST['customerLastname']))),
            'email' => strtolower(clean($_POST['customerEmail'])),
            'password' => $password,
            'id_role' => 3,
            'status' => clean($_POST['selectCustomerStatus']),
          ];
          //Comprobar si ya exste el email
          if(Model::list('users', ['email' => strtolower(clean($_POST['customerEmail']))]) != null){
            json_output(json_build(400, null, 'El email ya fue registrado antes por favor ingrese otro.'));
          }
          //Comprobar si ya exste el número de SAE
          if(Model::list('customer_data', ['sae' => clean($_POST['customerSae'])]) != null){
            json_output(json_build(400, null, 'El número de cliente SAE ya fue registrado antes por favor ingrese otro.'));
          }
          //Enviar datos al Modelo
          if(!$id = Model::add('users', $data)) {
            json_output(json_build(400, null, 'Hubo error al guardar el registro'));
          }

          $customer_data = [
            'id_user' => $id,
            'sae' => clean($_POST['customerSae']),
            'b2b' => $b2b,
            'dropshipping' => $dropshipping,
            'shipping' => $shipping
          ];

          if(!$id_data = Model::add('customer_data', $customer_data)) {
            json_output(json_build(400, null, 'Hubo error al guardar el registro'));
          }

          // se guardó con éxito
          json_output(json_build(201, Model::list('users', ['id' => $id], 1), 'Movimiento agregado con éxito'));
        }else{
          $password = empty($_POST['customerPassword']) ? "" : password_hash($_POST['customerPassword'].AUTH_SALT, PASSWORD_DEFAULT, ['cost' => 10]);
          //Comprobar si ya exste el email
          if(customersModel::unique_email(clean($_POST['idCustomer']), strtolower(clean($_POST['customerEmail']))) != null){

            json_output(json_build(400, null, 'El email ya fue registrado antes por favor ingrese otro.'));
            
          }else{

            if(customersModel::unique_sae(clean($_POST['idCustomer']), intval(clean($_POST['customerSae']))) != null){
              json_output(json_build(400, null, 'El número de cliente SAE ya fue registrado antes por favor ingrese otro.'));
            }

            if($password != ""){
              $data = [
                'name' => ucwords(strtolower(clean($_POST['customerName']))),
                'lastname' => ucwords(strtolower(clean($_POST['customerLastname']))),
                'email' => strtolower(clean($_POST['customerEmail'])),
                'password' => $password,
                'id_role' => 3,
                'status' => clean($_POST['selectCustomerStatus']),
              ];
            }else{
              $data = [
                'name' => ucwords(strtolower(clean($_POST['customerName']))),
                'lastname' => ucwords(strtolower(clean($_POST['customerLastname']))),
                'email' => strtolower(clean($_POST['customerEmail'])),
                'id_role' => 3,
                'status' => clean($_POST['selectCustomerStatus']),
              ];
            }
            //Enviar datos al Modelo
            if(!$id = Model::update('users', ['id' => clean($_POST['idCustomer'])] ,$data)) {
              json_output(json_build(400, null, 'Hubo error al guardar el registro'));
            }

            $customer_data = [
              // 'id_user' => $id,
              'sae' => clean($_POST['customerSae']),
              'b2b' => $b2b,
              'dropshipping' => $dropshipping,
              'shipping' => $shipping
            ];

            if(!$id_data = Model::update('customer_data', ['id_user' => clean($_POST['idCustomer'])] ,$customer_data)) {
              json_output(json_build(400, null, 'Hubo error al guardar el registro'));
            }


            // se guardó con éxito
            json_output(json_build(201, Model::list('users', ['id' => $id], 1), 'Cliente actualizado con éxito'));
          }
        }
      } catch (Exception $e) {
        json_output(json_build(400, null, $e->getMessage()));
      }
  }

  function get_customer(){
    try {
      $id = clean(intval($_POST['idCustomer']));
      if ($id == null) {
        json_output(json_build(400, null, 'No hay datos para mostrar, ingrese un ID valido.'));
      }

      $customer = customersModel::by_id($id);
      $customer_sae = Api::show('clientes', $customer['sae']);

      $data = [
        'customer' => $customer,
        'customer_sae' => $customer_sae['detalle'][0]
      ];

      json_output(json_build(201, $data));
    } catch (Exception $e) {
      json_output(json_build(400, null, $e->getMessage()));
    }
  }

  function delete_customer()
  {
    try {

      if(isset($_POST['idCustomer']) != null){

        $id = intval(clean(($_POST['idCustomer'])));

        $data = [
          'status' => 'deleted'
        ];

        if(!$response = Model::update('users', ['id' => $id] ,$data)) {

          json_output(json_build(400, null, 'Hubo error al borrar el registro.'));
        }

        json_output(json_build(201, null, 'El Cliente ha sido eliminado.'));

      }else{

        json_output(json_build(400, null, 'Argumentos insuficientes.'));
      }
    } catch (Exception $e) {
      json_output(json_build(400, null, $e->getMessage()));
    }
  }


//////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////     AJAX LOGIN      
/////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////

  function forgot_password(){
    if (!Csrf::validate($_POST['csrf']) || !check_posted_data(['userEmail','csrf'], $_POST)) {
      json_output(json_build(400, null, 'La sesión ya expiro o faltan argumentos.'));
    }

    try {

      if($_POST['userEmail'] != null){

        $email =strtolower(clean($_POST['userEmail']));

        if(!$user = Model::list('users', ['email' => $email, 'status' => 'active'] , 1)) {
          json_output(json_build(400, null, 'El usuario no existe.'));
        }

        Model::update('users', ['id' => $user['id'], 'status' => 'active'], ['token' => generate_token()]);


        $recovery = Model::list('users', ['email' => $email, 'status' => 'active'] , 1);

        $data= [
          'email' => $recovery['email'],
          'name' => $recovery['name'],
          'url' => URL.'login/recovery-password/'.$recovery['email'].'/'.$recovery['token']
        ];

        $email = new ajaxController;

        $email->email_recovery($data);

        if($email){
          
          Flasher::new('Se envío un email a tu correo para continuar con el proceso.', 'success');
          json_output(json_build(201, null, 'Se ha enviado un correo con los datos de recuperación.'));
        }

        
      }else{

        json_output(json_build(400, null, 'Argumentos insuficientes.'));
      }
    } catch (Exception $e) {
      json_output(json_build(400, null, $e->getMessage()));
    }
  }

  function email_recovery($data=[])
  {
    try {
      $email   = $data['email'];
      $subject = sprintf('[%s] Recuperación de contraseña.', get_sitename());
      $body    = '
          <div class="text" style="padding: 0 2.5em; text-align: center;">
            <h2>Recuperación de contraseña</h2>
            <h3>¡Hola '.$data['name'].'!</h3>
            <p>Se ha solicitado la recuperación de tu cuenta <span class="text-success">'.$data['email'].'</span></p>
            <p>Para continuar con la recuperación haz click en el botton reestablecer contraseña.</p>
            <p><a href="'.$data['url'].'" class="btn btn-primary">Reestablecer Contraseña</a></p>
          </div>
          <div>
            <p class="card-text"><small>Si no funciona el botón puedes copiar y pegar en tu explorador el siguiente enlace: <br> 
            <span class="text-success">'.$data['url'].'</span></small></p>
          </div>
      ';
      $alt     = 'Recuperación de contraseña Gava Design Panel.';
      send_email(get_siteemail(), $email, $subject, $body, $alt);

      return true;

    } catch (Exception $e) {
      echo $e->getMessage();
    }
  }

  function recovery_password(){
    if (!Csrf::validate($_POST['csrf']) || !check_posted_data(['userEmail','csrf','userToken','newPassword','confirm_password'], $_POST)) {
      // Flasher::new('Acceso no autorizado.', 'danger');
      // Redirect::back();
      json_output(json_build(400, null, 'La sesión ya expiro o faltan argumentos.'));
    }

    try {

      if($_POST['userEmail'] != null){

        $email =strtolower(clean($_POST['userEmail']));
        $token = clean($_POST['userToken']);
        $newPassword = clean($_POST['newPassword']);
        $retypePassword= clean($_POST['confirm_password']);

        if(!$user = Model::list('users', ['email' => $email, 'status' => 'active', 'token' => $token] , 1)) {
          json_output(json_build(400, null, 'Datos incorrectos.'));
        }

        if($newPassword != $retypePassword){
          json_output(json_build(400, null, 'Las contraseñas no coinsiden.'));
        }

        $password = password_hash($newPassword.AUTH_SALT, PASSWORD_DEFAULT, ['cost' => 10]);

        Model::update('users', ['id' => $user['id'], 'status' => 'active'], ['token' => '', 'password' => $password]);

        Flasher::new('Contraseña actualizada correctamente.', 'success');
        json_output(json_build(201, null, 'La contraseña se actualizo.'));
        
      }else{

        json_output(json_build(400, null, 'Argumentos insuficientes.'));
      }
    } catch (Exception $e) {
      json_output(json_build(400, null, $e->getMessage()));
    }

  }

  //////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////     AJAX POS      
/////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////



  function get_users_pos(){

    try {
      $selectOptions ='<option value="" selected>Selecciona un Cliente</option>';
      $data = customersModel::all_on_pos();
      if (count($data) > 0) {
        for ($i = 0; $i < count($data); $i++) {
          if ($data[$i]['status'] == 'active'){
            $selectOptions .= '<option value="'.$data[$i]['id'].'">'.$data[$i]['sae'].'-'.$data[$i]['name'].' '.$data[$i]['lastname'].'</option>';
          }
        }
      }
      json_output(json_build(200, $selectOptions));
    } catch (Exception $e) {
      json_output(json_build(400, null, $e->getMessage()));
    }
  }

  function get_products_pos()
  {
    try {
      $product = clean($_POST['productData']);

      if ($product == null) {
        json_output(json_build(400, null, 'No hay datos para mostrar, ingrese un ID valido.'));
      }

      $data = productsModel::search_product($product);

      $module = get_module('productsPos', $data);
      
      json_output(json_build(200, $module));

    } catch (Exception $e) {
      json_output(json_build(400, null, $e->getMessage()));
    }
  }

  function get_products_in_pos_detail()
  {
    try {

      $data = productsModel::products_in_pos_detail_by_user(get_user('id'));

      $module = get_module('detailPos', $data);
      
      json_output(json_build(200, $module));

    } catch (Exception $e) {
      json_output(json_build(400, null, $e->getMessage()));
    }
  }

  function get_totals_in_pos_detail()
  {
    try {

      $data = productsModel::products_in_pos_detail_by_user(get_user('id'));
      
      json_output(json_build(200, $data));

    } catch (Exception $e) {
      json_output(json_build(400, null, $e->getMessage()));
    }
  }

  function add_product_to_pos_detail()
  {
    if (!Csrf::validate($_POST['csrf']) || !check_posted_data(['idProduct', 'quantity','csrf'], $_POST)) {
      json_output(json_build(400, null, 'La sesión ya caduco o los argumentos son insuficientes'));
    }

    if (clean($_POST['idProduct']) == '' || intval( $_POST['quantity']) == '' || intval( $_POST['quantity']) < 1) {
      json_output(json_build(400, null, 'Error, datos incorrectos.'));
    }

    try {

      $product = clean($_POST['idProduct']);

      $product_data = Model::list('products', ['id' => $product], 1);

      $backorder = 0;

      if  ($product_data['stock'] < $_POST['quantity']){
        $backorder = $_POST['quantity'] -  $product_data['stock'];
      }


      $data = [
        'id_user' => get_user('id'),
        'id_product' => $product,
        'quantity' => intval($_POST['quantity']),
        'backorder' => $backorder,
        'price' => $product_data['standard_price'],
      ];

      $on_order = Model::list('pos_detail', ['id_user' => get_user('id'), 'id_product' => $product],1);

      if($on_order != ''){
        
        $newQty = intval($_POST['quantity'] + $on_order['quantity']);
        $newBackOrder = 0;
        if  ($product_data['stock'] < $newQty){
          $newBackOrder = $newQty -  $product_data['stock'];
        }

        $data = [
          'quantity' => $newQty,
          'backorder' => $newBackOrder,
        ];

        if(!$id = Model::update('pos_detail', ['id' => $on_order['id']], $data)) {
          json_output(json_build(400, null, 'Hubo error al guardar el registro'));
        }
        // se guardó con éxito
        json_output(json_build(201, null, 'Producto actualizado con éxito'));

      }else{
        
        if(!$id = Model::add('pos_detail', $data)) {
          json_output(json_build(400, null, 'Hubo error al guardar el registro'));
        }
        // se guardó con éxito
        json_output(json_build(201, null, 'Producto agregado con éxito'));
      }



    } catch (Exception $e) {
      json_output(json_build(400, null, $e->getMessage()));
    }
  }

  function delete_product_detail_pos()
  {
    if (!Csrf::validate($_POST['csrf']) || !check_posted_data(['idProduct','csrf'], $_POST)) {
      json_output(json_build(400, null, 'La sesión ya caduco o los argumentos son insuficientes'));
    }

    try {


      $id = clean(($_POST['idProduct']));

      Model::remove('pos_detail', ['id_product' => $id, 'id_user' => get_user('id')] , 1);


      json_output(json_build(201, null, "Se a quitado el producto {$_POST['idProduct']} el pedido."));

    } catch (Exception $e) {
      json_output(json_build(400, null, $e->getMessage()));
    }
  }

  function delete_all_products_detail_pos()
  {
    if (!Csrf::validate($_POST['csrf']) || !check_posted_data(['csrf'], $_POST)) {
      json_output(json_build(400, null, 'La sesión ya caduco o los argumentos son insuficientes'));
    }

    try {

      Model::remove('pos_detail', ['id_user' => get_user('id')]);

      json_output(json_build(201, null, 'Se han quitado todos los productos del pedido.'));

    } catch (Exception $e) {
      json_output(json_build(400, null, $e->getMessage()));
    }
  }

  function massimport(){
    if (!Csrf::validate($_POST['csrf']) || !check_posted_data(['csrf','inputQty', 'inputSku'], $_POST)) {
      json_output(json_build(400, null, 'Faltan argumentos.'));
    }

    try {
      $quantity = explode("\n", clean($_POST['inputQty']));
      $products = explode("\n",clean($_POST['inputSku']));
      $result = [];
      for ($i=0; $i < (count($quantity) > count($products) ? count($products) : count($quantity)); $i++) { 
        
        $qty = (int) intval($quantity[$i]);
        $sku = (string) strtoupper(clean($products[$i]));

        $alret = '<div class="alert alert-%s d-flex alert-dismissible fade show" role="alert">
                    <div class="alert-icon">
                      <i class="%s"></i>
                    </div>
                    <div>%s</div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                  </div>';

        if(!$exist = Model::list('products', ['id' => $sku], 1)){
          $result[] = sprintf($alret, 'danger', 'ci-close-circle', "La clave {$sku} es icorrecta o no existe.");
        }else{
          if ($in_cart = Model::list('pos_detail', ['id_product' => $sku, 'id_user' => get_user('id')], 1)) {
            $result[] = sprintf($alret, 'warning', 'ci-security-announcement', "El producto {$sku} ya se encuentra en el pedido.");
          }else{

            $qty = is_numeric($qty) && $qty > 0 ? $qty : 1;
            $data = [
              'id_product' => $sku,
              'quantity' => $qty,
              'id_user' => get_user('id'),
              'backorder' => $exist['stock'] >= $qty ? 0 : ($qty - $exist['stock']),
              'price' => $exist['standard_price'],
            ];
            
            Model::add('pos_detail', $data);
            $result[] = sprintf($alret, 'success', 'ci-check-circle', "El producto {$sku} fue agregado al Pedido.");
            
          }
        }
      }

      json_output(json_build(201, $result, 'Los productos se cargaron exitosamente.'));
    } catch (Exception $e) {
      json_output(json_build(400, null, $e->getMessage()));
    }

  }

  //Start Add new Sale

  function add_sale(){
    if (!Csrf::validate($_POST['csrf']) || !check_posted_data(['selectUser', 'customerSaePos', 'customerEmailPos', 'csrf'], $_POST)) {
      json_output(json_build(400, null, 'La sesión ya caduco o los argumentos son insuficientes'));
    }

    try {
      
      $id = intval($_POST['selectUser']);

      if (isset($_POST['newCustomer'])){
        $id = get_user('id');
      }

      if ($id == '') {
        json_output(json_build(400, null, 'Selecciona un cliente'));
      }

      $discount_type = clean($_POST['posDiscountType']);
      $discount_amount = $_POST['posDiscountAmount'] != '' ? $_POST['posDiscountAmount'] : 0;
      $customer = customersModel::by_id($id);
      $pos_detail = productsModel::products_in_pos_detail_by_user(get_user('id'));

      if (count($pos_detail) == 0) {
        json_output(json_build(400, null, 'No hay productos en el pedido.'));
      }

      if ($pos_detail[0]['subtotal']  <= 0 ) {
        json_output(json_build(400, null, 'El pedido tiene que ser mayor a $0.00'));
      }

      $discount = 0;

      if ($discount_type == "percent" && $discount_amount != '') {
        $discount = $pos_detail[0]['subtotal'] * $discount_amount;
      }elseif ($discount_type == "amount" && $discount_amount != '') {
        $discount = $discount_amount;
      }

      //Datos para ingresar a la DB Local
      $data = [
        'id_user' => $customer['id'],
        'subtotal' => $pos_detail[0]['subtotal'],
        'discount' => $discount,
        'tax' => ($pos_detail[0]['subtotal'] - $discount) * 0.16,
        'total' =>  ($pos_detail[0]['subtotal'] - $discount) * 1.16,
        'document' => clean($_POST['youOrder']),
        'address1' => $customer['address'],
        'address2' => $customer['address2'],
        'city' => $customer['city'],
        'state' => $customer['state'],
        'zip_code' => $customer['zip_code'],
        'comments' => clean($_POST['orderComments']),
        'status' => 'recived'
      ];

      if(!$order = Model::add('orders', $data)) { // Agregando el pedido a la tabla Orders
        json_output(json_build(400, null, 'Hubo error al guardar el registro'));
      }
      
      //Datos para ingresar el DB API 

      if(!$sae = Api::show('clientes', intval($_POST['customerSaePos']))){
        json_output(json_build(400, null, 'Error en la conexión'));
      }

      if($sae['total_registros'] <= 0){
        json_output(json_build(400, null, 'El cliente no esta registrado en SAE.'));
      }

      $sae_customer = $sae['detalle'][0];

      $seller_email = Model::list('sellers',['id' => $sae_customer['CVE_VEND']], 1);

      $email=[
        'order' => $data,
        'order_no' => $order,
        'email' => $_POST['customerEmailPos'],
        'seller_email' => $seller_email['email'],
        'detail' => $pos_detail,
        'customer' => $customer,
        'customer_sae' => $sae_customer
      ];

      if(!$this->send_email($email)){
        json_output(json_build(400, null, 'No se pudo envíar el correo.'));
      }

      $serie = "EXPO"; //Serie con la cual se guarda el pedido en SAE

      $data_api = [
        "CVE_DOC" => $serie.$order,
        "CVE_CLPV" => $sae_customer['CLAVE'],
        "CVE_VEND" => $sae_customer['CVE_VEND'],
        "CVE_PEDI" => (clean($_POST['youOrder'])) == '' ? ' ' : substr(clean($_POST['youOrder']),0,20),
        "FECHA_DOC" => date("Y-m-d"),
        "CAN_TOT" => $pos_detail[0]['subtotal_sae'],
        "IMP_TOT4" => ($pos_detail[0]['subtotal_sae'] - $discount) * 0.16,
        "DES_TOT" => $discount,
        "RFC" => $sae_customer['RFC'],
        "SERIE" => $serie,
        "FOLIO" => $order,
        "IMPORTE" => ($pos_detail[0]['subtotal_sae'] - $discount) * 1.16
      ];

      $create_order = Api::create("pedidos", $data_api);//Guardando Pedido en SAE por la API

      if ($create_order['status'] != 200){
        json_output(json_build(400, 'Error SAE', $create_order['detalle']));
      }

      for ($i=0; $i < count($pos_detail); $i++) { 

        //Agregar Productos al detalle.
        $detail = [
          'id_order' => $order,
          'id_product' => $pos_detail[$i]['id_product'],
          'quantity' => $pos_detail[$i]['quantity'],
          'backorder' => $pos_detail[$i]['backorder'],
          'price' => $pos_detail[$i]['price'],
        ];

        Model::add('order_detail', $detail); // Agregando las partidas al la tabla Order_detail


        $tot_partida = $pos_detail[$i]['price'] * $pos_detail[$i]['quantity'];

        $detail_api =[
          "CVE_DOC" => $serie.$order,
          "NUM_PAR" => $i+1,
          "CVE_ART" => $pos_detail[$i]['id_product'],
          "CANT" => $pos_detail[$i]['quantity'],
          "PREC" => $pos_detail[$i]['price'],
          "TOTIMP4" => ($tot_partida - ($tot_partida * $discount_amount)) * 0.16,
          "DESC1" => $discount_amount * 100,
          "TOT_PARTIDA" => $tot_partida,
          "COST" => "0",
          "VERSION_SINC" => date("Y-m-d H:i:s")
        ];



        Api::create('partidas', $detail_api);// Agregando las Partidas a SAE por la API

        // Actualizar ventas en productos
        $sales = Model::list('products', ['id' =>  $pos_detail[$i]['id_product']], 1);
        $new_sales = $sales['sales'] + $pos_detail[$i]['quantity'];
        Model::update('products', ['id' => $pos_detail[$i]['id_product']], ['sales' => $new_sales]);
      }

      Model::remove('pos_detail', ['id_user' => get_user('id')]);
      
      // se guardó con éxito
      json_output(json_build(201, $order, 'Pedido realizado con exito'));

    } catch (Exception $e) {
      json_output(json_build(400, null, $e->getMessage()));
    }
    
  }

  // Fin add new Sale

  static function send_email($data){
    try {
      $email   = $data['email'];
      $subject = "[B2B Gava] Nuevo Pedido {$data['order_no']}";
      $body = '
        <table>
          <tr>
            <td width="33.33%">
              <img class="logo" src="'.get_image("gava_logo_100.png").'" alt="Logo">
            </td>
            <td width="33.33%">
              <div class="text-center">
                <h4><strong>PEDIDO B2B GAVA DESIGN</strong></h4>
                <p>
                  Antiguo Camino a Culhuacan #120, Iztapalapa, CDMX. <br>
                  Teléfono: +(52) 55 5582 7483 <br>
                  Email: info@gavadesign.com
                </p>
              </div>
            </td>
            <td width="33.33%">
              <div class="text-right">
                <p>
                  No. Orden: <strong>B2B'.$data['order_no'].'</strong><br>
                                Fecha: '.format_date(now()).' <br>
                                OC: '.$data['order']['document'].' <br>
                </p>
              </div>
            </td>				
          </tr>
        </table>
        <table>
          <tr>
              <td width="140">Nombre:</td>
              <td>'.$data['customer']['name'].' '.$data['customer']['lastname'].'</td>
          </tr>
          <tr>
              <td>Razón Social:</td>
              <td>'.$data['customer_sae']['NOMBRE'].'</td>
          </tr>
          <tr>
              <td>Rfc:</td>
              <td>'.$data['customer_sae']['RFC'].'</td>
          </tr>
          <tr>
              <td>Teléfono</td>
              <td>'.$data['customer']['phone'].'</td>
          </tr>
          <tr>
              <td>Dirección de envío:</td>
              <td>'.$data['order']['address1'].', '.$data['order']['address2'].', '.$data['order']['city'].', '.$data['order']['state'].', '.$data['order']['zip_code'].'</td>
          </tr>
          <tr>
              <td>Comentarios:</td>
              <td>'.$data['order']['comments'].'</td>
          </tr>
        </table>
        <table>
        <thead class="table-active">
            <tr>
                <th>Descripción</th>
                <th class="text-right">Precio</th>
                <th class="text-center">Surtido</th>
                <th class="text-center">B/O</th>
                <th class="text-right">Importe</th>
            </tr>
        </thead>
        <tbody id="detalleOrden">
      ';

      for ($i=0 ; $i < count($data['detail']) ; $i++){
        $body .='
        <tr>
          <td>'.$data['detail'][$i]['id'].'</td>
          <td class="text-right">'.money($data['detail'][$i]['price']).'</td>
          <td class="text-center">'.$data['detail'][$i]['quantity'].'</td>
          <td class="text-center">'.$data['detail'][$i]['backorder'].'</td>
          <td class="text-right">'.money($data['detail'][$i]['amount']).'</td>
        </tr>
      ';
      }

      $body    .= '
          </tbody>
          <tfoot>
                  <tr>
                      <th colspan="4" class="text-right">Subtotal:</th>
                      <td class="text-right">'.money($data['order']['subtotal']).'</td>
                  </tr>
                  <tr>
                      <th colspan="4" class="text-right">Descuento:</th>
                      <td class="text-right">'.money($data['order']['discount']).'</td>
                  </tr>
                  <tr>
                      <th colspan="4" class="text-right">Iva:</th>
                      <td class="text-right">'.money($data['order']['tax']).'</td>
                  </tr>
                  <tr>
                      <th colspan="4" class="text-right">Total:</th>
                      <td class="text-right"><strong>'.money($data['order']['total']).'</strong></td>
                  </tr>
          </tfoot>
        </table>
      ';
      $alt     = 'Se ha generado un nuevo pedido.';
      send_email_order(get_siteemail(), $email, $subject, $body, $alt, $data['seller_email'], 'cobranza.gava@gmail.com');
      return true;
    } catch (Exception $e) {
      echo $e->getMessage();
      return false;
    }
  }

  

}