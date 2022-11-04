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
$result = mysqli_query($cn, "select *from categorie");




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
        <h1>Parc Matériel</h1>
        <div class="row">

<div class="col-md-10">


 <nav>
            <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="SERMAT_MATERIELS.php">Parc Matériel</a></li>

                <li class="breadcrumb-item">Catégories</li>
       
                
              
            </ol>
        </nav>
</div>
<div class="col-md-2" style="text-align:right">
    <button type="button" data-toggle="modal" data-target="#myModal" class="btn btn.outline" style="font-weight: 900 ;color:Green ">Nouveau  </button>
</div>
</div>
       
    </div><!-- End Page Title -->







    <div class="row ">

        <style>
            dt {
                float: left;
                clear: left;
                width: 150px;
                font-weight: normal;
                color: black;

            }

            dd {
                margin: 0 0 0 20px;
                padding: 0 0 0.5em 0;
                font-weight: bold;
                color: darkblue;
            }
        </style>

        <?php

        while ($row = mysqli_fetch_array($result)) {

            $idC = $row['ID_C'];
            $categorie = $row['CATEGORIE'];

            $resultngroupe = mysqli_query($cn, "SELECT COUNT(ID_TE) from sermat_type_engin where ID_C='$idC' ");
            while ($row = mysqli_fetch_array($resultngroupe)) {

                $NBGROUPE = $row['COUNT(ID_TE)'];

                $resultnbengins = mysqli_query($cn, "SELECT COUNT(ID_M) from sermat_engin where ID_C='$idC'");
                while ($row = mysqli_fetch_array($resultnbengins)) {

                    $nbengin = $row['COUNT(ID_M)'];
                    echo  '<div class="col-md-3" >';
                    echo '<div class="card" style="background-color:AZUSE">';

                    echo '<div class="card-body">';




                    echo ' <a class="nav-link collapsed"   data-bs-target="#icons-' . $idC . '"   data-bs-toggle="collapse">
                 <div class="row " style="font-weight: bolder ; font-family:Microsoft Tai Le ">
                 
                <div class="col-lg-12" >
                <h5  class="card-title" style="text-align:center" >' . $idC . '.' .  $categorie . ' ' . '<i class="bi bi-chevron-down ms-auto"></i></h5> </a>';
                    echo "</div>";

                    echo "</div>";
                }
            }

            echo '<ul id="icons-' . $idC . '" class="nav-content collapse " data-bs-parent="#sidebar-nav">';


        ?>



            <div class="row">

                <div class="col-md-9">
                    <h5 style="font-weight: 800"> Liste des Groupes :<?php echo " $NBGROUPE " ?> </h5>
                </div>
                <div class="col-md-2">
                    <a href="SERMAT_MATERIELS-GROUP.php?id=<?php echo $idC  ?>" class="btn btn-outline-success btn-sm"> <span class="glyphicon glyphicon-plus"></span> </a>

                </div>
            </div>

            <?php

            $resultTYPEENGIN = mysqli_query($cn, "SELECT *from sermat_type_engin WHERE ID_C=' $idC' ");
            while ($row = mysqli_fetch_array($resultTYPEENGIN)) {
                $idT = $row['ID_TE'];
                $type = $row['TYPE'];

                $nbenginsPARTYPE = mysqli_query($cn, "SELECT COUNT(ID_M) from sermat_engin where ID_C='$idC' and  ID_T='$idT'");
                while ($row = mysqli_fetch_array($nbenginsPARTYPE)) {
                    $nbenginT = $row['COUNT(ID_M)'];

                    echo '<div class="container" style="font-weight: bold ; font-family:Microsoft Tai Le ">';
                    echo '<li> 
                 
                                        <dt class="card-text" style="width: 200px;"   ><a href="SERMAT_MATERIELS_LISTE.php?idT=' . $idT . '&&idC=' . $idC . '"><i class="bi bi-folder" ></i>' . " " . $type .  '</a>  </dt>
                                        
                                        <dd class="card-text"    >' . " " . number_format($nbenginT, 0, ',', '.') . '</dd>
                                         
                                        </li>';
                    echo "</div>";
                }
            }


            echo '</ul>';

            echo '<div  class="position-absolute bottom-0 start-0" role="group" aria-label="Basic outlined example" style="width:">';
            echo " <a class='btn btn-outline-danger' ' role='button'> <span class='glyphicon glyphicon-trash'></span>  </a> ";
            echo '<button type="button" class="btn btn-outline-primary" ><span class="glyphicon glyphicon-pencil"></span></button>';


            echo "</div>";
            echo '<div  class="position-absolute bottom-0 end-0" role="group" style="padding:15PX 5PX  5PX 5PX" aria-label="Basic outlined example" style="width:">';
            ?>


            <span class="badge bg-primary " style="font-weight: bold"><?php echo " $nbengin " ?></span>


        <?php

            echo "</div>";


            echo "</div>";
            echo "</div>";
            echo "</div>";
        }

        ?>







    </div>




    <!-- MODAL caterogie-->
    <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog modal-lg">


            <div class="modal-content">
                <div class="modal-header" style="background-color:dodgerblue ;color:white ; font-weight: 900">

                    <h4 class="modal-title"  style=" font-weight: 900">Nouvelle Catégorie</h4>
                </div>
                <div class="modal-body">
                    <div class="card">


                        <div class="card-body">
                            <br />


                            <form action="SERMAT_NVCATEGORIE.php" method="POST" class="row g-3">

                                <div class=" row ">

                                    <div class="col-md-7">
                                        <label for="CATEGORIE" class="col-form-label">Désignation</label>
                                        <input class="form-control" name="CATEGORIE" type="text" value="">
                                    </div>



                                    <div class="col-md-3">
                                        <label for="CODE" class="col-form-label">Code</label>
                                        <input class="form-control" name="CODE" type="text">

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


    <script src="assets1/plugins/data-tables/jquery.datatables.min.js"></script>
    <script src="assets1/plugins/data-tables/datatables.bootstrap4.min.js"></script>
    <link href="assets1/plugins/data-tables/datatables.bootstrap4.min.css" rel="stylesheet">
</main>