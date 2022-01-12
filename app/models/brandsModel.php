<?php

/**
 * Plantilla general de modelos
 * Versión 1.0.1
 *
 * Modelo de brands
 */
class brandsModel extends Model {
  public static $t1   = 'brands'; // Nombre de la tabla en la base de datos;
  
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
    $sql = 'SELECT * FROM brands WHERE status != "deleted"';
    return ($rows = parent::query($sql)) ? $rows : [];
  }

  static function by_id($id)
  {
    // Un registro con $id
    $sql = 'SELECT * FROM brands WHERE id = :id LIMIT 1';
    return ($rows = parent::query($sql, ['id' => $id])) ? $rows[0] : [];
  }

  static function unique_name(string $name, int $id)
  {
    // Un registro con $id
    $sql = 'SELECT * FROM brands WHERE name = :name AND id != :id LIMIT 1';
    return ($rows = parent::query($sql, ['name' => $name ,'id' => $id])) ? $rows[0] : [];
  }
}

