<!-- Modal Content -->
<div class="modal fade" id="customerModal" tabindex="-1" user="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" user="document">
        <div id="modalColor" class="modal-content">
            <div class="modal-header bg-dark text-white">
                <h2 id="titleModal" class="h6 modal-title ">Nuevo Cliente</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="customerForm" name="customerForm" action="">
            <div class="modal-body">
                <?=insert_inputs();?>
                <input type="hidden" id="idCustomer" name="idCustomer">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group mb-3">
                            <label for="customerSae">SAE</label>
                            <input type="number" class="form-control" id="customerSae" name="customerSae" placeholder="N° de cliente SAE" required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group mb-3">
                            <label for="customerName">Nombre</label>
                            <input type="text" class="form-control" id="customerName" name="customerName" placeholder="Nombre del cliente" required>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group mb-3">
                            <label for="customerLastname">Apellido</label>
                            <input type="text" class="form-control" id="customerLastname" name="customerLastname" placeholder="Apellido del cliente" required>
                        </div>
                    </div>

                </div>

                <div class="form-group mb-3">
                    <label for="customerEmail">Email</label>
                    <input type="email" class="form-control" id="customerEmail" name="customerEmail" placeholder="customer@email.com" required>
                </div>
                
                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-goup mb-3 text-black">
                            <label for="selectCustomerStatus">Estatus</label>
                            <select class="form-select select2" id="selectCustomerStatus" name="selectCustomerStatus" required>
                                <option value="active">Activo</option>
                                <option value="inactive">Inactivo</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-6 col-sm-4">
                        <div class="row">
                            <label><span>Área de Acceso</span></label>
                            <div class="col-12">
                                <div class="form-check form-group form-switch">
                                    <input class="form-check-input" type="checkbox" name="customerB2b" id="customerB2b" checked> 
                                    <label class="form-check-label" for="customerB2b">B2B</label>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-check form-group form-switch">
                                    <input class="form-check-input" type="checkbox" name="customerDs" id="customerDs"> 
                                    <label class="form-check-label" for="customerDs">Dropshipping</label>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="col-6 col-sm-4">
                        <label><span>Maneja Envío</span></label>
                        <div class="form-check form-group form-switch">
                            <input class="form-check-input" type="checkbox" name="customerShipping" id="customerShipping"> 
                            <label class="form-check-label" for="customerShipping">Envío</label>
                        </div>
                        
                    </div>
                </div>

                <div class="form-group mb-3">
                    <label for="customerPassword">Contraseña</label>
                    <input type="password" class="form-control" id="customerPassword" name="customerPassword" placeholder="Contraseña">
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

<!-- Modal Content -->
<div class="modal fade" id="viewCustomerModal" tabindex="-1" user="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" user="document">
        <div id="modalColor" class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h2 id="titleModal" class="h6 modal-title ">Detalles de Usuario</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th colspan="2">Detalles</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th>SAE: </th>
                            <td id="celSae"></td>
                        </tr>
                        <tr>
                            <th>Nombre: </th>
                            <td id="celName"></td>
                        </tr>
                        <tr>
                            <th>Correo: </th>
                            <td id="celEmail"></td>
                        </tr>
                        <tr>
                            <th>Razón Social: </th>
                            <td id="celRs"></td>
                        </tr>
                        <tr>
                            <th>Rfc: </th>
                            <td id="celRfc"></td>
                        </tr>
                        <tr>
                            <th>Saldo: </th>
                            <td id="celSaldo"></td>
                        </tr>
                        <tr>
                            <th>Teléfono: </th>
                            <td id="celPhone"></td>
                        </tr>
                        <tr>
                            <th>Whatsapp: </th>
                            <td id="celWhatsapp"></td>
                        </tr>
                        <tr>
                            <th>B2B: </th>
                            <td id="celB2b"></td>
                        </tr>
                        <tr>
                            <th>Dropshipping: </th>
                            <td id="celDropshipping"></td>
                        </tr>
                        <tr>
                            <th>Envío: </th>
                            <td id="celShipping"></td>
                        </tr>
                        <tr>
                            <th>Estatus: </th>
                            <td id="celStatus"></td>
                        </tr>
                        <tr>
                            <th>Fecha de creación: </th>
                            <td id="celCreated"></td>
                        </tr>
                    </tbody>
                </table>
                <table class="table">
                    <thead>
                        <tr>
                            <th colspan="2">Detalles de Sesión</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th>Ip: </th>
                            <td id="celIp"></td>
                        </tr>
                        <tr>
                            <th>Dispositivo: </th>
                            <td id="celDevice"></td>
                        </tr>
                        <tr>
                            <th>Sistema Operativo: </th>
                            <td id="celOs"></td>
                        </tr>
                        <tr>
                            <th>Ubicación: </th>
                            <td id="celLocation"></td>
                        </tr>
                        <tr>
                            <th>Fecha de Acceso: </th>
                            <td id="celLogin"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer ">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
<!-- End of Modal Content -->
