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

    $resultMATERIEL = mysqli_query($cn, "SELECT sermat_engin.CODE,sermat_engin.MATERIEL,categorie.CATEGORIE,sermat_type_engin.TYPE FROM sermat_engin
                                          INNER JOIN categorie ON categorie.ID_C=sermat_engin.ID_C 
                                          INNER JOIN sermat_type_engin ON sermat_type_engin.ID_TE=sermat_engin.ID_T   where ID_M='$id'   ");


    $resultPROSUM = mysqli_query($cn, "SELECT  sermat_engin.MATERIEL, sermat_engin.CODE, produits.PRODUIT,produits.CODE_PRODUIT,  produits.U, sermat_stock.DATE_L, sermat_stock.REF, bc_articles.PU,
                                        SUM(sermat_stock.QTE), SUM(sermat_stock.QTE_CONS), SUM(sermat_stock.QTE*bc_articles.PU), SUM(sermat_stock.QTE_CONS*bc_articles.PU)    FROM bc_articles
                                        left  JOIN produits ON bc_articles.CODE_PRODUIT=produits.CODE_PRODUIT
                                        INNER JOIN sermat_stock ON sermat_stock.CODE_PRODUIT=bc_articles.CODE_PRODUIT AND sermat_stock.ID_COM=bc_articles.ID_COM
                                           INNER JOIN sermat_engin ON sermat_stock.ID_MACHINE=sermat_engin.ID_M
                                        where  sermat_engin.ID_M ='$id' AND sermat_stock.ID_MAG  ='$id1'
                                           ");

    $resultPROSUMPAR = mysqli_query($cn, "SELECT  sermat_engin.MATERIEL, sermat_engin.CODE, produits.PRODUIT,produits.CODE_PRODUIT,  produits.U, sermat_stock.DATE_L, sermat_stock.REF, bc_articles.PU,
                                            SUM(sermat_stock.QTE), SUM(sermat_stock.QTE_CONS), SUM(sermat_stock.QTE*bc_articles.PU), SUM(sermat_stock.QTE_CONS*bc_articles.PU)    FROM bc_articles
                                            left  JOIN produits ON bc_articles.CODE_PRODUIT=produits.CODE_PRODUIT
                                            INNER JOIN sermat_stock ON sermat_stock.CODE_PRODUIT=bc_articles.CODE_PRODUIT AND sermat_stock.ID_COM=bc_articles.ID_COM
                                            INNER JOIN sermat_engin ON sermat_stock.ID_MACHINE=sermat_engin.ID_M
                                            where  sermat_engin.ID_M ='$id' AND sermat_stock.ID_MAG='$id1' GROUP BY  produits.PRODUIT,produits.CODE_PRODUIT,  produits.U, sermat_stock.REF, bc_articles.PU ");



    $resultLIVRAISON = mysqli_query($cn, "SELECT sermat_engin.MATERIEL, sermat_engin.CODE, PRODUITS.CODE_PRODUIT, produits.PRODUIT, produits.RUPTURE,  produits.U, sermat_stock.DATE_L, sermat_stock.REF,
                                sermat_stock.QTE, sermat_stock.QTE_CONS   FROM `PRODUITS`
                                left  JOIN sermat_stock ON sermat_stock.CODE_PRODUIT=produits.CODE_PRODUIT
                                LEFT  JOIN sermat_engin ON sermat_stock.ID_MACHINE=sermat_engin.ID_M where  sermat_stock.ID_MACHINE='$id' AND sermat_stock.ID_MAG='$id1' ORDER BY DATE_L  ");
}



?>
<main id="main" class="main">




    <div class="row">
        <div class="col-lg-4">



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
            while ($row = mysqli_fetch_array($resultMATERIEL)) {

                echo '<div class="card ">';
                echo '<div class="card-body">';

                echo '<div class="row">';

                echo '<div class="col-xs-12">';
                echo '<h4 class="card-title" style="text-align:LEFT" >Imputation :' . "  " . $row['CODE'] . " - " . $row['MATERIEL'] . '</h4>';
                echo "</div>";

              


                echo "</div>";

                echo '<div class="form-group row">';

                echo '<div class="col-xs-12 " style="font-weight: bolder ; font-family:Microsoft Tai Le ">';
                echo '<dl>';

                echo '<dt class="card-text"  >Catégorie :' . '</dt>';
                echo '<dd class="card-text" >' . " " . $row['CATEGORIE'] . '</dd>';

                echo '<dt class="card-text"  >Groupe :' . '</dt>';
                echo '<dd class="card-text" >' . " " . $row['TYPE'] . '</dd>';


                echo '</dl>';


                echo "</div>";
                echo "</div>";
                echo "</div>";
                echo "</div>";



                while ($row = mysqli_fetch_array($resultPROSUM)) {



                    $STOCKCONST1 = $row['SUM(sermat_stock.QTE_CONS)'];
                    $STOCKMTCONST1 = $row['SUM(sermat_stock.QTE_CONS*bc_articles.PU)'];
                }
            }

            ?>


            <div class="card ">
                <div class="card-body">
                    <h4 class="card-title" >Imputation des Qté consommées</h4>

                    <div class="tab-content" id="nav-tabContent">



                        <table id="dtBasicExampleTCONS" class="table table-bordered table-sm" cellspacing="0" width="100%">
                            <thead style="font-family: sans-serif;">
                                <tr style="font-size:smaller">
                                    <th>
                                        Code
                                    </th>
                                    <th>
                                        Produit
                                    </th>
                                    <th>
                                        Qté
                                    </th>
                                    <th>
                                        PU
                                    </th>
                                    <th>
                                        MONTANT
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php

                                while ($row = mysqli_fetch_array($resultPROSUMPAR)) {

                                    $CODEP = $row['CODE_PRODUIT'];
                                    $PRODUIT = $row['PRODUIT'];
                                    $U = $row['U'];
                                    $PU = $row['PU'];

                                    $STOCKCONST2 = $row['SUM(sermat_stock.QTE_CONS)'];
                                    $STOCKMTCONST2 = $row['SUM(sermat_stock.QTE_CONS*bc_articles.PU)'];

                                    echo '<tr >';

                                    echo '<td style="font-size:smaller ;">' . $CODEP . '</td> ';
                                    echo '<td style="font-size:smaller ;" >' . $PRODUIT . '</td> ';
                                    echo '<td style="font-size:smaller ;text-align:RIGHT" >' . number_format($STOCKCONST2, 2, ',', '.')  . '</td> ';
                                    echo '<td style="font-size:smaller ;text-align:RIGHT" >' . number_format($PU, 2, ',', '.') . '</td> ';
                                    echo '<td style="font-size:smaller ;text-align:RIGHT" >' . number_format($STOCKMTCONST2, 2, ',', '.') .  '</td> ';



                                    echo '</tr>';
                                }


                                ?>
                            </tbody>
                        </table>
                        <?php



                        echo '<dd class="card-title"style="text-align:RIGHT;font-weight: 800"  >Montant Consommé ='  . number_format($STOCKMTCONST1, 2, ',', '.') . "  " .  ' </dd>';





                        ?>






                    </div>


                </div>

            </div>

            <?php
            $con = new mysqli("localhost", "root", "", "vrd");
            $query = $con->query("SELECT  sermat_engin.MATERIEL, sermat_engin.CODE, produits.PRODUIT,  produits.U,DATE_FORMAT(sermat_stock.DATE_L, '%Y-%m') AS MOIS, sermat_stock.REF, bc_articles.PU,
                SUM(sermat_stock.QTE_CONS) , SUM(sermat_stock.QTE*bc_articles.PU), SUM(sermat_stock.QTE_CONS*bc_articles.PU) AS CONS    FROM bc_articles
                left  JOIN produits ON bc_articles.CODE_PRODUIT=produits.CODE_PRODUIT
                INNER JOIN sermat_stock ON sermat_stock.CODE_PRODUIT=bc_articles.CODE_PRODUIT AND sermat_stock.ID_COM=bc_articles.ID_COM
                INNER JOIN sermat_engin ON sermat_stock.ID_MACHINE=sermat_engin.ID_M
                where  sermat_engin.ID_M ='$id' AND sermat_stock.ID_MAG='$id1' GROUP BY MOIS ORDER BY MOIS ");

            foreach ($query as $data) {

                $DATES[] = $data['MOIS'];
                $CONS[] = $data['CONS'];
            }

            ?>





            <!-- End Bar Chart -->


            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Consommation Par Mois</h5>

                    <!-- Column Chart -->
                    <div id="columnChart"></div>

                    <script>
                        document.addEventListener("DOMContentLoaded", () => {
                            new ApexCharts(document.querySelector("#columnChart"), {
                                series: [{
                                    name: 'Net Profit',
                                    data: <?php echo json_encode($CONS) ?>,
                                }],
                                chart: {
                                    type: 'bar',
                                    height: 350
                                },
                                plotOptions: {
                                    bar: {
                                        horizontal: false,
                                        columnWidth: '30%',
                                        endingShape: 'rounded'
                                    },
                                },
                                dataLabels: {
                                    enabled: false
                                },
                                stroke: {
                                    show: true,
                                    width: 2,
                                    colors: ['transparent']
                                },
                                xaxis: {
                                    categories: <?php echo json_encode($DATES) ?>,
                                },
                                yaxis: {
                                    title: {
                                        text: ' (Montant)'
                                    }
                                },
                                fill: {
                                    opacity: 1
                                },
                                tooltip: {
                                    y: {
                                        formatter: function(val) {
                                            return val
                                        }
                                    }
                                }
                            }).render();
                        });
                    </script>
                    <!-- End Column Chart -->

                </div>
            </div>






        </div>





        <div class="col-lg-8">


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
                                                Qte Consommé
                                            </th>







                                        </tr>
                                    </thead>


                                    <tbody>
                                        <?php

                                        while ($row = mysqli_fetch_array($resultLIVRAISON)) {


                                            $STOCKCONS = $row['QTE_CONS'];


                                            echo '<tr >';
                                            echo '<td style="font-size:SMALL ;text-align:CENTER "  >' . $row['DATE_L'] . '</td> ';
                                            echo '<td style="font-weight: 800;font-size:SMALL;text-align:CENTER  ">' . $row['CODE_PRODUIT'] . '</td> ';
                                            echo '<td  style="font-size:SMALL ;" >' . $row['CODE'] . '</td> ';
                                            echo '<td style="font-size:SMALL ;" >' . $row['PRODUIT'] . '</td> ';
                                            echo '<td style="text-align:CENTER " >' . $row['U'] . ' </td> ';




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









        </div>








        <!-- RECHERCHE TABLE STOCK-->
        <SCript>
            $(document).ready(function() {
                $('#dtBasicExampleSTOCKD').DataTable();
                $('.dataTables_length').addClass('bs-select');
            });
        </SCript>



        <!-- RECHERCHE TABLE STOCK-->
        <SCript>
            $(document).ready(function() {
                $('#dtBasicExampleTCONS').DataTable();
                $('.dataTables_length').addClass('bs-select');
            });
        </SCript>





        <script src="assets1/plugins/data-tables/jquery.datatables.min.js"></script>
        <script src="assets1/plugins/data-tables/datatables.bootstrap4.min.js"></script>
        <link href="assets1/plugins/data-tables/datatables.bootstrap4.min.css" rel="stylesheet">


</main>