<?php 
require_once INCLUDES.'inc_header.php'; 
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
    <div class="btn-toolbar mb-2 mb-md-0">
        
    </div>
</div>


<div class="row">
        
    <div class="col-lg-6 col-12 my-2">
            <div class="row">
                <div class="col-12">
                    <div class="card border-0 bg-yellow-100 shadow mb-1">
                        <div class="card-header">
                            <div class="fs-5 fw-normal">
                                    Cliente
                            </div>
                        </div>
                        <div class="card-body">
                            <form id="posForm" action="" novalidate>
                                <?=insert_inputs()?>
                                <div class="form-check form-switch mb-2">
                                    <input class="form-check-input" type="checkbox" id="newCustomer" name="newCustomer"> 
                                    <label class="form-check-label small" for="newCustomer">Nuevo</label>
                                </div>
                                <div class="form-goup mb-3 text-black selectCustomer">
                                    <label for="selectUser">Cliente</label>
                                    <select class="form-select selectChoices" id="selectUser" name="selectUser" required>
                                    </select>
                                </div>
                                <div class="row">
                                    <div class="col-md-3 col-6">
                                        <div class="form-group mb-3">
                                            <label for="customerSaePos">SAE</label>
                                            <input type="number" class="form-control" id="customerSaePos" name="customerSaePos"  readonly required>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-6">
                                        <div class="form-group mb-3">
                                            <label for="customerRfcPos">RFC</label>
                                            <input type="text" class="form-control" id="customerRfcPos" name="customerRfcPos" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="form-group mb-3">
                                            <label for="customerRsPos">Razón Social</label>
                                            <input type="text" class="form-control" id="customerRsPos" name="customerRsPos" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label for="customerNamePos">Nombre</label>
                                            <input type="text" class="form-control" id="customerNamePos" name="customerNamePos" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label for="customerEmailPos">Email</label>
                                            <input type="email" class="form-control" id="customerEmailPos" name="customerEmailPos" readonly required>
                                        </div>
                                    </div>
                                
                                </div>

                                <input id="posDiscountType" name="posDiscountType" type="text" hidden>
                                <input id="posDiscountAmount" name="posDiscountAmount" type="number" hidden>
                            
                            </form>
                        
                        </div>
                    </div>
                </div>

                <div class="accordion " id="commentCard">
                    <div class="accordion-item card border-0 shadow my-3">
                        <h2 class="accordion-header" id="panelsStayOpen-headingOne">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#commentsPanel" aria-expanded="true" aria-controls="commentsPanel">
                                Comentarios
                            </button>
                        </h2>
                        <div id="commentsPanel" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingOne">
                            <div class="accordion-body card-body row">
                            
                                <div class="form-group mb-3">
                                    <label for="youOrder">Su pedido</label>
                                    <input type="text" form="posForm" class="form-control" id="youOrder" name="youOrder">
                                </div>

                                <div class="form-group mb-3">
                                    <label for="orderComments">Comentarios</label>
                                    <input type="text" form="posForm" class="form-control" id="orderComments" name="orderComments">
                                </div>
                        
                            </div>
                        </div>
                    </div>
                </div>
            
                <div class="col-12">
                    <div class="card border-0 shadow">
                        <div class="card-header">
                            <div class="fs-5 fw-normal mb-2">Productos</div>
                            <div class="input-group">
                                <input type="text" class="form-control" id="productSearchPos" placeholder="Buscar producto..." aria-label="Search"> 
                                <span class="input-group-text" id="basic-addon2">
                                    <i class="fas fa-search"></i>
                                </span>
                            </div>
                        </div>
                        <div class="card-body">
                            <div id="product-content" class="row justify-content-center" style="height: 510px; overflow-y:auto;">

                                <div class="col-12 text-center  my-3">
                                        <h6>Buscar productos...</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

    </div>

    <div class="col-lg-6 col-12 my-2">
        <div class="card border-0 shadow mb-4">
            <div class="card-header">
                <div class="row align-items-center">
                    <div class="col"><h2 class="h5">Detalle</h2></div>
                    <div class="col text-right button-group">
                        <a href="./pos/massimport" class="btn btn-sm btn-primary d-inline-flex align-items-center animate-up-2 mb-1">Carga masiva <i class="fas fa-upload ms-2"></i> </a>
                        <button type="button" class="btn btn-sm btn-danger d-inline-flex align-items-center animate-up-2 mb-1 delete_all_products">Borrar detalle <i class="fas fa-trash-alt ms-2"></i></button>
                    </div>
                </div>
            </div>
            <div id="pos_detail" class="card-body" style="height: 550px; overflow-y:auto;">
                <div class="text-center py-3">
                    <h6>Detalle de la venta...</h6>
                </div>
            </div>
        </div>

        <div class="accordion " id="accordionPanelsStayOpenExample">
            <div class="accordion-item card border-0 shadow my-3">
                <h2 class="accordion-header" id="panelsStayOpen-headingOne">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseOne" aria-expanded="true" aria-controls="panelsStayOpen-collapseOne">
                        Descuento
                    </button>
                </h2>
                <div id="panelsStayOpen-collapseOne" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingOne">
                    <div class="accordion-body card-body row">
                    
                        <div class="col-sm-6">
                            <div class="input-group mb-2">
                                <span class="input-group-text">Tipo</span>
                                <select class="form-select discount_type" readonly>
                                    <option value="percent">Porcentaje %</option>
                                    <!-- <option value="amount">Monto $</option> -->
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="input-group mb-2">
                                <span class="input-group-text">Cantidad</span>
                                <input type="number" class="form-control discount_amount">
                            </div>
                        </div>
                        <div class="d-grid">
                            <button class="btn-danger btn btn_apply_discount">Aplicar descuento</button>
                        </div>
                
                    </div>
                </div>
            </div>
        </div>

        <div class="card border-0 shadow">
            <div class="card-body">

                <table id="pos_detail_totals" class="table mb-4">
                    <tbody>

                        <tr>
                            <th>
                                <h5>Subtotal:</h5>
                            </th>
                            <td class="text-end">
                                <h5 id="pos_subtotal"></h5>
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <h5 id="pos_discount_label">Descuento:</h5>
                            </th>
                            <td class="text-end">
                                <h5 id="pos_discount" class="text-danger"></h5>
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <h5>IVA (16%):</h5>
                            </th>
                            <td class="text-end">
                                <h5 id="pos_tax" class="">$0.00</h5>
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <h4>TOTAL:</h4>
                            </th>
                            <td class="text-end">
                                <h4 id="pos_total">$0.00</h4>
                            </td>
                        </tr>

                    </tbody>

                </table>

                <div class="d-grid">
                    <?php if ($_SESSION['permissions'][11]['w'] == 1) :?>
                        <button type="submit" form="posForm" class="btn btn-success mt-3">Guardar</button>
                    <?php endif ?>
                    
                </div>

            </div>
        </div>
    </div>
    
    

</div>

<?php require_once INCLUDES.'inc_footer.php'; ?>