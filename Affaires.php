
<?php
session_start();
include'index.php';
?>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

<?php

$cn= mysqli_connect("localhost", "root", "", "vrd");
 $result=mysqli_query($cn,"select *from affaires")

?>
<main id="main" class="main">
<?php
    if(isset($_SESSION['status']))
    {
        ?>
        <div class="alert alert-warning alert-dismissible " role="alert">
  <strong>Alert!</strong> <?php echo $_SESSION['status'] ; ?>
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
    

      <?php
       
        unset ($_SESSION['status']);
    }

    ?>
     <div class=" row justify-content-lg-LEFT">
        <div class="col-1">
   
   <button type="button" data-toggle="modal" data-target="#myModal" class="btn btn.outline" style="font-weight: 900 ;color:Green">+</i> </button>
  </div>
    <div class="col-5">
    <h4 style="font-weight: bold ">Liste des Affaires</h4>
    </div>

    <br />
    
    </div>
    <br />
    <div class="row ">
        
       

             
          <?php 
            while($row=mysqli_fetch_array($result)){
                $id=$row['ID_AFF'];
                echo  '<div class="col-lg-3">';
             echo '<div class="card">';
              echo'<div class="card-body">';
              echo'<h4 class="card-title" style="text-align:center" >'.$row['ID_AFF'].'.'.$row['AFFAIRE'].'</h4>';
              echo'<h6 class="card-text"" >Client :'.$row['CLIENT'].'</h6>';
              echo'<h6 class="card-text"" >Adresse :'.$row['ADRESSE'].'</h6>';
             
          

              echo'<div class="btn-group" role="group" aria-label="Basic outlined example">';
              echo" <a class='btn btn-outline-danger' href='Affairedelete.php?id=".$id."' role='button'> Supprimer </a> " ;
              echo'<button type="button" class="btn btn-outline-primary" >Modifier</button>';
              echo" <a class='btn btn-outline-info' href='Affaires_details.php?id=".$id."' role='button'> Détails </a> " ;
     
              echo"</div>";
            
              echo"</div>";
              echo"</div>";
              echo"</div>";

             }
        
           ?>
          
            
       


    

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


                            <form  action="AffairesNV.php" method="POST" class="row g-3">

                                <div class="form-group row ">
                                    <div class="col-xs-7">
                                        <label for="AFFAIRE" class="col-form-label">Désignation</label>
                                        <input class="form-control" name="AFFAIRE" type="text">
                                    </div>
                                    <div class="col-xs-5 ">
                                        <label for="CLIENT" class="col-form-label">Client</label>
                                        <input class="form-control" name="CLIENT"  type="text">
                                    </div>
                              </div>
                                <div class="form-group row ">
                                    <div class="col-xs-6">
                                        <label for="ADRESSE" class="col-form-label">Adresse</label>
                                        <input class="form-control" name="ADRESSE"  type="text">
                                    </div>
                                    <div class="col-xs-2 ">
                                        <label for="DELAI" class="col-form-label">Délai</label>
                                        <input class="form-control" name="DELAI" id="DELAI" type="number">
                                    </div>
                                    <div class="col-xs-3 ">
                                        <label for="DEMARRAGE" class="col-form-label">Démarrage</label>
                                        <input class="form-control" name="DEMARRAGE"  type="DATE">
                                    </div>
                                </div>


                                
                                <div class="form-group row ">
                                    
                                    <div class="col-xs-4 ">
                                        <label for="MONTANT" class="col-form-label">Montant</label>
                                        <input class="form-control" name="MONTANT" type="number">
                                    </div>

                                    <div class="col-xs-3">
                                        <label for="DEVISE" class="col-form-label">Devise:</label>
                                        <select class="form-select form-select-lg" name="DEVISE" type="text">
                                            <option selected>MAD</option>
                                            <option>CFA  </option>
                                            <option> USD $ </option>
                                            <option> EUR € </option>
                                            <option> Autre </option>

                                        </select>
                                    </div>
                                    <div class="col-xs-5">
                                    <label for="PAR" class="col-form-label">Créer par</label>
                                        <input class="form-control" name="PAR"  type="text">
                                        </div>
                                </div>

                                    <div class="modal-footer" >
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
        $(document).ready(function () {
            $("#myInputPOSTE").on("keyup", function () {
                var value = $(this).val().toLowerCase();
                $("#myTableAFF tr").filter(function () {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });
        });
    </script>
    <script>
        jQuery(document).ready(function () {
            jQuery('#AFFAIRE').DataTable({
                "aLengthMenu": [[10, 30, 50, 75, -1], [10, 30, 50, 75, "All"]],
                "pageLength": 10,
                "dom": '<"row justify-content-between top-information"lf>rt<"row justify-content-between bottom-information"ip><"clear">'
            });
        });
    </script>
    <script src="/assets1/plugins/data-tables/jquery.datatables.min.js"></script>
    <script src="/assets1/plugins/data-tables/datatables.bootstrap4.min.js"></script>
    <link href="/assets1/plugins/data-tables/datatables.bootstrap4.min.css" rel="stylesheet">
</main>








