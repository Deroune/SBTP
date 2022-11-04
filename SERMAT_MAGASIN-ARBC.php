<?php
session_start();
include 'index.php';
?>



<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>



    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
	<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
	<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>


<?php

$cn = mysqli_connect("localhost", "root", "", "vrd");
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $resultBC = mysqli_query($cn, "select sermat_commandes.ID_COM,sermat_commandes.ID_MAG,sermat_commandes.TVA,sermat_commandes.N_COMMANDE ,sermat_commandes.DATE_COMMANDE,sermat_commandes.DATE_LIV,fournisseurs.FOURNISSEUR
                       from sermat_commandes INNER JOIN fournisseurs on fournisseurs.ID_FOURNISSEUR=sermat_commandes.ID_FOURNISSEUR  where ID_COM='$id'   ");

    $resultBCARTICLE = mysqli_query($cn, "SELECT bc_articles.ID_AR, bc_articles.ID_COM, bc_articles.ID_MAG, bc_articles.ID_MACHINE, sermat_engin.MATERIEL,
                       bc_articles.CODE_PRODUIT, bc_articles.QTE,bc_articles.PU, bc_articles.NOTE,produits.PRODUIT,produits.U
                       FROM bc_articles INNER JOIN produits on produits.CODE_PRODUIT=bc_articles.CODE_PRODUIT    AND  bc_articles.ID_COM ='$id'
                     INNER JOIN sermat_commandes on sermat_commandes.ID_COM=bc_articles.ID_COM
                     INNER JOIN sermat_engin on bc_articles.ID_MACHINE=sermat_engin.ID_M     ");
}

$resultFR = mysqli_query($cn, "SELECT * FROM `fournisseurs` ");
$resultFR1 = mysqli_query($cn, "SELECT * FROM `fournisseurs` ");

?>
<main id="main" class="main">



















    <div class="row">
        <div class="col-md-4" style="height:200px">



            <style>
                dt {
                    float: left;
                    clear: left;
                    width: 110px;
                    font-weight: normal;
                    color: black;

                }

                dd {
                    margin: 0 0 0 80px;
                    padding: 0 0 0.5em 0;
                    font-weight: bold;
                    color: darkblue;
                }
            </style>


            <?php
            while ($row = mysqli_fetch_array($resultBC)) {
                $NBC2 = $row['ID_COM'];
                $NMAG = $row['ID_MAG'];

                echo '<div class="card ">';
                echo '<div class="card-body">';

                echo '<div class="row">';

                echo '<div class="col-xs-12">';
                echo '<h4 class="card-title" style="text-align:LEFT" >Commande :' . "  " . $row['N_COMMANDE'] . " - " . $row['FOURNISSEUR'] . '</h4>';
                echo "</div>";

                echo "</div>";

                echo '<div class="col-xs-12" style="font-weight: bolder ; font-family:Microsoft Tai Le ">';
                echo '<div class="form-group row">';

                $TVA = $row['TVA'];

                echo '<dl>';

                echo '<dt class="card-text"  >Date de Commande :' . '</dt>';
                echo '<dd class="card-text" >' . " " . $row['DATE_COMMANDE'] . '</dd>';
                echo '<dt class="card-text"  >Date de Livraison :' . '</dt>';
                echo '<dd class="card-text" >' . " " . $row['DATE_LIV'] . '</dd>';
                echo '<dt class="card-text"  >Imputation :' . '</dt>';

                echo '</dl>';

                echo "</div>";
                echo "</div>";
                echo "</div>";
                echo "</div>";
            }

            ?>

        </div>






        <div class="col-md-8">
            <div class="card">
                <div class="card-body">

                    <h4 class="card-title">Ajouter Articles au bon Commande</h4>

                    <?php

                    $connect = mysqli_connect("localhost", "root", "", "vrd");



                    $country = '';
                    $query = "SELECT  DISTINCT *  FROM `produits` ORDER BY PRODUIT  ";

                    $result = mysqli_query($connect, $query);
                    while ($row = mysqli_fetch_array($result)) {
                        $country .= '<option value="' . $row["PRODUIT"] . '">' . $row["PRODUIT"] . '</option>';
                    }

                    $MATERIEL1 = '';
                    $queryMAT = "SELECT  *FROM `sermat_engin`";

                    $result = mysqli_query($connect, $queryMAT);
                    while ($row = mysqli_fetch_array($result)) {
                        $MATERIEL1 .= '<option value="' . $row["MATERIEL"] . '">' . $row["MATERIEL"] . '</option>';
                    }
                    ?>
                    <div class="row">

                        <form action="SERMAT_NVARTICLEBC.php" method="POST">
                            <div class="table-responsive">

                                <!-- COMBOBOX ARTICLE -->

                                <table class="table table-bordered">

                                    <tr>



                                        <td class="hidden"><input type="text" name="IDMAG" class="hidden" value=" <?php echo $NMAG ?>" />
                                        <td class="hidden"><input type="text" name="IDCOM" class="hidden" value=" <?php echo $NBC2 ?>" />


                                        <td><select   name="NPRODUIT" id="NPRODUIT" class="myselect action" style="width: 280px;">
                                                <option value="">Produit</option><?php echo $country ?>
                                            </select>
                                        <td><select  name="CODEPRODUIT" id="CODEPRODUIT" class="myselect action" style="width: 100px;" >
                                                <option value="">Code</option>
                                            </select></td>

                                            <td><select name="IMPUTATION" id="IMPUTATION" class="myselect action" style="width: 300px;">
                                                <option value="">Imputation</option><?php echo $MATERIEL1 ?>
                                            </select>
                                        <td><select    name="IMPUTATION1" id="IMPUTATION1" class="myselect action" style="width:120PX">
                                                <option value="">ID_M</option>
                                            </select></td>

                                       
                                        <td><input type="text" name="QTE" placeholder="quantité" class="form-control QTE_list" style="HEIGHT: 30px;"/></td>
                                        <td><input type="text" name="PU" placeholder="PU" class="form-control PU_list"style="HEIGHT: 30px;" /></td>
                                        <td><input type="text" name="NOTE" placeholder="Note" class="form-control NOTE_list"style="HEIGHT: 30px;" /> </td>




                                        <td> <button type="submit" name="submit" id="submit" class="btn btn-outline-success " style="HEIGHT: 30px;"  href="SERMAT_MAGASIN-ARBC.php?id=' <?php echo $NBC2 ?> '"><span class="glyphicon glyphicon-ok" style="text-align:left ;font-weight: 750 "> </span> </button> </td>
                                    </tr>
                                </table>


                            </div>
                        </form>



                    </div>






                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Articles de La commande</h5>



                    <div class="col-xs-12">
                    
                    <table id="dtBasicExampleSTOCKD" class="table table-bordered table-sm" cellspacing="0" hight="100%">

                            <thead style="background-color:azure; color:DARKBLUE">
                                <tr>

                                   
                                    <th>
                                        Code Produit
                                    </th>
                                    <th>
                                        Produit
                                    </th>
                                 
                                    <th>
                                        Unité
                                    </th>
                                    <th>
                                        Quantité
                                    </th>
                                    <th>
                                       PU
                                    </th>
                                    <th>
                                        Imputation
                                    </th>

                                    <th>
                                        Montant HT
                                    </th>
                                 
                                    <th>
                                        Ac
                                    </th>
                            </thead>



                            <?php

                            echo '<tbody style="font-size:small">';

                            while ($row = mysqli_fetch_array($resultBCARTICLE)) {

                                echo '<tr style="font-size:small">';

                             
                                echo '<td>' . $row['CODE_PRODUIT'] . '   </td> ';
                                echo '<td>' . $row['PRODUIT'] . ' </td> ';
                             
                                echo '<td>' . $row['U'] . '</td> ';
                                echo '<td style="text-align:left ;font-weight: bold ">' . $row['QTE'] . '    </td> ';
                                echo '<td>' . $row['PU'] . '</td> ';
                                echo '<td>' . $row['MATERIEL'] . ' </td> ';
                             

                                echo '<td style="text-align:left ;font-weight: bold ">' . " " . number_format($row['PU'] * $row['QTE'], 2, ',', '.') . ' </td> ';
                             
                                echo '<td>
                                <a
                                href="SERMAT_MAGASIN-dlARBC.php?id=' . $row['ID_AR'] . ' &id1=' . $row['ID_COM'] . ' "

                                 class="btn btn-outline-danger btn-sm" > <span class="glyphicon glyphicon-trash"> </span>

                                 </a>
                                 </td>';
                                echo '</tr>';

                                echo '</tbody>';
                            }

                            echo '  </table>';
                            echo ' </div>';

                            $resultBCSUM = mysqli_query($cn, "SELECT SUM(QTE*PU),ID_COM  FROM bc_articles  WHERE  ID_COM =' $id ' GROUP BY ID_COM    ");

                            while ($row = mysqli_fetch_array($resultBCSUM)) {
                                $totalBC = $row['SUM(QTE*PU)'];

                                if ($totalBC === 0) {
                                } else {

                                    echo ' <div class="form-group row " >';

                                    echo '  <div class="col-xs-6">';

                                    echo "</div>";

                                    echo '  <div class="col-xs-5">';

                                    echo '<dt class="card-text" style="text-align:left ;font-weight: 750 "  >Total HT' . '</dt>';

                                    echo "<dd class='card-text' style='text-align:right ;font-weight: 750 '   >" . " " . number_format($totalBC, 2, ',', '.') . "</dd>";

                                    echo '<dt class="card-text" style="text-align:left ;font-weight: 750"  >TVA de ' . $TVA . ' %</dt>';

                                    echo "<dd class='card-text' style='text-align:right ;font-weight: 750'  >" . " " . number_format(($TVA * $totalBC) * 0.01, 2, ',', '.') . "</dd>";

                                    echo '<dt class="card-text" style="text-align:left ;font-weight: 800 "  >Total TTC' . '</dt>';

                                    echo "<dd class='card-text' style='text-align:right ; font-weight: 800 '   >" . " " . number_format($totalBC + ($TVA * $totalBC) * 0.01, 2, ',', '.') . "</dd>";

                                    echo "</div>";

                                    echo "</div>";
                                }
                            }
                            ?>
                    </div>
                </div>
            </div>
        </div>

    </div>









    <script>
        $(document).ready(function() {
            $('.action').change(function() {
                if ($(this).val() != '') {
                    var action = $(this).attr("id");
                    var query = $(this).val();
                    var result = '';

                    if (action == "NPRODUIT") {

                        result = 'CODEPRODUIT';

                    }
                    if (action == "IMPUTATION") {

                        result = 'IMPUTATION1';

                    }


                    $.ajax({
                        url: "fetch1.php?id=<?php echo $id ?> ",
                        method: "POST",
                        data: {
                            action: action,
                            query: query,

                        },
                        success: function(data) {
                            $('#' + result).html(data);
                        }
                    })

                }
            });
        });
    </script>





    <script type="text/javascript">
      $(".myselect").select2();
</script>














    <script src="assets1/plugins/data-tables/jquery.datatables.min.js"></script>
    <script src="assets1/plugins/data-tables/datatables.bootstrap4.min.js"></script>
    <link href="assets1/plugins/data-tables/datatables.bootstrap4.min.css" rel="stylesheet">


</main>