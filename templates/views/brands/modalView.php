<!-- Modal Content -->
<div class="modal fade" id="brandModal" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div id="modalColor" class="modal-content bg-dark text-white">
            <div class="modal-header">
                <h2 id="titleModal" class="h6 modal-title ">Nueva Marca</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="brandForm" name="brandForm" action="">
            <div class="modal-body">
                <?=insert_inputs();?>
                <input type="hidden" id="idBrand" name="idBrand">
                <div class="form-group mb-3">
                    <label for="brandName">Nombre de la Marca</label>
                    <input type="text" class="form-control" id="brandName" name="brandName" placeholder="Nombre del la marca" required>
                </div>

                <div class="form-goup mb-3 text-black">
                    <label for="selectBrandStatus"> <span class="text-white">Estatus</span> </label>
                    <select class="form-select selectChoices" id="selectBrandStatus" name="selectBrandStatus" required>
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