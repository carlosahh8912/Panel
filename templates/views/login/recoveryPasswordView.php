<!DOCTYPE html>
<html lang="<?php echo SITE_LANG; ?>">
    <head>
        <!-- Agregar basepath para definir a partir de donde se deben generar los enlaces y la carga de archivos -->
        <base href="<?php echo BASEPATH; ?>">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title><?php echo isset($d->title) ? $d->title.' - '.get_sitename() : get_sitename(); ?></title>
        <meta name="viewport" content="width=device-width,initial-scale=1,shrink-to-fit=no" />
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        
        <meta property="og:type" content="website" />
        <meta property="og:url" content="https://panel.gavadesign.com" />
        <meta property="og:title" content="Panel - Gava Design" />
        <!-- Favicon del sitio -->
        <?php echo get_favicon(); ?>
        <link rel="apple-touch-icon" sizes="180x180" href="<?=FAVICON.'favicon_180.png'?>" />
        <link rel="icon" type="image/png" sizes="32x32" href="<?=FAVICON.'favicon_32.png'?>" />
        <link rel="icon" type="image/png" sizes="16x16" href="<?=FAVICON.'favicon_16.png'?>" />
        <link rel="manifest" href="./site.webmanifest" />
        <!-- <link rel="mask-icon" href="./assets/img/favicon/safari-pinned-tab.svg" color="#ffffff" /> -->
        <meta name="msapplication-TileColor" content="#ffffff" />
        <meta name="theme-color" content="#ffffff" />
        
        <?php require_once INCLUDES.'inc_styles.php'; ?>

    </head>
    <body>
        <main>
            <section class="bg-soft d-flex align-items-center my-5 mt-lg-6 mb-lg-5">
                <div class="container">
                    <p class="text-center">
                        <?php echo Flasher::flash(); ?>
                    </p>
                    <div class="row justify-content-center form-bg-image">
                        <p class="text-center">
                            <a href="./login" class="text-gray-700"><i class="fas fa-angle-left me-2"></i> Regresar al Login</a>
                        </p>
                        <div class="col-12 d-flex align-items-center justify-content-center">
                            <div class="bg-white shadow-soft border rounded border-light p-4 p-lg-5 w-100 fmxw-500">
                                <h1 class="h3 mb-4">Reset password</h1>
                                <form id="resetPasswordForm" novalidate>
                                    <?php echo insert_inputs(); ?>
                                    <input type="hidden" id="userEmail" name="userEmail" value="<?=$d->email?>">
                                    <input type="hidden" id="userToken" name="userToken" value="<?=$d->token?>">
                                    <div class="mb-4">
                                        <label for="email">Tu Email</label>
                                        <div class="input-group"><input type="email" class="form-control" value="<?=$d->email;?>" placeholder="example@company.com" id="email" required disabled="disabled" /></div>
                                    </div>
                                    <div class="form-group mb-4">
                                        <label for="password">Tu Password</label>
                                        <div class="input-group">
                                            <span class="input-group-text" id="basic-addon4"><span class="fas fa-unlock-alt"></span></span>
                                            <input type="password" placeholder="Password" class="form-control" id="newPassword" name="newPassword" required autofocus />
                                        </div>
                                    </div>
                                    <div class="form-group mb-4">
                                        <label for="confirm_password">Confirmar Password</label>
                                        <div class="input-group">
                                            <span class="input-group-text" id="basic-addon5"><span class="fas fa-unlock-alt"></span></span>
                                            <input type="password" placeholder="Confirm Password" class="form-control" id="confirm_password" name="confirm_password" required />
                                        </div>
                                    </div>
                                    <div class="d-grid"><button type="submit" class="btn btn-dark">Cambiar password</button></div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </main>
        <?php require_once INCLUDES.'inc_scripts.php'; ?>
    </body>
</html>




