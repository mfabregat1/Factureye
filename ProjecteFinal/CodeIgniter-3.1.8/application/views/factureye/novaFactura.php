<div id="fondo">
    <div class="panel panel-primary" id='panel_intern'>
        <div class="panel-heading">
            <h1>Nova Factura</h1>
        </div>
        <div class="panel-body">
            <div class="container">
                <form enctype="multipart/form-data" method="post" name="Form" id="form_factura" action="<?= base_url();?>factureye/crearFactura">
                    <div class="form-group">
                        <label for="first_name">Numero de Factura</label>
                        <?php 
                            if(isset($arrayUltimaFactura[0]['id_factura'])){
                                $numFacturaActual = $arrayUltimaFactura[0]['id_factura']+1; 
                            }else{
                                $numFacturaActual = 1;
                            }
                        ?>
                        <input type="text" class="form-control" id="numero_factura" placeholder="Numero Factura" name="numero_factura" value="<?php echo $numFacturaActual;?>" required>
                    </div>
                    <div class="form-group">
                        <label for="client">Client: </label>
                        <select name="client" class="form-control" id="client" form="form_factura">                         
                            <?php
                                foreach ($arrayClients as $client)
                                    echo '<option value="'.$client['id_client'].'">'.$client['nom_client'].'</option>';
                            ?>
                        </select>
                    </div>
                    <input type="submit" class="btn btn-info" value='Crear i afegir productes'>
                </form>
            </div>
        </div>
    </div>
</div>