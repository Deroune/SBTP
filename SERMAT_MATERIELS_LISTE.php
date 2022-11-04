<?php
include 'index.php';
?>

<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>


<?php

$cn = mysqli_connect("localhost", "root", "", "vrd");
if (isset($_GET['idT'])) {
    $idT = $_GET['idT'];
    $idC = $_GET['idC'];
    $resultLISTEMATERIEL = mysqli_query($cn, "select *from sermat_engin where ID_T='$idT'");



    $resultLISTETYPE = mysqli_query($cn, "select *from sermat_type_engin where ID_TE='$idT'");
    $resultLISTECAT= mysqli_query($cn, "select *from Categorie where ID_C='$idC'");
    $resultnbengins = mysqli_query($cn, "SELECT COUNT(ID_M) from sermat_engin where ID_T='$idT'");
}

while ($row = mysqli_fetch_array($resultnbengins)) {

    $nbengins = $row['COUNT(ID_M)'];
}
while ($row = mysqli_fetch_array($resultLISTECAT)) {
    $CAT = $row['CATEGORIE'];
}
while ($row = mysqli_fetch_array($resultLISTETYPE)) {
    $TYPE = $row['TYPE'];

  
?>
<main id="main" class="main">

    <div class="pagetitle">

        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="SERMAT_MATERIELS.php">Parc Matériel</a></li>
                <li class="breadcrumb-item"><?php echo $CAT  ?></li>
                <li class="breadcrumb-item"><?php echo $TYPE ?></li>
                <li class="breadcrumb-item active">Liste Machines</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <div class="row">

        <div class="col-md-3" style="height:300px">

            <!DOCTYPE html>
            <html>

            <head>
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
            </head>



            </html>

            <?php
         


                echo '<div class="card ">';
                echo '<div class="card-body">';


                echo '<div class="row">';

                echo '<div class="col-xs-12">';
                echo '<h4 class="card-title" style="text-align:LEFT" >Groupe:' . "  " . $row['CODE'] . " - " . $row['TYPE'] . '</h4>';
                echo "</div>";



                echo "</div>";



                echo '<div class="form-group row">';

                echo '<div class="col-xs-12 " style="font-weight: bolder ; font-family:Microsoft Tai Le ">';
                echo '<dl>';



                echo '<dt class="card-text"  > Nombre  Engins:' . '</dt>';

                if($nbengins==''){
                    echo '<dd class="card-text" >' . " " . number_format(0, 0, ',', '.') . '</dd>';
                }else{
                    echo '<dd class="card-text" >' . " " . number_format($nbengins, 0, ',', '.') . '</dd>';
                }
               








                echo '</dl>';





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

                    <div class="row">
                        <div class="col-md-10">
                            <h4 style=' font-weight: 700'>Liste de Matériels</h4>
                        </div>
                        <div class="col-md-2">
                            <button type="button" data-toggle="modal" data-target="#myModal" class="btn btn-outline-success">Nouvelle Machine</button>
                        </div>

                    </div>
                    <table id="dtBasicExamplemachine" class="table table-bordered table-sm" cellspacing="0" width="100%">
                        <thead style="background-color:cornflowerblue ;color:white">
                            <tr>

                                <th>
                                    Code
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
                                    total heures
                                </th>
                                <th>
                                    Cout Maintenance
                                </th>

                                <th>
                                    total Panne
                                </th>
                                <th>
                                    Taux de fonctionnement
                                </th>


                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody id="myTablearticles">
                            <?php
                            $dsn =  'mysql:dbname=vrd;host=localhost';
                            $user = 'root';
                            $password = '';
                            $cn2 = new PDO($dsn, $user, $password);
                            $resultENGINS = $cn2->query("select *from sermat_engin  where ID_T='$idT' ");
                            while ($row = $resultENGINS->fetch()) {

                                $idM = $row['ID_M'];
                                echo '<tr style="height: 10px; overflow:auto; font-size:small ; color:black ; ">';

                                echo "<td>" . $row['CODE'] . "</td>";
                             
                                $image = $row['IMAGE'];
                                $ENC = "en cours";


                                echo "<td>" . $row['MATERIEL'] . "</td>";
                                echo "<td>" . $row['MARQUE'] . "</td>";
                                echo "<td>" . $row['MODEL'] . "</td>";
                                echo "<td>" .   $ENC . "</td>";
                                echo "<td>" .   $ENC . "</td>";
                                echo "<td>" .   $ENC . "</td>";
                                echo "<td>" .   $ENC . "</td>";




                                echo "<td> 
             
                <a class='btn btn-outline-info btn-sm' href='SERMAT_MATERIELSDETAILS.php?idT=" . $idT . "&&idC=" . $idC . "&&idM=" . $idM . "' role='button'>Détails </a> 
                </td>";

                                '</tr>';
                            }
                            ?>
                        </tbody>
                    </table>
                </div>




            </div>






        </div>
    </div>






























    <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog modal-lg">


            <div class="modal-content">
                <div class="modal-header" style=" font-weight: 700 ;background-color:cornflowerblue;color:white ;">

                    <h4 class="modal-title" style=" font-weight: 700  ;">Nouvelle Machine</h4>
                </div>
                <div class="modal-body">



                    <div class="card-body">
                        <br />


                        <form action="SERMAT_MATERIELS-NVMACHINE.php" method="POST" class="row g-3" enctype="multipart/form-data">


                            <div class="form-group row ">
                                <?php
                  

                                    $result1 = mysqli_query($cn, "select *from sermat_type_engin where ID_TE='$idT'");
                                
                                while ($row = mysqli_fetch_array($result1)) {
                                    $IDC = $row['ID_C'];
                                    $CC = $row['CODE'];



                                    $NONBUDGET = $row['TYPE'];
                                }


                                echo '<input class="hidden" name="IDC" type="text" value="' . $IDC . '">';
                                echo '<input class="hidden" name="IDT" type="text" value="' . $idT . '">';
                                echo ' <h5 class="modal-title" style=" font-weight: 700" > Groupe :' . $NONBUDGET . '</h5>';

                                ?>
                                <br />
                                <br />
                                <div class="col-xs-3">

                                    <input class="form-control" placeholder="CODE" name="CODE" type="text" style="background-color:azure ;" value="<?php echo $CC ?>-00">
                                </div>
                                <div class="col-xs-4">

                                    <input class="form-control" placeholder="Machine" name="MACHINE" type="text" style="background-color:azure ;">
                                </div>
                                <div class="col-xs-2">

                                    <input class="form-control" placeholder="Marque" name="MARQUE" type="text" style="background-color:azure ;">
                                </div>
                                <div class="col-xs-3">
                                    <input class="form-control" placeholder="SERIE" name="SERIE" type="text" style="background-color:azure ;">
                                </div>
                            </div>

                            <div class="form-group row ">
                                <div class="col-xs-3 ">

                                    <input class="form-control" placeholder="model" name="MODEL" type="text" style="background-color:azure ;">

                                </div>

                                <div class="col-xs-3">

                                    <input class="form-control" placeholder="Cout unitaire" name="PU" type="number" style="background-color:azure ;">
                                </div>
                                <div class="col-xs-2">

                                    <input class="form-control" placeholder="Unité" name="U" type="text" style="background-color:azure ;">
                                </div>
                                <div class="col-xs-4">

                                    <input class="form-control" placeholder="Type location" name="TLOC" type="text" style="background-color:azure ;">
                                </div>
                            </div>
                            <div class="form-group row ">


                                <div class="col-xs-3 ">

                                    <input class="form-control" placeholder="Devise" name="DEVISE" type="text" style="background-color:azure ;">
                                </div>
                                <div class="col-xs-3 ">

                                    <input class="form-control" placeholder="Consommation/j" name="CONSOMMATION" type="text" style="background-color:azure ;">
                                </div>

                                <div class="col-xs-6">

                                    <input class="form-control" placeholder="Compteur" name="COMPTEUR" type="number" style="background-color:azure ;">
                                </div>
                            </div>


                            <div class="form-group row ">

                                <div class="col-xs-3">

                                    <input class="form-control" placeholder="Date d'arrivée" name="DATE" type="date" style="background-color:azure ;">
                                </div>
                                <div class="col-xs-3 ">

                                    <input class="form-control-file" placeholder="Image" name="image" type="file" style="background-color:azure ;">
                                </div>
                            </div>






                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" name="NVARTICLE">Enregistré</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
                    </div>




                    </form>

                </div>









            </div>
        </div>

    </div>

    </div>



    <!-- RECHERCHE TABLE STOCK-->
    <SCript>
        $(document).ready(function() {
            $('#dtBasicExamplemachine').DataTable();
            $('.dataTables_length').addClass('bs-select');
        });
    </SCript>


    <script src="assets1/plugins/data-tables/jquery.datatables.min.js"></script>
    <script src="assets1/plugins/data-tables/datatables.bootstrap4.min.js"></script>
    <link href="assets1/plugins/data-tables/datatables.bootstrap4.min.css" rel="stylesheet">


</main>