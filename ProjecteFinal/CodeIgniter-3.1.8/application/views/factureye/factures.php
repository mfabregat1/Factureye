<div id="fondo">
    <div class="panel panel-primary" id='panel_intern'>
        <div class="panel-heading">
            <h1>Factures</h1>
        </div>
        <div class="panel-body">
            <div class="container">
                <button class='btn btn-success' id="nova_factura">Nova Factura</button>
                <table cellpadding=0 cellspacing=10 class="table">
                    <thead>
                        <tr>
                            <th>Nº Factura</th>
                            <th>Data Factura</th>
                            <th>Client</th>
                            <th>Venedor</th>
                            <th>Estat</th>
                            <th>Preu Total</th>
                            <th>Accions</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php for ($i=0; $i<count($arrayFactures); $i++){ ?>
                        <tr>
                            <td><?php echo htmlspecialchars($arrayFactures[$i]['numero_factura'],ENT_QUOTES,'UTF-8');?></td>
                            <td><?php echo htmlspecialchars($arrayFactures[$i]['data_factura'],ENT_QUOTES,'UTF-8');?></td>
                            <td><?php echo htmlspecialchars($arrayFactures[$i]['nom_client'],ENT_QUOTES,'UTF-8');?></td>
                            <td><?php echo htmlspecialchars($arrayFactures[$i]['first_name'],ENT_QUOTES,'UTF-8')." ".htmlspecialchars($arrayFactures[$i]['last_name'],ENT_QUOTES,'UTF-8');?></td>
                            <td><?php if($arrayFactures[$i]['estat_factura']==0){echo "Per Pagar";} else if($arrayFactures[$i]['estat_factura']==1){echo "Pagat";}else{echo "Error";}?></td>
                            <td><?php echo htmlspecialchars($arrayFactures[$i]['total_venta'],ENT_QUOTES,'UTF-8');?></td>
                            <td>
                                <a class="btn btn-primary" href="<?php echo site_url("factureye/veureFactura/".$arrayFactures[$i]['id_factura'])?>"><i class='glyphicon glyphicon-cog'></i></a>
                                <a class="btn btn-primary" href="<?php echo site_url("factureye/generar_pdf/".$arrayFactures[$i]['id_factura'])?>" target="_blank"><i class='glyphicon glyphicon-print'></i></a>
                                <a class="btn btn-primary" href="<?php echo site_url("factureye/eliminarFactura/".$arrayFactures[$i]['id_factura'])?>"><i class='glyphicon glyphicon-remove'></i></a>
                            </td>
                        </tr>
                    <?php }?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script>
    $('#nova_factura').click(function(){
        $(location).attr('href',"<?php echo site_url('factureye/novaFactura')?>");
    });
</script>