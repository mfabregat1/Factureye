<div id="fondo">
    <div class="panel panel-primary" id='panel_intern'>
        <div class="panel-heading">
            <h1>Editar Treballador</h1>
        </div>
        <div class="panel-body">
            <div class="container">
                <form enctype="multipart/form-data" method="post" name="Form" id="form_treballador" action="<?= base_url();?>factureye/modificarInfoTreballador">
                    <input type="hidden" name="id" value="<?php echo $arrayUsuari[0]['id']; ?>">
                    <div class="form-group">
                        <label for="first_name">Nom</label>
                        <input type="text" class="form-control" id="first_name" placeholder="Nom" name="first_name" value="<?php echo $arrayUsuari[0]['first_name']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="last_name">Cognom</label>
                        <input type="text" class="form-control" id="last_name" placeholder="Cognom" name="last_name" value="<?php echo $arrayUsuari[0]['last_name']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="username">Nom d'usuari</label>
                        <input type="text" class="form-control" id="username" placeholder="Nom d'usuari" name="username" value="<?php echo $arrayUsuari[0]['username']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Contrassenya (Opcional)</label>
                        <input type="password" class="form-control" id="password" placeholder="Contrassenya" name="password">
                    </div>
                    <div class="form-group">
                        <label for="email">Correu Electronic</label>
                        <input type="email" class="form-control" id="email" placeholder="Correu Electronic" name="email" value="<?php echo $arrayUsuari[0]['email']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="phone">Telefon</label>
                        <input type="text" class="form-control" id="phone" placeholder="Telefon" name="phone" value="<?php echo $arrayUsuari[0]['phone']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="grup">Grup d'usuari: </label>
                        <select name="grup" form="form_treballador" id="grup">
                            <option value="1">Administrador</option>
                            <option value="2">Treballador</option>
                        </select>
                    </div>
                    <input type="submit" class="btn-warning" value='Modifica'>
                </form>
            </div>
        </div>
    </div>
</div>