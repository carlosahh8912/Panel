<?php require_once INCLUDES.'inc_header.php'; ?>
<div class="pt-3">
        <?php echo Flasher::flash(); ?>
    </div>
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-4">
    <div class="d-block mb-4 mb-md-0">
        <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
            <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
                <li class="breadcrumb-item">
                    <a href="./"><span class="fas fa-tachometer-alt"></span></a>
                </li>
                <!-- <li class="breadcrumb-item"><a href="#">ant Page</a></li> -->
                <li class="breadcrumb-item active" aria-current="page"><?= $d->title; ?></li>
            </ol>
        </nav>
        <h2 class="h4"><?= $d->title; ?></h2>
    </div>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="./pos" class="btn btn-sm btn-dark"><span class="fas fa-plus me-2"></span> Nuevo Pedido</a>
        <div class="btn-group ms-2 ms-lg-3"><a href="./orders/list" type="button" class="btn btn-sm btn-outline-primary">Ver en lista</a></div>
    </div>
</div>

<div class="cardrow invoice layout-top-spacing shadow-sm table-wrapper">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">

        <div class="app-hamburger-container">
            <div class="hamburger"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-menu chat-menu d-xl-none"><line x1="3" y1="12" x2="21" y2="12"></line><line x1="3" y1="6" x2="21" y2="6"></line><line x1="3" y1="18" x2="21" y2="18"></line></svg></div>
        </div>

        <div class="doc-container">
            <div class="tab-title">
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-12">

                        <div class="search">
                            <input type="text" class="form-control" placeholder="Buscar pedido...">
                        </div>

                        <ul class="nav nav_invoice nav-pills inv-list-container d-block" id="pills-tab" role="tablist">

                            <?php
                                for ($i=0; $i < count($d->orders); $i++):
                            ?>

                            <li class="nav-item">
                                <div class="nav-link list-actions" id="invoice-<?=$d->orders[$i]->id?>" data-invoice-id="<?=$d->orders[$i]->id?>">
                                    <div class="f-m-body">
                                        <div class="f-head">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-dollar-sign"><line x1="12" y1="1" x2="12" y2="23"></line><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path></svg>
                                        </div>
                                        <div class="f-body">
                                            <p class="invoice-number">Pedido #<?=$d->orders[$i]->id?></p>
                                            <p class="invoice-customer-name"><span><?=$d->orders[$i]->sae?></span> <?= $d->orders[$i]->name.' '.$d->orders[$i]->lastname ?></p>
                                            <p class="invoice-generated-date">Fecha: <?=format_date($d->orders[$i]->created_at)?></p>
                                        </div>
                                    </div>
                                </div>
                            </li>

                            <?php endfor  ?>

                        </ul>

                    </div>
                </div>
            </div>

            <div class="invoice-container">
                <div class="invoice-inbox">

                    <div class="inv-not-selected">
                        <p>Selecciona un pedido de la lista.</p>
                    </div>

                    <div class="invoice-header-section">
                        <h4 class="inv-number"></h4>
                        <div class="invoice-action">
                            <a href="./orders/pdf/" target="_blank" class="action-download">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-download"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
                            </a>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-printer action-print" <?= tooltip('Imprimir'); ?> ><polyline points="6 9 6 2 18 2 18 9"></polyline><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path><rect x="6" y="14" width="12" height="8"></rect></svg>
                        </div>
                    </div>
                                    
                    <div id="ct" class="">

                        <?php
                            for ($i=0; $i < count($d->orders); $i++):
                        ?>
                        
                        <div class="invoice-<?=$d->orders[$i]->id?>">
                            <div class="content-section  animated animatedFadeInUp fadeInUp">

                                <div class="row inv--head-section ">

                                    <div class="col-sm-6 col-12">
                                        <h3 class="in-heading">PEDIDO</h3>
                                    </div>
                                    <div class="col-sm-6 col-12 align-self-center text-sm-right">
                                        <div class="company-info">
                                            <img src="<?=get_image('gava_logo_200x200.jpg')?>" class="img-responsive rounded-1 me-3" width="50" alt="">
                                            <h5 class="inv-brand-name">Gava Design</h5>
                                        </div>
                                    </div>
                                    
                                </div>

                                <div class="row inv--detail-section">

                                    <div class="col-sm-7 align-self-center">
                                        <p class="inv-to">Pedido de</p>
                                    </div>
                                    <div class="col-sm-5 align-self-center  text-sm-right order-sm-0 order-1">
                                        <p class="inv-detail-title">Gava Design</p>
                                    </div>
                                    
                                    <div class="col-sm-7 align-self-center">
                                        <p class="inv-customer-name"><?=$d->orders[$i]->sae?></span> <?= $d->orders[$i]->name.' '.$d->orders[$i]->lastname ?></p>
                                        <p class="inv-street-addr"><?=$d->orders[$i]->address1?>, <?=$d->orders[$i]->address2?>, <?=$d->orders[$i]->zip_code?></p>
                                        <p class="inv-email-address"><?=$d->orders[$i]->email?></p>
                                        <p class="inv-email-address">Pedido: <?=$d->orders[$i]->document?></p>
                                    </div>
                                    <div class="col-sm-5 align-self-center  text-sm-right order-2">
                                        <p class="inv-list-number"><span class="inv-title">Pedido : </span> <span class="inv-number">[invoice number]</span></p>
                                        <p class="inv-created-date"><span class="inv-title">Fecha : </span> <span class="inv-date"><?=format_date($d->orders[$i]->created_at)?></span></p>
                                        <p class="inv-due-date"><span class="inv-title">Actualización : </span> <span class="inv-date"><?=format_date($d->orders[$i]->updated_at)?></span></p>
                                    </div>
                                </div>

                                <div class="row inv--product-table-section">
                                    <div class="col-12">
                                        <div class="table-responsive">
                                            <table class="table">
                                                <thead class="">
                                                    <tr>
                                                        <th scope="col">#</th>
                                                        <th scope="col">Sku</th>
                                                        <th scope="col">Producto</th>
                                                        <th class="text-right" scope="col">Cant</th>
                                                        <th class="text-right" scope="col">B/O</th>
                                                        <th class="text-right" scope="col">Precio</th>
                                                        <th class="text-right" scope="col">Monto</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                        $detail = orderModel::detail_by_id($d->orders[$i]->id);

                                                        foreach($detail as $row):
                                                    ?>
                                                    <tr>
                                                        <td>1</td>
                                                        <td><?=$row['id_product']?></td>
                                                        <td class="text-truncate"><?=$row['title']?></td>
                                                        <td class="text-right"><?=$row['quantity']?></td>
                                                        <td class="text-right"><?=$row['backorder']?></td>
                                                        <td class="text-right"><?=money($row['price'])?></td>
                                                        <td class="text-right"><?=money(($row['quantity'] - $row['backorder']) * $row['price'])?></td>
                                                    </tr>
                                                    <?php endforeach ?>                

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mt-4">
                                    <div class="col-sm-5 col-12 order-sm-0 order-1">
                                        <div class="inv--payment-info">
                                            <div class="row">
                                                <div class="col-sm-12 col-12">
                                                    <h6 class=" inv-title">Observaciones:</h6>
                                                </div>
                                                <div class="col-sm-8 col-12">
                                                    <p class=""><?=$d->orders[$i]->comments?></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-7 col-12 order-sm-1 order-0">
                                        <div class="inv--total-amounts text-sm-right">
                                            <div class="row">
                                                <div class="col-sm-8 col-7">
                                                    <p class="">Subtotal: </p>
                                                </div>
                                                <div class="col-sm-4 col-5">
                                                    <p class=""><?=money($d->orders[$i]->subtotal)?></p>
                                                </div>
                                                <?php if($d->orders[$i]->discount != ''): ?>
                                                <div class="col-sm-8 col-7">
                                                <!-- <span class="discount-percentage">5%</span> -->
                                                    <p class=" discount-rate">Descuento : </p>
                                                </div>
                                                <div class="col-sm-4 col-5">
                                                    <p class="">- <?=money($d->orders[$i]->discount)?></p>
                                                </div>
                                                <?php endif ?>
                                                <div class="col-sm-8 col-7">
                                                    <p class="">Iva (16%): </p>
                                                </div>
                                                <div class="col-sm-4 col-5">
                                                    <p class=""><?=money($d->orders[$i]->tax)?></p>
                                                </div>
                                                <div class="col-sm-8 col-7 grand-total-title">
                                                    <h4 class="">Total : </h4>
                                                </div>
                                                <div class="col-sm-4 col-5 grand-total-amount">
                                                    <h4 class=""><?=money($d->orders[$i]->total)?></h4>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div> 


                        
                        <?php endfor;  ?>
                    </div>


                </div>

                <div class="inv--thankYou">
                    <div class="row">
                        <div class="col-sm-12 col-12">
                            <p class="">Gracias por su compra.</p>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
</div>
<?php require_once INCLUDES.'inc_footer.php'; ?>