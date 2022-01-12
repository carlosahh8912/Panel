<?=insert_inputs()?>
<input type="hidden" id="idRole" name="idRole" value="<?= $d->id_role; ?>" required>
<table class="table table-bordered table-responsive-lg table-striped">
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Modulo</th>
            <th class="" scope="col">Ver</th>
            <th class="" scope="col">Crear</th>
            <th class="" scope="col">Actualizar</th>
            <th class="" scope="col">Eliminar</th>
        </tr>
    </thead>
    <tbody>
        
        <?php

            $no = 1;
            $modulos = $data['modulos'];
            for ($i = 0; $i < count($modulos); $i++) :
            
            $permisos = $modulos[$i]['permisos'];
            $rCheck = $permisos['r'] == 1 ? "checked" : "";
            $wCheck = $permisos['w'] == 1 ? "checked" : "";
            $uCheck = $permisos['u'] == 1 ? "checked" : "";
            $dCheck = $permisos['d'] == 1 ? "checked" : "";

            $idmod = $modulos[$i]['id'];

        ?>

        <tr>
            <th>
                <?= $modulos[$i]['id']; ?>
                <input type="hidden" name="modulos[<?= $i; ?>][id]" value="<?= $idmod ?>" required>
            </th>
            <td><?= $modulos[$i]['name']; ?></td>
            <td >
                <div class="form-check form-switch ms-2">
                    <input class="form-check-input" type="checkbox" name="modulos[<?= $i; ?>][r]" <?= $rCheck; ?> class="b4cb" data-on="SI" data-off="NO" data-onstyle="success" data-toggle="toggle">
                </div>
            </td>
            <td class="text-center">
                <div class="form-check form-switch ms-2">
                <input class="form-check-input" type="checkbox" name="modulos[<?= $i; ?>][w]" <?= $wCheck; ?> class="b4cb" data-on="SI" data-off="NO" data-onstyle="success" data-toggle="toggle"> 
                </div>
            </td>
            <td class="text-center">
                <div class="form-check form-switch ms-2">
                <input class="form-check-input" type="checkbox" name="modulos[<?= $i; ?>][u]" <?= $uCheck; ?> class="b4cb" data-on="SI" data-off="NO" data-onstyle="success" data-toggle="toggle">
                </div>
            </td>
            <td class="text-center">
                <div class="form-check form-switch ms-2">
                <input class="form-check-input" type="checkbox" name="modulos[<?= $i; ?>][d]" <?= $dCheck; ?> class="b4cb" data-on="SI" data-off="NO" data-onstyle="success" data-toggle="toggle">
                </div>
            </td>
        </tr>
        <?php 
            endfor 
        ?>
    </tbody>
</table>