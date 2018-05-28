<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h3 class="modal-title" id="exampleModalLabel">Modificar Producte</h3>
      </div>
      <div class="modal-body">
        <form enctype="multipart/form-data" method="post" name="FormUsers" action="<?= base_url();?>factureye/modificarProducteFactura">
            <input type="hidden" name="id_factura" class="id_factura" value="<?php echo $arrayInfoFactura[0]['id_factura']; ?>"/>
            <input type="hidden" name="id_producte" class="id_producte" value="1"/>
            <div class="form-group">
                <label for="quantitat" class="col-form-label">Nova Quantitat:</label>
                <input type='number' id="quantitat" class="field" name='quantitat' required/>
            </div>
            <input type="submit" class="btn btn-info" value="Actualitza">
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tanca</button>
      </div>
    </div>
  </div>
</div>