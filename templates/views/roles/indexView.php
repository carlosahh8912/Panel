<?php 
require_once INCLUDES.'inc_header.php'; 
require_once 'modalView.php'; 
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
    </div>
    <div class="btn-toolbar mb-2 mb-md-0">
    <?php if ($_SESSION['permissions'][3]['w'] == 1) :?>
        <button onclick="openModal();" class="btn btn-sm btn-dark"><span class="fas fa-plus me-2"></span> Nuevo Rol</button>
        <!-- <div class="btn-group ms-2 ms-lg-3"><button type="button" class="btn btn-sm btn-outline-primary">Share</button> <button type="button" class="btn btn-sm btn-outline-primary">Export</button></div> -->
        <?php endif ?>
    </div>
</div>
<div class="card card-body shadow-sm table-wrapper">
  <table id="rolesTable" class="table table-borderless table-striped table-hover align-items-center datatable">
    <thead>
      <tr>
        <th class="border-bottom">ID</th>
        <th class="border-bottom">Rol</th>
        <th class="border-bottom">Descripción</th>
        <th class="border-bottom">Estatus</th>
        <th class="border-bottom">Acciones</th>
      </tr>
    </thead>
  </table>
</div>
<?php require_once INCLUDES.'inc_footer.php'; ?>