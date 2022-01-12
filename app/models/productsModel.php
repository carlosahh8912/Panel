<?php

/**
 * Plantilla general de modelos
 * Versión 1.0.1
 *
 * Modelo de products
 */
class productsModel extends Model {
  public static $t1   = 'products'; // Nombre de la tabla en la base de datos;
  
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
    $sql = 'SELECT p.*, b.name as brand, c.name as category, s.name as subcategory
            FROM products p 
            INNER JOIN brands b
            ON p.id_brand = b.id
            INNER JOIN categories c
            ON p.id_category = c.id
            INNER JOIN subcategories s
            ON p.id_subcategory = s.id
            WHERE p.status != "deleted"
            ORDER BY p.id DESC';
    return ($rows = parent::query($sql)) ? $rows : [];
  }

  static function all_by_sale()
  {
    // Todos los registros
    $sql = 'SELECT p.*, b.name as brand, c.name as category, s.name as subcategory
            FROM products p 
            INNER JOIN brands b
            ON p.id_brand = b.id
            INNER JOIN categories c
            ON p.id_category = c.id
            INNER JOIN subcategories s
            ON p.id_subcategory = s.id
            WHERE p.status != "deleted"
            ORDER BY p.sales DESC';
    return ($rows = parent::query($sql)) ? $rows : [];
  }

  static function by_id(string $id)
  {
    // Un registro con $id
    $sql = 'SELECT p.*, b.name as brand, c.name as category, s.name as subcategory,
            (SELECT COUNT(*) FROM product_images WHERE id_product = "'.$id.'" ) as images
            FROM products p 
            INNER JOIN brands b
            ON p.id_brand = b.id
            INNER JOIN categories c
            ON p.id_category = c.id
            INNER JOIN subcategories s
            ON p.id_subcategory = s.id
            WHERE p.status != "deleted"
            AND p.id = :id 
            LIMIT 1';
    return ($rows = parent::query($sql, ['id' => $id])) ? $rows[0] : [];
  }

  static function unique_ean(string $ean, string $id)
  {
    // Un registro con $id
    $sql = 'SELECT * FROM products WHERE ean = :ean AND id != :id LIMIT 1';
    return ($rows = parent::query($sql, ['ean' => $ean ,'id' => $id])) ? $rows[0] : [];
  }

  static function search_product($product)
  {
    // Todos los registros
    $sql = 'SELECT p.*, b.name as brand, c.name as category, s.name as subcategory
            FROM products p 
            INNER JOIN brands b
            ON p.id_brand = b.id
            INNER JOIN categories c
            ON p.id_category = c.id
            INNER JOIN subcategories s
            ON p.id_subcategory = s.id
            WHERE p.status = "active"
            AND p.id LIKE "%'.$product.'%"
            OR p.ean LIKE "%'.$product.'%"
            OR p.title LIKE "%'.$product.'%"
            ORDER BY p.id ASC
            LIMIT 26';
    return ($rows = parent::query($sql)) ? $rows : [];
  }

  static function products_in_pos_detail_by_user(int $id)
  {
    // Todos los registros
    $sql = 'SELECT pos.*, p.*, b.name as brand, c.name as category, s.name as subcategory, (pos.price * pos.quantity) as amount,
            (SELECT SUM((quantity-backorder)*price) FROM pos_detail WHERE id_user = :id_user2 ) as subtotal,
            (SELECT SUM(quantity * price) FROM pos_detail WHERE id_user = :id_user3 ) as subtotal_sae
            FROM pos_detail pos
            INNER JOIN products p 
            ON pos.id_product = p.id
            INNER JOIN brands b
            ON p.id_brand = b.id
            INNER JOIN categories c
            ON p.id_category = c.id
            INNER JOIN subcategories s
            ON p.id_subcategory = s.id
            WHERE p.status = "active"
            AND pos.id_user = :id_user
            ORDER BY p.id ASC';
    return ($rows = parent::query($sql, ['id_user' => $id, 'id_user2' => $id, 'id_user3' => $id])) ? $rows : [];
  }

}

