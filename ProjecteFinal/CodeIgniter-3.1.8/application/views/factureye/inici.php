<div id="fondo">
    <div id="cont_inici">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h1>Benvingut a FacturEye</h1>
            </div>
            <div class="panel-body">
                <div id="noticies">
                    <div class="panel panel-primary" style="margin: 0 auto; width: 90%">
                        <div class="panel-heading">
                            <h3>Ultimes noticies...</h3>
                        </div>
                        <div class="panel-body">
                            <?php 
                            $img = $noticia['imatge'];

                            if ($img == ''){
                                $imatge = "<img style='border-radius:25%; width:130px; height:130px;' src='https://vignette.wikia.nocookie.net/dragonball/images/3/32/Cruz-roja-x-mal-no-clipart_428380.jpg/revision/latest?cb=20121120163956&path-prefix=es'>";
                            }else{
                                $imatge = "<img style='border-radius:25%; width:130px; height:130px;' src='data:image/jpeg; base64,".base64_encode($noticia['imatge'])."'>";
                            }
                            echo $imatge;
                            echo "<h4><b>".$noticia['titol_noticia']."</b></h4>";
                            echo "<p><b>".$noticia['noticia']."</b></p>";

                            ?>
                        </div>
                    </div>
                </div>
                <div id="login">
                    <div class="panel panel-primary" style="margin: 0 auto; width: 100%">
                        <div class="panel-heading">
                            <h3>LOGIN</h3>
                        </div>
                        <div class="panel-body">
                            <form method="post" class="form-horizontal" action="<?= base_url();?>factureye/principal">
                                <div class="form-group">
                                    <div class="col-sm-12">
                                        <input name="nom" type="text" class="form-control" id="email" placeholder="Email">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-12"> 
                                      <input name="contra" type="password" class="form-control" id="pwd" placeholder="Contrassenya">
                                    </div>
                                </div>
                                <div class="form-group"> 
                                    <div class="col-sm-offset-2 col-sm-8">
                                      <div class="checkbox">
                                        <label><input name="recordar" type="checkbox">Recordar-me</label>
                                      </div>
                                    </div>
                                </div>
                                <div class="form-group"> 
                                    <div class="col-sm-offset-2 col-sm-8">
                                      <button type="submit" class="btn btn-info">Entrar</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div id="noticies_rss">
                    <div class="panel panel-primary" style="margin: 0 auto; width: 100%">
                        <div class="panel-heading">
                            <h3>Noticies RSS</h3>
                        </div>
                        <div class="panel-body">
                            <a type="application/rss+xml" href="<?= base_url();?>generador_rss.php"><img src="<?= base_url();?>img/icono-rss.gif"></a>
                            <br /><hr />
                            <?php
                            try
                            {
                                //consumir RSS propi
                                $articulos = simplexml_load_string(file_get_contents(base_url().'generador_rss.php'));

                                foreach($articulos->channel->item as $noticia)
                                {
                                    echo "<h3><b>".$noticia->title."</b></h3>";
                                    echo "<p><b>".$noticia->pubDate."</b></p>";
                                    echo "<p>".$noticia->description."</p>";
                                    echo "<br/>";
                                }
                            }
                            catch(Exception $e)
                            {
                                echo 'Excepción capturada: ',  $e->getMessage(), "\n";
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>