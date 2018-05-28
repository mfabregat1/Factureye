<div id="fondo">
    <div class="panel panel-primary" id='panel_intern'>
        <div class="panel-heading">
            <h1>Treballadors</h1>
        </div>
        <div class="panel-body">
            <div class="container">
                <h4><b>Numero de Factura : </b><?php echo htmlspecialchars($arrayInfoFactura[0]['numero_factura'],ENT_QUOTES,'UTF-8');?></h4>
                <h4><b>Client : </b><?php echo htmlspecialchars($arrayInfoFactura[0]['nom_client'],ENT_QUOTES,'UTF-8');?></h4>
                <h4><b>Venedor : </b><?php echo htmlspecialchars($arrayInfoFactura[0]['first_name'],ENT_QUOTES,'UTF-8')." ".htmlspecialchars($arrayInfoFactura[0]['last_name'],ENT_QUOTES,'UTF-8');?></h4>
                <br/><br/>
                <form enctype="multipart/form-data" method="post" name="FormProducts" onSubmit="return enviado()" action="<?= base_url();?>factureye/inserirProductesQuantitat">
                    <input type='hidden' name='id_factura' value="<?php echo $arrayInfoFactura[0]['id_factura'];?>"/>
                    <table cellpadding=0 cellspacing=10 class="table">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Quantitat</th>
                                <th>Codi Producte</th>
                                <th>Nom Producte</th>
                                <th>Marca</th>
                                <th>Categoria</th>
                                <th>Subcategoria</th>
                                <th>Estat</th>
                                <th>Preu</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php for ($i=0; $i<count($arrayProductes); $i++){ ?>
                            <tr>
                                <td><input type='checkbox' class="checkbox" name='id[]' value="<?php echo $arrayProductes[$i]['id_producte'];?>"/></td>
                                <td><input type='number' class="field" disabled name='quantitat[]'/></td>
                                <td><?php echo htmlspecialchars($arrayProductes[$i]['codi_producte'],ENT_QUOTES,'UTF-8');?></td>
                                <td><?php echo htmlspecialchars($arrayProductes[$i]['nom_producte'],ENT_QUOTES,'UTF-8');?></td>
                                <td><?php echo htmlspecialchars($arrayProductes[$i]['marca_producte'],ENT_QUOTES,'UTF-8');?></td>
                                <td><?php echo htmlspecialchars($arrayProductes[$i]['categoria'],ENT_QUOTES,'UTF-8');?></td>
                                <td><?php echo htmlspecialchars($arrayProductes[$i]['subcategoria'],ENT_QUOTES,'UTF-8');?></td>
                                <td><?php if($arrayProductes[$i]['estat_producte']==0){echo "No disponible";} else if($arrayProductes[$i]['estat_producte']==1){echo "Disponible";}else{echo "Error";}?></td>
                                <td><?php echo htmlspecialchars($arrayProductes[$i]['preu_producte'],ENT_QUOTES,'UTF-8');?></td>
                            </tr>
                        <?php }?>
                        </tbody>
                    </table>
                    <input class='btn btn-danger' type='submit' value='Afegir'>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    $('#nou_treballador').click(function(){
        $(location).attr('href',"<?php echo site_url('factureye/nouTreballador')?>");
    });
    $('.checkbox').change(function() {
        $(this).parent().next().find('.field').prop('disabled', !$(this).is(':checked'))
    });
</script>