<div id="fondo">
    <div class="panel panel-primary" id='panel_intern'>
        <div class="panel-heading">
            <h1>Treballadors</h1>
        </div>
        <div class="panel-body">
            <div class="container">
                <button class='btn btn-success' id="nou_treballador">Nou Treballador</button>
                <form enctype="multipart/form-data" method="post" name="FormUsers" action="<?= base_url();?>factureye/eliminarTreballador">
                    <table cellpadding=0 cellspacing=10 class="table">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Nom</th>
                                <th>Cognom</th>
                                <th>Nom d'usuari</th>
                                <th>Contrassenya</th>
                                <th>Correu Electronic</th>
                                <th>Telefon</th>
                                <th>Accions</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php for ($i=0; $i<count($arrayUsuaris); $i++){ ?>
                            <tr>
                                <td><input type='checkbox' name='id[]' value="<?php echo $arrayUsuaris[$i]['id'];?>"></td>
                                <td><?php echo htmlspecialchars($arrayUsuaris[$i]['first_name'],ENT_QUOTES,'UTF-8');?></td>
                                <td><?php echo htmlspecialchars($arrayUsuaris[$i]['last_name'],ENT_QUOTES,'UTF-8');?></td>
                                <td><?php echo htmlspecialchars($arrayUsuaris[$i]['username'],ENT_QUOTES,'UTF-8');?></td>
                                <td><?php echo htmlspecialchars($arrayUsuaris[$i]['password'],ENT_QUOTES,'UTF-8');?></td>
                                <td><?php echo htmlspecialchars($arrayUsuaris[$i]['email'],ENT_QUOTES,'UTF-8');?></td>
                                <td><?php echo htmlspecialchars($arrayUsuaris[$i]['phone'],ENT_QUOTES,'UTF-8');?></td>
                                <td>
                                    <a class="btn btn-primary" href="<?php echo site_url("factureye/modificarTreballador/".$arrayUsuaris[$i]['id'])?>"><i class='glyphicon glyphicon-cog'></i></a>
                                </td>
                            </tr>
                        <?php }?>
                        </tbody>
                    </table>
                    <input class='btn btn-danger' type='submit' value='Eliminar'>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    $('#nou_treballador').click(function(){
        $(location).attr('href',"<?php echo site_url('factureye/nouTreballador')?>");
    });
</script>