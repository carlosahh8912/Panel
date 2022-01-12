<?php 
require_once INCLUDES.'inc_header.php'; 
?>
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
        <!-- <p class="mb-0">Your web analytics dashboard template.</p> -->
    </div>
    <div class="btn-toolbar mb-2 mb-md-0">
        <?php if ($_SESSION['permissions'][11]['w'] == 1) :?>
        <a href="./pos" class="btn btn-sm btn-dark"><span class="fas fa-chevron-left me-2"></span> Regresar a Pedido</a>
        <!-- <div class="btn-group ms-2 ms-lg-3"><button type="button" class="btn btn-sm btn-outline-primary">Share</button> <button type="button" class="btn btn-sm btn-outline-primary">Export</button></div> -->
        <?php endif ?>
    </div>
</div>

<div class="row">
    <div  class="col-12 col-xl-6 mb-3">
        <form class="row" id="massimport_form" novalidate>
        <?= insert_inputs() ?>        
        <div class="col-12 col-lg-6 mb-4">
            <div class="card border-light shadow-sm">
                <div class="card-header border-bottom border-light"><h2 class="h5 mb-0">Cantidades</h2></div>
                <div class="card-body form-group">
                <textarea class="form-control" name="inputQty" id="inputQty" cols="30" rows="10"></textarea>

                </div>
            </div>
        </div>

        <div class="col-12 col-lg-6 mb-4">
            <div class="card border-light shadow-sm">
                <div class="card-header border-bottom border-light"><h2 class="h5 mb-0">Claves</h2></div>
                <div class="card-body form-group">
                    <textarea class="form-control" name="inputSku" id="inputSku" cols="30" rows="10"></textarea>
                </div>
            </div>
        </div>
        
        <div class="col-12 ">
            <button type="submit" class="btn btn-primary w-100"> <i class="fas fa-upload me-2"></i> Cargar Productos</button>
        </div>
    </form>
    </div>

    <div class="col-12 col-xl-6 mb-4">
        <div class="card border-light shadow-sm">
            <div class="card-header border-bottom border-light"><h2 class="h5 mb-0">Resultado</h2></div>
            <div class="card-body" id="massimport_result">
            </div>
        </div>
    </div>

</div>




<?php require_once INCLUDES.'inc_footer.php'; ?>