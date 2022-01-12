<?php require_once INCLUDES.'inc_header.php'; ?>


<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-4">
    <div class="d-block mb-4 mb-md-0">
        <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
            <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
                <li class="breadcrumb-item">
                    <a href="./"><span class="fas fa-tachometer-alt"></span></a>
                </li>
                <!-- <li class="breadcrumb-item"><a href="#">Creator</a></li> -->
                <li class="breadcrumb-item active" aria-current="page">Creator</li>
            </ol>
        </nav>
        <h2 class="h4"><?=$d->title;?></h2>
        <!-- <p class="mb-0">Your web analytics dashboard template.</p> -->
    </div>
</div>

<div class="row">
  <div class="col-12">
    <?php echo Flasher::flash(); ?>
  </div>

  <!-- formulario -->
  <div class="col-xl-12">
    <div class="card">
      <div class="card-header">
        <h4><?php echo $d->title; ?></h4>
      </div>
      <div class="card-body">
        <a class="btn btn-success" href="<?php echo 'creator/controller' ?>">Crear controlador</a>
        <a class="btn btn-success" href="<?php echo 'creator/model' ?>">Crear modelo</a>
      </div>
    </div>
  </div>
</div>


<?php require_once INCLUDES.'inc_footer.php'; ?>

