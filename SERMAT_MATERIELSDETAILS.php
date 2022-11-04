<?php
session_start();
include 'index.php';

?>
<script src='assets1/js/chart.js'></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>




<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
<link rel="stylesheet" href="http://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">




<?php

$cn = mysqli_connect("localhost", "root", "", "vrd");
if (isset($_GET['idM'])) {
    $idM = $_GET['idM'];
    $idC = $_GET['idC'];
    $idT = $_GET['idT'];
}

$resultMATERIEL = mysqli_query($cn, "SELECT sermat_engin.CODE,sermat_engin.MATERIEL,sermat_engin.IMAGE,sermat_engin.MODEL,sermat_engin.MARQUE,sermat_engin.CONS_G,categorie.CATEGORIE,sermat_type_engin.TYPE FROM sermat_engin
                                                                INNER JOIN categorie ON categorie.ID_C=sermat_engin.ID_C
                                                                INNER JOIN sermat_type_engin ON sermat_type_engin.ID_TE=sermat_engin.ID_T   where ID_M='$idM'   ");

$resultPROSUM = mysqli_query($cn, "SELECT  sermat_engin.MATERIEL, sermat_engin.CODE, produits.PRODUIT,produits.CODE_PRODUIT,  produits.U, sermat_stock.DATE_L, sermat_stock.REF, bc_articles.PU,
                                                                SUM(sermat_stock.QTE), SUM(sermat_stock.QTE_CONS), SUM(sermat_stock.QTE*bc_articles.PU), SUM(sermat_stock.QTE_CONS*bc_articles.PU)    FROM bc_articles
                                                                left  JOIN produits ON bc_articles.CODE_PRODUIT=produits.CODE_PRODUIT
                                                                INNER JOIN sermat_stock ON sermat_stock.CODE_PRODUIT=bc_articles.CODE_PRODUIT AND sermat_stock.ID_COM=bc_articles.ID_COM
                                                                INNER JOIN sermat_engin ON sermat_stock.ID_MACHINE=sermat_engin.ID_M
                                                                where  sermat_engin.ID_M ='$idM'
                                                                ");

$resultLIVRAISON = mysqli_query($cn, "SELECT sermat_engin.MATERIEL, sermat_engin.CODE, PRODUITS.CODE_PRODUIT, produits.PRODUIT, produits.RUPTURE,  produits.U, sermat_stock.DATE_L, sermat_stock.REF,
                                                                        sermat_stock.QTE, sermat_stock.QTE_CONS   FROM `PRODUITS`
                                                                        left  JOIN sermat_stock ON sermat_stock.CODE_PRODUIT=produits.CODE_PRODUIT
                                                                        LEFT  JOIN sermat_engin ON sermat_stock.ID_MACHINE=sermat_engin.ID_M where  sermat_stock.ID_MACHINE='$idM'  ORDER BY DATE_L  ");

$resultPOINTAGE = mysqli_query($cn, "SELECT   sermat_engin.ID_M ,sermat_materiels_suivi.ETAS,DATE_FORMAT(sermat_materiels_suivi.DATE, '%Y-%m') AS MOIS,
SUM(sermat_materiels_suivi.POINTAGE) , SUM(sermat_materiels_suivi.GASOIL) , SUM(sermat_materiels_suivi.HUILE_H) ,
SUM(sermat_materiels_suivi.HUILE_M) ,sermat_materiels_suivi.ETAS FROM sermat_materiels_suivi
INNER JOIN sermat_engin ON sermat_materiels_suivi.ID_M=sermat_engin.ID_M
where  sermat_materiels_suivi.ID_M ='$idM'   GROUP BY sermat_materiels_suivi.ETAS ");


$resultLISTECAT = mysqli_query($cn, "select *from Categorie where ID_C='$idC'");
while ($row = mysqli_fetch_array($resultLISTECAT)) {
    $CAT = $row['CATEGORIE'];
}

$resultLISTETYPE = mysqli_query($cn, "select *from sermat_type_engin where ID_TE='$idT'");
while ($row = mysqli_fetch_array($resultLISTETYPE)) {
    $TYPE = $row['TYPE'];
}
while ($row = mysqli_fetch_array($resultMATERIEL)) {
    $machine = $row['MATERIEL'];
?>
    <main id="main" class="main">

        <div class="pagetitle">

            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="SERMAT_MATERIELS.php">Parc Matériel</a></li>
                    <li class="breadcrumb-item"><a href="SERMAT_MATERIELS.php"><?php echo $CAT ?></a></li>
                    <li class="breadcrumb-item"><a href="SERMAT_MATERIELS_LISTE.php?idT=<?php echo $idT ?>&&idC=<?php echo $idC ?>"><?php echo $TYPE ?></a></li>

                    <li class="breadcrumb-item active"> <?php echo $machine ?></li>
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

            $image = $row['IMAGE'];
            echo '<div class="card ">';
            echo '<div class="card-body">';
            echo '<br/>';
            echo '<img src="IMGMACHINES/' . $image . '"  class="card-img-top" alt="...">';
            echo '<div class="row">';

            echo '<h4 class="card-title" style="text-align:LEFT" >Machine :' . "  " . $row['CODE'] . " - " . $row['MATERIEL'] . '</h4>';

            echo "</div>";

            echo '<div class="form-group row">';

            echo '<div class="col-xs-12 " style="font-weight: bolder ; font-family:Microsoft Tai Le ">';
            echo '<dl>';

            echo '<dt class="card-text"  >Catégorie :' . '</dt>';
            echo '<dd class="card-text" >' . " " . $row['CATEGORIE'] . '</dd>';

            echo '<dt class="card-text"  >Groupe :' . '</dt>';
            echo '<dd class="card-text" >' . " " . $row['TYPE'] . '</dd>';
            echo '<dt class="card-text"  >Marque :' . '</dt>';
            echo '<dd class="card-text" >' . " " . $row['MARQUE'] . '</dd>';
            echo '<dt class="card-text"  >Model :' . '</dt>';
            echo '<dd class="card-text" >' . " " . $row['MODEL'] . '</dd>';
            echo '<dt class="card-text"  >Cons. moy :' . '</dt>';
            echo '<dd class="card-text" >' . " " . $row['CONS_G'] . '</dd>';

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

                    <div class="row">

                        <div class="col-md-9">
                            <h4 class="card-title">Documents de la Machine</h4>
                        </div>
                        <div class="col-md-2">
                            <button type="button" data-toggle="modal" data-target="#myModal" class="btn btn.outline" style="font-weight: 900 ;color:Green "><span class="glyphicon glyphicon-plus"></span> </button>

                        </div>
                    </div>

                    <?php
                    $resultMATERIELDOC = mysqli_query($cn, "SELECT * FROM `sermat_materiels-doc` WHERE  ID_M ='$idM'   ");
                    while ($row = mysqli_fetch_array($resultMATERIELDOC)) {
                        $IDDOC = $row['ID_DOC'];
                        $doc = $row['DOCUMENT'];
                        $NOMDOC = $row['NOMDOC'];

                        echo '<ul>';

                        echo '<li><a  href="TEST.php?id=' . $IDDOC . '"

                         ><h6  style="text-align:LEFT" >' . "  " . $NOMDOC . '</h6></a></li>';

                        echo '</ul>';
                    }

                    ?>

                </div>

            </div>











            </div>






            <div class="col-lg-9">
                <input type="text" name="idm1" id="idm1" class="hidden" value="<?php echo $idM ?>" />

                <div class="col-md-3">
                    <input type="text" name="from_date" id="from_date" class="form-control" placeholder="From Date" />
                </div>
                <div class="col-md-3">
                    <input type="text" name="to_date" id="to_date" class="form-control" placeholder="To Date" />

                </div>
                <div class="col-md-5">
                    <input type="button" name="filter" id="filter" value="Filter" class="btn btn-info" />

                </div>
                <div style="clear:both"></div>
                <br />

                <!-- SITUATION PAR ETAS -->
                <div class="card ">
                    <div class="card-body">

                        <h5 class="card-title">Situation par Etas de la machine</h5>

                        <div class="col-md-7">

                            <div class="tab-content" id="nav-tabContent">
                                <table class="table table-bordered table-sm" cellspacing="0" width="100%" id="order_table1">
                                    <thead style="font-family: sans-serif;">
                                        <tr style="font-size:smaller">

                                            <th>
                                                Etas
                                            </th>
                                            <th>
                                                Total Pointage
                                            </th>

                                            <th>
                                                Total Gasoil
                                            </th>
                                            <th>
                                                Total Huile H.
                                            </th>
                                            <th>
                                                Total Huile M.
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        while ($row = mysqli_fetch_array($resultPOINTAGE)) {
                                            $ETAS1 = $row['ETAS'];
                                            $TGS1 = $row['SUM(sermat_materiels_suivi.GASOIL)'];
                                            $THY1 = $row['SUM(sermat_materiels_suivi.HUILE_H)'];
                                            $THM1 = $row['SUM(sermat_materiels_suivi.HUILE_M)'];
                                            $TPT1 = $row['SUM(sermat_materiels_suivi.POINTAGE)'];
                                            $DDT = $row['MOIS'];


                                            echo '<tr >';

                                            echo '<td style="font-size:smaller ;">' . $ETAS1 . '</td> ';

                                            echo '<td style="font-size:smaller ;text-align:RIGHT" >' . number_format($TPT1, 2, ',', '.') . '</td> ';
                                            echo '<td style="font-size:smaller ;text-align:RIGHT" >' . number_format($TGS1, 2, ',', '.') . '</td> ';
                                            echo '<td style="font-size:smaller ;text-align:RIGHT" >' . number_format($THY1, 2, ',', '.') . '</td> ';
                                            echo '<td style="font-size:smaller ;text-align:RIGHT" >' . number_format($THM1, 2, ',', '.') . '</td> ';

                                            echo '</tr>';
                                        }

                                        ?>
                                    </tbody>
                                </table>
                                <?php

                                ?>

                            </div>

                        </div>
                        <div class="col-md-5">

                            <?php
                            $queryP = mysqli_query($cn, "SELECT   sermat_engin.ID_M ,sermat_materiels_suivi.ETAS,DATE_FORMAT(sermat_materiels_suivi.DATE, '%Y-%m') AS MOIS,
                            SUM(sermat_materiels_suivi.POINTAGE) AS POINTAGE , SUM(sermat_materiels_suivi.GASOIL) , SUM(sermat_materiels_suivi.HUILE_H) ,
                            SUM(sermat_materiels_suivi.HUILE_M) ,sermat_materiels_suivi.ETAS FROM sermat_materiels_suivi
                            INNER JOIN sermat_engin ON sermat_materiels_suivi.ID_M=sermat_engin.ID_M
                            where  sermat_materiels_suivi.ID_M ='$idM'AND sermat_materiels_suivi.ETAS = 'Panne'   ");
                            while ($row = mysqli_fetch_array($queryP)) {
                                $ETTP = $row['ETAS'];
                                $POINTAGEP = number_format($row['POINTAGE'], 2);
                            }

                            $queryM = mysqli_query($cn, "SELECT   sermat_engin.ID_M ,sermat_materiels_suivi.ETAS,DATE_FORMAT(sermat_materiels_suivi.DATE, '%Y-%m') AS MOIS,
                            SUM(sermat_materiels_suivi.POINTAGE) AS POINTAGE , SUM(sermat_materiels_suivi.GASOIL) , SUM(sermat_materiels_suivi.HUILE_H) ,
                            SUM(sermat_materiels_suivi.HUILE_M) ,sermat_materiels_suivi.ETAS FROM sermat_materiels_suivi
                            INNER JOIN sermat_engin ON sermat_materiels_suivi.ID_M=sermat_engin.ID_M
                            where  sermat_materiels_suivi.ID_M ='$idM'AND sermat_materiels_suivi.ETAS = 'Marche'   ");

                            while ($row = mysqli_fetch_array($queryM)) {
                                $ETTM = $row['ETAS'];
                                $POINTAGEM = number_format($row['POINTAGE'], 2);
                            }

                            $queryimm = mysqli_query($cn, "SELECT   sermat_engin.ID_M ,sermat_materiels_suivi.ETAS,DATE_FORMAT(sermat_materiels_suivi.DATE, '%Y-%m') AS MOIS,
                            SUM(sermat_materiels_suivi.POINTAGE) AS POINTAGE , SUM(sermat_materiels_suivi.GASOIL) , SUM(sermat_materiels_suivi.HUILE_H) ,
                            SUM(sermat_materiels_suivi.HUILE_M) ,sermat_materiels_suivi.ETAS FROM sermat_materiels_suivi
                            INNER JOIN sermat_engin ON sermat_materiels_suivi.ID_M=sermat_engin.ID_M
                            where  sermat_materiels_suivi.ID_M ='$idM'AND sermat_materiels_suivi.ETAS = 'Immobilisée'  ");

                            while ($row = mysqli_fetch_array($queryimm)) {
                                $ETTimm = $row['ETAS'];
                                $POINTAGEimm = number_format($row['POINTAGE'], 2);
                            }

                            $queryt = mysqli_query($cn, "SELECT   sermat_engin.ID_M ,sermat_materiels_suivi.ETAS,DATE_FORMAT(sermat_materiels_suivi.DATE, '%Y-%m') AS MOIS,
                            SUM(sermat_materiels_suivi.POINTAGE) AS POINTAGE , SUM(sermat_materiels_suivi.GASOIL) , SUM(sermat_materiels_suivi.HUILE_H) ,
                            SUM(sermat_materiels_suivi.HUILE_M) ,sermat_materiels_suivi.ETAS FROM sermat_materiels_suivi
                            INNER JOIN sermat_engin ON sermat_materiels_suivi.ID_M=sermat_engin.ID_M
                            where  sermat_materiels_suivi.ID_M ='$idM'AND sermat_materiels_suivi.ETAS = 'Intemperies'  ");

                            while ($row = mysqli_fetch_array($queryt)) {
                                $ETTt = $row['ETAS'];
                                $POINTAGEt = number_format($row['POINTAGE'], 2);
                            }
                            ?>





                            <!-- Pie Chart -->
                            <div id="pieChart"></div>

                            <script>
                                document.addEventListener("DOMContentLoaded", () => {
                                    new ApexCharts(document.querySelector("#pieChart"), {

                                        series: [<?php echo $POINTAGEP ?>, <?php echo $POINTAGEM ?>, <?php echo $POINTAGEimm ?>, <?php echo $POINTAGEt ?>],

                                        chart: {
                                            height: 250,
                                            type: 'pie',
                                            toolbar: {
                                                show: true
                                            }
                                        },
                                        labels: ['Panne ', 'Marche', 'Immobulisée', 'Intemperie']
                                    }).render();
                                });
                            </script>
                            <!-- End Pie Chart -->


                            <!-- End Pie Chart -->




                        </div>




                    </div>
                </div>



                <!-- POINTAGE MENSUEL -->
                <div class="card ">
                    <div class="card-body">

                        <h5 class="card-title">Situation Mensuelle</h5>

                        <div class="col-md-7">

                            <div class="tab-content" id="nav-tabContent">
                                <table class="table table-bordered table-sm" cellspacing="0" width="100%" id="order_table">
                                    <thead style="font-family: sans-serif;">
                                        <tr style="font-size:smaller">

                                            <th style="text-align:center">
                                                Période
                                            </th>
                                            <th style="text-align:center">
                                                Etas
                                            </th>
                                            <th style="text-align:center">
                                                Pointage
                                            </th>

                                            <th style="text-align:center">
                                                Gasoil
                                            </th>
                                            <th style="text-align:center">
                                                Huile H.
                                            </th>
                                            <th style="text-align:center">
                                                Huile M.
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>



                                        <?php
                                        $resultPOINTAGE2 = mysqli_query($cn, "SELECT   sermat_engin.ID_M ,sermat_materiels_suivi.ETAS,DATE_FORMAT(sermat_materiels_suivi.DATE, '%Y-%m') AS MOIS,
                                   SUM(sermat_materiels_suivi.POINTAGE) , SUM(sermat_materiels_suivi.GASOIL) , SUM(sermat_materiels_suivi.HUILE_H) ,
                                   SUM(sermat_materiels_suivi.HUILE_M) ,sermat_materiels_suivi.ETAS FROM sermat_materiels_suivi
                                   INNER JOIN sermat_engin ON sermat_materiels_suivi.ID_M=sermat_engin.ID_M
                                   where  sermat_materiels_suivi.ID_M ='$idM'   GROUP BY MOIS,sermat_materiels_suivi.ETAS  ");

                                        while ($row = mysqli_fetch_array($resultPOINTAGE2)) {
                                            $ETAS2 = $row['ETAS'];
                                            $TGS2 = $row['SUM(sermat_materiels_suivi.GASOIL)'];
                                            $THY2 = $row['SUM(sermat_materiels_suivi.HUILE_H)'];
                                            $THM2 = $row['SUM(sermat_materiels_suivi.HUILE_M)'];
                                            $TPT2 = $row['SUM(sermat_materiels_suivi.POINTAGE)'];
                                            $DDT2 = $row['MOIS'];

                                            echo '<tr >';
                                            echo '<td style="font-size:smaller ;">' . $DDT2 . '</td> ';
                                            echo '<td style="font-size:smaller ;">' . $ETAS2 . '</td> ';

                                            echo '<td style="font-size:smaller ;text-align:RIGHT" >' . number_format($TPT2, 2, ',', '.') . '</td> ';
                                            echo '<td style="font-size:smaller ;text-align:RIGHT" >' . number_format($TGS2, 2, ',', '.') . '</td> ';
                                            echo '<td style="font-size:smaller ;text-align:RIGHT" >' . number_format($THY2, 2, ',', '.') . '</td> ';
                                            echo '<td style="font-size:smaller ;text-align:RIGHT" >' . number_format($THM2, 2, ',', '.') . '</td> ';

                                            echo '</tr>';
                                        }
                                        ?>
                                    </tbody>
                                </table>
                                <?php

                                ?>

                            </div>

                        </div>


                        <div class="col-md-5">

                            <?php

                            $queryR = $cn->query("SELECT   sermat_engin.ID_M ,
                                SUM(sermat_materiels_suivi.POINTAGE) AS POINTAGE, SUM(sermat_materiels_suivi.GASOIL) AS GS, SUM(sermat_materiels_suivi.HUILE_H) AS HY,
                                SUM(sermat_materiels_suivi.HUILE_M) AS HM,sermat_materiels_suivi.ETAS,DATE_FORMAT(sermat_materiels_suivi.DATE, '%Y-%m') AS MOIS FROM sermat_materiels_suivi
                                INNER JOIN sermat_engin ON sermat_materiels_suivi.ID_M=sermat_engin.ID_M
                                where  sermat_materiels_suivi.ID_M ='$idM'  AND sermat_materiels_suivi.ETAS = 'Marche'
                                GROUP BY MOIS,sermat_materiels_suivi.ETAS ORDER BY MOIS ");
                            foreach ($queryR as $data) {

                                $POINTAGER[] = $data['POINTAGE'];
                            }

                            $query1 = $cn->query("SELECT sermat_engin.ID_M ,
                            SUM(sermat_materiels_suivi.POINTAGE) AS POINTAGE, SUM(sermat_materiels_suivi.GASOIL) AS GS, SUM(sermat_materiels_suivi.HUILE_H) AS HY,
                            SUM(sermat_materiels_suivi.HUILE_M) AS HM,sermat_materiels_suivi.ETAS,DATE_FORMAT(sermat_materiels_suivi.DATE, '%Y-%m') AS MOIS FROM sermat_materiels_suivi
                            INNER JOIN sermat_engin ON sermat_materiels_suivi.ID_M=sermat_engin.ID_M
                            where sermat_materiels_suivi.ID_M ='$idM'
                            GROUP BY MOIS,sermat_materiels_suivi.ETAS ORDER BY MOIS ");

                            foreach ($query1 as $data) {
                                $ETT[] = $data['ETAS'];
                                $DATE1[] = $data['MOIS'];
                                $POINTAGE1[] = $data['POINTAGE'];
                                $GS[] = $data['GS'] / 100;
                                $HY[] = $data['HY'] / 10;
                                $HM[] = $data['HM'] / 10;
                            }
                            ?>


                            <!-- Column Chart -->
                            <div id="columnChart1"></div>

                            <script>
                                document.addEventListener("DOMContentLoaded", () => {
                                    new ApexCharts(document.querySelector("#columnChart1"), {
                                        series: [{
                                            name: 'Pointage Réel',
                                            data: <?php echo json_encode($POINTAGER) ?>,
                                        }, {
                                            name: 'Gasoil *100',
                                            data: <?php echo json_encode($GS) ?>,
                                        }, {
                                            name: 'H.Hydr *10',
                                            data: <?php echo json_encode($HY) ?>,
                                        }, {
                                            name: 'H.Mot *10',
                                            data: <?php echo json_encode($HM) ?>,
                                        }],
                                        chart: {
                                            type: 'bar',
                                            height: 350
                                        },
                                        plotOptions: {
                                            bar: {
                                                horizontal: false,
                                                columnWidth: '80%',
                                                endingShape: 'rounded'
                                            },
                                        },
                                        dataLabels: {
                                            enabled: true
                                        },
                                        stroke: {
                                            show: true,
                                            width: 2,
                                            colors: ['transparent']
                                        },
                                        xaxis: {
                                            categories: <?php echo json_encode($DATE1) ?>,
                                        },
                                        yaxis: {
                                            title: {
                                                text: 'QTE'
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

                <!-- CONSOMMATION PIECES -->


                <div class="card ">
                    <div class="card-body">


                        <div class="col-md-7">


                            <h4 class="card-title">Cout de pieces rechange</h4>

                            <div class="tab-content" id="nav-tabContent">



                                <table class="table table-bordered table-sm" cellspacing="0" width="100%" id="order_table3">
                                    <thead style="font-family: sans-serif;">
                                        <tr style="font-size:smaller">
                                        <th>
                                                PERIODE
                                            </th>
                                            <th>
                                                Code
                                            </th>

                                            <th>
                                                Qté
                                            </th>

                                            <th>
                                                MONTANT
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php

$resultPROSUMPAR = mysqli_query($cn, "SELECT  sermat_engin.MATERIEL, sermat_engin.CODE, produits.PRODUIT,produits.GROUPE, DATE_FORMAT( sermat_stock.DATE_L, '%Y-%m') AS MOIS , sermat_stock.REF, bc_articles.PU,
                                    SUM(sermat_stock.QTE), SUM(sermat_stock.QTE_CONS), SUM(sermat_stock.QTE*bc_articles.PU), SUM(sermat_stock.QTE_CONS*bc_articles.PU) AS CONSOM   FROM bc_articles
                                    left  JOIN produits ON bc_articles.CODE_PRODUIT=produits.CODE_PRODUIT
                                            INNER JOIN sermat_stock ON sermat_stock.CODE_PRODUIT=bc_articles.CODE_PRODUIT AND sermat_stock.ID_COM=bc_articles.ID_COM
                                            INNER JOIN sermat_engin ON sermat_stock.ID_MACHINE=sermat_engin.ID_M
                                    where  sermat_engin.ID_M ='$idM'  GROUP BY  MOIS,produits.GROUPE  ORDER BY CONSOM DESC ");
                                        while ($row = mysqli_fetch_array($resultPROSUMPAR)) {
                                            $DATEC = $row['MOIS'];
                                            $GROUPE = $row['GROUPE'];
                                            $PRODUIT = $row['PRODUIT'];
                                         
                                            $PU = $row['PU'];

                                            $STOCKCONST2 = $row['SUM(sermat_stock.QTE_CONS)'];
                                            $STOCKMTCONST2 = $row['CONSOM'];

                                            echo '<tr >';
                                            echo '<td style="font-size:smaller ;">' . $DATEC . '</td> ';
                                            echo '<td style="font-size:smaller ;">' . $GROUPE . '</td> ';

                                            echo '<td style="font-size:smaller ;text-align:RIGHT" >' . number_format($STOCKCONST2, 2, ',', '.') . '</td> ';
                                            echo '<td style="font-size:smaller ;text-align:RIGHT" >' . number_format($STOCKMTCONST2, 2, ',', '.') . '</td> ';

                                            echo '</tr>';
                                        }

                                        ?>
                                    </tbody>
                                </table>
                                <?php

                                echo '<dd class="card-title"style="text-align:RIGHT;font-weight: 800"  >Montant Consommé =' . number_format($STOCKMTCONST1, 2, ',', '.') . "  " . ' </dd>';

                                ?>






                            </div>
                        </div>


                        <div class="col-md-5">

                            <?php



                            $query1 = $cn->query("SELECT  sermat_engin.MATERIEL, sermat_engin.CODE, produits.PRODUIT,produits.GROUPE ,  produits.U, sermat_stock.DATE_L, sermat_stock.REF, bc_articles.PU,
                                                    SUM(sermat_stock.QTE_CONS*bc_articles.PU) AS CONS    FROM bc_articles
                                                    left  JOIN produits ON bc_articles.CODE_PRODUIT=produits.CODE_PRODUIT
                                                    INNER JOIN sermat_stock ON sermat_stock.CODE_PRODUIT=bc_articles.CODE_PRODUIT AND sermat_stock.ID_COM=bc_articles.ID_COM
                                                    INNER JOIN sermat_engin ON sermat_stock.ID_MACHINE=sermat_engin.ID_M
                                                    where  sermat_engin.ID_M ='$idM'  GROUP BY produits.GROUPE ORDER BY CONS DESC  ");

                            foreach ($query1 as $data) {

                                $GROUP[] = $data['GROUPE'];
                                $CONSG[] = $data['CONS'];
                            }

                            ?>

                            <script src="https://cdnjs.cloudflare.com/ajax/libs/chartjs-plugin-datalabels/2.1.0/chartjs-plugin-datalabels.min.js" integrity="sha512-Tfw6etYMUhL4RTki37niav99C6OHwMDB2iBT5S5piyHO+ltK2YX8Hjy9TXxhE1Gm/TmAV0uaykSpnHKFIAif/A==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>




                            <!-- Bar Chart -->
                            <br />
                            <canvas id="barChart" style="max-height: 400px"></canvas>
                            <script>
                                document.addEventListener("DOMContentLoaded", () => {
                                    new Chart(document.querySelector('#barChart'), {
                                        type: 'bar',
                                        data: {
                                            labels: <?php echo json_encode($GROUP) ?>,
                                            datasets: [{
                                                label: 'Montant ',
                                                data: <?php echo json_encode($CONSG) ?>,
                                                backgroundColor: [
                                                    'rgba(255, 99, 132, 0.2)',
                                                    'rgba(54, 162, 235, 0.2)',
                                                    'rgba(255, 159, 64, 0.2)',
                                                    'rgba(255, 205, 86, 0.2)',
                                                    'rgba(75, 192, 192, 0.2)',

                                                    'rgba(153, 102, 255, 0.2)',
                                                    'rgba(201, 203, 207, 0.2)'
                                                ],
                                                borderColor: [
                                                    'rgb(255, 99, 132)',
                                                    'rgb(54, 162, 235)',
                                                    'rgb(255, 159, 64)',
                                                    'rgb(255, 205, 86)',
                                                    'rgb(75, 192, 192)',

                                                    'rgb(153, 102, 255)',
                                                    'rgb(201, 203, 207)'
                                                ],
                                                borderWidth: 1
                                            }]
                                        },

                                        options: {
                                            indexAxis: 'y',

                                        },
                                        plugins: [ChartDataLabels]

                                    });

                                });
                            </script>
                            <!-- End Bar CHart -->



                        </div>

                    </div>









                </div>


                <!-- MODAL DOCUMENT-->
                <div class="modal fade" id="myModal" role="dialog">
                    <div class="modal-dialog modal-lg">


                        <div class="modal-content">
                            <div class="modal-header" style="background-color:#0380a6 ;color:white ; font-weight: 900">

                                <h4 class="modal-title" style=" font-weight: 900">Nouveau document</h4>
                            </div>
                            <div class="modal-body">
                                <div class="card">


                                    <div class="card-body">
                                        <br />


                                        <form action="SERMAT_MATERIEL-NVDOC.php" method="POST" class="row g-3">

                                            <div class="form-group row ">


                                                <div class="col-xs-8 ">

                                                    <input class="form-control" placeholder="Désignation" name="Désignation" type="text" style="background-color:azure ;">
                                                </div>
                                                <div class="col-xs-4 ">

                                                    <input class="form-control" placeholder="" name="DATE" type="date" style="background-color:azure ;">
                                                </div>


                                            </div>


                                            <div class="form-group row ">

                                                <div class="col-xs-4 ">

                                                    <input class="form-control" placeholder="" name="DATEEX" type="date" style="background-color:azure ;">
                                                </div>
                                                <div class="col-xs-3 ">

                                                    <input class="form-control-file" placeholder="Image" name="image" type="file" style="background-color:azure ;">
                                                </div>
                                            </div>




                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-primary" name="NVDOC">Enregistré</button>
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
                                            </div>




                                        </form>

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
                <!-- FILTRAGE POINTAGE-->
                <script>
                    $(document).ready(function() {
                        $.datepicker.setDefaults({
                            dateFormat: 'yy-mm-dd'
                        });
                        $(function() {
                            $("#from_date").datepicker();
                            $("#to_date").datepicker();
                            $("#idm1").val();
                        });
                        $('#filter').click(function() {
                            var from_date = $('#from_date').val();
                            var to_date = $('#to_date').val();
                            var idm1 = $('#idm1').val();
                            if (from_date != '' && to_date != '' && idm1 != '') {
                                $.ajax({
                                    url: "filter.php ",
                                    method: "POST",
                                    data: {
                                        from_date: from_date,
                                        to_date: to_date,
                                        idm1: idm1,
                                    },
                                    success: function(data) {
                                        $('#order_table').html(data);
                                    }
                                });
                            } else {
                                alert("Please Select Date");
                            }
                        });
                    });
                </script>
                

                <!-- FILTRAGE ETAS2-->
                <script>
                    $(document).ready(function() {
                        $.datepicker.setDefaults({
                            dateFormat: 'yy-mm-dd'
                        });
                        $(function() {
                            $("#from_date").datepicker();
                            $("#to_date").datepicker();
                            var idm1 = $('#idm1').val();
                        });
                        $('#filter').click(function() {
                            var from_date = $('#from_date').val();
                            var to_date = $('#to_date').val();
                            var idm1 = $('#idm1').val();
                            if (from_date != '' && to_date != '') {
                                $.ajax({
                                    url: "filterMachine2.php",
                                    method: "POST",
                                    data: {
                                        from_date: from_date,
                                        to_date: to_date,
                                        idm1: idm1,
                                    },
                                    success: function(data) {
                                        $('#order_table1').html(data);
                                    }
                                });
                            } else {
                                alert("Please Select Date");
                            }
                        });
                    });
                </script>
                <!-- FILTRAGE CONSOMMATION3-->
                <script>
                    $(document).ready(function() {
                        $.datepicker.setDefaults({
                            dateFormat: 'yy-mm-dd'
                        });
                        $(function() {
                            $("#from_date").datepicker();
                            $("#to_date").datepicker();
                            var idm1 = $('#idm1').val();
                        });
                        $('#filter').click(function() {
                            var from_date = $('#from_date').val();
                            var to_date = $('#to_date').val();
                            var idm1 = $('#idm1').val();
                            if (from_date != '' && to_date != '') {
                                $.ajax({
                                    url: "filterMachine3.php",
                                    method: "POST",
                                    data: {
                                        from_date: from_date,
                                        to_date: to_date,
                                        idm1: idm1,
                                    },
                                    success: function(data) {
                                        $('#order_table3').html(data);
                                    }
                                });
                            } else {
                                alert("Please Select Date");
                            }
                        });
                    });
                </script>


                <script src="assets1/plugins/data-tables/jquery.datatables.min.js"></script>
                <script src="assets1/plugins/data-tables/datatables.bootstrap4.min.js"></script>
                <link href="assets1/plugins/data-tables/datatables.bootstrap4.min.css" rel="stylesheet">


    </main>