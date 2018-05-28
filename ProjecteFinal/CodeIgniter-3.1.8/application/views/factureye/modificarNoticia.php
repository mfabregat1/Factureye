<div id="fondo">
    <div class="panel panel-primary" id='panel_intern'>
        <div class="panel-heading">
            <h1>Editar Noticia</h1>
        </div>
        <div class="panel-body">
            <div class="container">
                <form enctype="multipart/form-data" method="post" name="Form" id="form_noticia" action="<?= base_url();?>factureye/modificarInfoNoticia">
                    <input type="hidden" name="id" value="<?php echo $arrayNoticia[0]['id_noticia']; ?>">
                    <div class="form-group">
                        <label for="titol_noticia">Titol de la noticia</label>
                        <input type="text" class="form-control" id="titol_noticia" placeholder="Titol" name="titol_noticia" value="<?php echo $arrayNoticia[0]['titol_noticia']; ?>"required>
                    </div>
                    <div class="form-group">
                        <label for="imatge">Imatge de la noticia</label>
                        <input type="file" id="imatge" class="form-control" name="imagen" style="color: transparent"/><br />
                        <small class="imgHelp" class="form-text text-muted">Format: jpg o png.</small><br/>
                        <small class="imgHelp" class="form-text text-muted">Pes maxim: 100KB.</small><br/>
                    </div>
                    <div class="form-group">
                        <label for="textarea">Cos de la noticia</label>
                        <textarea class="form-control" form="form_noticia" id="textarea" placeholder="Cos Noticia" rows="5" name="noticia"><?php echo $arrayNoticia[0]['noticia']; ?></textarea>
                    </div>
                    <input type="submit" class="btn-warning" value='Modifica'>
                </form>
            </div>
        </div>
    </div>
</div>
