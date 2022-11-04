<?php
session_start();
include 'index.php';

?>



<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script rel="stylesheet" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
	<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
	<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>

<?php

$cn = mysqli_connect("localhost", "root", "", "vrd");
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $resultMAG = mysqli_query($cn, "select *from magasins where ID_MAG='$id' ");
    $resultBC = mysqli_query($cn, "select sermat_commandes.ID_COM,sermat_commandes.N_COMMANDE,sermat_commandes.ID_MAG ,sermat_commandes.TVA,sermat_commandes.M_PAIMENT,sermat_commandes.REF,sermat_commandes.DATE_COMMANDE,fournisseurs.FOURNISSEUR
                       from sermat_commandes INNER JOIN fournisseurs on fournisseurs.ID_FOURNISSEUR=sermat_commandes.ID_FOURNISSEUR  where ID_MAG='$id'   ");
}

$resultFR = mysqli_query($cn, "SELECT * FROM `fournisseurs`  ID_FOURNISSEUR ");
$resultFR1 = mysqli_query($cn, "SELECT * FROM `fournisseurs` ORDER BY FOURNISSEUR ");
$resultPRODUIT = mysqli_query($cn, "SELECT  SUBSTR( MAX(N_COMMANDE), 5,20)FROM `sermat_commandes` ");

?>
<main id="main" class="main">

    <?php


    if (isset($_SESSION['status'])) {
    ?>
        <div class="alert alert-warning alert-dismissible " role="alert">
            <strong>Alert!</strong> <?php echo $_SESSION['status']; ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>


    <?php

        unset($_SESSION['status']);
    }





    echo '<div class="row">';

    while ($row = mysqli_fetch_array($resultMAG)) {

        $magasin = $row['MAGASIN'];

    ?>

















        <div>

            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="SERMAT_MAGASIN.php">Magasins-Service Matériels</a></li>
                    <li class="breadcrumb-item active"><a><?php echo $magasin ?></li>

                </ol>
            </nav>
        </div><!-- End Page Title -->

        <div class="col-md-3">



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
            echo '<h4 class="card-title" style="text-align:LEFT" >Magasin :' . "  " . $row['ID_MAG'] . " - " . $row['MAGASIN'] . '</h4>';
            echo "</div>";

            echo "</div>";

            echo '<div class="form-group row">';

            echo '<div class="col-xs-12 " style="font-weight: bolder ; font-family:Microsoft Tai Le ">';
            echo '<dl>';

            echo '<dt class="card-text"  >Site :' . '</dt>';
            echo '<dd class="card-text" >' . " " . $row['ADRESSE'] . '</dd>';
            echo '<dt class="card-text"  >Responsable :' . '</dt>';
            echo '<dd class="card-text" >' . " " . $row['RESPONSABLE'] . '</dd>';
            echo '<dt class="card-text"  >Imputation :' . '</dt>';
            echo '<dd class="card-text" >' . " " . $row['TYPE'] . '</dd>';
            echo '<br/>';



            $resultMONTANTLIV = mysqli_query($cn, "SELECT SUM(sermat_stock.QTE*bc_articles.PU),SUM(sermat_stock.QTE_CONS*bc_articles.PU) FROM `sermat_stock`  INNER JOIN bc_articles ON
                                                              bc_articles.CODE_PRODUIT= sermat_stock.CODE_PRODUIT WHERE sermat_stock.ID_MAG ='$id'
                                                              ");
            while ($row = mysqli_fetch_array($resultMONTANTLIV)) {
                $MCONS = $row['SUM(sermat_stock.QTE_CONS*bc_articles.PU)'];

                $MLIV = $row['SUM(sermat_stock.QTE*bc_articles.PU)'];
                $MSTOCK =     $MLIV - $MCONS;
                echo '<dt class="card-text"  >Montant Livré :' . '</dt>';
                echo '<dd class="card-text" >' . " " . number_format($MLIV, 2, ',', '.') . '</dd>';


                echo '<dt class="card-text"  >Montant Cons. :' . '</dt>';
                echo '<dd class="card-text" >' . " " . number_format($MCONS, 2, ',', '.') . '</dd>';
                echo '<dt class="card-text"  >Montant Stock :' . '</dt>';
                echo '<dd class="card-text" >' . " " . number_format($MSTOCK, 2, ',', '.') . '</dd>';


                echo '</dl>';
            }

            ?>







        <?php
        echo "</div>";
        echo "</div>";
        echo "</div>";
        echo "</div>";
    }



        ?>

        </div>



        <div class="col-md-9">


            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Suivi de Magasin Sermat</h4>

                    <ul class="nav nav-tabs nav-tabs-bordered d-flex" id="pills-tab" role="tablist">
                        <li class="nav-item flex-fill" role="presentation">
                            <button class="nav-link w-100 " id="pills-Stock-tab" data-bs-toggle="pill" data-bs-target="#pills-Stock" type="button" role="tab" aria-controls="pills-Stock" aria-selected="true"><span class="glyphicon glyphicon-tasks"></span>- Stock</button>
                        </li>
                        <li class="nav-item flex-fill" role="presentation">
                            <button class="nav-link w-100 active" id="pills-Commandes-tab" data-bs-toggle="pill" data-bs-target="#pills-Commandes" type="button" role="tab" aria-controls="pills-Commandes" aria-selected="false"> <span class="glyphicon glyphicon-menu-hamburger"></span>-Commandes</button>
                        </li>
                        <li class="nav-item flex-fill" role="presentation">
                            <button class="nav-link w-100" id="pills-Livraisons-tab" data-bs-toggle="pill" data-bs-target="#pills-Livraisons" type="button" role="tab" aria-controls="pills-Livraisons" aria-selected="false"><span class="glyphicon glyphicon-save"></span>-Livraisons</button>
                        </li>
                        <li class="nav-item flex-fill" role="presentation">
                            <button class="nav-link w-100" id="pills-Consommation-tab" data-bs-toggle="pill" data-bs-target="#pills-Consommation" type="button" role="tab" aria-controls="pills-Consommation" aria-selected="false"><span class="glyphicon glyphicon-open"></span>-Consommation</button>
                        </li>
                        <li class="nav-item flex-fill" role="presentation">
                            <button class="nav-link w-100" id="pills-Fournisseurs-tab" data-bs-toggle="pill" data-bs-target="#pills-Fournisseurs" type="button" role="tab" aria-controls="pills-Fournisseurs" aria-selected="false"><span class="glyphicon glyphicon-user"></span>-Fournisseurs</button>
                        </li>
                        <li class="nav-item flex-fill" role="presentation">
                            <button class="nav-link w-100" id="pills-Produits-tab" data-bs-toggle="pill" data-bs-target="#pills-Produits" type="button" role="tab" aria-controls="pills-Produits" aria-selected="false"><span class="glyphicon glyphicon-plus"></span>-Produits</button>
                        </li>
                        <li class="nav-item flex-fill" role="presentation">
                            <button class="nav-link w-100" id="pills-Références-tab" data-bs-toggle="pill" data-bs-target="#pills-Références" type="button" role="tab" aria-controls="pills-Références" aria-selected="false"> <span class="glyphicon glyphicon-list-alt"></span>-Références</button>
                        </li>
                        <li class="nav-item flex-fill" role="presentation">
                            <button class="nav-link w-100" id="pills-Imputation-tab" data-bs-toggle="pill" data-bs-target="#pills-Imputation" type="button" role="tab" aria-controls="pills-Imputation" aria-selected="false"> <span class="glyphicon glyphicon-list-alt"></span>-Imputation</button>
                        </li>
                    </ul>
                    <div class="tab-content pt-2" id="myTabContent">
                        <!-- stock-->
                        <div class="tab-pane fade1  " id="pills-Stock" role="tabpanel" aria-labelledby="Stock-tab">

                            <div class="row" style="background-color:aliceblue;">


                                <h5 class="card-title">Suivi de Livraisons</h5>
                                <div class="col-12">
                                    <div class="tab-content" id="nav-tabContent">


                                        <div>
                                            <table id="dtBasicExampleBC" class="table table-bordered table-sm" cellspacing="0" width="100%">
                                                <thead style="background-color: #007798;    color: #ffffff;font-family: sans-serif;">
                                                    <tr>


                                                        <th>
                                                            CODE
                                                        </th>
                                                        <th>
                                                            Produit
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

                                                        <th>
                                                            Stock
                                                        </th>

                                                        <th>
                                                            alert
                                                        </th>
                                                        <th>
                                                            Détails
                                                        </th>


                                                    </tr>
                                                </thead>


                                                <tbody style="font-size:small ;width:100% ">
                                                    <?php

                                                    $resultLIVRAISON = mysqli_query($cn, "SELECT  PRODUITS.CODE_PRODUIT, produits.PRODUIT, produits.RUPTURE,  produits.U, SUM(sermat_stock.QTE), SUM(sermat_stock.QTE_CONS)  FROM `PRODUITS`
                                                                  left  JOIN sermat_stock ON sermat_stock.CODE_PRODUIT=produits.CODE_PRODUIT where  sermat_stock.ID_MAG='$id'
                                                                    GROUP by produits.CODE_PRODUIT, produits.PRODUIT ");

                                                    while ($row = mysqli_fetch_array($resultLIVRAISON)) {
                                                        $RUP = $row['RUPTURE'];
                                                        $stk = $row['SUM(sermat_stock.QTE)'] - $row['SUM(sermat_stock.QTE_CONS)'];

                                                        $RUPTURESTOCK = "Rupture";
                                                     
                                                        $DISPO = "Disponible";
                                                        $CODEPRODUIT = $row['CODE_PRODUIT'];

                                                        $rel = "-";
                                                        $nvbc = "Préparer un BC";

                                                        echo '<tr >';
                                                        echo '<td style="text-align:left ;font-weight: 800 ">' . $row['CODE_PRODUIT'] . '</td> ';
                                                        echo '<td>' . $row['PRODUIT'] . '</td> ';
                                                        echo '<td>' . $row['U'] . ' </td> ';

                                                        echo '<td style="text-align:right  ">' . number_format($row['SUM(sermat_stock.QTE)'], 2, ',', '.') . ' </td> ';

                                                        echo '<td style="text-align:right  ">' . number_format($row['SUM(sermat_stock.QTE_CONS)'], 2, ',', '.') . ' </td> ';

                                                        echo '<td style="text-align:right ;font-weight: 800 ">' . number_format($stk, 2, ',', '.') . ' </td> ';

                                                        if ($stk == 0) {

                                                            echo '<td>
                                                    <span class="badge bg-danger" ><i class="bi bi-exclamation-octagon me-2" ></i>' . $RUPTURESTOCK . '</span>  </td> ';
                                                        } elseif ($stk <= $RUP && $stk != 0) {
                                                            echo '<td>
                                                    <span class="badge bg-warning"><i class="bi bi-exclamation-octagon me-2"></i>' . $RUPTURESTOCK . '</span>  </td> ';
                                                        } else {
                                                            echo '<td>
                                                        <span class="badge bg-success"><i class="bi bi-check-circle me-2"></i>' . $DISPO . '</span>  </td> ';
                                                        };

                                                        echo '<td>
                                                        <a
                                                        href="SERMAT_MAGASIN-SUIVIDETAIL.php?id=' .  $CODEPRODUIT .  '&id1=' . $id . '"

                                                         class="btn btn-outline-info btn-sm"  > <span class="glyphicon glyphicon-zoom-in"></span>

                                                         </a>
                                                         </td>';

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

                        <!-- COMMANDES-->
                        <div class="tab-pane fade1 show active" id="pills-Commandes" role="tabpanel" aria-labelledby="Commandes-tab">
                            <div class="row">



                                <div class="col-md-12">
                                    <div class="card">
                                        <div class="card-body">

                                            <div class="row">

                                                <div class="col-md-10">

                                                    <h5 class="card-title">Bons de Commandes</h5>

                                                </div>
                                                <div class="col-md-2">
                                                    <button type="button" data-toggle="modal" data-target="#myModal" class="btn btn.outline" style="font-weight: 900 ;color:Green ;margin-top: 20PX">Nouveau BC </button>
                                                </div>
                                            </div>



                                            <div class="row">
                                                <div class="col-12">












                                                    <table id="dtBasicExampleBC" class="table table-bordered table-sm" cellspacing="0" width="100%">

                                                        <thead style="background-color: #007798;    color: #ffffff;font-family: sans-serif;">
                                                            <tr>

                                                                <th>
                                                                    N° BC
                                                                </th>
                                                                <th>
                                                                    Date
                                                                </th>
                                                                <th>
                                                                    Fournisseur
                                                                </th>
                                                                <th>
                                                                    TVA
                                                                </th>
                                                                <th>
                                                                    Mode de Paiment
                                                                </th>
                                                                <th>
                                                                    Imputation
                                                                </th>


                                                                <th>
                                                                    Montant HT
                                                                </th>
                                                                <th>
                                                                    Montant TTC
                                                                </th>
                                                                <th>
                                                                    Validation
                                                                </th>
                                                                <th>

                                                                </th>

                                                                <th>

                                                                </th>

                                                        </thead>

                                                        <tbody style="font-size:small ;">

                                                            <?php

                                                            while ($row = mysqli_fetch_array($resultBC)) {

                                                                $id = $row['ID_MAG'];
                                                                $IDCOM = $row['ID_COM'];
                                                                $NBC = $row['N_COMMANDE'];
                                                                $tva = $row['TVA'];

                                                                echo '<tr style="font-family: system-ui ;line-height: 25px;min-height: 25px;height: 25px;">';
                                                                echo '<td style="text-align:left ;font-weight:BOLD ">' . $NBC . '</td> ';
                                                                echo '<td>' . $row['DATE_COMMANDE'] . '</td> ';
                                                                echo '<td>' . $row['FOURNISSEUR'] . '</td> ';
                                                                echo '<td>' . $row['TVA'] . " " . '%</td> ';

                                                                echo '<td>' . $row['M_PAIMENT'] . '</td> ';
                                                                echo '<td>' . $row['REF'] . '</td> ';

                                                                $resultBCSUM = mysqli_query($cn, "SELECT SUM(QTE*PU),ID_COM  FROM bc_articles  WHERE  ID_COM =' $IDCOM ' GROUP BY ID_COM    ");

                                                                while ($row = mysqli_fetch_array($resultBCSUM)) {
                                                                    $SOMMEBC = $row['SUM(QTE*PU)'];
                                                                    $SOMMEBCttc = $SOMMEBC + ($SOMMEBC * $tva) * 0.01;
                                                                    $bcvalidé = "Validé";
                                                                    $bcAnnulé = "Annulé";
                                                                    $bcENCOURS = "en cours";
                                                                    $sumv = 0;
                                                                    $v = "vide";

                                                                    if ($SOMMEBC != '') {
                                                                        echo '<td style="text-align:right ">' . number_format($SOMMEBC, 2, ',', '.') . '</td> ';
                                                                        echo '<td style="text-align:right ;font-weight:BOLD ">' . number_format($SOMMEBCttc, 2, ',', '.') . '</td> ';
                                                                        echo '<td>   <span class="badge bg-success"><i class="bi bi-check-circle me-2"></i>' . $bcvalidé . '</span>  </td>';
                                                                    } elseif ($SOMMEBC === 0) {
                                                                        echo '<td>' . number_format($sumv, 2, ',', '.') . '</td> ';
                                                                        echo '<td style="text-align:right ;font-weight:BOLD ">' . number_format($sumv, 2, ',', '.') . '</td> ';
                                                                        echo '<td>  <span class="badge bg-success"><i class="bi bi-check-circle me-2"></i>' . $v . '</span>  </td>';
                                                                        echo '<td>  <span class="badge bg-danger"><i class="bi bi-x-circle"></i>' . $v . '</span>  </td>';
                                                                    }
                                                                }

                                                                echo '<td>

                                                                <a  href="SERMAT_MAGASIN-BCDELETE.php?id=' . $IDCOM . ' &id1=' . $id . ' "

                                                                 class="btn btn-outline-danger btn-sm" > <span class="glyphicon glyphicon-trash"> </span>

                                                                 </a>

                                                                 </td>';

                                                                echo '<td>
                                                                 <a
                                                                 href="SERMAT_MAGASIN-ARBC.php?id=' . $IDCOM . '"

                                                                  class="btn btn-outline-primary btn-sm" > <span class="glyphicon glyphicon-list"> </span> Articles

                                                                  </a>
                                                                  </td>';

                                                                echo ' </tr>';
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
                        </div>

                        <!-- livraison-->
                        <div class="tab-pane fade1" id="pills-Livraisons" role="tabpanel" aria-labelledby="Livraisons-tab">
                            <div class="row">


                                <h5 class="card-title">Suivi de Livraisons</h5>

                                <div class="row">

                                    <form name="add-liv" id="add-liv" action="SERMAT_NVARTICLELIV.php" method="POST">
                                        <div class="table-responsive">

                                            <!-- COMBOBOX LIVRAISON -->
                                            <?php

                                            $connect = mysqli_connect("localhost", "root", "", "vrd");

                                            $country = '';
                                            $query = "SELECT  DISTINCT fournisseurs.FOURNISSEUR ,sermat_commandes.ID_MAG FROM `fournisseurs`  INNER JOIN sermat_commandes
                                            ON sermat_commandes.ID_FOURNISSEUR=fournisseurs.ID_FOURNISSEUR
                                             WHERE sermat_commandes.ID_MAG='$id'";

                                            $result = mysqli_query($connect, $query);

                                            while ($row = mysqli_fetch_array($result)) {
                                                $country .= '<option value="' . $row["FOURNISSEUR"] . '" >' . $row["FOURNISSEUR"] . '</option>';
                                            }

                                            ?>
                                            <table class="table table-bordered">

                                                <tr>
                                                    <td class="hidden"><input type="text" name="IDMAG" id="IDMAG" placeholder="" class="hidden" value=" <?php echo $id ?>" />
                                                    <td><select name="FOURNISSEUR" id="FOURNISSEUR" class="myselect action"  style="width: 250px;">
                                                            <option value="">Fournissseur</option><?php echo $country ?>
                                                        </select>
                                                    <td><select name="BC" id="BC" class="myselect action"  style="width: 100px;">
                                                            <option value="">N-BC</option>
                                                        </select></td>
                                                    <td><select name="PRODUIT" id="PRODUIT" class="myselect action"  style="width: 250px;">
                                                            <option value="">produit</option>
                                                        </select></td>
                                                    </select></td>


                                                    <td><input type="number" name="QTE" placeholder="Qté" class="form-control QTE_list" style="HEIGHT: 30px;" /></td>
                                                    <td><input type="date" name="DATE" placeholder="DATE" class="form-control date_list" style="HEIGHT: 30px;"/> </td>
                                                    <td style="width: 120px ;"><input type="text" name="BL" placeholder="BL" class="form-control BL_list" style="HEIGHT: 30px;"/> </td>

                                                    <td class="hidden"><input type="text" name="REF" placeholder="REF" Value="LIVRAISON" />LIVRAISON</td>

                                                    <td><input type="text" name="NOTE" placeholder="Note" class="form-control NOTE_list" style="HEIGHT: 30px;width: 150px;"/> </td>

                                                    <td> <button type="submit" name="submit" id="submit" class="btn btn-outline-success " style="HEIGHT: 30px;"><span class="glyphicon glyphicon-ok" style="text-align:left ;font-weight: 750 "> </span> </button> </td>
                                                </tr>
                                            </table>


                                        </div>
                                    </form>



                                </div>









                                <div class="col-12">
                                    <div class="tab-content" id="nav-tabContent">


                                        <div>
                                            <table id="dtBasicExampleLIV" class="table table-bordered table-sm" cellspacing="0" width="100%">

                                                <thead style="background-color: #007798;    color: #ffffff;font-family: sans-serif;">
                                                    <tr>

                                                        <th>
                                                            Date
                                                        </th>
                                                        <th>
                                                            BL
                                                        </th>
                                                        <th>
                                                            CODE P
                                                        </th>
                                                        <th>
                                                            Produit
                                                        </th>

                                                        <th>
                                                            Qte livrée
                                                        </th>

                                                        <th>
                                                            bc
                                                        </th>

                                                        <th>
                                                            fournisseur
                                                        </th>





                                                        <th>
                                                            note
                                                        </th>
                                                        <th>

                                                        </th>
                                                    </tr>
                                                </thead>

                                                <tbody style="font-size:small ;">

                                                    <?php

                                                    $resultLIVRAISON = mysqli_query($cn, "SELECT  sermat_stock.ID_MAG, sermat_commandes.N_COMMANDE, fournisseurs.FOURNISSEUR,
                                                sermat_stock.DATE_L, sermat_stock.CODE_PRODUIT,produits.PRODUIT, sermat_stock.QTE, sermat_stock.BL , sermat_stock.NOTE FROM `sermat_stock`  INNER JOIN sermat_commandes
                                                on sermat_commandes.ID_COM=sermat_stock.ID_COM INNER JOIN fournisseurs ON fournisseurs.ID_FOURNISSEUR=sermat_stock.ID_FOURNISSEUR INNER JOIN produits
                                                ON produits.CODE_PRODUIT=sermat_stock.CODE_PRODUIT   WHERE sermat_stock.ID_MAG='$id' AND  sermat_stock.REF='LIVRAISON' ORDER BY  sermat_stock.DATE_L");

                                                    while ($row = mysqli_fetch_array($resultLIVRAISON)) {

                                                        echo '<tr >';
                                                        echo '<td>' . $row['DATE_L'] . '</td> ';
                                                        echo '<td style="text-align:left ;font-weight: 800 ">' . $row['BL'] . '</td> ';
                                                        echo '<td>' . $row['CODE_PRODUIT'] . ' </td> ';
                                                        echo '<td>' . $row['PRODUIT'] . ' </td> ';
                                                        echo '<td style="text-align:right ;font-weight: 800 "> ' . $row['QTE'] . ' </td> ';
                                                        echo '<td>' . $row['N_COMMANDE'] . ' </td> ';

                                                        echo '<td>' . $row['FOURNISSEUR'] . ' </td> ';

                                                        echo '<td>' . $row['NOTE'] . ' </td> ';
                                                        echo '<td>

                                                        <a  href="SERMAT_MAGASIN-BCDELETE.php?id=' . $IDCOM . ' &id1=' . $id . ' "

                                                         class="btn btn-outline-danger btn-sm" > <span class="glyphicon glyphicon-trash"> </span>

                                                         </a>

                                                         </td>';

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

                        <!-- consommation-->
                        <div class="tab-pane fade1" id="pills-Consommation" role="tabpanel" aria-labelledby="Consommation-tab">
                            <div class="row">

                                <?php

                                $MATERIEL1 = '';
                                $queryMAT = "SELECT  *FROM `sermat_engin`";

                                $result = mysqli_query($connect, $queryMAT);
                                while ($row = mysqli_fetch_array($result)) {
                                    $MATERIEL1 .= '<option value="' . $row["MATERIEL"] . '">' . $row["MATERIEL"] . '</option>';
                                }

                                ?>
                                <h5 class="card-title">Suivi de Consommation</h5>
                                <div class="col-12">
                                    <div class="tab-content" id="nav-tabContent">
                                        <div class="row">

                                            <form name="add-liv" id="add-liv" action="SERMAT_NVARTICLECONS.php" method="POST">
                                                <div class="table-responsive">

                                                    <!-- COMBOBOX consommation -->

                                                    <table class="table table-bordered">

                                                        <tr>
                                                            <td class="hidden"><input type="text" name="IDMAG" placeholder="" class="hidden" value=" <?php echo $id ?>" />
                                                            <td><select name="FOURNISSEUR1" id="FOURNISSEUR1" class="myselect action"  style="width: 150px;">
                                                                    <option value="">Fournissseur</option><?php echo $country ?>
                                                                </select>
                                                            <td><select name="BC1" id="BC1" class="myselect action"  style="width: 100px;">
                                                                    <option value="">BC</option>
                                                                </select></td>
                                                            <td><select name="PRODUIT1" id="PRODUIT1" class="myselect action"  style="width: 150px;">
                                                                    <option value="">produit</option>
                                                                </select></td>
                                                            <td><select name="QTE1" id="QTE1" class="form-control action" style="width: 80px ;HEIGHT: 30px">
                                                                    <option value="">stock</option>
                                                                </select></td>

                                                            <td><select name="IDM" id="IDM" class="myselect action"  style="width: 180px;">
                                                                    <option value="" style="width: 180px ;">Imputation</option><?php echo $MATERIEL1 ?>
                                                                </select></td>

                                                            <td><input type="number" name="QTE" id="QTE" placeholder="Qté" class="form-control QTE_list" style="width: 80px ;HEIGHT: 30px" /></td>

                                                            <td><input type="date" name="DATE" placeholder="DATE" class="form-control date_list" style="HEIGHT: 30px"/> </td>
                                                            <td style="width: 120px ;"><input type="text" name="BL" placeholder="BL" class="form-control BL_list" style="width: 120px ;HEIGHT: 30px" /> </td>

                                                            <td class="hidden"><input type="text" name="REF" placeholder="REF" Value="CONSOMMATION" />CONSOMMATION</td>

                                                            <td><input type="text" name="NOTE" placeholder="Note" class="form-control NOTE_list" style="HEIGHT: 30px"/> </td>
                                                            <td> <button type="submit" name="submit" id="submit" class="btn btn-outline-success" style="HEIGHT: 30px"><span class="glyphicon glyphicon-ok" style="text-align:left ;font-weight: 750 "> </span> </button></td>



                                                        </tr>
                                                    </table>

                                                </div>
                                            </form>



                                        </div>
                                        <div>
                                            <table id="dtBasicExampleCONS" class="table table-bordered table-sm" style="width: 100%;">

                                                <thead style="background-color: #007798;    color: #ffffff;font-family: sans-serif;">
                                                    <tr>

                                                        <th>
                                                            Date
                                                        </th>
                                                        <th>
                                                            BL
                                                        </th>
                                                        <th>
                                                            CODE P
                                                        </th>
                                                        <th>
                                                            Produit
                                                        </th>

                                                        <th>
                                                            Qte consommée
                                                        </th>

                                                        <th>
                                                            bc
                                                        </th>
                                                        <th>
                                                            imputation
                                                        </th>
                                                        <th>
                                                            fournisseur
                                                        </th>

                                                        <th>
                                                            note
                                                        </th>
                                                        <th>

                                                        </th>
                                                    </tr>
                                                </thead>


                                                <tbody style="font-size:small ;">
                                                    <?php

                                                    $resultLIVRAISON = mysqli_query($cn, "SELECT  sermat_stock.ID_MAG, sermat_commandes.N_COMMANDE, sermat_engin.MATERIEL, fournisseurs.FOURNISSEUR,
                                                                sermat_stock.DATE_L, sermat_stock.CODE_PRODUIT,produits.PRODUIT, sermat_stock.QTE_CONS, sermat_stock.BL , sermat_stock.NOTE FROM `sermat_stock`  INNER JOIN sermat_commandes
                                                                on sermat_commandes.ID_COM=sermat_stock.ID_COM INNER JOIN fournisseurs ON fournisseurs.ID_FOURNISSEUR=sermat_stock.ID_FOURNISSEUR INNER JOIN produits 
                                                                ON produits.CODE_PRODUIT=sermat_stock.CODE_PRODUIT INNER JOIN sermat_engin ON sermat_engin.ID_M=sermat_stock.ID_MACHINE  WHERE sermat_stock.ID_MAG='$id' AND  sermat_stock.REF='CONSOMMATION' ORDER BY sermat_stock.DATE_L  ");

                                                    while ($row = mysqli_fetch_array($resultLIVRAISON)) {

                                                        echo '<tr >';
                                                        echo '<td>' . $row['DATE_L'] . '</td> ';
                                                        echo '<td style="text-align:left ;font-weight: 800 ">' . $row['BL'] . '</td> ';
                                                        echo '<td>' . $row['CODE_PRODUIT'] . ' </td> ';
                                                        echo '<td>' . $row['PRODUIT'] . ' </td> ';
                                                        echo '<td style="text-align:right ;font-weight: 800 ">' . $row['QTE_CONS'] . ' </td> ';
                                                        echo '<td>' . $row['N_COMMANDE'] . ' </td> ';
                                                        echo '<td >' . $row['MATERIEL'] . ' </td> ';
                                                        echo '<td>' . $row['FOURNISSEUR'] . ' </td> ';

                                                        echo '<td>' . $row['NOTE'] . ' </td> ';
                                                        echo '<td>

                                                        <a  href="SERMAT_MAGASIN-BCDELETE.php?id=' . $IDCOM . ' &id1=' . $id . ' "

                                                         class="btn btn-outline-danger btn-sm" > <span class="glyphicon glyphicon-trash"> </span>

                                                         </a>

                                                         </td>';

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
                        <!-- fournisseurs-->
                        <div class="tab-pane fade1" id="pills-Fournisseurs" role="tabpanel" aria-labelledby="Fournisseurs-tab">


                            <h5 class="card-title">Liste des Fournisseurs</h5>



                            <div class="col-12">
                                <div class="tab-content" id="nav-tabContent">
                                    <div class="row">

                                        <form name="add-FR" id="add-FR">
                                            <div class="table-responsive">
                                                <table class="table table-bordered" id="dynamic_fieldFR">
                                                    <tr>
                                                        <td> <button type="button" name="add3" id="add3" class="btn btn-success btn-sm"><span class="glyphicon glyphicon-plus"></button></td>
                                                    </tr>
                                                </table>

                                                <button type="button" name="submit3" id="submit3" class="btn btn-outline-success "><span class="glyphicon glyphicon-ok" style="text-align:left ;font-weight: 750 "> Enregistrer </span> </button>
                                            </div>
                                        </form>
                                    </div>

                                    <div>
                                        <table id="dtBasicExampleFR" class="table table-bordered table-sm" cellspacing="0" width="100%">

                                            <thead style="background-color: #007798;    color: #ffffff;font-family: sans-serif;">
                                                <tr>

                                                    <th>
                                                        #
                                                    </th>
                                                    <th>
                                                        CODE
                                                    </th>
                                                    <th>
                                                        FOURNISSEUR
                                                    </th>
                                                    <th>
                                                        TYPE
                                                    </th>
                                                    <th>
                                                        ADRESSE
                                                    </th>
                                                    <th>
                                                        CONTACT
                                                    </th>
                                                    <th>

                                                    </th>
                                                </tr>
                                            </thead>

                                            <tbody style="font-size:small ;">

                                                <?php

                                                while ($row = mysqli_fetch_array($resultFR)) {

                                                    echo '<tr >';
                                                    echo '<td>'

                                                        . $row['ID_FOURNISSEUR'] . '

                                                                       </td> ';
                                                    echo '<td style="text-align:left ;font-weight: 800 ">'

                                                        . $row['CODE_FR'] . '

                                                                      </td> ';
                                                    echo '<td>'

                                                        . $row['FOURNISSEUR'] . '

                                                                      </td> ';
                                                    echo '<td>'

                                                        . $row['TYPE'] . '

                                                                     </td> ';
                                                    echo '<td>'

                                                        . $row['ADRESSE'] . '

                                                                    </td> ';
                                                    echo '<td>'

                                                        . $row['CONTACT'] . '

                                                                   </td> ';

                                                    if ($IDCOM = '') {
                                                    } else {
                                                        echo '<td>

                                                                   <a  href="SERMAT_MAGASIN-BCDELETE.php?id=' . $IDCOM . ' &id1=' . $id . ' "
           
                                                                    class="btn btn-outline-danger btn-sm" > <span class="glyphicon glyphicon-trash"> </span>
           
                                                                    </a>
           
                                                                    </td>';
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
                        <!-- produits-->
                        <div class="tab-pane fade1" id="pills-Produits" role="tabpanel" aria-labelledby="Produits-tab">
                            <div class="row">


                                <h5 class="card-title">Liste des Produits</h5>
                                <div class="col-12">
                                    <div class="tab-content" id="nav-tabContent">
                                        <div class="row">

                                            <form name="add-PR" id="add-PR">
                                                <div class="table-responsive">
                                                    <table class="table table-bordered" id="dynamic_fieldPR">
                                                        <tr>
                                                            <td> <button type="button" name="add4" id="add4" class="btn btn-success btn-sm"><span class="glyphicon glyphicon-plus"></button></td>


                                                        </tr>
                                                    </table>

                                                    <button type="button" name="submit4" id="submit4" class="btn btn-outline-success "><span class="glyphicon glyphicon-ok" style="text-align:left ;font-weight: 750 "> Enregistrer </span> </button>
                                                </div>
                                            </form>
                                        </div>

                                        <div>
                                            <table id="dtBasicExamplePRODUIT" class="table table-bordered table-sm" cellspacing="0" width="100%">

                                                <thead style="background-color: #007798;    color: #ffffff;font-family: sans-serif;">
                                                    <tr>

                                                        <th>
                                                            #
                                                        </th>
                                                        <th>
                                                            Code
                                                        </th>
                                                        <th>
                                                            Produit
                                                        </th>
                                                        <th>
                                                            u
                                                        </th>
                                                        <th>
                                                            Rupture
                                                        </th>
                                                        <th>
                                                            TYPE
                                                        </th>
                                                        <th>

                                                        </th>
                                                    </tr>
                                                </thead>

                                                <tbody style="font-size:small ;">

                                                    <?php

                                                    $resultPRODUITS = mysqli_query($cn, "SELECT * FROM `produits` WHERE REF='SERMAT' ORDER BY ID_PRODUIT");

                                                    while ($row = mysqli_fetch_array($resultPRODUITS)) {

                                                        echo '<tr >';
                                                        echo '<td>' . $row['ID_PRODUIT'] . '</td> ';
                                                        echo '<td style="text-align:left ;font-weight: 800 ">' . $row['CODE_PRODUIT'] . ' </td> ';
                                                        echo '<td>' . $row['PRODUIT'] . ' </td> ';
                                                        echo '<td>' . $row['U'] . ' </td> ';
                                                        echo '<td>' . $row['RUPTURE'] . ' </td> ';
                                                        echo '<td>' . $row['GROUPE'] . ' </td> ';

                                                        if ($IDCOM = '' && $id = '') {
                                                        } else {
                                                            echo '<td>

                                                        <a  href="SERMAT_MAGASIN-BCDELETE.php?id=' . $IDCOM . ' &id1=' . $id . ' "

                                                         class="btn btn-outline-danger btn-sm" > <span class="glyphicon glyphicon-trash"> </span>

                                                         </a>

                                                         </td>';
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

                        <!-- reférences-->


                        <div class="tab-pane fade1" id="pills-Références" role="tabpanel" aria-labelledby="Références-tab">

                            <div class="card">
                                <div class="card-body">

                                    <div class="d-flex align-items-start">

                                        <div class="nav flex-column nav-pills me-3" id="v-pills-tab" role="tablist" aria-orientation="vertical" style="width:300px ;text-align:left ;">
                                            <br />

                                            <button style="width:300px ;text-align:left ;" class="nav-link active" id="v-pills-Produits-tab" data-bs-toggle="pill" data-bs-target="#v-pills-Produits" type="button" role="tab" aria-controls="v-pills-Produits" aria-selected="true"> <span class="glyphicon glyphicon-chevron-right"></span>-Références des Produits</button>
                                            <button style="width:300px ;text-align:left ;" class="nav-link" id="v-pills-Fournisseurs-tab" data-bs-toggle="pill" data-bs-target="#v-pills-Fournisseurs" type="button" role="tab" aria-controls="v-pills-Fournisseurs" aria-selected="false"> <span class="glyphicon glyphicon-chevron-right"></span>-Références des Fournisseurs</button>
                                            <button style="width:300px ;text-align:left ;" class="nav-link" id="v-pills-Sites-tab" data-bs-toggle="pill" data-bs-target="#v-pills-Sites" type="button" role="tab" aria-controls="v-pills-Sites" aria-selected="false"> <span class="glyphicon glyphicon-chevron-right"></span>-Liste des Machines</button>
                                        </div>

                                        <div class="tab-content" id="v-pills-tabContent" style="width:100%;">
                                            <div class="tab-pane fade1 show active" id="v-pills-Produits" role="tabpanel" aria-labelledby="v-pills-Produits-tab">

                                                <h5 class="card-title">Références des Produits</h5>


                                                <div class="tab-content" id="nav-tabContent">
                                                    <div class="row">

                                                        <form name="add-REF" id="add-REF">
                                                            <div class="table-responsive">
                                                                <table class="table table-bordered" id="dynamic_fieldREF">
                                                                    <tr>
                                                                        <td> <button type="button" name="add5" id="add5" class="btn btn-success btn-sm"><span class="glyphicon glyphicon-plus"></button></td>
                                                                    </tr>
                                                                </table>

                                                                <button type="button" name="submit5" id="submit5" class="btn btn-outline-success "><span class="glyphicon glyphicon-ok" style="text-align:left ;font-weight: 750 "> Enregistrer </span> </button>
                                                            </div>
                                                        </form>
                                                    </div>


                                                    <table id="dtBasicExampleREFPRODUIT" class="table table-bordered table-sm" cellspacing="0" width="100%">

                                                        <thead style="background-color:azure;    color:black">
                                                            <tr>

                                                                <th>
                                                                    #
                                                                </th>
                                                                <th>
                                                                    Imputation
                                                                </th>
                                                                <th>
                                                                    Référence
                                                                </th>

                                                            </tr>
                                                        </thead>

                                                        <tbody id="myInputREF">

                                                            <?php

                                                            $resultREF = mysqli_query($cn, "SELECT * FROM `references` WHERE TYPE='PRODUIT_SERMAT'  ");

                                                            while ($row = mysqli_fetch_array($resultREF)) {

                                                                echo '<tr >';
                                                                echo '<td>' . $row['ID_REF'] . '</td> ';
                                                                echo '<td>' . $row['TYPE'] . '</td> ';
                                                                echo '<td style="text-align:left ;font-weight: bold ">' . $row['REF'] . ' </td> ';

                                                                echo '</tr>';
                                                            }

                                                            ?>
                                                        </tbody>
                                                    </table>



                                                </div>
                                            </div>



                                            <div class="tab-pane fade1" id="v-pills-Fournisseurs" role="tabpanel" aria-labelledby="v-pills-Fournisseurs-tab">

                                                <h5 class="card-title">Références des Fournisseurs</h5>


                                                <div class="tab-content" id="nav-tabContent">
                                                    <div class="row">

                                                        <form name="add-REF" id="add-REFFR">
                                                            <div class="table-responsive">
                                                                <table class="table table-bordered" id="dynamic_fieldREFFR">
                                                                    <tr>
                                                                        <td> <button type="button" name="add6" id="add6" class="btn btn-success btn-sm"><span class="glyphicon glyphicon-plus"></button></td>
                                                                    </tr>
                                                                </table>

                                                                <button type="button" name="submit6" id="submit6" class="btn btn-outline-success "><span class="glyphicon glyphicon-ok" style="text-align:left ;font-weight: 750 "> Enregistrer </span> </button>
                                                            </div>
                                                        </form>
                                                    </div>


                                                    <table id="dtBasicExampleREFFR" class="table table-bordered table-sm" cellspacing="0" width="100%">
                                                        <thead style="background-color:azure;    color:black">
                                                            <tr>

                                                                <th>
                                                                    #
                                                                </th>
                                                                <th>
                                                                    Imputation
                                                                </th>
                                                                <th>
                                                                    Référence
                                                                </th>

                                                            </tr>
                                                        </thead>

                                                        <tbody id="myInputREF">

                                                            <?php

                                                            $resultREF = mysqli_query($cn, "SELECT * FROM `references` WHERE  TYPE='FOURNISSEUR_SERMAT' ");

                                                            while ($row = mysqli_fetch_array($resultREF)) {

                                                                echo '<tr >';
                                                                echo '<td>' . $row['ID_REF'] . '</td> ';
                                                                echo '<td>' . $row['TYPE'] . '</td> ';
                                                                echo '<td style="text-align:left ;font-weight: bold ">' . $row['REF'] . ' </td> ';

                                                                echo '</tr>';
                                                            }

                                                            ?>
                                                        </tbody>
                                                    </table>



                                                </div>
                                            </div>




                                            <div class="tab-pane fade1" id="v-pills-Sites" role="tabpanel" aria-labelledby="v-pills-Sites-tab">


                                                <h5 class="card-title">Références des sites</h5>


                                                <div class="tab-content" id="nav-tabContent">

                                                    <table id="dtBasicExample" class="table table-sm" style="color:black ; font-family:'Microsoft Tai Le' ">


                                                        <thead style="background-color:azure;    color:black">
                                                            <tr>

                                                                <th>
                                                                    #
                                                                </th>
                                                                <th>
                                                                    CODE
                                                                </th>
                                                                <th>
                                                                    Matériel
                                                                </th>
                                                                <th>
                                                                    Marque
                                                                </th>
                                                                <th>
                                                                    Model
                                                                </th>
                                                                <th>
                                                                    Serie
                                                                </th>

                                                            </tr>
                                                        </thead>

                                                        <tbody id="myInputREF">

                                                            <?php

                                                            $resultMACHINE = mysqli_query($cn, "SELECT * FROM `sermat_engin`  ORDER BY ID_C ");

                                                            while ($row = mysqli_fetch_array($resultMACHINE)) {

                                                                echo '<tr >';
                                                                echo '<td>' . $row['ID_M'] . '</td> ';
                                                                echo '<td style="text-align:left ;font-weight: bold ">' . $row['CODE'] . '</td> ';
                                                                echo '<td >' . $row['MATERIEL'] . ' </td> ';
                                                                echo '<td>' . $row['MARQUE'] . '</td> ';
                                                                echo '<td>' . $row['MODEL'] . '</td> ';
                                                                echo '<td>' . $row['SERIE'] . '</td> ';

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

                        </div>

                        <!-- Imputation-->
                        <div class="tab-pane fade1" id="pills-Imputation" role="tabpanel" aria-labelledby="Imputation-tab">
                            <div class="row">


                                <h5 class="card-title"> Imputation</h5>
                                <div class="col-12">
                                    <div class="tab-content" id="nav-tabContent">




                                        <div class="tab-content" id="nav-tabContent">


                                            <table id="dtBasicExample" class="table table-bordered table-sm" cellspacing="0" width="100%">

                                                <thead style="background-color:azure;    color:black">
                                                    <tr>

                                                        <th>
                                                            #
                                                        </th>
                                                        <th>
                                                            CODE
                                                        </th>
                                                        <th>
                                                            Matériel
                                                        </th>
                                                        <th>
                                                            Marque
                                                        </th>
                                                        <th>
                                                            Model
                                                        </th>
                                                        <th>
                                                            Serie
                                                        </th>

                                                        <th>

                                                        </th>

                                                    </tr>
                                                </thead>

                                                <tbody style="font-size:small ;">

                                                    <?php

                                                    $resultMACHINE = mysqli_query($cn, "SELECT sermat_engin.ID_M,sermat_engin.CODE,sermat_engin.MATERIEL,sermat_engin.MARQUE,sermat_engin.SERIE,sermat_engin.MODEL,sermat_stock.ID_MACHINE
                                                                                           FROM `sermat_engin`  INNER JOIN sermat_stock ON sermat_stock.ID_MACHINE=sermat_engin.ID_M WHERE sermat_stock.ID_MAG ='$id'
                                                                                            GROUP BY sermat_engin.ID_M   ORDER BY sermat_engin.ID_C ");

                                                    while ($row = mysqli_fetch_array($resultMACHINE)) {

                                                        echo '<tr >';
                                                        echo '<td>' . $row['ID_M'] . '</td> ';
                                                        echo '<td style="text-align:left ;font-weight: 800 ">' . $row['CODE'] . '</td> ';
                                                        echo '<td >' . $row['MATERIEL'] . ' </td> ';
                                                        echo '<td>' . $row['MARQUE'] . '</td> ';
                                                        echo '<td>' . $row['MODEL'] . '</td> ';
                                                        echo '<td>' . $row['SERIE'] . '</td> ';
                                                        echo '<td>
                                                                <a
                                                                href="SERMAT_MAGASIN-SUIVIIMPU.php?id=' .  $row['ID_M'] . '&&id1=' .  $id . '"
        
                                                                 class="btn btn-outline-primary btn-sm"  > <i class="bi bi-file-earmark-bar-graph">Détails</i>
        
                                                                 </a>
                                                                 </td>';

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

                </div>

            </div>
        </div>
      
        </div>

        <!-- MODAL  BC-->
        <div class="modal fade" id="myModal" role="dialog">
            <div class="modal-dialog modal-lg">


                <div class="modal-content">
                    <div class="modal-header">

                        <h4 class="modal-title">Nouveau Bon de commande</h4>
                    </div>
                    <div class="modal-body">
                        <div class="card">


                            <div class="card-body">
                                <br />

                                <form action="SERMAT_NVBC.php" method="POST" class="row g-3">

                                    <div class="form-group row ">
                                        <div class="col-xs-8">
                                            <?php
                                            echo '<input class="hidden" name="IDMAG1" type="text" value="' . $id . '">';
                                            ?>

                                            <label for="FOURNISSEUR" class="col-form-label">Fournisseur</label>

                                            <select  class="myselect action"  style="width: 350px;" name="FOURNISSEUR" id=" FOURNISSEUR" type="text">

                                                <?php

                                                while ($row = mysqli_fetch_array($resultFR1)) {

                                                    echo '<option selected>' . $row['FOURNISSEUR'] . '</option>';
                                                }

                                                ?>

                                            </select>

                                        </div>

                                        <div class="col-xs-4 ">
                                            <?php
                                            while ($row = mysqli_fetch_array($resultPRODUIT)) {
                                                $MAXCODE = $row['SUBSTR( MAX(N_COMMANDE), 5,20)'] + 1;
                                            }
                                            ?>
                                         
                                            <input class="form-control" name="CODE" type="text" value="SER-<?php echo $MAXCODE ?>"  style="HEIGHT: 30px">
                                        </div>
                                    </div>
                                    <div class="form-group row ">
                                        <div class="col-xs-3">
                                            <label for="ADRESSE" class="col-form-label">Date De la commande</label>
                                            <input class="form-control" name="DATE" type="date">
                                        </div>
                                        <div class="col-xs-3 ">
                                            <label for="DELAI" class="col-form-label">Date de Livraison</label>
                                            <input class="form-control" name="DATEL" id="DATEL" type="date">
                                        </div>

                                    </div>


                                    <div class="form-group row ">
                                        <div class="col-xs-3 ">
                                            <label for="DELAI" class="col-form-label">Mode Paiment</label>
                                            <input class="form-control" name="MODEP" id="MODEP" type="text">
                                        </div>
                                        <div class="col-xs-3 ">
                                            <label for="DELAI" class="col-form-label">TVA</label>
                                            <input class="form-control" name="TVA" id="TVA" type="numbr">
                                        </div>
                                        <div class="col-xs-3">
                                            <label for="DEVISE" class="col-form-label">Imputation:</label>
                                            <select class="form-select form-select-lg" name="REF" id=" REF" type="text">
                                                <option selected>SERMAT</option>
                                                <option>MARITIME</option>
                                                <option> BASE DE VIE </option>
                                                <option> CHANTIER </option>
                                                <option>DIVERS </option>

                                            </select>
                                            <br>

                                        </div>





                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-primary" name="NVAFFAIRE">Enregistré</button>
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
                                        </div>




                                </form>

                            </div>








                        </div>
                    </div>
                </div>

            </div>
        </div>

 

           <!-- RECHERCHE combobox-->
           <script type="text/javascript">
      $(".myselect").select2();
</script>


        <!-- RECHERCHE TABLE MACHINE-->
        <SCript>
            $(document).ready(function() {
                $('#dtBasicExample').DataTable();
                $('.dataTables_length').addClass('bs-select');
            });
        </SCript>


        <!-- RECHERCHE TABLE PRODUITS-->
        <SCript>
            $(document).ready(function() {
                $('#dtBasicExamplePRODUIT').DataTable();
                $('.dataTables_length').addClass('bs-select');
            });
        </SCript>

        <!-- RECHERCHE TABLE COMMANDE-->
        <SCript>
            $(document).ready(function() {
                $('#dtBasicExampleBC').DataTable();
                $('.dataTables_length').addClass('bs-select');
            });
        </SCript>

        <!-- RECHERCHE TABLE LIVRAISON-->
        <SCript>
            $(document).ready(function() {
                $('#dtBasicExampleLIV').DataTable();
                $('.dataTables_length').addClass('bs-select');
            });
        </SCript>

        <!-- RECHERCHE TABLE CONSOMMATION-->
        <SCript>
            $(document).ready(function() {
                $('#dtBasicExampleCONS').DataTable();
                $('.dataTables_length').addClass('bs-select');
            });
        </SCript>


        <!-- RECHERCHE TABLE STOCK-->
        <SCript>
            $(document).ready(function() {
                $('#dtBasicExampleSTOCK').DataTable();
                $('.dataTables_length').addClass('bs-select');
            });
        </SCript>

        <!-- RECHERCHE TABLE FOURNISSEUR-->
        <SCript>
            $(document).ready(function() {
                $('#dtBasicExampleFR').DataTable();
                $('.dataTables_length').addClass('bs-select');
            });
        </SCript>

        <!-- RECHERCHE TABLE REF FOURNISSEUR-->
        <SCript>
            $(document).ready(function() {
                $('#dtBasicExampleREFFR').DataTable();
                $('.dataTables_length').addClass('bs-select');
            });
        </SCript>

        <!-- RECHERCHE TABLE REF PRODUIT-->
        <SCript>
            $(document).ready(function() {
                $('#dtBasicExampleREFPRODUIT').DataTable();
                $('.dataTables_length').addClass('bs-select');
            });
        </SCript>


        <!-- CASCADE COMBOBOX LIV-->
        <script>
            $(document).ready(function() {
                $('.action').change(function() {
                    if ($(this).val() != '') {
                        var action = $(this).attr("id");
                        var query = $(this).val();
                        var result = '';

                        if (action == "FOURNISSEUR") {

                            result = 'BC';

                        }
                        if (action == "BC") {
                            result = 'PRODUIT';
                        }


                        $.ajax({
                            url: "fetch.php?id=<?php echo $id ?> ",
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
        <!-- CASCADE COMBOBOX CONS-->
        <script>
            $(document).ready(function() {
                $('.action').change(function() {
                    if ($(this).val() != '') {
                        var action = $(this).attr("id");
                        var query = $(this).val();
                        var result = '';

                        if (action == "FOURNISSEUR1") {
                            result = 'BC1';

                        }
                        if (action == "BC1") {
                            result = 'PRODUIT1';
                        }
                        if (action == "PRODUIT1") {
                            result = 'QTE1';
                        }

                        $.ajax({
                            url: "fetch.php?id=<?php echo $id ?> ",
                            method: "POST",
                            data: {
                                action: action,
                                query: query
                            },
                            success: function(data) {
                                $('#' + result).html(data);
                            }
                        })

                    }
                });
            });
        </script>


        <!-- AJOUTER FOURNISSEUR-->

        <?php

        $country1 = '';

        $query1 = "SELECT  DISTINCT REF  FROM `references`WHERE TYPE='FOURNISSEUR_SERMAT'  ORDER BY REF  ";

        $result1 = mysqli_query($cn, $query1);
        while ($row = mysqli_fetch_array($result1)) {
            $country1 .= '<option value="' . $row["REF"] . '">' . $row["REF"] . '</option>';
        }

        ?>
        <script>
            $(document).ready(function() {
                var i = 1;
                $('#add3').click(function() {
                    i++;
                    $('#dynamic_fieldFR').append('<tr id="row' + i + '"> <td><button type="button" name="remove" id="' + i + '" class="btn btn-danger btn_remove btn-sm"><span class="glyphicon glyphicon-remove">   <td><input type="text" name="CODE[]" placeholder="Code" class="form-control code_list" /><td><input type="text" name="FOURNISSEUR[]" placeholder="Fournisseur" class="form-control FOURNISSEUR_list" /></td><td><select type="text" name="TYPE[]" placeholder="Référence" class="form-control TYPE_list"> <option value="">Référence</option><?php echo $country1 ?> </select></td><td><input type="text" name="ADRESSE[]" placeholder="Adressse" class="form-control ADRESSE_list" /> <td><input type="text" name="CONTACT[]" placeholder="Contact" class="form-control CONTACT_list" /> </td></td></td> <td><input type="text" name="REF[]" placeholder="REF" class="hidden" value="SERMAT"  /> </td></td> </tr>');


                });
                $(document).on('click', '.btn_remove', function() {
                    var button_id = $(this).attr("id");
                    $('#row' + button_id + '').remove();
                });
                $('#submit3').click(function() {
                    $.ajax({
                        url: "SERMAT_NVFOURNISSEUR.php",
                        method: "POST",
                        data: $('#add-FR').serialize(),
                        success: function(data) {
                            alert(data);
                            $('#add-FR')[0].reset();
                        }
                    });
                });
            });
        </script>

        <!-- AJOUTER PRODUIT-->

        <?php

        $country = '';

        $query = "SELECT  DISTINCT *  FROM `references`WHERE TYPE='PRODUIT_SERMAT'  ORDER BY REF  ";

        $result = mysqli_query($cn, $query);
        while ($row = mysqli_fetch_array($result)) {
            $country .= '<option value="' . $row["REF"] . '">' . $row["REF"] . '</option>';
        }

        ?>



        <script>
            $(document).ready(function() {
                var i = 1;
                $('#add4').click(function() {
                    i++;
                    $('#dynamic_fieldPR').append('<tr id="row' + i + '"> <td><button type="button" name="remove" id="' + i + '" class="btn btn-danger btn_remove btn-sm"><span class="glyphicon glyphicon-remove">   <td><input type="text" name="CODE[]" placeholder="Code" class="form-control code_list"  value="PR-"/><td><input type="text" name="PRODUIT[]" placeholder="PRODUIT" class="form-control PRODUIT_list" /></td><td class="hidden"><input type="text" name="TYPE[]" placeholder="Imputation" class="form-control TYPE_list" value="SERMAT"  /> </td><td><input type="number" name="RUPTURE[]" placeholder="Alert" class="form-control RUPTURE_list" /> <td><input type="text" name="U[]" placeholder="Unité" class="form-control U_list" /> </td><td><select type="text" name="GROUPE[]" placeholder="Référence" class="form-control GROUPE_list"> <option value="">Référence</option><?php echo $country ?> </select></td></tr>');


                });
                $(document).on('click', '.btn_remove', function() {
                    var button_id = $(this).attr("id");
                    $('#row' + button_id + '').remove();
                });
                $('#submit4').click(function() {
                    $.ajax({
                        url: "SERMAT_NVPRODUIT.php",
                        method: "POST",
                        data: $('#add-PR').serialize(),
                        success: function(data) {
                            alert(data);
                            $('#add-PR')[0].reset();
                        }
                    });
                });
            });
        </script>

        <!-- AJOUTER REF PRODUIT-->


        <script>
            $(document).ready(function() {
                var i = 1;
                $('#add5').click(function() {
                    i++;
                    $('#dynamic_fieldREF').append('<tr id="row' + i + '"> <td><button type="button" name="remove" id="' + i + '" class="btn btn-danger btn_remove btn-sm"><span class="glyphicon glyphicon-remove">  <td class="hidden"><input type="text" name="TYPE[]" placeholder="" class="form-control TYPE_list"  value="PRODUIT_SERMAT"/></td> <td><input type="text" name="REF[]" placeholder="Groupe" class="form-control REF_list"  value=""/></td> </tr>');


                });
                $(document).on('click', '.btn_remove', function() {
                    var button_id = $(this).attr("id");
                    $('#row' + button_id + '').remove();
                });
                $('#submit5').click(function() {
                    $.ajax({
                        url: "SERMAT_NVREF.php",
                        method: "POST",
                        data: $('#add-REF').serialize(),
                        success: function(data) {
                            alert(data);
                            $('#add-REF')[0].reset();
                        }
                    });
                });
            });
        </script>
        <!-- AJOUTER REF FOURNISSEUR-->
        <script>
            $(document).ready(function() {
                var i = 1;
                $('#add6').click(function() {
                    i++;
                    $('#dynamic_fieldREFFR').append('<tr id="row' + i + '"> <td><button type="button" name="remove" id="' + i + '" class="btn btn-danger btn_remove btn-sm"><span class="glyphicon glyphicon-remove">   <td class="hidden"><input type="text" name="TYPE[]" placeholder="" class="form-control TYPE_list"  value="FOURNISSEUR_SERMAT"/></td> <td><input type="text" name="REF[]" placeholder="Groupe" class="form-control REF_list"  value=""/></td> </tr>');


                });
                $(document).on('click', '.btn_remove', function() {
                    var button_id = $(this).attr("id");
                    $('#row' + button_id + '').remove();
                });
                $('#submit6').click(function() {
                    $.ajax({
                        url: "SERMAT_NVREF.php",
                        method: "POST",
                        data: $('#add-REFFR').serialize(),
                        success: function(data) {
                            alert(data);
                            $('#add-REFFR')[0].reset();
                        }
                    });
                });
            });
        </script>



        <script src="assets1/plugins/data-tables/jquery.datatables.min.js"></script>
        <script src="assets1/plugins/data-tables/datatables.bootstrap4.min.js"></script>
        <link href="assets1/plugins/data-tables/datatables.bootstrap4.min.css" rel="stylesheet">


</main>