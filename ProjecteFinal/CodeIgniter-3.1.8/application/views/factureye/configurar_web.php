<div id="fondo">
    <div class="panel panel-primary" id='panel_intern'>
        <div class="panel-heading">
            <h1>Configuració</h1>
        </div>
        <div class="panel-body">
            <div class="container">
                <form enctype="multipart/form-data" method="post" name="Form" action="<?= base_url();?>factureye/modificar_config">
                    <div class="row" style="float:left;">
                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                            <?php
                            if ($arrayLogo['logo'] == false){
                                $imatge = "<img class='img_responsive' src='https://vignette.wikia.nocookie.net/dragonball/images/3/32/Cruz-roja-x-mal-no-clipart_428380.jpg/revision/latest?cb=20121120163956&path-prefix=es'>";
                            }else{
                                $imatge = "<img class='img_responsive' src='data:image/jpeg; base64,".base64_encode($arrayLogo['logo'])."'>";
                            }
                            echo $imatge;
                            ?>
                            <br/>
                            <div class="form-group">
                                Logo: <input type="file" class="form-control" name="imagen" style="color: transparent"/><br />
                                <small class="imgHelp" class="form-text text-muted">Format: jpg o png.</small><br/>
                                <small class="imgHelp" class="form-text text-muted">Pes maxim: 100KB.</small><br/><br/>
                            </div>
                        </div>
                    </div>
                    <div class="row"style="width: 100%;">
                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                            <input type="hidden" value=1>
                            <div class="form-group">
                                <label for="nom_empresa">Nom de l'empresa:</label>
                                <input type="text" class="form-control" id="nom_empresa" name="nom_empresa" value="<?php echo $info['nom_empresa']; ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="direccio">Direccio:</label>
                                <input type="text" class="form-control" id="direccio" name="direccio" value="<?php echo $info['direccio']; ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="ciutat">Ciutat:</label>
                                <input type="text" class="form-control" id="ciutat" name="ciutat" value="<?php echo $info['ciutat']; ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="codi_postal">Codi Postal:</label>
                                <input type="text" class="form-control" id="codi_postal" name="codi_postal" value="<?php echo $info['codi_postal']; ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="provincia">Provincia:</label>
                                <input type="text" class="form-control" id="provincia" name="provincia" value="<?php echo $info['provincia']; ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="telefon">Telefon:</label>
                                <input type="text" class="form-control" id="telefon" name="telefon" value="<?php echo $info['telefon']; ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="email">Correu Electronic de contacte:</label>
                                <input type="text" class="form-control" id="email" name="email" value="<?php echo $info['email']; ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="impost">Impost (IVA) en %:</label>
                                <input type="number" class="form-control" id="impost" name="impost" value="<?php echo $info['impost']; ?>" required>
                            </div>
                            <input type="submit" class="btn-info" >
                        </div> 
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>