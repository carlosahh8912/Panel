<?php

/**
 * Plantilla general de controladores
 * Versión 1.0.2
 *
 * Controlador de orders
 */
class ordersController extends Controller {
  function __construct()
  {
    // Validación de sesión de usuario, descomentar si requerida
  
    if (!Auth::validate()) {
      Flasher::new('Debes iniciar sesión primero.', 'danger');
      Redirect::to('login');
    }

    if ($_SESSION['permissions'][10]['r'] != 1) {
      Flasher::new('Notienes permisos para acceder a este modulo.', 'danger');
      Redirect::to('home');
    }

  }
  
  function index()
  {

    $data = 
    [
      'title' => 'Pedidos',
      'orders' => orderModel::all(),
    ];
    register_styles([PLUGINS.'perfect-scrollbar/perfect-scrollbar.css'], 'perfect-scrollbar');
    register_styles([CSS.'invoice.css'], 'CSS de Pedidos');
    register_scripts([PLUGINS.'perfect-scrollbar/perfect-scrollbar.min.js'], 'perfect-scrollbar');
    register_scripts([JS.'functions_orders.js'], 'Archivo con las funciones de la página orders');
    register_scripts([JS.'invoice.js'], 'JS de los pedidos');
    // Descomentar vista si requerida
    View::render('index', $data);
  }

  function order(){

    $data = 
    [
      'title' => 'Orden de Compra',
    ];
    register_scripts([JS.'functions_orders.js'], 'Archivo con las funciones de la página orders');
    // Descomentar vista si requerida
    View::render('order', $data);


  }

  function list(){
    $data = 
    [
      'title' => 'Lista de Pedidos',
      'orders' => orderModel::all(),
    ];
    register_scripts([JS.'functions_orders.js'], 'Archivo con las funciones de la página orders');
    View::render('list', $data);
  }

  function prueba(){

    $orders = orderModel::all();

    echo debug($orders);

  }

  function pdf($order = null){
    if (!$order) {
      Flasher::new('Número de orden incorrecto.', 'danger');
      Redirect::to('./orders');
    }

    $detail = orderModel::detail_by_id($order);
    
    try {
      
      $order = orderModel::by_id($order);
      

      $content = '
      <!DOCTYPE html>
      <html lang="es">
      <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Pedido B2B</title>
        
        <!-- Theme core CSS -->
        <!-- <link type="text/css" href="'.CSS.'volt.css" rel="stylesheet" /> -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <link type="text/css" href="'.CSS.'invoice.css" rel="stylesheet" />

        <!-- fontawesome CSS -->
        <link type="text/css" href="'.PLUGINS.'fortawesome/fontawesome-free/css/all.min.css" rel="stylesheet" />
        
        <!-- Google Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Roboto+Condensed&display=swap" rel="stylesheet">

        <style>
          * {
            font-family: "Roboto Condensed", sans-serif;
          }
        
        
        </style>

      
      </head>
      <body class="container-fluid bg-light">
        <div style="padding: 0;" class="row border">
          <div style=" margin: 0;" class="col-12">
            <table style="margin: 0;" class="table">
              <tbody  style="margin: 0;" class="">
                <tr>
                  <td>
                    <p class="" style="font-size: 35px;">PEDIDO</p>
                  </td>
                  <td class="text-end">
                    <img src="%s" class="rounded-2" width="50" alt="">
                    <p class="" style="font-size:20px;">Gava Design</p>
                  </td>
                </tr>
                <tr>
                  <td class="">Pedido de</td>
                  <td class="text-end">Gava Design</td>
                </tr>
                <tr>
                  <td class="text-primary">%s</td>
                  <td class="text-end">Pedido <span class="text-primary">#%s</span></td>
                </tr>
                <tr>
                  <td class="">%s</td>
                  <td class="text-end">Fecha: %s</td>
                </tr>
                <tr>
                  <td class="">#OC: %s</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
        <div class="row inv--product-table-section">
          <div class="col-12">

            <table class="table table-border table-responsive table-hover">
              <thead class="bg-dark text-white border-dark">
                <tr class="">
                  <th class="text-center">Sku</th>
                  <th class="text-center">Descripción</th>
                  <th class="text-center">Precio</th>
                  <th class="text-center">Cantidad</th>
                  <th class="text-center">B/O</th>
                  <th class="text-center">Importe</th>
                </tr>
              </thead>
              <tbody class="border py-1">

                %s

              <tr style="border-top: 2px solid #797979;">
                <td colspan="4" rowspan="4">
                  <p class="text-primary">Observaciones:</p>
                  <p>%s</p>
                </td>
                <td class="text-end">Subtotal</td>
                <td class="text-end">%s</td>
              </tr>

              <tr>
                <td class="text-end">Descuento</td>
                <td class="text-end">%s</td>
              </tr>

              <tr>
                <td class="text-end">Iva (0.16)</td>
                <td class="text-end">%s</td>
              </tr>

              <tr class="py-4">
                <th class="text-end">Total</th>
                <th class="text-end">%s</th>
              </tr>



              </tbody>

            </table>
          </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
      </body>
      </html>';

      $rows = '';

      for ($i=0; $i < count($detail) ; $i++) { 
        $rows .= '
        <tr class="border">
          <td class="mx-2">'.$detail[$i]['id_product'].'</td>
          <td class="">'.$detail[$i]['title'].'</td>
          <td class="text-end">'.money($detail[$i]['price']).'</td>
          <td class="text-center">'.number_format($detail[$i]['quantity'] - $detail[$i]['backorder']).'</td>
          <td class="text-center">'.$detail[$i]['backorder'].'</td>
          <td class="text-end">'.money(($detail[$i]['quantity'] - $detail[$i]['backorder']) * $detail[$i]['price']).'</td>
        </tr>
        
        ';
      }


      $content = sprintf($content, get_image('gava_logo_200x200.jpg'), $order['sae'].' - '.$order['name'].' '.$order['lastname'], $order['id'], $order['email'], format_date($order['created_at']), $order['document'], $rows, $order['comments'], money($order['subtotal']), money($order['discount']), money($order['tax']),  money($order['total']));
  
      // Método 1
      $pdf = new BeePdf($content, 'Pedido_'.$order['id'], true); // Se muestra directo en navegador, para descargar pasar en parámetro 2 true y para guardar en parámetro 3 true
  
      // Método 2
      //$pdf = new BeePdf();
      //$pdf->create('bee_pdfs', $content);

    } catch (Exception $e) {
      Flasher::new($e->getMessage(), 'danger');
      Redirect::to('./orders');
    }
  }


  function test(){
    $detail = orderModel::detail_by_id(55);

    echo debug($detail);
  }

}