<div id="fondo">
    <div class="panel panel-primary" id='panel_intern'>
        <div class="panel-heading">
            <h1>Nou Treballador</h1>
        </div>
        <div class="panel-body">
            <div class="container">
                <form enctype="multipart/form-data" method="post" name="Form" id="form_treballador" action="<?= base_url();?>factureye/afegirTreballador">
                    <div class="form-group">
                        <label for="first_name">Nom</label>
                        <input type="text" class="form-control" id="first_name" placeholder="Nom" name="first_name" required>
                    </div>
                    <div class="form-group">
                        <label for="last_name">Cognom</label>
                        <input type="text" class="form-control" id="last_name" placeholder="Cognom" name="last_name" required>
                    </div>
                    <div class="form-group">
                        <label for="username">Nom d'usuari</label>
                        <input type="text" class="form-control" id="username" placeholder="Nom d'usuari" name="username" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Contrassenya</label>
                        <input type="password" class="form-control" id="password" placeholder="Contrassenya" name="password" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Correu Electronic</label>
                        <input type="email" class="form-control" id="email" placeholder="Correu Electronic" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="phone">Telefon</label>
                        <input type="text" class="form-control" id="phone" placeholder="Telefon" name="phone" required>
                    </div>
                    <input type="hidden" name="active" value='1'>
                    <div class="form-group">
                        <label for="grup">Grup d'usuari: </label>
                        <select name="grup" form="form_treballador" id="grup">
                            <option value="1">Administrador</option>
                            <option value="2">Treballador</option>
                        </select>
                    </div>
                    <input type="submit" class="btn btn-info" value='Afegir'>
                </form>
            </div>
        </div>
    </div>
</div>