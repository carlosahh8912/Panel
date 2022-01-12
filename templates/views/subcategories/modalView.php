<!-- Modal Content -->
<div class="modal fade" id="subcategoryModal" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div id="modalColor" class="modal-content bg-dark text-white">
            <div class="modal-header">
                <h2 id="titleModal" class="h6 modal-title ">Nueva Subcategoría</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="subcategoryForm" name="subcategoryForm" action="">
            <div class="modal-body">
                <?=insert_inputs();?>
                <input type="hidden" id="idSubcategory" name="idSubcategory">
                <div class="form-group mb-3">
                    <label for="subcategoryName">Nombre de la Subcategoría</label>
                    <input type="text" class="form-control" id="subcategoryName" name="subcategoryName" placeholder="Nombre del la Subcategoría" required>
                </div>

                <div class="form-goup mb-3 text-black">
                    <label for="selectSubcategoryBrands"> <span class="text-white">Marca</span> </label>
                    <select onchange="get_subcategory_categories();" class="form-select select2" id="selectSubcategoryBrands" name="selectSubcategoryBrands" required>
                    </select>
                </div>

                <div class="form-goup mb-3 text-black">
                    <label for="selectSubategoryCategories"> <span class="text-white">Categoría</span> </label>
                    <select class="form-select select2" id="selectSubcategoryCategories" name="selectSubcategoryCategories" required>
                    </select>
                </div>

                <div class="form-goup mb-3 text-black">
                    <label for="selectSubcategoryStatus"> <span class="text-white">Estatus</span> </label>
                    <select class="form-select select2" id="selectSubcategoryStatus" name="selectSubcategoryStatus" required>
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