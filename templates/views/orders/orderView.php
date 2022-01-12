<?php require_once INCLUDES.'inc_header.php'; ?>
            <div class="row justify-content-center mt-4">
                <div class="col-12">
                    <button type="button" class="btn btn-primary d-inline-flex align-items-center" onclick="print(printArea);">Imprimir <i class="fas fa-print ms-2"></i></button>
                </div>
                <div class="col-12 col-xl-9">
                    <div id="printArea" class="card shadow border-0 p-4 p-md-5 position-relative">
                        <div class="d-flex justify-content-between pb-4 pb-md-5 mb-4 mb-md-5 border-bottom border-light">
                            <img class="image-md" src="<?=get_image('gava_logo.png')?>" alt="<?=get_sitename()?>" />
                            <div>
                                <h4>Gava Design</h4>
                                <ul class="list-group simple-list">
                                    <li class="list-group-item fw-normal">Ant. Camino a Culhuacan 120</li>
                                    <li class="list-group-item fw-normal">Iztapalapa, CDMX, México</li>
                                    <li class="list-group-item fw-normal">info@gavadesign.com</li>
                                </ul>
                            </div>
                        </div>
                        <div class="mb-6 d-flex align-items-center justify-content-center">
                            <h2 class="h1 mb-0">Pedido #00123</h2>
                            <span class="badge badge-lg bg-info ms-4">En Proceso</span>
                        </div>
                        <div class="row justify-content-between mb-4 mb-md-5">
                            <div class="col-sm">
                                <h5>Cliente:</h5>
                                <div>
                                    <ul class="list-group simple-list">
                                        <li class="list-group-item fw-normal">(1586) The Home Store</li>
                                        <li class="list-group-item fw-normal">Dirección</li>
                                        <li class="list-group-item fw-normal">311 West Mechanic Lane Middletown, NY 10940</li>
                                        <li class="list-group-item fw-normal">customer@email.com</li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-sm col-lg-4">
                                <dl class="row text-sm-right">
                                    <dt class="col-6"><strong>Pedido No.</strong></dt>
                                    <dd class="col-6">00123</dd>
                                    <dt class="col-6"><strong>Creación:</strong></dt>
                                    <dd class="col-6">31/03/2021</dd>
                                    <dt class="col-6"><strong>Actualización:</strong></dt>
                                    <dd class="col-6">30/04/2021</dd>
                                </dl>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="table-responsive">
                                    <table class="table mb-0">
                                        <thead class="bg-light border-top">
                                            <tr>
                                                <th scope="row" class="border-0 text-left">Sku</th>
                                                <th scope="row" class="border-0">Descripción</th>
                                                <th scope="row" class="border-0">Precio</th>
                                                <th scope="row" class="border-0">Cant.</th>
                                                <th scope="row" class="border-0">Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <th scope="row" class="text-left fw-bold h6">BO09-A</th>
                                                <td class="text-truncate">DESTAPADOR DE LUCHADOR</td>
                                                <td class="text-end">$109.00</td>
                                                <td>10</td>
                                                <td class="text-end">$1,090.00</td>
                                            </tr>
                                            <tr>
                                                <th scope="row" class="text-left fw-bold h6">BO09-A</th>
                                                <td class="text-truncate">DESTAPADOR DE LUCHADOR</td>
                                                <td class="text-end">$109.00</td>
                                                <td>10</td>
                                                <td class="text-end">$1,090.00</td>
                                            </tr>
                                            <tr>
                                                <th scope="row" class="text-left fw-bold h6">BO09-A</th>
                                                <td class="text-truncate">DESTAPADOR DE LUCHADOR</td>
                                                <td class="text-end">$109.00</td>
                                                <td>10</td>
                                                <td class="text-end">$1,090.00</td>
                                            </tr>
                                            <tr>
                                                <th scope="row" class="text-left fw-bold h6">BO09-A</th>
                                                <td class="text-truncate">DESTAPADOR DE LUCHADOR</td>
                                                <td class="text-end">$109.00</td>
                                                <td>10</td>
                                                <td class="text-end">$1,090.00</td>
                                            </tr>
                                            <tr>
                                                <th scope="row" class="text-left fw-bold h6">BO09-A</th>
                                                <td class="text-truncate">DESTAPADOR DE LUCHADOR</td>
                                                <td class="text-end">$109.00</td>
                                                <td>10</td>
                                                <td class="text-end">$1,090.00</td>
                                            </tr>
                                           
                                        </tbody>
                                    </table>
                                </div>
                                <div class="d-flex justify-content-end text-right mb-4 py-4">
                                    <div class="mt-4">
                                        <table class="table table-clear">
                                            <tbody>
                                                <tr>
                                                    <td class="left"><strong>Subtotal</strong></td>
                                                    <td class="right">$8.497,00</td>
                                                </tr>
                                                <tr>
                                                    <td class="left"><strong>Descuento (10%)</strong></td>
                                                    <td class="right">$1,699,40</td>
                                                </tr>
                                                <tr>
                                                    <td class="left"><strong>IVA (16%)</strong></td>
                                                    <td class="right">$679,76</td>
                                                </tr>
                                                <tr>
                                                    <td class="left"><strong>Total</strong></td>
                                                    <td class="right"><strong>$7.477,36</strong></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <!-- <h4>Payments to:</h4>
                                <span><a href="/cdn-cgi/l/email-protection" class="__cf_email__" data-cfemail="dcacbda5b1b9b2a89caab3b0a8f2bfb3b1">[email&#160;protected]</a></span> -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
<?php require_once INCLUDES.'inc_footer.php'; ?>