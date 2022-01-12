<?php require_once INCLUDES.'inc_header.php'; ?>
<div class="pt-2">
    <?php echo Flasher::flash(); ?>
</div>
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-4">
    <div class="btn-toolbar dropdown">
        <button class="btn btn-dark btn-sm me-2 dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="fas fa-plus me-2"></span>Nueva tarea</button>
        <div class="dropdown-menu dashboard-dropdown dropdown-menu-start mt-2 py-0">
            <a class="dropdown-item fw-normal rounded-top" href="./products"><span class="fas fa-box"></span>Producto</a> 
            <a class="dropdown-item fw-normal" href="./orders"><span class="fas fa-file-invoice-dollar"></span>Pedidos</a>
            <a class="dropdown-item fw-normal" href="./pos"><span class="fas fa-receipt"></span>Nuevo Pedido</a>
            <a class="dropdown-item fw-normal" href="./customers"><span class="fas fa-user-tie"></span>Cliente</a>

        </div>
    </div>
    <!-- <div class="btn-group"><button type="button" class="btn btn-sm btn-outline-primary">Share</button> <button type="button" class="btn btn-sm btn-outline-primary">Export</button></div> -->
</div>
<div class="row">

    <!-- card resumen -->
    <div class="col-12 col-sm-6 col-xl-4 mb-4">
        <div class="card border-0 shadow">
            <div class="card-body">
                <div class="row d-block d-xl-flex align-items-center">
                    <div class="col-12 col-xl-5 text-xl-center mb-3 mb-xl-0 d-flex align-items-center justify-content-xl-center">
                        <div class="icon-shape icon-shape-secondary rounded me-4 me-sm-0">
                            <i class="fas fa-users h1"></i>
                        </div>
                        <div class="d-sm-none">
                            <h2 class="h5">Clientes</h2>
                            <h3 class="fw-extrabold mb-1"><?= number_format(count($d->customers)) ?></h3>
                        </div>
                    </div>
                    <div class="col-12 col-xl-7 px-xl-0">
                        <div class="d-none d-sm-block">
                            <h2 class="h4 text-gray-400 mb-0">Clientes</h2>
                            <h3 class="fw-extrabold mb-2"><?= number_format(count($d->customers)) ?></h3>
                        </div>
                        <small class="d-flex align-items-center text-gray-500">Clientes Activos</small>
                        <div class="small d-flex mt-1">
                            <div>Nuevos Clientes
                                <span class="text-success fw-bolder">0</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12 col-sm-6 col-xl-4 mb-4">
        <div class="card border-0 shadow">
            <div class="card-body">
                <div class="row d-block d-xl-flex align-items-center">
                    <div class="col-12 col-xl-5 text-xl-center mb-3 mb-xl-0 d-flex align-items-center justify-content-xl-center">
                        <div class="icon-shape icon-shape-success rounded me-4 me-sm-0">
                            <i class="fas fa-boxes h1 text-tertiary"></i>
                        </div>
                        <div class="d-sm-none">
                            <h2 class="h5">Productos</h2>
                            <h3 class="fw-extrabold mb-1"><?= number_format(count($d->products)) ?></h3>
                        </div>
                    </div>
                    <div class="col-12 col-xl-7 px-xl-0">
                        <div class="d-none d-sm-block">
                            <h2 class="h4 text-gray-400 mb-0">Productos</h2>
                            <h3 class="fw-extrabold mb-2"><?= number_format(count($d->products)) ?></h3>
                        </div>
                        <small class="d-flex align-items-center text-gray-500">Total de productos al</small>
                        <div class="small d-flex mt-1">
                            <div>
                                <?= format_date(now())?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12 col-sm-6 col-xl-4 mb-4">
        <div class="card border-0 shadow">
            <div class="card-body">
                <div class="row d-block d-xl-flex align-items-center">
                    <div class="col-12 col-xl-5 text-xl-center mb-3 mb-xl-0 d-flex align-items-center justify-content-xl-center">
                        <div class="icon-shape icon-shape-primary rounded me-4 me-sm-0">
                            <i class="fas fa-file-invoice-dollar h1 text-dark"></i>
                        </div>
                        <div class="d-sm-none">
                            <h2 class="h5">Pedidos</h2>
                            <h3 class="fw-extrabold mb-1"><?= number_format(count($d->orders)) ?></h3>
                        </div>
                    </div>
                    <div class="col-12 col-xl-7 px-xl-0">
                        <div class="d-none d-sm-block">
                            <h2 class="h4 text-gray-400 mb-0">Pedidos</h2>
                            <h3 class="fw-extrabold mb-2"><?= number_format(count($d->orders)) ?></h3>
                        </div>
                        <small class="d-flex align-items-center text-gray-500">Último Pedido</small>
                        <div class="small d-flex mt-1">
                            <div>#<?= $d->orders[0]->id ?>
                                <span class="text-success fw-bolder"><?= $d->orders[0]->sae.'-'.$d->orders[0]->name.' '.$d->orders[0]->lastname ?></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- End cards resumen -->


    <div class="col-12 mb-4">
        <div class="row">
            <div class="col-12 col-lg-8 mb-4">
                <div class="card border-light shadow-sm">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col"><h2 class="h5">Top 10 productos</h2></div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table align-items-center table-flush">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col">SKu</th>
                                    <th scope="col">Stock</th>
                                    <th scope="col">Precio</th>
                                    <th scope="col">Total Pedido</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php for ($i=0; $i < 10; $i++) :   ?>
                                <tr>
                                    <th><?= $d->products[$i]->id ?> <span><?= $i == 0 ? '<i class="fas fa-medal ms-2 text-tertiary"></i>' : ''?></span></th>
                                    <td><?= $d->products[$i]->stock ?></td>
                                    <td><?= money($d->products[$i]->standard_price) ?></td>
                                    <td><?= number_format($d->products[$i]->sales) ?></td>
                                </tr>
                                <?php endfor ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-12 col-lg-4 mb-4">
                <div class="card border-light shadow-sm">
                    <div class="card-header border-bottom border-light"><h2 class="h5 mb-0">Productos con mucho stock</h2></div>
                    <div class="card-body">
                        <?php for($i = 0; $i < 10 ; $i++): ?>
                        <div class="row align-items-center mb-4">
                            <div class="col-auto">
                                <span class="icon icon-md <?= $i == 0 ? 'text-danger' : 'text-warning' ?>"><span class="fas fa-box"></span></span>
                            </div>
                            <div class="col">
                                <div class="progress-wrapper">
                                    <div class="progress-info">
                                        <div class="h6 mb-0"><?= $d->stock[$i]->id ?></div>
                                        <div class="small fw-bold text-dark"><span><?= number_format($d->stock[$i]->stock) ?></span></div>
                                    </div>
                                    <!-- <div class="progress mb-0"><div class="progress-bar bg-purple" role="progressbar" aria-valuenow="34" aria-valuemin="0" aria-valuemax="100" style="width: 34%;"></div></div> -->
                                </div>
                            </div>
                        </div>
                        <?php endfor ?>
                    </div>
                </div>
            </div>
         </div>

        </div>
    </div>

    <div class="col-12 mb-4">
                <div class="card border-light shadow-sm">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col"><h2 class="h5">Últimos 10 pedidos</h2></div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table align-items-center table-flush">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Cliente</th>
                                    <th scope="col">SAE</th>
                                    <th scope="col">Subtotal</th>
                                    <th scope="col">Impuesto</th>
                                    <th scope="col">Total</th>
                                    <th scope="col">Fecha</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php for ($i=0; $i < (count($d->orders) > 10 ? 10 : count($d->orders)); $i++) :   ?>
                                <tr>
                                    <th><?= $d->orders[$i]->id ?></th>
                                    <td><?= $d->orders[$i]->name.' '.$d->orders[$i]->lastname ?></td>
                                    <td><?= $d->orders[$i]->sae ?></td>
                                    <td><?= money($d->orders[$i]->subtotal) ?></td>
                                    <td><?= money($d->orders[$i]->tax) ?></td>
                                    <td><?= money($d->orders[$i]->total) ?></td>
                                    <td><?= format_date($d->orders[$i]->created_at) ?></td>
                                </tr>
                                <?php endfor ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

</div>
<?php require_once INCLUDES.'inc_footer.php'; ?>