<?php

/**
 * Plantilla general de modelos
 * Versión 1.0.1
 *
 * Modelo de order
 */
class orderModel extends Model {
  public static $t1   = 'orders'; // Nombre de la tabla en la base de datos;
  
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
    $sql = 'SELECT o.*, u.name, u.lastname, u.email, c.sae
            FROM orders o
            INNER JOIN users u
            ON o.id_user = u.id
            LEFT JOIN customer_data c
            ON u.id = c.id_user
            ORDER BY created_at DESC';
    return ($rows = parent::query($sql)) ? $rows : [];
  }

  static function by_id($id)
  {
    // Un registro con $id
    $sql = 'SELECT o.*, u.name, u.lastname, u.email, c.sae
            FROM orders o
            INNER JOIN users u
            ON o.id_user = u.id
            LEFT JOIN customer_data c
            ON u.id = c.id_user 
            WHERE o.id = :id 
            LIMIT 1';
    return ($rows = parent::query($sql, ['id' => $id])) ? $rows[0] : [];
  }

  static function detail_by_id($id)
  {
    // Un registro con $id
    $sql = 'SELECT d.*, p.title
            FROM order_detail d
            INNER JOIN products p
            ON d.id_product = p.id
            WHERE d.id_order = :id 
            ORDER BY d.id_product ASC';
    return ($rows = parent::query($sql, ['id' => $id])) ? $rows : [];
  }
}

