<?php

/**
 * Plantilla general de modelos
 * Versión 1.0.1
 *
 * Modelo de subcategories
 */
class subcategoriesModel extends Model {
  public static $t1   = 'subcategories'; // Nombre de la tabla en la base de datos;
  
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
    $sql = 'SELECT s.*, c.name as category, c.id_brand, b.name as brand
            FROM subcategories s
            INNER JOIN categories c
            ON s.id_category = c.id
            INNER JOIN brands b
            ON c.id_brand = b.id
            WHERE s.status != "deleted"';
    return ($rows = parent::query($sql)) ? $rows : [];
  }

  static function by_id($id)
  {
    // Un registro con $id
    $sql = 'SELECT s.*, c.name as category, c.id_brand, b.name as brand
            FROM subcategories s
            INNER JOIN categories c
            ON s.id_category = c.id
            INNER JOIN brands b
            ON c.id_brand = b.id
            WHERE s.id = :id 
            AND s.status != "deleted"
            LIMIT 1';
    return ($rows = parent::query($sql, ['id' => $id])) ? $rows[0] : [];
  }

  static function unique_name(string $name, int $id, int $category)
  {
    // Un registro con $id
    $sql = 'SELECT * FROM subcategories WHERE name = :name AND id != :id AND id_category = :id_category LIMIT 1';
    return ($rows = parent::query($sql, ['name' => $name ,'id' => $id, 'id_category' => $category])) ? $rows[0] : [];
  }
}

