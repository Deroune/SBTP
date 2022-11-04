<?php
include 'index.php';
?>



<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<?php

$cn = mysqli_connect("localhost", "root", "", "vrd");
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $resultARTICLE = mysqli_query($cn, "select *from articles where ID_A='$id'");
    $result1 = mysqli_query($cn, "select *from depenses where ID_A='$id' ORDER BY `TYPE` ASC");
    $resultSUMMOD = mysqli_query($cn, "SELECT SUM(QTE_D*PU) FROM `depenses` WHERE ID_A='$id' AND TYPE='MainOeuvre' AND REF='Budget'");
    $resultSUMMATERIEL = mysqli_query($cn, "SELECT SUM(QTE_D*PU) FROM `depenses` WHERE ID_A='$id' AND TYPE='Materiel'AND REF='Budget' ");
    $resultSUMFOURNITURE = mysqli_query($cn, "SELECT SUM(QTE_D*PU) FROM `depenses` WHERE ID_A='$id' AND TYPE='Fourniture'AND REF='Budget' ");
    $resultSUMST = mysqli_query($cn, "SELECT SUM(QTE_D*PU) FROM `depenses` WHERE ID_A='$id' AND TYPE='Sous traitant'AND REF='Budget' ");
    $resultSUM = mysqli_query($cn, "SELECT SUM(QTE_D*PU) FROM `depenses` WHERE ID_A='$id' AND REF='Budget' ");
}
$resultPOSTE = mysqli_query($cn, "select *from poste ");
$resultFOURNITURES = mysqli_query($cn, "select *from fournitures ");
$resultMATERIEL = mysqli_query($cn, "select *from materiel ");
$resultST = mysqli_query($cn, "select *from st ");


while ($row = mysqli_fetch_array($resultARTICLE)) {

    $IDAF = $row['ID_AFF'];
    $IDAB = $row['ID_B'];
    $IDA = $row['ID_A'];
    $QTEAR = $row['QTE_A'];
    $AR = $row['ARTICLE'];
    $CH = $row['CHAPITRE'];
    $NPRIX = $row['NPRIX'];
    $U = $row['U'];
    $PUA = $row['PU_A'];
}
?>
<main id="main" class="main">

    <!-- MODAL POSTE-->

    <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog modal-lg">


            <div class="modal-content">
                <div class="modal-header" style="background-color:darkorange;color:white">

                    <h4 class="modal-title" style="font-weight: bold ">Liste des Postes</h4>
                </div>
                <div class="modal-body">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">


                                <button class="btn btn-outline-light" data-toggle="collapse" href="#collapseP" style="text-align:left ;font-weight: bold ;color:black"> Nouveau Poste</button>
                                <br />

                                <div class="panel-group">
                                    <div class="panel panel-default">


                                        <div id="collapseP" class="panel-collapse collapse">
                                            <div class="card-body">

                                                <br>

                                                <form action="PosteNV.php?id=<?php echo  $id ?>" method="post" class="row g-3">

                                                    <div class="form-group row ">
                                                        <div class="col-xs-6">
                                                            <label for="POSTE" class="col-form-label">Poste</label>
                                                            <input class="form-control" name="POSTE" id="POSTE" type="text">
                                                        </div>
                                                        <div class="col-xs-3 ">
                                                            <label for="SALAIRE" class="col-form-label">Salaire:</label>
                                                            <input class="form-control" name="SALAIRE" id="SALAIRE" type="number" step="0.01">
                                                        </div>


                                                    </div>



                                                    <div class="form-group row ">




                                                        <div class="col-xs-3">
                                                            <label for="U" class="col-form-label">Unité</label>
                                                            <select class="form-select form-select-lg" name="UP" id="UP" type="text">
                                                                <option selected>Jour</option>
                                                                <option>Mois</option>
                                                                <option>Semaine</option>
                                                                <option>An</option>
                                                                <option>FFT</option>
                                                                <option>autre</option>

                                                            </select>
                                                        </div>


                                                        <div class="col-xs-3">
                                                            <label for="NIVEAU" class="col-form-label">Niveau:</label>
                                                            <select class="form-select form-select-lg" name="NIVEAU" id="NIVEAU" type="text">
                                                                <option selected>N-1</option>
                                                                <option>N-2</option>
                                                                <option>N-3</option>

                                                            </select>

                                                        </div>

                                                        <div class="col-xs-3">
                                                            <label for="DEVISE" class="col-form-label">Devise:</label>
                                                            <select class="form-select form-select-lg" name="DEVISE" id=" DEVISE" type="text">
                                                                <option selected>MAD</option>
                                                                <option>CFA </option>
                                                                <option> USD $ </option>
                                                                <option> EUR € </option>
                                                                <option> Autre </option>

                                                            </select>

                                                        </div>
                                                    </div>
                                                    <div class="modal-footer " style="height:50%">
                                                        <button type="submit" class="btn btn-primary">Enregistrer</button>
                                                    </div>

                                                </form>




                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>


                    <div class="card">
                        <div class="card-body">

                            <br>


                            <table id="hoverable-data-table" class="table display nowrap   ">
                                <thead>
                                    <tr>
                                        <th>
                                            Poste
                                        </th>
                                        <th>
                                            Niveau
                                        </th>
                                        <th>
                                            Cout
                                        </th>
                                        <th>
                                            Unité
                                        </th>

                                        <th>
                                            Devise
                                        </th>


                                        <th>
                                            Inserer
                                        </th>





                                    </tr>
                                </thead>
                                <tbody id="myTablePOSTE">
                                    <?php
                                    while ($row = mysqli_fetch_array($resultPOSTE)) {

                                        echo '<tr style="height: 10px; overflow:auto; font-size:small ; color:black ; ">';

                                        echo "<td>" . $row['POSTE'] . "</td>";



                                        echo "<td>" . $row['NIVEAU'] . "</td>";
                                        echo "<td>" . $row['SALAIRE'] . "</td>";
                                        echo "<td>" . $row['U'] . "</td>";
                                        echo "<td>" . $row['DEVISE'] . "</td>";


                                        echo '<td> 
                               
                            
                                <button id="select" data-id="' . $row['ID_PO'] . '"  data-poste="' . $row['POSTE'] . '" data-salaire="' . $row['SALAIRE'] . '" 
                                 data-u="' . $row['U'] . '"  class="btn btn-outline-success btn-sm" data-dismiss="modal">  <span class="glyphicon glyphicon-save"> </span> Select </button>




                          
                                </td>';

                                        '</tr>';
                                    }

                                    ?>

                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>





                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
                </div>



            </div>

        </div>
    </div>





    <!-- MODAL MATERIEL-->

    <div class="modal fade" id="myModal2" role="dialog">
        <div class="modal-dialog modal-lg">


            <div class="modal-content">
                <div class="modal-header" style="background-color:darkblue;color:white">

                    <h4 class="modal-title" style="font-weight: bold ">Liste des Machines</h4>
                </div>
                <div class="modal-body">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">

                                <button class="btn btn-outline-light" data-toggle="collapse" href="#collapseM" style="text-align:left ;font-weight: bold ;color:black">Ajouter Nouvelle Machine</button>
                                <br />

                                <div class="panel-group">
                                    <div class="panel panel-default">


                                        <div id="collapseM" class="panel-collapse collapse">
                                            <div class="card-body">
                                                <br />


                                                <form action="MaterielNV.php?id=<?php echo  $id ?>" method="post" class="row g-3">

                                                    <div class="form-group row ">
                                                        <div class="col-xs-6">
                                                            <label for="POSTE" class="col-form-label">Machine:</label>
                                                            <input class="form-control" name="MACHINE" id="MACHINE" type="text">
                                                        </div>
                                                        <div class="col-xs-3 ">
                                                            <label for="SALAIRE" class="col-form-label">Cout:</label>
                                                            <input class="form-control" name="COUT" id="COUT" type="number" step="0.01">
                                                        </div>


                                                    </div>



                                                    <div class="form-group row ">




                                                        <div class="col-xs-2">
                                                            <label for="U" class="col-form-label">Unité</label>
                                                            <select class="form-select form-select-lg" name="UM" id="UM" type="text">
                                                                <option selected>Jour</option>
                                                                <option>Mois</option>
                                                                <option>Semaine</option>
                                                                <option>An</option>
                                                                <option>FFT</option>
                                                                <option>autre</option>

                                                            </select>
                                                        </div>


                                                        <div class="col-xs-3">
                                                            <label for="NIVEAU" class="col-form-label">Consommation:</label>
                                                            <input class="form-control" name="CONS" id="CONS" type="number" step="0.01">



                                                        </div>

                                                        <div class="col-xs-3">
                                                            <label for="DEVISE" class="col-form-label">Devise:</label>
                                                            <select class="form-select form-select-lg" name="DEVISE" id=" DEVISE" type="text">
                                                                <option selected>MAD</option>
                                                                <option>CFA </option>
                                                                <option> USD $ </option>
                                                                <option> EUR € </option>
                                                                <option> Autre </option>

                                                            </select>


                                                        </div>
                                                        <div class="col-xs-4">
                                                            <label for="DEVISE" class="col-form-label">Location:</label>
                                                            <select class="form-select form-select-lg" name="LOCATION" id="LOCATION" type="text">
                                                                <option selected>Sans Gasoil et avec Chauffeur</option>
                                                                <option>Sans Gasoil et sans Chauffeur </option>
                                                                <option> avec Gasoil et Chauffeur</option>
                                                                <option> avec Gasoil et sans Chauffeur</option>


                                                            </select>

                                                        </div>
                                                    </div>
                                                    <div class="modal-footer " style="height:50%">
                                                        <button type="submit" class="btn btn-primary">Enregistrer</button>
                                                    </div>

                                                </form>




                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>
                    <div class="card">
                        <div class="card-body">

                            <br>

                            <table id="hoverable-data-table M" class="table display nowrap   ">
                                <thead>
                                    <tr>
                                        <th>
                                            Machine
                                        </th>
                                        <th>
                                            Cout
                                        </th>
                                        <th>
                                            Devise
                                        </th>
                                        <th>
                                            Unité
                                        </th>

                                        <th>
                                            Cons.G
                                        </th>
                                        <th>
                                            Location
                                        </th>

                                        <th>
                                            Inserer
                                        </th>





                                    </tr>
                                </thead>
                                <tbody id="myTableMATERIELS">
                                    <?php
                                    while ($row = mysqli_fetch_array($resultMATERIEL)) {

                                        echo '<tr style="height: 10px; overflow:auto; font-size:small ; color:black ; ">';

                                        echo "<td>" . $row['MATERIEL'] . "</td>";
                                        echo "<td>" . $row['COUT'] . "</td>";
                                        echo "<td>" . $row['DEVISE'] . "</td>";
                                        echo "<td>" . $row['U'] . "</td>";
                                        echo "<td>" . $row['CONS_G'] . "</td>";
                                        echo "<td>" . $row['LOCATION'] . "</td>";


                                        echo '<td> 
                               
                            
                                <button id="selectM"
                                data-id="' . $row['ID_M'] . '"
                                data-poste="' . $row['MATERIEL'] . '"
                                data-salaire="' . $row['COUT'] . '"
                                data-u="' . $row['U'] . '"
                                data-cons="' . $row['CONS_G'] . '"
                                data-typeloc="' . $row['LOCATION'] . '"
                                class="btn btn-outline-success btn-sm" data-dismiss="modal2">
                            <span class="glyphicon glyphicon-save">
                            </span> Select
                               </button>



                          
                                </td>';

                                        '</tr>';
                                    }

                                    ?>

                                </tbody>
                            </table>


                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
                </div>
            </div>
        </div>

    </div>




    <!-- MODAL FOURNITURES-->

    <div class="modal fade" id="myModal3" role="dialog">
        <div class="modal-dialog modal-lg">


            <div class="modal-content">
                <div class="modal-header" style="background-color:darkgreen;color:white">

                    <h4 class="modal-title" style="font-weight: bold ">Liste des Fournitures Consommable</h4>
                </div>
                <div class="modal-body">
                    <div class="card">

                        <div class="row">

                            <div class="card">
                                <div class="card-body">


                                    <div class="panel-group">
                                        <div class="panel panel-default">

                                            <button class="btn btn-outline-info" data-toggle="collapse" href="#collapseF">Nouveau</button>
                                            <br />
                                            <div id="collapseF" class="panel-collapse collapse">
                                                <div class="card-body">
                                                    <br />


                                                    <form action="" method="post" class="row g-3">

                                                        <div class="form-group row ">
                                                            <div class="col-xs-6">
                                                                <label for="POSTE" class="col-form-label">Designation:</label>
                                                                <input class="form-control" name="POSTE" id="POSTE" type="text">
                                                            </div>
                                                            <div class="col-xs-3 ">
                                                                <label for="SALAIRE" class="col-form-label">PU:</label>
                                                                <input class="form-control" name="SALAIRE" id="SALAIRE" type="number" step="0.01">
                                                            </div>


                                                        </div>



                                                        <div class="form-group row ">




                                                            <div class="col-xs-3">
                                                                <label for="U" class="col-form-label">Unité</label>
                                                                <select class="form-select form-select-lg" name="UP" id="UP" type="text">
                                                                    <option selected>Jour</option>
                                                                    <option>Mois</option>
                                                                    <option>Semaine</option>
                                                                    <option>An</option>
                                                                    <option>FFT</option>
                                                                    <option>autre</option>

                                                                </select>
                                                            </div>


                                                            <div class="col-xs-3">
                                                                <label for="NIVEAU" class="col-form-label">SITE:</label>
                                                                <input class="form-control" name="SALAIRE" id="SALAIRE" type="text">



                                                            </div>

                                                            <div class="col-xs-3">
                                                                <label for="DEVISE" class="col-form-label">Devise:</label>
                                                                <select class="form-select form-select-lg" name="DEVISE" id=" DEVISE" type="text">
                                                                    <option selected>MAD</option>
                                                                    <option>CFA </option>
                                                                    <option> USD $ </option>
                                                                    <option> EUR € </option>
                                                                    <option> Autre </option>

                                                                </select>


                                                            </div>
                                                            <div class="col-xs-4">
                                                                <label for="DEVISE" class="col-form-label">Livraison:</label>
                                                                <select class="form-select form-select-lg" name="DEVISE" id=" DEVISE" type="text">
                                                                    <option selected>RENDU</option>
                                                                    <option>DEPART </option>



                                                                </select>

                                                            </div>
                                                            <div class="modal-footer " style="height:50%">
                                                                <button type="submit" class="btn btn-primary">Enregistrer</button>
                                                            </div>
                                                        </div>
                                                    </form>




                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                        </div>

                        <div class="card-body">

                            <br>

                            <dl>


                                <dd>
                                    <table id="hoverable-data-table M" class="table ">
                                        <thead>
                                            <tr>
                                                <th>
                                                    Fourniture
                                                </th>
                                                <th>
                                                    Prix
                                                </th>
                                                <th>
                                                    Devise
                                                </th>
                                                <th>
                                                    Unité
                                                </th>

                                                <th>
                                                    Livraison
                                                </th>
                                                <th>
                                                    Ville
                                                </th>

                                                <th>
                                                    Inserer
                                                </th>





                                            </tr>
                                        </thead>
                                        <tbody id="myTableMATERIELS">
                                            <?php
                                            while ($row = mysqli_fetch_array($resultFOURNITURES)) {

                                                echo '<tr style="height: 10px; overflow:auto; font-size:small ; color:black ; ">';

                                                echo "<td>" . $row['FOURNITURE'] . "</td>";
                                                echo "<td>" . $row['PRIX_F'] . "</td>";
                                                echo "<td>" . $row['DEVISE'] . "</td>";
                                                echo "<td>" . $row['U_F'] . "</td>";
                                                echo "<td>" . $row['VILLE_F'] . "</td>";
                                                echo "<td>" . $row['LIVRAISON'] . "</td>";


                                                echo '<td> 
                               
                                <button id="selectFOUR"
                                data-id="' . $row['ID_F'] . '"
                                data-fourniture="' . $row['FOURNITURE'] . '"
                                data-prix="' . $row['PRIX_F'] . '"
                                data-u="' . $row['U_F'] . '"
                                data-livraison="' . $row['LIVRAISON'] . '"
                             
                                class="btn btn-outline-success btn-sm" data-dismiss="modal3">
                            <span class="glyphicon glyphicon-save">
                            </span> Select
                        </button>

                              



                          
                                </td>';

                                                '</tr>';
                                            }

                                            ?>




                                        </tbody>
                                    </table>
                                </dd>
                            </dl>

                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
                </div>
            </div>

        </div>
    </div>



    <!-- MODAL Sous traitance -->
    <div class="modal fade" id="myModal4" role="dialog">
        <div class="modal-dialog modal-lg">


            <div class="modal-content">
                <div class="modal-header" style="background-color:darkred;color:white">

                    <h4 class="modal-title" style="font-weight: bold ">Liste des Taches</h4>
                </div>
                <div class="modal-body">
                    <div class="card">

                        <div class="row">

                            <div class="card">
                                <div class="card-body">


                                    <div class="panel-group">
                                        <div class="panel panel-default">

                                            <button class="btn btn-outline-info" data-toggle="collapse" href="#collapseST">Ajouter Nouvelle Tache</button>
                                            <br />
                                            <div id="collapseST" class="panel-collapse collapse">
                                                <div class="card-body">
                                                    <br />


                                                    <form action="" method="post" class="row g-3">

                                                        <div class="form-group row ">
                                                            <div class="col-xs-6">
                                                                <label for="POSTE" class="col-form-label">Poste</label>
                                                                <input class="form-control" name="POSTE" id="POSTE" type="text">
                                                            </div>
                                                            <div class="col-xs-3 ">
                                                                <label for="SALAIRE" class="col-form-label">Salaire:</label>
                                                                <input class="form-control" name="SALAIRE" id="SALAIRE" type="number" step="0.01">
                                                            </div>


                                                        </div>



                                                        <div class="form-group row ">




                                                            <div class="col-xs-3">
                                                                <label for="U" class="col-form-label">Unité</label>
                                                                <select class="form-select form-select-lg" name="UP" id="UP" type="text">
                                                                    <option selected>Jour</option>
                                                                    <option>Mois</option>
                                                                    <option>Semaine</option>
                                                                    <option>An</option>
                                                                    <option>FFT</option>
                                                                    <option>autre</option>

                                                                </select>
                                                            </div>


                                                            <div class="col-xs-3">
                                                                <label for="NIVEAU" class="col-form-label">Niveau:</label>
                                                                <select class="form-select form-select-lg" name="NIVEAU" id="NIVEAU" type="text">
                                                                    <option selected>N-1</option>
                                                                    <option>N-2</option>
                                                                    <option>N-3</option>

                                                                </select>

                                                            </div>

                                                            <div class="col-xs-3">
                                                                <label for="DEVISE" class="col-form-label">Devise:</label>
                                                                <select class="form-select form-select-lg" name="DEVISE" id=" DEVISE" type="text">
                                                                    <option selected>MAD</option>
                                                                    <option>CFA </option>
                                                                    <option> USD $ </option>
                                                                    <option> EUR € </option>
                                                                    <option> Autre </option>

                                                                </select>

                                                            </div>
                                                        </div>
                                                        <div class="modal-footer " style="height:50%">
                                                            <button type="submit" class="btn btn-primary">Enregistrer</button>
                                                        </div>

                                                    </form>




                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                        </div>


                        <div class="card-body">

                            <br>

                            <dl>


                                <dd>
                                    <table id="hoverable-data-table" class="table ">
                                        <thead>
                                            <tr>
                                                <th>
                                                    Poste
                                                </th>
                                                <th>
                                                    Niveau
                                                </th>
                                                <th>
                                                    Cout
                                                </th>
                                                <th>
                                                    Unité
                                                </th>

                                                <th>
                                                    Devise
                                                </th>


                                                <th>
                                                    Inserer
                                                </th>





                                            </tr>
                                        </thead>
                                        <tbody id="myTablePOSTE">
                                            <?php
                                            while ($row = mysqli_fetch_array($resultPOSTE)) {

                                                echo '<tr style="height: 10px; overflow:auto; font-size:small ; color:black ; ">';

                                                echo "<td>" . $row['POSTE'] . "</td>";



                                                echo "<td>" . $row['NIVEAU'] . "</td>";
                                                echo "<td>" . $row['SALAIRE'] . "</td>";
                                                echo "<td>" . $row['U'] . "</td>";
                                                echo "<td>" . $row['DEVISE'] . "</td>";


                                                echo '<td> 
                               
                            
                                <button id="select" data-id="' . $row['ID_PO'] . '"  data-poste="' . $row['POSTE'] . '" data-salaire="' . $row['SALAIRE'] . '" 
                                 data-u="' . $row['U'] . '"  class="btn btn-outline-success btn-sm" data-dismiss="modal">  <span class="glyphicon glyphicon-save"> </span> Select </button>




                          
                                </td>';

                                                '</tr>';
                                            }

                                            ?>

                                        </tbody>
                                    </table>
                                </dd>
                            </dl>

                        </div>
                    </div>
                </div>




                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
                </div>



            </div>

        </div>
    </div>








    <div class="row ">


        <div class="col-sm-3">
            <!-- COUT  MOD-->
            <div class="row ">

                <div class="card small">
                    <div class="card-body  " style="padding:1px">
                        <br />

                        <div class="panel-group">
                            <div class="panel panel-default  ">

                                <div class="panel-heading">

                                    <div class="row col-12 ">
                                        <div class="col-10">
                                            <h4 style="font-weight: bold ">Coût de la main-d'œuvre </h4>



                                        </div>
                                        <div class="col-2  ">
                                            <button class="btn btn.outline" data-toggle="collapse" href="#collapse1" style="float:right"><i class="fa fa-plus" style="color:forestgreen"></i> </button>
                                        </div>
                                    </div>

                                    <?php
                                    while ($row = mysqli_fetch_array($resultSUM)) {
                                        $total = $row['SUM(QTE_D*PU)'];
                                        while ($row = mysqli_fetch_array($resultSUMMOD)) {

                                            echo '<tr style="height: 10px; overflow:auto; font-size:small ; color:black ; ">';
                                            $totalmod = $row['SUM(QTE_D*PU)'];
                                            if ($total == 0) {
                                                $pourcentagemod = 0;
                                            } else {
                                                $pourcentagemod = ($totalmod / $total) * 100;
                                            }


                                            echo '<div class="row">';

                                            echo '<div class="col-6 ">';
                                            echo "<h4 style='color: orange; font-weight: 700'>" . number_format($totalmod, 2, ',', '.') . "</H4>";
                                            echo '</div>';

                                            echo '<div class="col-3 ">';
                                            echo "<h4 style='color:orange; font-weight: bold '>" . number_format($pourcentagemod, 2, ',', '.') . '%' . "</H4>";
                                            echo '</div>';

                                            echo '</div>';
                                        }
                                    }

                                    ?>




                                    <div id="collapse1" class="panel-collapse collapse">
                                        <div class="card-body">
                                            <br />

                                            <form action="BudgetNVMOD.php" method="post" class="row g-3">

                                                <input class="hidden" name="REF" type="text" value="Budget">
                                                <input class="hidden" name="TYPE" type="text" value="MainOeuvre">




                                                <div class="form-group row   ">

                                                    <?php




                                                    echo '<div class="col-xs-3 ">';


                                                    echo '<input class="hidden" name="ID_AFF"  type="text" value=" ' . $IDAF . '">';

                                                    echo '</div>';
                                                    echo '<div class="col-xs-3 ">';

                                                    echo '<input class="hidden" name="ID_B"  type="text" value=" ' . $IDAB . '">';

                                                    echo '</div>';

                                                    echo '<div class="col-xs-3 ">';

                                                    echo '<input class="hidden" name="ID_A" type="text" value=" ' . $IDA . '">';

                                                    echo '</div>';

                                                    echo '<div class="col-xs-4">';


                                                    echo '<input class="hidden" name="QTE_A" type="text" value=" ' . $QTEAR . '">';


                                                    echo '</div>';

                                                    ?>
                                                </div>


                                                <div class="form-group row ">
                                                    <div class="col-xs-7 ">
                                                        <label for="DEPENSE" class="col-form-label">Désignation</label>
                                                        <input class="form-control" name="DEPENSE" id="DEPENSE" type="text">
                                                    </div>
                                                    <div class="col-xs-3">
                                                        <label for="U" class="col-form-label">U</label>
                                                        <input class="form-control" name="U" id="U" type="text">
                                                    </div>
                                                    <div class="col-xs-1">
                                                        <label type="hidden" for="aj" class="col-form-label">.</label>
                                                        <button type="button" data-toggle="modal" data-target="#myModal" class="btn btn-success">+</button>
                                                    </div>

                                                </div>



                                                <div class="form-group row">
                                                    <div class="col-xs-5">
                                                        <label for="PU" class="col-form-label">Cout U:</label>
                                                        <input class="form-control" name="PU" id="PU" type="text">
                                                    </div>

                                                    <div class="col-xs-4">
                                                        <label for="CADENCE" class="col-form-label">Cadence:</label>
                                                        <input class="form-control" name="CADENCE" id="CADENCE" type="number" step="0.01">
                                                    </div>
                                                    <div class="col-xs-3">
                                                        <label for="COEF" class="col-form-label">%:</label>
                                                        <input class="form-control" name="COEF" type="number" step="0.01">
                                                    </div>

                                                </div>



                                                <div class="form-group mb-4">
                                                    <label for="Note" class="col-form-label">Note:</label>
                                                    <input class="form-control" name="NOTE" type="text">
                                                </div>

                                                <div class="modal-footer">

                                                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                                                </div>

                                            </form>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>


            <!-- COUT  MATERIEL-->
            <div class="row ">

                <div class="card small">
                    <div class="card-body  " style="padding:1px">
                        <br />

                        <div class="panel-group">
                            <div class="panel panel-default  ">

                                <div class="panel-heading">

                                    <div class="row col-12 ">
                                        <div class="col-10">
                                            <h4 style="font-weight: bold ">
                                                Coût de matériel

                                        </div>
                                        <div class="col-2  ">
                                            <button class="btn btn.outline" data-toggle="collapse" href="#collapsem" style="float:right"><i class="fa fa-plus" style="color:forestgreen"></i> </button>
                                        </div>
                                    </div>
                                    <?php



                                    while ($row = mysqli_fetch_array($resultSUMMATERIEL)) {

                                        echo '<tr style="height: 10px; overflow:auto; font-size:small ; color:black ; ">';
                                        $totalMAT = $row['SUM(QTE_D*PU)'];
                                        if ($total == 0) {
                                            $pourcentagemat = 0;
                                        } else {
                                            $pourcentagemat = ($totalMAT / $total) * 100;
                                        }




                                        echo '<div class="row">';

                                        echo '<div class="col-6 ">';
                                        echo "<h4 style='color: blue; font-weight: 700'>" . number_format($totalMAT, 2, ',', '.') . "</H4>";
                                        echo '</div>';

                                        echo '<div class="col-3 ">';
                                        echo "<h4 style='color:blue ; font-weight: bold '>" . number_format($pourcentagemat, 2, ',', '.') . '%' . "</H4>";
                                        echo '</div>';

                                        echo '</div>';
                                    }


                                    ?>






                                    <div id="collapsem" class="panel-collapse collapse">
                                        <div class="card-body">
                                            <br />

                                            <form action="BudgetNVMAT.php" method="post" class="row g-3">
                                                <input class="hidden" name="REF" id="REF" type="text" value="Budget">
                                                <input class="hidden" name="TYPE" id="TYPE" type="text" value="Matériel">





                                                <div class="form-group row   ">
                                                    <?php

                                                    echo '<div class="col-xs-3 ">';



                                                    echo '<input class="hidden" name="ID_AFF"  type="text" value=" ' . $IDAF . '">';

                                                    echo '</div>';
                                                    echo '<div class="col-xs-3 ">';

                                                    echo '<input class="hidden" name="ID_B"  type="text" value=" ' . $IDAB . '">';

                                                    echo '</div>';

                                                    echo '<div class="col-xs-3 ">';

                                                    echo '<input class="hidden" name="ID_A" type="text" value=" ' . $IDA . '">';

                                                    echo '</div>';

                                                    echo '<div class="col-xs-4">';


                                                    echo '<input class="hidden" name="QTE_A" type="text" value=" ' . $QTEAR . '">';


                                                    echo '</div>';


                                                    ?>
                                                </div>

                                                <div class="form-group row ">
                                                    <div class="col-xs-7 ">
                                                        <label for="DEPENSE" class="col-form-label">Désignation</label>
                                                        <input class="form-control" name="DEPENSE" id="DEPENSEM" type="text">
                                                    </div>
                                                    <div class="col-xs-3">
                                                        <label for="U" class="col-form-label">U</label>
                                                        <input class="form-control" name="U" id="Um" type="text">
                                                    </div>
                                                    <div class="col-xs-1">
                                                        <label type="hidden" for="aj" class="col-form-label">.</label>
                                                        <button type="button" data-toggle="modal" data-target="#myModal2" class="btn btn-success">+</button>
                                                    </div>

                                                </div>



                                                <div class="form-group row">
                                                    <div class="col-xs-5">
                                                        <label for="PU" class="col-form-label">Cout U:</label>
                                                        <input class="form-control" name="PU" id="PUMACHINE" type="text">
                                                    </div>

                                                    <div class="col-xs-4">
                                                        <label for="CADENCE" class="col-form-label">Cadence:</label>
                                                        <input class="form-control" name="CADENCE" id="CADENCEM" type="number" step="0.01">
                                                    </div>
                                                    <div class="col-xs-3">
                                                        <label for="COEF" class="col-form-label">%:</label>
                                                        <input class="form-control" name="COEF" id="COEF" type="number" step="0.01">
                                                    </div>

                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-xs-10">
                                                        <label for="TYPELOC" class="col-form-label">Location:</label>
                                                        <input class="form-control" name="TYPELOC" id="TYPELOC" type="text">

                                                    </div>
                                                </div>


                                                <div class="form-group row">
                                                    <div class="col-xs-6">
                                                        <label for="CONSM" class="col-form-label">Cons. Gasoil:</label>
                                                        <input class="form-control" name="CONSM" id="CONSM" type="text">
                                                    </div>

                                                    <div class="col-xs-6">
                                                        <label for="CADENCE" class="col-form-label">PU GASOIL:</label>
                                                        <input class="form-control" name="PUG" id="PUG" type="number" step="0.01">
                                                    </div>


                                                </div>

                                                <div class="form-group mb-4">
                                                    <label for="Note" class="col-form-label">Note:</label>
                                                    <input class="form-control" name="NOTE" id="Note" type="text">
                                                </div>

                                                <div class="modal-footer">

                                                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                                                </div>

                                            </form>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>





            </div>


            <!-- COUT  MATERIAUX-->
            <div class="row ">

                <div class="card small">
                    <div class="card-body  " style="padding:1px">
                        <br />

                        <div class="panel-group">
                            <div class="panel panel-default  ">

                                <div class="panel-heading">

                                    <div class="row col-12 ">
                                        <div class="col-10">
                                            <h4 style="font-weight: bold ">
                                                Coût des matériaux






                                        </div>
                                        <div class="col-2  ">
                                            <button class="btn btn.outline" data-toggle="collapse" href="#collaps4" style="float:right"><i class="fa fa-plus" style="color:forestgreen"></i> </button>
                                        </div>


                                    </div>
                                    <?php


                                    while ($row = mysqli_fetch_array($resultSUMFOURNITURE)) {

                                        echo '<tr style="height: 10px; overflow:auto; font-size:small ; color:black ; ">';
                                        $totalFOUR = $row['SUM(QTE_D*PU)'];

                                        if ($total == 0) {
                                            $pourcentagefr = 0;
                                        } else {
                                            $pourcentagefr = ($totalFOUR / $total) * 100;
                                        }



                                        echo '<div class="row">';

                                        echo '<div class="col-6 ">';
                                        echo "<h4 style='color:green; font-weight: 700'>" . number_format($totalFOUR, 2, ',', '.') . "</H4>";
                                        echo '</div>';

                                        echo '<div class="col-3 ">';
                                        echo "<h4 style='color: green; font-weight:bold  '>" . number_format($pourcentagefr, 2, ',', '.') . '%' . "</H4>";
                                        echo '</div>';

                                        echo '</div>';
                                    }


                                    ?>




                                    <div id="collaps4" class="panel-collapse collapse">
                                        <div class="card-body">
                                            <br />

                                            <form action="BudgetNVFOURN.php" method="post" class="row g-3">
                                                <input class="hidden" name="REF" id="REF" type="text" value="Budget">
                                                <input class="hidden" name="TYPE" id="TYPE" type="text" value="Fourniture">





                                                <div class="form-group row   ">
                                                    <?php

                                                    echo '<div class="col-xs-3 ">';



                                                    echo '<input class="hidden" name="ID_AFF"  type="text" value=" ' . $IDAF . '">';

                                                    echo '</div>';
                                                    echo '<div class="col-xs-3 ">';

                                                    echo '<input class="hidden" name="ID_B"  type="text" value=" ' . $IDAB . '">';

                                                    echo '</div>';

                                                    echo '<div class="col-xs-3 ">';

                                                    echo '<input class="hidden" name="ID_A" type="text" value=" ' . $IDA . '">';

                                                    echo '</div>';

                                                    echo '<div class="col-xs-4">';


                                                    echo '<input class="hidden" name="QTE_A" type="text" value=" ' . $QTEAR . '">';


                                                    echo '</div>';


                                                    ?>
                                                </div>


                                                <div class="form-group row ">
                                                    <div class="col-xs-7 ">
                                                        <label for="DEPENSE" class="col-form-label">Désignation</label>
                                                        <input class="form-control" name="DEPENSE" id="DEPENSEF" type="text">
                                                    </div>
                                                    <div class="col-xs-3">
                                                        <label for="U" class="col-form-label">U</label>
                                                        <input class="form-control" name="U" id="UF" type="text">
                                                    </div>
                                                    <div class="col-xs-1">
                                                        <label type="hidden" for="aj" class="col-form-label">.</label>
                                                        <button type="button" data-toggle="modal" data-target="#myModal3" class="btn btn-success">+</button>
                                                    </div>

                                                </div>



                                                <div class="form-group row">
                                                    <div class="col-xs-5">
                                                        <label for="PU" class="col-form-label">Prix U:</label>
                                                        <input class="form-control" name="PU" id="PUF" type="text">
                                                    </div>

                                                    <div class="col-xs-4">
                                                        <label for="QTE" class="col-form-label">QTE:</label>
                                                        <input class="form-control" name="QTE" id="QTE" type="number" step="0.01">
                                                    </div>
                                                    <div class="col-xs-3">
                                                        <label for="COEF" class="col-form-label">%:</label>
                                                        <input class="form-control" name="COEF" id="COEF" type="number" step="0.01">
                                                    </div>

                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-xs-7">
                                                        <label for="LIVF" class="col-form-label">Livraison:</label>
                                                        <input class="form-control" name="LIVF" id="LIVF" type="text">
                                                    </div>
                                                </div>


                                                <div class="form-group mb-4">
                                                    <label for="Note" class="col-form-label">Note:</label>
                                                    <input class="form-control" name="NOTE" id="Note" type="text">
                                                </div>

                                                <div class="modal-footer">

                                                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                                                </div>

                                            </form>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>





            </div>


            <!-- COUT  SOUS TRAITANT-->
            <div class="row ">

                <div class="card small">
                    <div class="card-body  " style="padding:1px">
                        <br />

                        <div class="panel-group">
                            <div class="panel panel-default  ">

                                <div class="panel-heading">

                                    <div class="row col-12 ">
                                        <div class="col-10">
                                            <h4 style="font-weight: bold ">
                                                coût de sous-traitance






                                        </div>
                                        <div class="col-2  ">
                                            <button class="btn btn.outline" data-toggle="collapse" href="#collapse5" style="float:right"><i class="fa fa-plus" style="color:forestgreen"></i> </button>
                                        </div>


                                    </div>
                                    <?php


                                    while ($row = mysqli_fetch_array($resultSUMST)) {

                                        echo '<tr style="height: 10px; overflow:auto; font-size:small ; color:black ; ">';
                                        $totalST = $row['SUM(QTE_D*PU)'];

                                        if ($total == 0) {
                                            $pourcentagefr = 0;
                                        } else {
                                            $pourcentagefr = ($totalST / $total) * 100;
                                        }



                                        echo '<div class="row">';

                                        echo '<div class="col-6 ">';
                                        echo "<h4 style='color:red; font-weight: 700'>" . number_format($totalST, 2, ',', '.') . "</H4>";
                                        echo '</div>';

                                        echo '<div class="col-3 ">';
                                        echo "<h4 style='color: red; font-weight:bold  '>" . number_format($pourcentagefr, 2, ',', '.') . '%' . "</H4>";
                                        echo '</div>';

                                        echo '</div>';
                                    }


                                    ?>




                                    <div id="collapse5" class="panel-collapse collapse">
                                        <div class="card-body">
                                            <br />

                                            <form action="BudgetNVST.php" method="post" class="row g-3">
                                                <input class="hidden" name="REF" id="REF" type="text" value="Budget">
                                                <input class="hidden" name="TYPE" id="TYPE" type="text" value="Sous traitant">





                                                <div class="form-group row   ">
                                                    <?php

                                                    echo '<div class="col-xs-3 ">';



                                                    echo '<input class="hidden" name="ID_AFF"  type="text" value=" ' . $IDAF . '">';

                                                    echo '</div>';
                                                    echo '<div class="col-xs-3 ">';

                                                    echo '<input class="hidden" name="ID_B"  type="text" value=" ' . $IDAB . '">';

                                                    echo '</div>';

                                                    echo '<div class="col-xs-3 ">';

                                                    echo '<input class="hidden" name="ID_A" type="text" value=" ' . $IDA . '">';

                                                    echo '</div>';

                                                    echo '<div class="col-xs-4">';


                                                    echo '<input class="hidden" name="QTE_A" type="text" value=" ' . $QTEAR . '">';


                                                    echo '</div>';


                                                    ?>
                                                </div>


                                                <div class="form-group row ">
                                                    <div class="col-xs-7 ">
                                                        <label for="DEPENSE" class="col-form-label">Désignation</label>
                                                        <input class="form-control" name="DEPENSE" id="DEPENSEF" type="text">
                                                    </div>
                                                    <div class="col-xs-3">
                                                        <label for="U" class="col-form-label">U</label>
                                                        <input class="form-control" name="U" id="UF" type="text">
                                                    </div>
                                                    <div class="col-xs-1">
                                                        <label type="hidden" for="aj" class="col-form-label">.</label>
                                                        <button type="button" data-toggle="modal" data-target="#myModal4" class="btn btn-success">+</button>
                                                    </div>

                                                </div>



                                                <div class="form-group row">
                                                    <div class="col-xs-5">
                                                        <label for="PU" class="col-form-label">Prix U:</label>
                                                        <input class="form-control" name="PU" id="PUF" type="text">
                                                    </div>

                                                    <div class="col-xs-6">
                                                        <label for="QTE" class="col-form-label">QTE:</label>
                                                        <input class="form-control" name="QTE" id="QTE" type="number" step="0.01">
                                                    </div>
                                                    <div class="col-xs-4">

                                                        <input class="hidden" name="COEF" id="COEF" type="number" step="0.01" value="1">
                                                    </div>

                                                </div>



                                                <div class="form-group mb-6">
                                                    <label for="Note" class="col-form-label">Note:</label>
                                                    <input class="form-control" name="NOTE" id="Note" type="text">
                                                </div>

                                                <div class="modal-footer">

                                                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                                                </div>

                                            </form>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>





            </div>


            <!-- CHART-->
            <div class="row ">


                <div class="card ">
                    <div class="card-body">
                        <div id="columnChart"></div>

                        <script>
                            document.addEventListener("DOMContentLoaded", () => {
                                new ApexCharts(document.querySelector("#columnChart"), {
                                    series: [{
                                        name: 'Matériel',
                                        data: [<?php echo $totalMAT ?>]

                                    }, {
                                        name: 'Matériaux',
                                        data: [<?php echo $totalFOUR ?>]
                                    }, {
                                        name: 'Mod',
                                        data: [<?php echo $totalmod ?>]
                                    }, {
                                        name: 'ST',
                                        data: [<?php echo $totalST ?>]
                                    }],
                                    chart: {
                                        type: 'bar',
                                        height: 200
                                    },
                                    plotOptions: {
                                        bar: {
                                            horizontal: true,
                                            columnWidth: '100%',
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
                                        categories: [''],
                                    },
                                    yaxis: {
                                        title: {
                                            text: 'Montant '
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


                    </div>
                </div>


            </div>
        </div>
        <!-- DETAIL DEPENSES-->
        <div class="col-sm-9">


            <style>
                dt {
                    float: left;
                    clear: left;
                    width: 110px;
                    font-weight: normal;
                    color: black;

                }

                dd {
                    margin: 0 0 0 60px;
                    padding: 0 0 0.5em 0;
                    font-weight: bold;
                    color: darkblue;
                    font-family: Cambria, Cochin, Georgia, Times, 'Times New Roman', serif;

                }
            </style>






            <?php



            echo '<div class="card ">';
            echo '<div class="card-body">';


            echo '<div class="row">';

            echo '<div class="col-xs-8">';


            echo '<h4 class="card-title" style="text-align:LEFT" > Article : ' . "  " . $NPRIX . " - " . $AR . '</h4>';






            echo '<dl>';
            echo '<dt class="card-text"  >Chapitre:' . '</dt>';
            echo '<dd class="card-text" >' . " " . $CH . '</dd>';
            echo '<dt class="card-text"  >Quantité:' . '</dt>';
            echo '<dd class="card-text" >' . " " . $QTEAR . "  " . $U .  '</dd>';
            echo '<dt class="card-text"  >Prix U:' . '</dt>';
            echo '<dd class="card-text" >' . " " . $PUA  .  '</dd>';
            echo '</dl>';




            echo "</div>";


            ?>



            <br />

            <table class="table table-sm" style="color:black ; font-family:'Microsoft Tai Le' ">
                <thead style="background-color: aliceblue">
                    <tr>

                        <th>
                            Type
                        </th>

                        <th>
                            Désignation
                        </th>


                        <th>
                            Cadence
                        </th>
                        <th>
                            Unité
                        </th>
                        <th>
                            Coefficient
                        </th>
                        <th>
                            Qté réelle
                        </th>
                        <th>
                            Prix U
                        </th>
                        <th>
                            Cout Total
                        </th>
                        <th>
                            Note
                        </th>



                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while ($row = mysqli_fetch_array($result1)) {
                        $id = $row['ID_A'];
                        echo '<tr style="height: 10px; overflow:auto; font-size:small ; color:black ;line-height:10px ">';

                        echo "<td>" . $row['TYPE'] . "</td>";

                        $pu = $row['PU'];
                        $qted = $row['QTE_D'];


                        echo "<td>" . $row['DEPENSE'] . "</td>";
                        echo "<td>" . $row['CADENCE'] . "</td>";
                        echo "<td>" . $row['U'] . "</td>";
                        echo "<td>" . $row['COEF_D'] . "</td>";
                        echo "<td>" . $row['QTE_D'] . "</td>";
                        echo "<td>" . $row['PU'] . "</td>";
                        echo "<td>" . $pu * $qted . "</td>";
                        echo "<td>" . $row['NOTE'] . "</td>";


                        '</tr>';
                    }

                    ?>
                </tbody>
            </table>






        </div>
    </div>





    <!-- inserer poste en input-->
    <script>
        $(document).ready(function() {
            $(document).on('click', '#select', function() {
                var IdPo = $(this).data('id');
                var poste = $(this).data('poste');
                var salaire = $(this).data('salaire');
                var u = $(this).data('u');

                $('#DEPENSE').val(poste);
                $('#PU').val(salaire);
                $('#U').val(u);

            })

        })
    </script>

    <!-- inserer materiel-->
    <script>
        $(document).ready(function() {
            $(document).on('click', '#selectM', function() {
                var IdPo = $(this).data('id');
                var poste = $(this).data('poste');
                var salaire = $(this).data('salaire');
                var u = $(this).data('u');
                var cons = $(this).data('cons');
                var typeloc = $(this).data('typeloc');
                $('#DEPENSEM').val(poste);
                $('#PUMACHINE').val(salaire);
                $('#Um').val(u);
                $('#CONSM').val(cons);
                $('#TYPELOC').val(typeloc);
            })

        })
    </script>

    <!-- inserer FOURNITURE-->
    <script>
        $(document).ready(function() {
            $(document).on('click', '#selectFOUR', function() {
                var id = $(this).data('id');
                var fourniture = $(this).data('fourniture');
                var prix = $(this).data('prix');
                var u = $(this).data('u');
                var livraison = $(this).data('livraison');

                $('#DEPENSEF').val(fourniture);
                $('#PUF').val(prix);
                $('#UF').val(u);
                $('#LIVF').val(livraison);

            })

        })
    </script>

    <!-- nouveau poste-->

    <script>
        $(document).ready(function() {
            $("#myInputPOSTE").on("keyup", function() {
                var value = $(this).val().toLowerCase();
                $("#myTablePOSTE tr").filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });
        });
    </script>

    <!-- PAGINATION TABLE POSTE-->
    <script>
        jQuery(document).ready(function() {
            jQuery('#hoverable-data-table').DataTable({
                "aLengthMenu": [
                    [10, 30, 50, 75, -1],
                    [10, 30, 50, 75, "All"]
                ],
                "pageLength": 10,
                "dom": '<"row justify-content-between top-information"lf>rt<"row justify-content-between bottom-information"ip><"clear">'
            });
        });
    </script>
    <script src="assets1/plugins/data-tables/jquery.datatables.min.js"></script>
    <script src="assets1/plugins/data-tables/datatables.bootstrap4.min.js"></script>
    <link href="assets1/plugins/data-tables/datatables.bootstrap4.min.css" rel="stylesheet">



</main>