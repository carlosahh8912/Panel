<!-- scripts necessarios -->
<script src="<?php echo PLUGINS;?>jquery/jquery-3.6.0.min.js"></script>
<script src="<?php echo PLUGINS;?>popperjs/core/dist/umd/popper.min.js"></script>
<script src="<?php echo PLUGINS;?>bootstrap/dist/js/bootstrap.min.js"></script>

<!-- toastr js -->
<!-- <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script> -->

<!-- Datatable js -->
<script src="<?php echo PLUGINS.'datatable/datatables/js/jquery.dataTables.min.js'; ?>"></script>
<script src="<?php echo PLUGINS.'datatable/datatables.min.js'; ?>"></script>
<script src="<?php echo PLUGINS.'datatable/datatables/js/dataTables.bootstrap5.min.js'; ?>"></script>
<!-- waitme js -->
<script src="<?php echo PLUGINS.'waitme/waitMe.min.js'; ?>"></script>
<!-- sweetalert2 js -->
<script src="<?php echo PLUGINS;?>sweetalert2/dist/sweetalert2.all.min.js"></script>
<!-- JqValidation js -->
<script src="<?php echo PLUGINS;?>jquery-validation/jquery.validate.min.js"></script>
<script src="<?php echo PLUGINS;?>jquery-validation/additional-methods.min.js"></script>
<script src="<?php echo PLUGINS;?>jquery-validation/localization/messages_es.min.js"></script>
<!-- notyf js -->
<script src="<?php echo PLUGINS;?>notyf/notyf.min.js"></script>
<!-- simplebar js -->
<script src="<?php echo PLUGINS;?>simplebar/dist/simplebar.min.js"></script>
<!-- choices js -->
<script src="<?php echo PLUGINS;?>choices.js/public/assets/scripts/choices.min.js"></script>
<!-- Select2 js -->
<script src="<?php echo PLUGINS;?>select2/select2.min.js"></script>
<!-- vanillajs-datepicker js -->
<script src="<?php echo PLUGINS;?>vanillajs-datepicker/dist/js/datepicker.min.js"></script>
<!-- smooth js -->
<script src="<?php echo PLUGINS;?>smooth-scroll/dist/smooth-scroll.polyfills.min.js"></script>
<!-- fullcalendar js -->
<script src="<?php echo PLUGINS;?>fullcalendar/main.min.js"></script>
<!-- leaflet js -->
<script src="<?php echo PLUGINS;?>leaflet/dist/leaflet.js"></script>
<!-- Theme js -->
<script src="<?php echo JS;?>volt.js"></script>
<!-- Objeto Bee Javascript registrado -->
<?php echo load_bee_obj(); ?>
<!-- Scripts personalizados Bee Framework -->
<script src="<?php echo JS.'main.js?v='.get_version(); ?>"></script>
<!-- Scripts registrados manualmente -->
<?php echo load_scripts(); ?>

