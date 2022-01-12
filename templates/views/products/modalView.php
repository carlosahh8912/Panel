<!-- Modal Content -->
<div class="modal fade" id="productModal" tabindex="-1" user="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" user="document">
        <div id="modalColor" class="modal-content ">
            <div class="modal-header bg-dark text-white">
                <h2 id="titleModal" class="h6 modal-title ">Nuevo Usuario</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="productForm" name="productForm" action="">
            <div class="modal-body">
                <?=insert_inputs();?>
                <input type="hidden" id="idProduct" name="idProduct">
                <div class="row">
                    <div class="col-6">
                        <div class="form-group mb-3">
                            <label for="productSku">SKU</label>
                            <input type="text" class="form-control" id="productSku" name="productSku" placeholder="Clave del Producto" required>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group mb-3">
                            <label for="productEan">EAN</label>
                            <input type="number" class="form-control" id="productEan" name="productEan" placeholder="Código de barras del producto" required>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="form-group mb-3">
                            <label for="productTitle">Título</label>
                            <input type="text" class="form-control" id="productTitle" name="productTitle" placeholder="Título del Producto" required>
                        </div>
                    </div>

                    <div class="col-4">
                        <div class="form-group mb-3">
                            <label for="productStock">Stock</label>
                            <input type="number" class="form-control" id="productStock" name="productStock" placeholder="Existencias" required>
                        </div>
                    </div>

                    <div class="col-4">
                        <div class="form-group mb-3">
                            <label for="productPrice">Precio Regular</label>
                            <input type="number" class="form-control" id="productPrice" name="productPrice" placeholder="Precio" required>
                        </div>
                    </div>

                    <div class="col-4">
                        <div class="form-group mb-3">
                            <label for="productOfferPrice">Precio de Oferta</label>
                            <input type="number" class="form-control" id="productOfferPrice" name="productOfferPrice" placeholder="Precio Elevado">
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="form-group mb-3">
                            <label for="productKeywords">Keywords</label>
                            <input type="text" class="form-control tagin" id="productKeywords" name="productKeywords" data-placeholder="Keywords para separar agregar(,)">
                        </div>
                    </div>

                </div>

                
                
                <div class="row">
                    <div class="col-4">
                        <div class="form-goup mb-3">
                            <label for="selectProductBrand"><span class="">Marca</span></label>
                            <select onchange="load_subcategory();" class="form-select select2" id="selectProductBrand" name="selectProductBrand" required>
                            </select>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-goup mb-3">
                            <label for="selectProductCategory"><span class="">Categoría</span></label>
                            <select onchange="get_product_subcategory();" class="form-select select2" id="selectProductCategory" name="selectProductCategory" required>
                            </select>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-goup mb-3">
                            <label for="selectPeroductSubcategory"><span class="">Subcategoría</span></label>
                            <select class="form-select select2" id="selectPeroductSubcategory" name="selectPeroductSubcategory" required>
                            </select>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-goup mb-3">
                            <label for="selectProductImg"><span class="">Cantidad de Imagenes</span></label>
                            <select class="form-select" id="selectProductImg" name="selectProductImg" required>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                                <option value="6">6</option>
                                <option value="7">7</option>
                                <option value="8">8</option>

                            </select>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-goup mb-3">
                            <label for="selectPeroductStatus"><span class="">Estatus</span></label>
                            <select class="form-select" id="selectPeroductStatus" name="selectPeroductStatus" required>
                                <option value="active">Activo</option>
                                <option value="inactive">Inactivo</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-6">
                        <div class="form-group mb-3">
                            <label for="productHeight">Alto</label>
                            <input type="number" class="form-control" id="productHeight" name="productHeight" placeholder="Height" required>
                        </div>
                    </div>

                    <div class="col-6">
                        <div class="form-group mb-3">
                            <label for="productWidth">Ancho</label>
                            <input type="number" class="form-control" id="productWidth" name="productWidth" placeholder="Width" required>
                        </div>
                    </div>

                    <div class="col-6">
                        <div class="form-group mb-3">
                            <label for="productLength">Largo</label>
                            <input type="number" class="form-control" id="productLength" name="productLength" placeholder="Length" required>
                        </div>
                    </div>

                    <div class="col-6">
                        <div class="form-goup mb-3">
                            <label for="selectProductDimensionsUnit"><span class="">Unidad de medida</span></label>
                            <select class="form-select" id="selectProductDimensionsUnit" name="selectProductDimensionsUnit" required>
                                <option value="cm">cm</option>
                                <option value="m">m</option>
                                <option value="in">in</option>
                                <option value="ft">ft</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-6">
                        <div class="form-group mb-3">
                            <label for="selectProductWeight">Peso</label>
                            <input type="number" class="form-control" id="selectProductWeight" name="selectProductWeight" placeholder="Weight" required>
                        </div>
                    </div>

                    <div class="col-6">
                        <div class="form-goup mb-3">
                            <label for="selectProductWeightUnit">Unidad de Peso</label>
                            <select class="form-select" id="selectProductWeightUnit" name="selectProductWeightUnit" required>
                                <option value="g">g</option>
                                <option value="kg">kg</option>
                                <option value="lb">Lb</option>
                                <option value="mg">mg</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-9">
                        <div class="form-group mb-3">
                            <label for="productDescription">Descripción del producto</label>
                            <textarea class="form-control summernote" name="productDescription" id="productDescription" cols="30" rows="10" placeholder="Descripción larga del producto." required></textarea>
                        </div>
                    </div>
                    <div class="col-sm-3">

                        <div class="row">
                            <label><span class="">Etiqueta del Producto</span></label>
                            <div class="col-sm-12 col-4">
                                <div class="form-check form-group form-switch">
                                    <input class="form-check-input" type="checkbox" name="productNewness" id="productNewness"> 
                                    <label class="form-check-label" for="productNewness">Novedad</label>
                                </div>
                            </div>
                            <div class="col-sm-12 col-4">
                                <div class="form-check form-group form-switch">
                                    <input class="form-check-input" type="checkbox" name="productBestSeller" id="productBestSeller"> 
                                    <label class="form-check-label" for="productBestSeller">Top Seller</label>
                                </div>
                            </div>
                            <div class="col-sm-12 col-4">
                                <div class="form-check form-group form-switch">
                                    <input class="form-check-input" type="checkbox" name="productOffer" id="productOffer"> 
                                    <label class="form-check-label" for="productOffer">Oferta</label>
                                </div>
                            </div>
                        
                        </div>

                    </div>
                
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
<div class="modal fade" id="viewProductModal" tabindex="-1" user="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg" user="document">
        <div id="modalColor" class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h2 id="titleModal" class="h6 modal-title ">Detalles del Producto</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table class="table" width="300" >
                    <thead>
                        <tr>
                            <th colspan="6">Detalles</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th>SKU: </th>
                            <td id="celSku"></td>
                            <th>EAN: </th>
                            <td id="celEan"></td>
                            <th>Estatus: </th>
                            <td id="celStatus"></td>
                        </tr>
                        <tr>
                            <th>Titulo: </th>
                            <td colspan="5" id="celTitle"></td>
                        </tr>
                        <tr>
                            <th>Stock: </th>
                            <td id="celStock"></td>
                            <th>Precio: </th>
                            <td id="celPrice"></td>
                            <th>Precio Oferta: </th>
                            <td id="celPriceOffer"></td>
                        </tr>
                        <tr>
                            <th>Descripción: </th>
                            <td class="text-wrap" colspan="5" ><p class="text-wrap" id="celDescription"></p></td>
                        </tr>
                        <tr>
                            <th>Palabras Clave: </th>
                            <td class="text-wrap" colspan="5" ><p class="text-wrap" id="celKeywords"></p></td>
                        </tr>
                        <tr>
                            <th>Marca: </th>
                            <td id="celBrand"></td>
                            <th>Categoría: </th>
                            <td id="celCategory"></td>
                            <th>Subcategoría: </th>
                            <td id="celSubcategory"></td>
                        </tr>
                        <tr>
                            <th>Novedad: </th>
                            <td id="celNewness"></td>
                            <th>Top Seller: </th>
                            <td id="celTopSeller"></td>
                            <th>Oferta: </th>
                            <td id="celOffer"></td>
                        </tr>
                        <tr>
                            <th>Alto: </th>
                            <td id="celHeight"></td>
                            <th>Ancho: </th>
                            <td id="celWidth"></td>
                            <th>Largo: </th>
                            <td id="celLength"></td>
                        </tr>
                        <tr>
                            <th>Unidad Dimensiones: </th>
                            <td id="celDimensionsUnit"></td>
                            <th>Peso: </th>
                            <td id="celWeight"></td>
                            <th>Unidad Peso: </th>
                            <td id="celWeightUnit"></td>
                        </tr>
                        <tr>
                            <th>Número de Imagenes: </th>
                            <td id="celImages"></td>
                            <th>Actualización: </th>
                            <td id="celDate"></td>
                            <th>Pedidos: </th>
                            <td id="celSales"></td>
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