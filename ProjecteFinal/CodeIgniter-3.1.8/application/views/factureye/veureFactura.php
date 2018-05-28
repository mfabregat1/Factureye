<div id="fondo">
    <div class="panel panel-primary" id='panel_intern'>
        <div class="panel-heading">
            <h1>Productes de la Factura</h1>
        </div>
        <div class="panel-body">
            <div class="container">
                <h4><b>Numero de Factura : </b><?php echo htmlspecialchars($arrayInfoFactura[0]['numero_factura'],ENT_QUOTES,'UTF-8');?></h4>
                <h4><b>Client : </b><?php echo htmlspecialchars($arrayInfoFactura[0]['nom_client'],ENT_QUOTES,'UTF-8');?></h4>
                <h4><b>Venedor : </b><?php echo htmlspecialchars($arrayInfoFactura[0]['first_name'],ENT_QUOTES,'UTF-8')." ".htmlspecialchars($arrayInfoFactura[0]['last_name'],ENT_QUOTES,'UTF-8');?></h4>
                <a class="btn btn-primary" href="<?php echo site_url('factureye/afegirProductesFactura/'.$arrayInfoFactura[0]['id_factura'])?>"><i class='glyphicon glyphicon-plus'></i>Afegir Producte</a>
                <br/><br/>
                <table cellpadding=0 cellspacing=10 class="table">
                    <thead>
                        <tr>
                            <th>Codi Producte</th>
                            <th>Nom Producte</th>
                            <th>Quantitat</th>
                            <th>Preu</th>
                            <th>Accions</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php 
                    $preu_final_sense_iva = 0;
                    for ($i=0; $i<count($arrayProductesFactura); $i++){ ?>
                        <tr>
                            <td><?php echo htmlspecialchars($arrayProductesFactura[$i]['codi_producte'],ENT_QUOTES,'UTF-8');?></td>
                            <td><?php echo htmlspecialchars($arrayProductesFactura[$i]['nom_producte'],ENT_QUOTES,'UTF-8');?></td>
                            <td><?php echo htmlspecialchars($arrayProductesFactura[$i]['quantitat'],ENT_QUOTES,'UTF-8');?></td>
                            <td><?php $preu_producte = $arrayProductesFactura[$i]['preu_producte'] * $arrayProductesFactura[$i]['quantitat']; $preu_final_sense_iva = $preu_final_sense_iva+$preu_producte; echo $preu_producte;?></td>
                            <td>
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal" data-whatever="<?php echo $arrayProductesFactura[$i]['id_producte'];?>"><i class='glyphicon glyphicon-cog'></i></button>
                                <a class="btn btn-primary" href="<?php echo site_url('factureye/eliminarProducteFactura/'.$arrayInfoFactura[0]['id_factura'].'/'.$arrayProductesFactura[$i]['id_producte'])?>"><i class='glyphicon glyphicon-remove'></i></a>
                            </td>
                        </tr> 
                            
                    <?php } 
                    $iva = intval($arrayInfoEmpresa['impost']);
                    $preu_final_amb_iva = $preu_final_sense_iva+($preu_final_sense_iva * $iva / 100);
                    $this->load->view("factureye/modal/modificar_producte");
                    ?>
                        <tr>
                            <td></td><td></td><td></td>
                            <td><b>IVA : </b></td>
                            <td><b><?php echo htmlspecialchars($arrayInfoEmpresa['impost'],ENT_QUOTES,'UTF-8');?>%</b></td>
                        </tr>
                        <tr>
                            <td></td><td></td><td></td>
                            <td><b>Preu Final (SENSE IVA): </b></td>
                            <td><b><?php echo htmlspecialchars($preu_final_sense_iva,ENT_QUOTES,'UTF-8');?>€</b></td>
                        </tr>
                        <tr>
                            <td></td><td></td><td></td>
                            <td><b>Preu Final (AMB IVA): </b></td>
                            <td><b><?php echo htmlspecialchars($preu_final_amb_iva,ENT_QUOTES,'UTF-8');?>€</b></td>
                        </tr>
                    </tbody>
                </table>
                <form enctype="multipart/form-data" method="post" name="FormUsers" id="form_factura" action="<?= base_url();?>factureye/actualitzarPreuEstatFactura">
                    <input type="hidden" name="preu_final" value="<?php echo $preu_final_amb_iva; ?>">
                    <input type="hidden" name="id_factura" value="<?php echo $arrayInfoFactura[0]['id_factura']; ?>">
                    <div class="form-group">
                        <label for="grup">Estat Factura: </label>
                        <select name="estat" form="form_factura" id="estat">
                            <option value="0">Per Pagar</option>
                            <option value="1">Pagat</option>
                        </select>
                    </div>
                    <input type="submit" class="btn btn-info" value="Crea/Actualitza">
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    $('#exampleModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget)
        var idProducte = button.data('whatever') 
        console.log(idProducte);
        var modal = $(this)
        modal.find('.modal-body .id_producte').val(idProducte)
    })
</script>