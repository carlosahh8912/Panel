<!-- Modal Content -->
<div class="modal fade" id="userModal" tabindex="-1" user="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" user="document">
        <div id="modalColor" class="modal-content bg-dark text-white">
            <div class="modal-header">
                <h2 id="titleModal" class="h6 modal-title ">Nuevo Usuario</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="userForm" name="userForm" action="">
            <div class="modal-body">
                <?=insert_inputs();?>
                <input type="hidden" id="idUser" name="idUser">
                <div class="row">
                    <div class="col-6">
                        <div class="form-group mb-3">
                            <label for="userName">Nombre</label>
                            <input type="text" class="form-control" id="userName" name="userName" placeholder="Nombre del usuario" required>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group mb-3">
                            <label for="userLastname">Apellido</label>
                            <input type="text" class="form-control" id="userLastname" name="userLastname" placeholder="Apellido del usuario" required>
                        </div>
                    </div>

                </div>

                <div class="form-group mb-3">
                    <label for="userEmail">Email</label>
                    <input type="email" class="form-control" id="userEmail" name="userEmail" placeholder="user@email.com" required>
                </div>
                
                <div class="row">
                    <div class="col-6">
                        <div class="form-goup mb-3 text-black">
                            <label for="selectUserRole"><span class="text-white">Tipo de Usuario</span></label>
                            <select class="form-select select2" id="selectUserRole" name="selectUserRole" required>
                            </select>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-goup mb-3 text-black">
                            <label for="selectUserStatus"><span class="text-white">Estatus</span></label>
                            <select class="form-select select2" id="selectUserStatus" name="selectUserStatus" required>
                                <option value="active">Activo</option>
                                <option value="inactive">Inactivo</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="form-group mb-3">
                    <label for="userPassword">Contraseña</label>
                    <input type="password" class="form-control" id="userPassword" name="userPassword" placeholder="Contraseña">
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
<div class="modal fade" id="viewUserModal" tabindex="-1" user="dialog" aria-hidden="true">
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
                            <th>ID: </th>
                            <td id="celId"></td>
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
                            <th>Tipo de usuario: </th>
                            <td id="celRole"></td>
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
                            <th>Explorador: </th>
                            <td id="celBrowser"></td>
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


<!-- Modal Content -->
<div class="modal fade" id="modal_two_factor_authentication" tabindex="-1" user="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" user="document">
        <div id="modalColor" class="modal-content">
            <div class="modal-header">
                <h2 id="titleModal" class="h4 modal-title ">Activar Google Authenticator</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body scroll-y">
                <?php $secret = get_g_secret_key(); ?>
                <!--begin::Apps-->
                <div class="" data-kt-element="apps">
                    <!--begin::Heading-->
                    <h5 class="text-dark">Aplicación de Autenticación</h5>
                    <!--end::Heading-->
                    <!--begin::Description-->
                    <div class="text-gray-500 mb-3">Usamos  
                        <a href="https://support.google.com/accounts/answer/1066447?hl=en" target="_blank">Google Authenticator</a>, 
                        escanea el código QR. Generará un código de 6 dígitos para que ingrese a continuación. 
                        <!--begin::QR code image-->
                        <div class="pt-2 text-center">
                            <img src="<?= get_g_qr($_SESSION['user_session']['user']['name'], $secret)?>" alt="" class="mw-100px">
                        </div>
                    <!--end::QR code image-->
                    </div>

                    <!--end::Description-->
                    <!--begin::Notice-->
                    <div class="d-flex rounded border-warning border border-dashed rounded p-3 mb-3">
                        <!--begin::Icon-->
                        <!--begin::Svg Icon | path: icons/duotone/Code/Warning-1-circle.svg-->
                        <div class="text-warning mt-4 me-4 h3">
                            <i class="fas fa-exclamation-triangle"></i>
                        </div>
                        <!--end::Svg Icon-->
                        <!--end::Icon-->
                        <!--begin::Wrapper-->
                        <div class="d-flex flex-stack flex-grow-1">
                            <!--begin::Content-->
                            <div class="fw-bold">
                                <div class="fs-10 text-gray-600">Si tiene problemas para usar el código QR, seleccione la entrada manual en su aplicación e ingrese su nombre de usuario y el código: 
                                
                                    <div id="viewSecret" class="fw-boldest text-dark pt-2"><?=$secret?></div>
                                </div>
                            </div>
                            <!--end::Content-->
                        </div>
                        <!--end::Wrapper-->
                    </div>
                    <!--end::Notice-->
                    <!--begin::Form-->
                    <form class="form" id="codeForm" action="">
                        <!--begin::Input group-->
                        <?=insert_inputs()?>
                        <input type="hidden" id="idUserCode" name="idUserCode" value="<?=$_SESSION['user_session']['user']['id']?>" required/>
                        <input type="hidden" id="secretKey" name="secretKey" value="<?=$secret?>" required/>
                        <div class="mb-4 fv-row form-group">
                            <input type="number" class="form-control text-center" placeholder="Ingresa el código de autenticación" min="1" max="999999" id="code" name="code">
                        </div>
                        <!--end::Input group-->
                        <!--begin::Actions-->
                        <div class="text-center">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn btn-primary ms-5">
                                <span class="indicator-label">Activar</span>
                            </button>
                        </div>
                        <!--end::Actions-->
                    <div></div></form>
                    <!--end::Form-->
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End of Modal Content -->
