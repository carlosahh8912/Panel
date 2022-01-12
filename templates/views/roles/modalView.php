<!-- Modal Content -->
<div class="modal fade" id="roleModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div id="modalColor" class="modal-content bg-dark text-white">
            <div class="modal-header">
                <h2 id="titleModal" class="h6 modal-title ">Nuevo Rol</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="roleForm" name="roleForm" action="">
            <div class="modal-body">
                <?=insert_inputs();?>
                <input type="hidden" id="idRole" name="idRole">
                <div class="form-group mb-3">
                    <label for="roleName">Nombre del Rol</label>
                    <input type="text" class="form-control" id="roleName" name="roleName" placeholder="Nombre del Rol" required>
                </div>
                <div class="form-group mb-3">
                    <label for="roleDescription">Descripción del Rol</label>
                    <input type="text" class="form-control" id="roleDescription" name="roleDescription" placeholder="Descripción del rol" required>
                </div>

                <div class="form-goup mb-3 text-black">
                    <label for="selectRoleStatus"><span class="text-white">Estatus</span></label>
                    <select class="form-select selectChoices" id="selectRoleStatus" name="selectRoleStatus" required>
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

<div class="modal fade" tabindex="-1"  role="dialog" id="modalPermisos">
<div class="modal-dialog modal-dialog-centered  modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header bg-primary text-white">
            <h5 class="modal-title">Permisos del Rol</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <!-- form start -->
        <form id="formPermisos" name="formPermisos">
        <div class="modal-body" id="permissionTable">
            
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary ms-auto">Guardar</button>
        </div>
        </form>
    </div>
</div>
</div>