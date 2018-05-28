<html>
  <head>
      <link rel="stylesheet" type="text/css" href="./assets/css/dompdf.css">
  </head>

<body>

  <header>
      <table>
          <tr>
              <td id="header_logo">
                  <img id="logo" src="./assets/images/hd.png">
              </td>
              <td id="header_texto">
                  <div>CENTRO NACIONAL DE TUTORIALES MÉXICO Y ALREDEDORES</div>
                  <div>Consejo de alguna institución para el desarrollox</div>
                  <div>"La mejor de mí para ustedes"</div>
              </td>

              <td id="header_logos">
                  <img id="logo1" src="./assets/images/hd1.png">
                  <img id="logo2" src="./assets/images/hd2.png">
              </td>
          </tr>
      </table>
  </header>
  <footer>
      <div id="footer_texto">Aquí habrá algo relevante para el footer del documento, tiene border top 3px, fontsize de 9px y texto centrado</div>
  </footer>

  <table border="1" id="table_info">
       <thead>
           <tr>
               <th>Nombre</th>
               <th>Email</th>
               <th>Teléfono</th>
               <th>Edad</th>
               <th>Sexo</th>
           </tr>
       </thead>
       <tbody>
          <?php foreach ($usuarios as $usuario) { ?>
            <tr>
                <td><?php echo $usuario->nombre;?></td>
                <td><?php echo $usuario->email;?></td>
                <td><?php echo $usuario->telefono;?></td>
                <td><?php echo $usuario->edad;?></td>
                <td><?php echo $usuario->sexo;?></td>
            </tr>
          <?php  }?>
       </tbody>
</table>



</body>
</html>
