<!-- footer -->
            <footer class="bg-white rounded shadow p-5 mb-4 mt-4">
                <div class="row">
                    <div class="col-12 col-lg-6 mb-4 mb-lg-0">
                        <p class="mb-0 text-center text-xl-left"><?php echo get_sitename().' '.date('Y').' &copy; Todos los derechos reservados.'; ?> <a class="text-primary fw-normal" href="https://gavadesign.com" target="_blank">Gava Design</a></p>
                    </div>
                    <div class="col-12 col-lg-6">
                        <ul class="list-inline list-group-flush list-group-borderless text-center text-xl-right mb-0">
                            <li class="list-inline-item px-0 px-sm-2">Version <?=get_version();?></li>
                        </ul>
                    </div>
                </div>
            </footer>
        </main>
        <div class="waitMe_container progress" style="background:#fff">
            <div style="background:#000"></div>
        </div>  
    <?php require_once INCLUDES.'inc_scripts.php'; ?>
    </body>
</html>