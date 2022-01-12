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
        <!-- <p class="mb-0">Your web analytics dashboard template.</p> -->
    </div>
</div>

<div class="row">
    <div class="col-12 col-xl-4">
        <div class="row">
            <div class="col-12 mb-4">
                <div class="card shadow-sm text-center p-0">
                    <div class="profile-cover rounded-top" data-background="<?= get_image('bg_profile.svg')?>"></div>
                    <div class="card-body pb-5">
                        <img src="<?= $data['user']['avatar'] != null ? $data['user']['avatar'] : 'https://ui-avatars.com/api/?name='.$data['user']['name'].'+'.$data['user']['lastname'].'&background=random&format=svg' ?>" class="user-avatar large-avatar rounded-circle mx-auto mt-n7 mb-4" alt="profile_image" />
                        <h4 class="h3"><?=$data['user']['name'].' '.$data['user']['lastname']?></h4>
                        <h5 class="fw-normal"><?=$data['user']['rolename']?></h5>
                        <!-- <a class="btn btn-sm btn-dark me-2" href="#"><span class="fas fa-user-plus me-1"></span> Connect</a> <a class="btn btn-sm btn-secondary" href="#">Send Message</a> -->
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="card card-body shadow-sm mb-4">
                    <h2 class="h5 mb-4">Cambia tu imágen de perfil</h2>
                    <div class="d-flex align-items-center">
                        <div class="me-3">
                            <div class="user-avatar xl-avatar"><img class="rounded" src="<?= $data['user']['avatar'] != null ? $data['user']['avatar'] : 'https://ui-avatars.com/api/?name='.$data['user']['name'].'+'.$data['user']['lastname'].'&background=random&format=svg' ?>" alt="change avatar" /></div>
                        </div>
                        <div class="file-field">
                            <div class="d-flex justify-content-xl-center ms-xl-3">
                                <div class="d-flex">
                                    <span class="icon icon-md"><span class="fas fa-paperclip me-3"></span></span> <input type="file" />
                                    <div class="d-md-block text-left">
                                        <div class="fw-normal text-dark mb-1">Elige una imágen</div>
                                        <div class="text-gray small">JPG, GIF o PNG. Max size of 800K</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-xl-8">
        <div class="card card-body shadow-sm mb-4">
            <h2 class="h5 mb-4">Información General</h2>
            <form id="dataUserForm">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <div class="form-group">
                            <label for="first_name">Nombre</label> 
                            <input class="form-control" id="profileName" name="profileName" type="text" placeholder="Nombre" value="<?=$data['user']['name'] ?>" required />
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="form-group">
                            <label for="last_name">Apellido</label> 
                            <input class="form-control" id="profileLastname" name="profileLastname" type="text" placeholder="Apellido" value="<?=$data['user']['lastname'] ?>" required/>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <div class="form-group">
                            <label for="email">Correo</label> 
                            <input class="form-control" id="profileEmail" name="profileEmail" type="email" placeholder="name@company.com" value="<?=$data['user']['email'] ?>" required />
                        </div>
                    </div>
                </div>
                <div class="mt-3 ms-auto"><button type="submit" class="btn btn-dark">Guardar Cambios</button></div>
            </form>
        </div>

        <div class="card card-body shadow-sm mb-4">
            <h2 class="h5 mb-4">Seguridad</h2>
            <form>
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <div class="form-group">
                            <label for="first_name">Contraseña</label> 
                            <input class="form-control" id="current_password" type="password" placeholder="" required />
                        </div>
                    </div>
                    <div class="col-md-12 mb-3">
                        <div class="form-group">
                            <label for="last_name">Nueva contraseña</label> 
                            <input class="form-control" id="new_password" type="password" placeholder="" required />
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <div class="form-group">
                            <label for="email">Confirmar contraseña</label> 
                            <input class="form-control" id="conform_password" type="password" placeholder="" required />
                        </div>
                    </div>
                </div>
                <div class="mt-3 ms-auto"><button type="submit" class="btn btn-dark">Cambiar contraseña</button></div>
            </form>
        </div>

        <div class="card card-body shadow-sm mb-4">
            <h2 class="h5 mb-4">Seguridad de la cuenta</h2>
            <?php if ($data['user']['2fa_key'] == '') : ?>
            <div class="d-flex rounded border-primary border border-dashed rounded p-4">
                <div class="text-primary h3 me-4">
                    <i class="fas fa-user-shield"></i>
                </div>
                <div class="d-flex flex-stack flex-grow-1 flex-wrap flex-md-nowrap">
                    <div class="mb-3 mb-md-0 fw-bold">
                        <h4 class="text-gray-800 fw-bolder">Seguridad de 2 factores</h4>
                        <div id="two_factor_text" class="fs-6 text-gray-600 pe-4">La autenticación de dos factores agrega una capa adicional de seguridad a su cuenta. Para poder iniciar sesión, además deberá proporcionar un código de 6 dígitos</div>
                        <div id="two_factor_activate" class="fs-6 text-gray-600 pe-4 d-none">Cierra tu seción para completar la activación.</div>
                    </div>
                    <a id="two_factor_button" class="btn btn-primary px-6 align-self-center text-nowrap" data-bs-toggle="modal" data-bs-target="#modal_two_factor_authentication">Activar</a>
                </div>
            </div>
            <?php else: ?>
                <div class="d-flex rounded border-primary border border-dashed rounded p-4">
                    <div class="text-primary h3 me-4">
                        <i class="fas fa-user-shield"></i>
                    </div>
                    <div class="d-flex flex-stack flex-grow-1 flex-wrap flex-md-nowrap">
                        <div class="mb-3 mb-md-0 fw-bold">
                            <h4 class="text-gray-800 fw-bolder">Seguridad de 2 factores</h4>
                            <div class="fs-6 text-gray-600 pe-4">La autenticación de dos factores esta activada.</div>
                        </div>
                        <button class="btn btn-primary px-6 align-self-center text-nowrap desactive_two_factor" onclick="desactive_2fa(<?=$_SESSION['user_session']['user']['id']?>)">Desactivar</button>
                    </div>
                </div>
            <?php endif ?>
        </div>

        <div class="card card-body shadow-sm mb-4 mb-lg-0">
            <h2 class="h5 mb-4">Actividad</h2>
            <?php for ($i=0; $i < count($data['sessions']); $i++) : ?>
            <div class="d-flex rounded border-warning border rounded p-3 mb-2">
                <div class="h1 me-4 mx-2">
                    <?= $data['sessions'][$i]['device'] == 'Desktop' ? '<i class="fas fa-desktop"></i>' : ($data['sessions'][$i]['device'] == 'Mobile' ? '<i class="fas fa-mobile-alt"></i>' : '<i class="fas fa-tablet-alt"></i>') ?>
                </div>
                <div>
                    <p class="m-0"><?= $data['sessions'][$i]['ip_address']?>
                        <?= $data['sessions'][$i]['ip_address'] == get_user_ip() && $data['sessions'][$i]['device'] == get_user_device() ? '<span class="badge bg-success">Actual</span>' : '' ?>
                    </p>
                    <p class="m-0"><?= $data['sessions'][$i]['location']?> - <small class="text-muted"> <?= $data['sessions'][$i]['date_login']?></small></p>
                    <p class="m-0"><?= $data['sessions'][$i]['system']?></p>
                </div>
            </div>
            <?php endfor ?>
        </div>
    </div>
</div>
<?php require_once INCLUDES.'inc_footer.php'; ?>