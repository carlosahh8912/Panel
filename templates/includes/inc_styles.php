<!-- Todo plugin debe ir debajo de está línea -->

<!-- sweetalert2 CSS -->
<link type="text/css" href="<?=PLUGINS;?>sweetalert2/dist/sweetalert2.min.css" rel="stylesheet" />

<!-- notyf CSS -->
<link type="text/css" href="<?=PLUGINS;?>notyf/notyf.min.css" rel="stylesheet" />

<!-- Plugins core CSS -->
<link type="text/css" href="<?=PLUGINS;?>fullcalendar/main.min.css" rel="stylesheet" />
<link type="text/css" href="<?=PLUGINS;?>dropzone/dist/min/dropzone.min.css" rel="stylesheet" />
<link type="text/css" href="<?=PLUGINS;?>choices.js/public/assets/styles/choices.min.css" rel="stylesheet" />
<link type="text/css" href="<?=PLUGINS;?>leaflet/dist/leaflet.css" rel="stylesheet" />

<!-- <link type="text/css" href="<?=PLUGINS;?>select2/select2.min..css" rel="stylesheet" /> -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
<!-- <link type="text/css" href="<?=PLUGINS;?>select2/select2-bootstrap-5-theme.min..css" rel="stylesheet" /> -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.1.1/dist/select2-bootstrap-5-theme.min.css" />

<!-- Theme core CSS -->
<link type="text/css" href="<?=CSS;?>volt.css" rel="stylesheet" />

<!-- Toastr css -->
<!-- <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css"> -->

<!-- Datattable css -->
<link rel="stylesheet" href="<?php echo PLUGINS.'datatable/datatables/css/dataTables.bootstrap5.min.css'; ?>">

<!-- Waitme css -->
<link rel="stylesheet" href="<?php echo PLUGINS.'waitme/waitMe.min.css'; ?>">

<!-- fontawesome CSS -->
<link type="text/css" href="<?=PLUGINS;?>fortawesome/fontawesome-free/css/all.min.css" rel="stylesheet" />


<!-- Estilos registrados manualmente -->
<?php echo load_styles(); ?>

<!-- Estilos personalizados deben ir en main.css o abajo de esta línea -->
<link rel="stylesheet" href="<?php echo CSS.'main.css?v='.get_version(); ?>">
