<?php
session_start();
include 'index.php';
?>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

<?php

$cn = mysqli_connect("localhost", "root", "", "vrd");
$result = mysqli_query($cn, "select *from magasins");

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

    ?>

    <div class="pagetitle">
        <h3>Magasins de Service Matériel</h3>
        <nav>
            <ol class="breadcrumb">
                <div class="col-10">
                    <li class="breadcrumb-item"><a href="SERMAT_MAGASIN.php">Magasins de Service Matériel</a></li>
                </div>
                <div class="col-2">

                    <button type="button" data-toggle="modal" data-target="#myModal" class="btn btn.outline" style="font-weight: 900 ;color:Green">Nouveau</i> </button>
                </div>



            </ol>
        </nav>
    </div><!-- End Page Title -->


    <tbody style="font-size:small ;">




        <?php
        while ($row = mysqli_fetch_array($result)) {
            $id = $row['ID_MAG'];
            $DEVISE = $row['DEVISE'];
            echo  '<div class="col-lg-3">';
            echo '<div class="card" style="background-color:	#ADD8E6">';
            
            echo '<div class="card-body">';
            echo '<h4 class="card-title" style="text-align:center" >' . $id . '.' . $row['MAGASIN'] . '</h4>';


            echo '<h6 class="card-text"" >Adresse :' . $row['ADRESSE'] . '</h6>';
            echo '<h6 class="card-text"" >Responsable :' . $row['RESPONSABLE'] . '</h6>';



            $resultPROSUM = mysqli_query($cn, "SELECT SUM(sermat_stock.QTE*bc_articles.PU),SUM(sermat_stock.QTE_CONS*bc_articles.PU) FROM `sermat_stock`  INNER JOIN bc_articles ON
            bc_articles.CODE_PRODUIT= sermat_stock.CODE_PRODUIT WHERE sermat_stock.ID_MAG ='$id'
            ");
            while ($row = mysqli_fetch_array($resultPROSUM)) {
                $MCONS = $row['SUM(sermat_stock.QTE_CONS*bc_articles.PU)'];

                $MLIV = $row['SUM(sermat_stock.QTE*bc_articles.PU)'];
                $MSTOCK =     $MLIV - $MCONS;

                echo '<h6 class="card-title" style="text-align:center" >Montant du Stock :' . " " . number_format($MSTOCK, 2, ',', '.') . " " . $DEVISE . '</h6>';

                echo '<div  class="position-absolute bottom-0 end-0" role="group" aria-label="Basic outlined example" style="width:">';
                echo " <a class='btn btn-outline-danger' ' role='button'> <span class='glyphicon glyphicon-trash'></span>  </a> ";
                echo '<button type="button" class="btn btn-outline-primary" ><span class="glyphicon glyphicon-pencil"></span></button>';
                echo " <a class='btn btn-outline-info' href='SERMAT_MAGASIN-SUIVI.php?id=" . $id . "' role='button'> <span class='glyphicon glyphicon-tasks'></span> </a> ";

                echo "</div>";

                echo "</div>";
                echo "</div>";
                echo "</div>";
            }
        }
        ?>

        </td>
        </tr>
    </tbody>
    </table>


    <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog modal-lg">


            <div class="modal-content">
                <div class="modal-header">

                    <h4 class="modal-title">Nouveau Affaires</h4>
                </div>
                <div class="modal-body">
                    <div class="card">


                        <div class="card-body">
                            <br />


                            <form action="SERMAT_MAGASINNV.php" method="POST" class="row g-3">

                                <div class="form-group row ">
                                    <div class="col-xs-6">
                                        <label for="MAGASIN" class="col-form-label">Désignation</label>
                                        <input class="form-control" name="MAGASIN" type="text">
                                    </div>
                                    <div class="col-xs-6 ">
                                        <label for="ADRESSE" class="col-form-label">Adresse</label>
                                        <input class="form-control" name="ADRESSE" type="text">
                                    </div>
                                </div>
                                <div class="form-group row ">
                                    <div class="col-xs-6">
                                        <label for="RESPONSABLE" class="col-form-label">Responsable</label>
                                        <input class="form-control" name="RESPONSABLE" type="text">
                                    </div>

                                    <div class="col-xs-3 ">
                                        <label for="TYPEB" class="col-form-label">Imutation</label>
                                        <select class="form-select form-select-lg" name="TYPE" type="text">
                                            <option selected>SERMAT</option>
                                            <option>CHANTIER</option>
                                            <option>MARTIME</option>
                                            <option>BASE DE VIE</option>



                                        </select>
                                    </div>


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









    <script>
        $(document).ready(function() {
            $("#myInputPOSTE").on("keyup", function() {
                var value = $(this).val().toLowerCase();
                $("#myTableAFF tr").filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });
        });
    </script>
    <script>
        jQuery(document).ready(function() {
            jQuery('#AFFAIRE').DataTable({
                "aLengthMenu": [
                    [10, 30, 50, 75, -1],
                    [10, 30, 50, 75, "All"]
                ],
                "pageLength": 10,
                "dom": '<"row justify-content-between top-information"lf>rt<"row justify-content-between bottom-information"ip><"clear">'
            });
        });
    </script>

    <!-- RECHERCHE TABLE FOURNISSEUR-->
    <SCript>
        $(document).ready(function() {
            $('#dtBasicExampleMAG').DataTable();
            $('.dataTables_length').addClass('bs-select');
        });
    </SCript>
    <script src="assets1/plugins/data-tables/jquery.datatables.min.js"></script>
    <script src="assets1/plugins/data-tables/datatables.bootstrap4.min.js"></script>
    <link href="assets1/plugins/data-tables/datatables.bootstrap4.min.css" rel="stylesheet">
</main>