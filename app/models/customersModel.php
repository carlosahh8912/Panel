<?php

/**
 * Plantilla general de modelos
 * Versión 1.0.1
 *
 * Modelo de customers
 */
class customersModel extends Model {
  public static $t1   = 'customers'; // Nombre de la tabla en la base de datos;
  
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
    $sql = 'SELECT u.*, cd.phone, cd.whatsapp, cd.sae, cd.shipping, cd.b2b, cd.dropshipping, ca.address, ca.address2, ca.city, ca.zip_code, ca.state
            FROM users u
            LEFT JOIN customer_data cd
            ON cd.id_user = u.id
            LEFT JOIN customer_address ca
            ON ca.id_user = u.id
            WHERE u.status != "deleted"
            AND u.id_role = 3
            ';
    return ($rows = parent::query($sql)) ? $rows : [];
  }

  static function by_id($id)
  {
    // Un registro con $id
    $sql = 'SELECT u.*, DATE_FORMAT(u.created_at, "%d-%m-%Y") AS created, cd.phone, cd.whatsapp, cd.sae, cd.shipping, cd.b2b, cd.dropshipping, ca.address, ca.address2, ca.city, ca.zip_code, ca.state, s.ip_address, s.system, s.location, s.device, s.date_login
    FROM users u
    LEFT JOIN customer_data cd
    ON cd.id_user = u.id
    LEFT JOIN customer_address ca
    ON ca.id_user = u.id
    LEFT JOIN sessions s
    ON u.id = s.id_user
    WHERE u.status != "deleted"
    -- AND u.id_role = 3
    AND u.id = :id 
    LIMIT 1';
    return ($rows = parent::query($sql, ['id' => $id])) ? $rows[0] : [];
  }

  static function unique_email(int $id, string $email)
  {
    // Un registro con $id
    $sql = 'SELECT * FROM users WHERE email = :email AND id != :id LIMIT 1';
    return ($rows = parent::query($sql, ['email' => $email ,'id' => $id])) ? $rows[0] : [];
  }

  static function unique_sae(int $id, int $sae)
  {
    // Un registro con $id
    $sql = 'SELECT u.*, cd.sae
            FROM users u
            LEFT JOIN customer_data cd
            ON cd.id_user = u.id  
            WHERE cd.sae = :sae 
            AND u.id != :id 
            LIMIT 1';
    return ($rows = parent::query($sql, ['sae' => $sae ,'id' => $id])) ? $rows[0] : [];
  }

  static function all_on_pos()
  {
    // Todos los registros
    $sql = 'SELECT u.*, cd.phone, cd.whatsapp, cd.sae, cd.shipping, cd.b2b, cd.dropshipping, ca.address, ca.address2, ca.city, ca.zip_code, ca.state
            FROM users u
            LEFT JOIN customer_data cd
            ON cd.id_user = u.id
            LEFT JOIN customer_address ca
            ON ca.id_user = u.id
            WHERE u.status = "active"
            AND u.id_role = 3
            ';
    return ($rows = parent::query($sql)) ? $rows : [];
  }

}

