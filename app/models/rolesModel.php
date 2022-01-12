<?php

/**
 * Plantilla general de modelos
 * Versión 1.0.1
 *
 * Modelo de roles
 */
class rolesModel extends Model {
  public static $t1   = 'roles'; // Nombre de la tabla en la base de datos;
  
  // Nombre de tabla 2 que talvez tenga conexión con registros
  //public static $t2 = '__tabla 2___'; 
  //public static $t3 = '__tabla 3___'; 

  function __construct()
  {
    // Constructor general
  }
  
  static function all()
  {
    // Todos los registros
    $sql = 'SELECT * FROM roles WHERE status != "deleted" AND id > 3';
    if ($_SESSION['user_session']['user']['id_role'] == 1) {
      $sql = 'SELECT * FROM roles WHERE status != "deleted" AND id != 1';
    }
    
    return ($rows = parent::query($sql)) ? $rows : [];
  }

  static function by_id(int $id)
  {
    // Un registro con $id
    $sql = 'SELECT * FROM roles WHERE id = :id LIMIT 1';
    return ($rows = parent::query($sql, ['id' => $id])) ? $rows[0] : [];
  }

  static function unique_name(string $name, int $id)
  {
    // Un registro con $id
    $sql = 'SELECT * FROM roles WHERE name = :name AND id != :id LIMIT 1';
    return ($rows = parent::query($sql, ['name' => $name ,'id' => $id])) ? $rows[0] : [];
  }
  
  static function role_permissions(int $id)
  {
    $sql = 'SELECT p.id, p.id_role, r.name as rolename, p.id_module,  m.name as modulename, p.r, p.w, p.u, p.d
            FROM permissions p
            INNER JOIN roles r
            ON p.id_role = r.id
            INNER JOIN modules m
            ON p.id_module = m.id
            WHERE p.id_role = :id ';
    return ($rows = parent::query($sql, ['id' => $id])) ? $rows : [];
  }

  static function get_user_roles()
  {
    // Todos los registros
    $sql = 'SELECT * FROM roles WHERE status = "active" AND id > 3';
    if ($_SESSION['user_session']['user']['id_role'] == 1) {
      $sql = 'SELECT * FROM roles WHERE status = "active" AND id > 1';
    }
    
    return ($rows = parent::query($sql)) ? $rows : [];
  }


}

