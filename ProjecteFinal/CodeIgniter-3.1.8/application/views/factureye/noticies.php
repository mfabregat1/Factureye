<div id="fondo">
    <div class="panel panel-primary" id='panel_intern'>
        <div class="panel-heading">
            <h1>Noticies</h1>
        </div>
        <div class="panel-body">
            <div class="container">
                <button class='btn btn-success' id="nova_noticia">Nova Noticia</button>
                <br/><br/><br/>
                <div id="div_noticies">
                    <?php for ($i=0; $i<count($arrayNoticies); $i++){ ?>
                        <div class="col-xs-12 col-sm-12 col-md-5 col-lg-5" id="div_noticia">
                            <?php
                            if ($arrayNoticies[$i]['imatge'] == false){
                                $imatge = "<img class='img_responsive' src='https://vignette.wikia.nocookie.net/dragonball/images/3/32/Cruz-roja-x-mal-no-clipart_428380.jpg/revision/latest?cb=20121120163956&path-prefix=es'>";
                            }else{
                                $imatge = "<img class='img_responsive' src='data:image/jpeg; base64,".base64_encode($arrayNoticies[$i]['imatge'])."'>";
                            }
                            echo $imatge;
                            ?>
                            <h2><b><?php echo htmlspecialchars($arrayNoticies[$i]['titol_noticia'],ENT_QUOTES,'UTF-8');?></b></h2>
                            <p><b><?php echo htmlspecialchars($arrayNoticies[$i]['noticia'],ENT_QUOTES,'UTF-8');?></b></p>
                            <p><b><?php echo htmlspecialchars($arrayNoticies[$i]['data'],ENT_QUOTES,'UTF-8');?></b></p>
                            <?php echo anchor("factureye/modificarNoticia/".$arrayNoticies[$i]['id_noticia'], "<i class='glyphicon glyphicon-cog'></i> Modificar");?>
                            <?php echo anchor("factureye/eliminarNoticia/".$arrayNoticies[$i]['id_noticia'], "<i class='glyphicon glyphicon-remove'></i> Eliminar");?>
                        </div>
                    <?php }?>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $('#nova_noticia').click(function(){
        $(location).attr('href',"<?php echo site_url('factureye/novaNoticia')?>");
    });
</script>