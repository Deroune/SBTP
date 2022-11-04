<?php
session_start();
include 'index.php';

?>


<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>







<?php

$cn = mysqli_connect("localhost", "root", "", "vrd");
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $id1 = $_GET['id1'];

    $resultPRO = mysqli_query($cn, "select * FROM produits  where CODE_PRODUIT='$id'   ");

    $resultPROSUM = mysqli_query($cn, "SELECT  PRODUITS.CODE_PRODUIT, produits.PRODUIT, produits.RUPTURE,  produits.U, sermat_stock.DATE_L, sermat_stock.REF, bc_articles.PU,
                                        SUM(sermat_stock.QTE), SUM(sermat_stock.QTE_CONS), SUM(sermat_stock.QTE*bc_articles.PU), SUM(sermat_stock.QTE_CONS*bc_articles.PU)    FROM bc_articles
                                        left  JOIN produits ON bc_articles.CODE_PRODUIT=produits.CODE_PRODUIT
                                        INNER JOIN sermat_stock ON sermat_stock.CODE_PRODUIT=bc_articles.CODE_PRODUIT AND sermat_stock.ID_COM=bc_articles.ID_COM
                                        where  sermat_stock.CODE_PRODUIT='$id' AND sermat_stock.ID_MAG='$id1' ");

    $resultPROBC = mysqli_query($cn, "SELECT  PRODUITS.CODE_PRODUIT, produits.PRODUIT,  produits.U, sermat_commandes.N_COMMANDE, SUM(bc_articles.QTE) , bc_articles.PU,fournisseurs.FOURNISSEUR
                                      FROM `PRODUITS`  INNER  JOIN bc_articles ON bc_articles.CODE_PRODUIT=produits.CODE_PRODUIT
                                    INNER  JOIN sermat_commandes ON bc_articles.ID_COM=sermat_commandes.ID_COM
                                    INNER  JOIN fournisseurs ON fournisseurs.ID_FOURNISSEUR=sermat_commandes.ID_FOURNISSEUR
                                            where  PRODUITS.CODE_PRODUIT='$id' AND sermat_commandes.ID_MAG='$id1' GROUP BY  PRODUITS.CODE_PRODUIT, produits.PRODUIT,  produits.U, sermat_commandes.N_COMMANDE , bc_articles.PU,fournisseurs.FOURNISSEUR
                                        ");
}

$resultLIVRAISON = mysqli_query($cn, "SELECT  PRODUITS.CODE_PRODUIT, produits.PRODUIT, produits.RUPTURE,  produits.U, sermat_stock.DATE_L, sermat_stock.REF,
                                sermat_stock.QTE, sermat_stock.QTE_CONS,sermat_engin.MATERIEL   FROM `PRODUITS`
                                left  JOIN sermat_stock ON sermat_stock.CODE_PRODUIT=produits.CODE_PRODUIT
                                LEFT  JOIN sermat_engin ON sermat_stock.ID_MACHINE=sermat_engin.ID_M where  sermat_stock.CODE_PRODUIT='$id'  AND sermat_stock.ID_MAG='$id1'  ORDER BY DATE_L  ");

$resultCOMSOMMATIONM = mysqli_query($cn, "SELECT sermat_engin.MATERIEL ,sermat_engin.CODE,SUM(sermat_stock.QTE_CONS)  FROM sermat_stock RIGHT JOIN  sermat_engin
  ON sermat_engin.ID_M=sermat_stock.ID_MACHINE WHERE sermat_stock.CODE_PRODUIT='$id'   AND sermat_stock.ID_MAG='$id1'   GROUP BY sermat_engin.MATERIEL,sermat_engin.CODE HAVING SUM(sermat_stock.QTE_CONS)>0 ");
 while ($row = mysqli_fetch_array($resultPRO)) {
 $PRODUIT= $row['PRODUIT'];
 $CODEP= $row['CODE_PRODUIT'];
?>
<main id="main" class="main">

<div>

<?php
$resultMAG = mysqli_query($cn, "select *from magasins where ID_MAG='$id1' ");
while ($row = mysqli_fetch_array($resultMAG)) {
  
$magasin = $row['MAGASIN'];

}
?>
<nav>
    <ol class="breadcrumb">

    <li class="breadcrumb-item"><a href="SERMAT_MAGASIN.php">Magasins de Service Matériel</a></li>
    <li class="breadcrumb-item"><a href="SERMAT_MAGASIN-SUIVI.php?id=<?php echo $id1 ?>"><?php echo $magasin ?></a></li>
    <li class="breadcrumb-item"><a href="SERMAT_MAGASIN-SUIVI.php?id=<?php echo $id1 ?>">Stock</a></li>
  
 
    <li class="breadcrumb-item active"><a><?php echo $PRODUIT ?></li>
  
    </ol>
</nav>
</div><!-- End Page Title -->


    <div class="row">


        <div class="col-lg-3">



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


    
                echo '<div class="card ">';
                echo '<div class="card-body">';

                echo '<div class="row">';

                echo '<div class="col-xs-12">';
                echo '<h4 class="card-title" style="text-align:LEFT" >Produit :' . "  " .  $CODEP . " - " .  $PRODUIT . '</h4>';
                echo "</div>";

                echo "</div>";

                echo '<div class="form-group row">';

                echo '<div class="col-xs-12 " style="font-weight: bolder ; font-family:Microsoft Tai Le ">';
                echo '<dl>';

                while ($row = mysqli_fetch_array($resultPROSUM)) {

                    $QTELIVT = $row['SUM(sermat_stock.QTE)'];
                    $QTEMTLIVT = $row['SUM(sermat_stock.QTE*bc_articles.PU)'];
                    $U = $row['U'];
                    $STOCKCONST = $row['SUM(sermat_stock.QTE_CONS)'];
                    $STOCKMTCONST = $row['SUM(sermat_stock.QTE_CONS*bc_articles.PU)'];

                    $STOCKT = $row['SUM(sermat_stock.QTE)'] - $row['SUM(sermat_stock.QTE_CONS)'];

                    echo '<h4 class="card-title"  >Suivi Stock</h4>';

                    echo '<dt class="card-text"  style="width: 180px;" >Qté livrée  :' . '</dt>';
                    echo '<dd class="card-text" style="text-align:left " >' . " " . number_format($QTELIVT, 2, ',', '.') . "  " . $row['U'] . ' <span class="glyphicon glyphicon-arrow-down"  style="color:limegreen "></span></dd>';
                    echo '<dt class="card-text"  style="width: 180px;"  >Qté consommée :' . '</dt>';
                    echo '<dd class="card-text"style="text-align:left "  >' . " " . number_format($STOCKCONST, 2, ',', '.') . "  " . $row['U'] . ' <span class="glyphicon glyphicon-arrow-up"  style="color:red "></span></dd>';

                    echo '<dt class="card-text" style="width: 180px;"   >Qté Stock :' . '</dt>';
                    if ($STOCKT == 0) {
                        echo '<dd class="card-text" style="text-align:left " >' . " " . number_format($STOCKT, 2, ',', '.') . "  " . $row['U'] . '  <span class="glyphicon glyphicon-remove-circle"  style="color:red "></span></dd>';
                    } else {
                        echo '<dd class="card-text" style="text-align:left " >' . " " . number_format($STOCKT, 2, ',', '.') . "  " . $row['U'] . ' <span class="glyphicon glyphicon-ok-circle"  style="color:limegreen "></span></dd>';
                    }

                    echo '</br>';

                    echo '<dt class="card-text"  style="width: 180px;"  >Montant Livré :' . '</dt>';
                    echo '<dd class="card-text"style="text-align:left "  >' . " " . number_format($QTEMTLIVT, 2, ',', '.') . "  " . ' </dd>';
                    echo '<dt class="card-text"  style="width: 180px;"  >Montant Consommé :' . '</dt>';
                    echo '<dd class="card-text"style="text-align:left "  >' . " " . number_format($STOCKMTCONST, 2, ',', '.') . "  " . ' </dd>';
                    echo '<dt class="card-text"  style="width: 180px;"  >Montant stock :' . '</dt>';
                    echo '<dd class="card-text"style="text-align:left "  >' . " " . number_format($QTEMTLIVT - $STOCKMTCONST, 2, ',', '.') . "  " . ' </dd>';
                }

                echo '</dl>';

            ?>
        </div>
    </div>

    </div>
    </div>

    <div class="card ">
        <div class="card-body">
            <h4 class="card-title">Historique des Commandes</h4>
            <table class="table table-borderless table-sm" cellspacing="0" width="100%">

                <thead>
                    <tr style="font-size:smaller">

                        <th>
                            BC
                        </th>
                        <th>
                            Fournisseur
                        </th>
                        <th>
                            QTE
                        </th>
                        <th>
                            PU
                        </th>



                    </tr>
                </thead>


                <tbody id="myTableST">
                    <?php

                    while ($row = mysqli_fetch_array($resultPROBC)) {

                        $BC = $row['N_COMMANDE'];
                        $FR = $row['FOURNISSEUR'];
                        $PU = $row['PU'];
                        $QTE = $row['SUM(bc_articles.QTE)'];


                        echo '<tr style="font-size:smaller ;">';

                        echo '<td style="font-size:smaller ;">' . $BC . '</td> ';
                        echo '<td style="font-size:smaller ;">' . $FR . '</td> ';
                        echo '<td style="font-size:smaller ;text-align:RIGHT">' . $QTE . '</td> ';
                        echo '<td style="font-size:smaller ;text-align:RIGHT">' . $PU . ' </td> ';

                        echo '</tr>';
                    }

                    ?>
                </tbody>
            </table>
            <?php
                $resultPROBC2 = mysqli_query($cn, "SELECT  sermat_commandes.N_COMMANDE, SUM(bc_articles.QTE*bc_articles.PU) ,fournisseurs.FOURNISSEUR
FROM bc_articles  INNER  JOIN  sermat_commandes ON bc_articles.ID_COM=sermat_commandes.ID_COM
INNER  JOIN fournisseurs ON fournisseurs.ID_FOURNISSEUR=sermat_commandes.ID_FOURNISSEUR
      where  bc_articles.CODE_PRODUIT='$id' GROUP BY   bc_articles.CODE_PRODUIT
  ");

                while ($row = mysqli_fetch_array($resultPROBC2)) {
                    $SOMMEBC = $row['SUM(bc_articles.QTE*bc_articles.PU)'];
                    echo '<dd class="card-title"style="text-align:RIGHT"  >Total Commandes =' . number_format($SOMMEBC, 2, ',', '.') . ' </dd>';
                }
            ?>
        </div>
    </div>



    <div class="card ">
        <div class="card-body">
            <h4 class="card-title">Imputation des Qté consommées</h4>
            <table class="table table-bordered table-sm" cellspacing="0" width="100%">

                <table class="table table-borderless table-sm" cellspacing="0" width="100%">
                    <tr style="font-size:smaller">
                        <th>
                            Code
                        </th>
                        <th>
                            Machine
                        </th>
                        <th>
                            Qté cons.
                        </th>


                    </tr>
                    </thead>


                    <tbody>
                        <?php

                        while ($row = mysqli_fetch_array($resultCOMSOMMATIONM)) {

                            $MATER2 = $row['MATERIEL'];
                            $QTE2 = $row['SUM(sermat_stock.QTE_CONS)'];
                            $CODEM = $row['CODE'];

                            echo '<tr >';

                            echo '<td style="font-size:smaller ;">' . $CODEM . '</td> ';
                            echo '<td style="font-size:smaller ;" >' . $MATER2 . '</td> ';
                            echo '<td style="font-size:smaller ;text-align:RIGHT" >' . $QTE2 . '</td> ';

                            echo '</tr>';
                        }

                        ?>
                    </tbody>
                </table>



            <?php
                echo '<dd class="card-title"style="text-align:RIGHT"  >Total Consommé =' . number_format($STOCKCONST, 2, ',', '.') . "    " . $U . ' </dd>';
            }

            echo "</div>";
            echo "</div>";

            ?>




<div class="card">
                <div class="card-body">
                    <canvas id="myChart"></canvas>
                </div>
            </div>


        </div>



        <div class="col-lg-9">


            <div class="card">
                <div class="card-body">


                    <div class="row">


                        <h5 class="card-title">Historique du Produit</h5>
                        <div class="col-12">
                            <div class="tab-content" id="nav-tabContent">



                                <table id="dtBasicExampleSTOCKD" class="table table-bordered table-sm" cellspacing="0" width="100%">

                                    <thead style="background-color: #0380a6;    color: #ffffff;font-family: sans-serif;">
                                        <tr style="font-size:smaller">

                                            <th>
                                                Date
                                            </th>
                                            <th>
                                                #Produit
                                            </th>
                                            <th>
                                                Opération
                                            </th>
                                            <th>
                                                Imputation
                                            </th>

                                            <th>
                                                Unité
                                            </th>


                                            <th>
                                                Qte livrée
                                            </th>
                                            <th>
                                                Qte Consommé
                                            </th>







                                        </tr>
                                    </thead>


                                    <tbody id="myTableST">
                                        <?php

                                        while ($row = mysqli_fetch_array($resultLIVRAISON)) {

                                            $QTELIV = $row['QTE'];
                                            $STOCKCONS = $row['QTE_CONS'];
                                            $STOCK = $row['QTE'] - $row['QTE_CONS'];

                                            echo '<tr >';
                                            echo '<td style="font-size:SMALL ;text-align:CENTER "  >' . $row['DATE_L'] . '</td> ';
                                            echo '<td style="text-align:left ;font-weight: 800;font-size:SMALL;text-align:CENTER  ">' . $row['CODE_PRODUIT'] . '</td> ';
                                            echo '<td  style="font-size:SMALL ;" >' . $row['REF'] . '</td> ';
                                            echo '<td style="font-size:SMALL ;" >' . $row['MATERIEL'] . '</td> ';
                                            echo '<td style="text-align:CENTER " >' . $row['U'] . ' </td> ';

                                            if ($row['QTE'] != 0) {
                                                echo '<td style="text-align:right ;font-weight: 800;font-size:SMALL "> ' . number_format($QTELIV, 2, ',', '.') . " " . '<span class="glyphicon glyphicon-arrow-down"  style="color:limegreen "></span> </td> ';
                                            } else {
                                                echo '<td style="text-align:right;font-size:SMALL  " >' . number_format($QTELIV, 2, ',', '.') . ' </td> ';
                                            }

                                            if ($row['QTE_CONS'] != 0) {
                                                echo '<td style="text-align:right ;font-weight: 800;font-size:SMALL ">' . number_format($STOCKCONS, 2, ',', '.') . " " . ' <span class="glyphicon glyphicon-arrow-up" style="color:red "></span></td> ';
                                            } else {
                                                echo '<td style="text-align:right;font-size:SMALL " >' . number_format($STOCKCONS, 2, ',', '.') . ' </td> ';
                                            }

                                            echo '</tr>';
                                        }

                                        ?>
                                    </tbody>
                                </table>



                            </div>

                        </div>

                    </div>


                </div>
            </div>

            <?php

            $query = $cn->query("select sermat_engin.MATERIEL ,SUM(sermat_stock.QTE_CONS) AS CONS FROM sermat_stock RIGHT JOIN  sermat_engin
                       ON sermat_engin.ID_M=sermat_stock.ID_MACHINE WHERE CODE_PRODUIT='$id'   GROUP BY sermat_engin.MATERIEL HAVING SUM(sermat_stock.QTE_CONS)>0 ORDER BY CONS DESC    ");

            foreach ($query as $data) {

                $Machine[] = $data['MATERIEL'];
                $CONS[] = $data['CONS'];
            }

            ?>








           

            <script src="https://cdnjs.cloudflare.com/ajax/libs/chartjs-plugin-datalabels/2.1.0/chartjs-plugin-datalabels.min.js" integrity="sha512-Tfw6etYMUhL4RTki37niav99C6OHwMDB2iBT5S5piyHO+ltK2YX8Hjy9TXxhE1Gm/TmAV0uaykSpnHKFIAif/A==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
            <script>
                // setup 
                const data = {
                    labels: <?php echo json_encode($Machine) ?>,
                    datasets: [{
                        label: 'Qté consommée',
                        data: <?php echo json_encode($CONS) ?>,
                        columnWidth: '30%',
                        backgroundColor: [
                            'rgba(255, 26, 104, 0.2)',
                            'rgba(54, 162, 235, 0.2)',
                            'rgba(255, 206, 86, 0.2)',
                            'rgba(75, 192, 192, 0.2)',
                            'rgba(153, 102, 255, 0.2)',
                            'rgba(255, 159, 64, 0.2)',
                            'rgba(0, 0, 0, 0.2)'
                        ],
                        borderColor: [
                            'rgba(255, 26, 104, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(153, 102, 255, 1)',
                            'rgba(255, 159, 64, 1)',
                            'rgba(0, 0, 0, 1)'
                        ],

                        borderWidth: 1


                    }]

                };

                // config 
                const config = {
                    type: 'bar',

                    data,
                    options: {

                        indexAxis: 'y',

                    },
                    plugins: [ChartDataLabels]

                };

                // render init block
                const myChart = new Chart(
                    document.getElementById('myChart'),
                    config
                );
            </script>

        </div>
    </div>





    </div>
    </div>


    </div>









    <!-- RECHERCHE TABLE STOCK-->
    <SCript>
        $(document).ready(function() {
            $('#dtBasicExampleSTOCKD').DataTable();
            $('.dataTables_length').addClass('bs-select');
        });
    </SCript>





    <script src="assets1/plugins/data-tables/jquery.datatables.min.js"></script>
    <script src="assets1/plugins/data-tables/datatables.bootstrap4.min.js"></script>
    <link href="assets1/plugins/data-tables/datatables.bootstrap4.min.css" rel="stylesheet">


</main>