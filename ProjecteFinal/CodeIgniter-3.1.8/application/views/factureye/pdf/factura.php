<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>FacturEye</title>
        <style>
            table{
                font-family: "Arial Black", Gadget, sans-serif;
            }
            .table {
                border-collapse: collapse;
                width: 100%;
            }
            .table th, td {
                text-align: left;
                padding: 8px;
            }

            .table tr:nth-child(even) {background-color: #D8D8D8;}
        </style>
    </head>
    <body>
        <div id="contenidor_factura">
            <table callspacing="15" cellpadding="5">
                <tbody>
                    <tr>
                        <td style="width: 25%; color: #444444;">
                            <?php
                            if ($arrayLogo['logo'] == false){
                                $imatge = "<img width='250px'; src='".FCPATH."img\\x.jpg'>";
                            }else{
                                $imatge = "<img width='250px'; src='".FCPATH."img\\".$arrayLogo['nom']."'>";
                            }
                            echo $imatge;
                            ?>
                        </td>
                        <?php for($td=0; $td<18; $td++){
                            echo "<td></td>";
                        } ?>
                        <td style="width: 50%; color: #34495e;font-size:12px;text-align:center;">
                            <?php
                            echo "<span style='color: #34495e;font-size:14px;font-weight:bold'>".$arrayInfoEmpresa['nom_empresa']."</span><br/>";
                            echo "<b>".$arrayInfoEmpresa['direccio']."</b><br/>";
                            echo "<b>".$arrayInfoEmpresa['ciutat'].", ".$arrayInfoEmpresa['provincia'].", ".$arrayInfoEmpresa['codi_postal']."</b><br/>";
                            echo "<b>".$arrayInfoEmpresa['email']."</b><br/>";
                            echo "<b>".$arrayInfoEmpresa['telefon']."</b><br/>";
                            ?>
                        </td>
                    </tr>
                </tbody>
            </table>
            <br/>
            <table cellpadding="5" class="table" style="width:30%;">
                <thead>
                    <tr>
                        <th>Informaci&#243; de la Factura</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td><b>Numero de Factura: </b> <?php echo htmlspecialchars($arrayInfoFactura[0]['numero_factura'],ENT_QUOTES,'UTF-8');?></td></tr>
                    <tr><td><b>Client : </b><?php echo htmlspecialchars($arrayInfoFactura[0]['nom_client'],ENT_QUOTES,'UTF-8');?></td></tr>
                    <tr><td><b>Venedor : </b><?php echo htmlspecialchars($arrayInfoFactura[0]['first_name'],ENT_QUOTES,'UTF-8')." ".htmlspecialchars($arrayInfoFactura[0]['last_name'],ENT_QUOTES,'UTF-8');?></td></tr>
                </tbody>
            </table>
            <br/>
            <table cellpadding="10" class="table">
                <thead>
                    <tr>
                        <th>Codi Producte</th>
                        <th>Nom Producte</th>
                        <th>Quantitat</th>
                        <th>Preu</th>
                    </tr>
                </thead>
                <tbody>
                <?php 
                $preu_final_sense_iva = 0;
                for ($i=0; $i<count($arrayProductesFactura); $i++){ ?>
                    <tr>
                        <td><?php echo htmlspecialchars($arrayProductesFactura[$i]['codi_producte'],ENT_QUOTES,'UTF-8');?></td>
                        <td><?php echo htmlspecialchars($arrayProductesFactura[$i]['nom_producte'],ENT_QUOTES,'UTF-8');?></td>
                        <td><?php echo htmlspecialchars($arrayProductesFactura[$i]['quantitat'],ENT_QUOTES,'UTF-8');?></td>
                        <td><?php $preu_producte = $arrayProductesFactura[$i]['preu_producte'] * $arrayProductesFactura[$i]['quantitat']; $preu_final_sense_iva = $preu_final_sense_iva+$preu_producte; echo $preu_producte;?></td>
                    </tr> 

                <?php } 
                $iva = intval($arrayInfoEmpresa['impost']);
                $preu_final_amb_iva = $preu_final_sense_iva+($preu_final_sense_iva * $iva / 100);
                ?>
                    <tr>
                        <td></td><td></td>
                        <td><b>IVA : </b></td>
                        <td><b><?php echo htmlspecialchars($arrayInfoEmpresa['impost'],ENT_QUOTES,'UTF-8');?>%</b></td>
                    </tr>
                    <tr>
                        <td></td><td></td>
                        <td><b>Preu Final (SENSE IVA): </b></td>
                        <td><b><?php echo htmlspecialchars($preu_final_sense_iva,ENT_QUOTES,'UTF-8');?>&#8364;</b></td>
                    </tr>
                    <tr>
                        <td></td><td></td>
                        <td><b>Preu Final (AMB IVA): </b></td>
                        <td><b><?php echo htmlspecialchars($preu_final_amb_iva,ENT_QUOTES,'UTF-8');?>&#8364;</b></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </body>
</html>