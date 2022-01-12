<!-- Modal Content -->
<div class="modal fade" id="moduleModal" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div id="modalColor" class="modal-content bg-dark text-white">
            <div class="modal-header">
                <h2 id="titleModal" class="h6 modal-title ">Nuevo Rol</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="moduleForm" name="moduleForm" action="">
            <div class="modal-body">
                <?=insert_inputs();?>
                <input type="hidden" id="idModule" name="idModule">
                <div class="form-group mb-3">
                    <label for="moduleName">Nombre del Modulo</label>
                    <input type="text" class="form-control" id="moduleName" name="moduleName" placeholder="Nombre del Rol" required>
                </div>

                <div class="form-goup mb-3 text-black">
                    <label for="selectModuleStatus"> <span class="text-white">Estatus</span> </label>
                    <select class="form-select selectChoices" id="selectModuleStatus" name="selectModuleStatus" required>
                        <option value="active">Activo</option>
                        <option value="inactive">Inactivo</option>
                    </select>
                </div>

            </div>
            <div class="modal-footer ">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button id="btnActionForm" type="submit" class="btn btn-success ms-auto"><span id="btnText">Guardar</span></button>
            </div>
            </form>
        </div>
    </div>
</div>
<!-- End of Modal Content -->