<nav class="navbar navbar-inverse">
    <div class="navbar-header">
        <button type="button" data-target="#navbarCollapse" data-toggle="collapse" class="navbar-toggle">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a href="#" id="principal" class="navbar-brand">FacturEye</a>
    </div>
    <!-- Collection of nav links, forms, and other content for toggling -->
    <div id="navbarCollapse" class="collapse navbar-collapse">
        <ul class="nav navbar-nav">
            <li><a href="#" id="link_factures"><i class='glyphicon glyphicon-list-alt'></i> Factures <span class="sr-only">(current)</span></a></li>
            <li><a href="#" id="link_productes"><i class='glyphicon glyphicon-barcode'></i> Productes</a></li>
            <li><a href="#" id="link_clients"><i class='glyphicon glyphicon-user'></i> Clients</a></li>
            <li><a href="#" id="link_treballadors"><i class='glyphicon glyphicon-lock'></i> Treballadors</a></li>
            <li><a href="#" id="link_noticies"><i class='glyphicon glyphicon-file'></i> Noticies</a></li>
            <li><a href="#" id="link_config"><i class='glyphicon glyphicon-cog'></i> Configuració</a></li>
        </ul>
        <ul class="nav navbar-nav navbar-right">
            <li><a href="#" id="logout"><i class='glyphicon glyphicon-off'></i> Salir</a></li>
        </ul>
    </div>
</nav>
<script>
    $('#logout').click(function(){
        $(location).attr('href',"<?php echo site_url('factureye/logout')?>");
    });
    $('#principal').click(function(){
        $(location).attr('href',"<?php echo site_url('factureye/factures')?>");
    });
    $('#link_factures').click(function(){
        $(location).attr('href',"<?php echo site_url('factureye/factures')?>");
    });
    $('#link_productes').click(function(){
        $(location).attr('href',"<?php echo site_url('factureye/productes')?>");
    });
    $('#link_clients').click(function(){
        $(location).attr('href',"<?php echo site_url('factureye/clients')?>");
    });
    $('#link_treballadors').click(function(){
        $(location).attr('href',"<?php echo site_url('factureye/treballadors')?>");
    });
    $('#link_noticies').click(function(){
        $(location).attr('href',"<?php echo site_url('factureye/noticies')?>");
    });
    $('#link_config').click(function(){
        $(location).attr('href',"<?php echo site_url('factureye/configurar_web')?>");
    });
</script>