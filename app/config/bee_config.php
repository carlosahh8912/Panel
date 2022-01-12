<?php 

/**
 * Constantes migradas de bee_config.php
 * a este archivo para cuando se deba realizar una actualización del sistema
 * o corrección       , las credenciales de la base de datos no queden expuestas ni
 * sean modificadas en el proceso por accidente así como el basepath y otras constantes que requieran
 * configuración especial en producción
 */
define('IS_LOCAL'     , in_array($_SERVER['REMOTE_ADDR'], ['127.0.0.1', '::1']));
define('BASEPATH'     , IS_LOCAL ? '/' : '/'); // Debe ser cambiada a la ruta de tu proyecto en producción y desarrollo
define('IS_DEMO'      , false);

// Set para conexión en producción o servidor real
define('DB_ENGINE'    , 'mysql');
define('DB_HOST'      , 'localhost');
define('DB_NAME'      , 'gavadfqn_gava_b2b');
define('DB_USER'      , 'gavadfqn_b2b');
define('DB_PASS'      , 'GAVA/b2b_$');
define('DB_CHARSET'   , 'utf8');

/** Extra constants to be used */

// Para uso futuro de Gmaps o alguna implementación similar
define('GMAPS'        , '__TOKEN__');

// Nombres de cookies para autentificación de usuarios
// el valor puede ser cambiado en caso de utilizar
// multiples instancias de Bee para proyectos diferentes y los cookies no representen un problema por el nombre repetido
define('AUTH_TKN_NAME', 'bee__cookie_tkn');
define('AUTH_ID_NAME' , 'bee__cookie_id');

// Salt utilizada para agregar seguridad al hash de contraseñas o similar dependiendo el uso requerido
define('AUTH_SALT'    , 's&=Kp^H-k&~xw3audCjd+;u`+hA|f;U^^08lPq%J*4ruk^Mfld)vZ99mEl~(T).M');

// En caso de implementación de pagos en línea para definir si se está trabajando con pasarelas en modo sanbox / prueba o producción
define('SANDBOX'      , false); // live or sandbox



