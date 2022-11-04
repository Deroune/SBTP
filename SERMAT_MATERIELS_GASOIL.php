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
    $resultLISTEMATERIEL = mysqli_query($cn, "select *from sermat_engin ");



    $resultLISTETYPE = mysqli_query($cn, "select *from sermat_type_engin ");
    $resultLISTECAT = mysqli_query($cn, "select *from Categorie ");
}




?>
<main id="main" class="main">

    <div class="pagetitle">

        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="SERMAT_MATERIELS.php">Parc Matériel</a></li>

                <li class="breadcrumb-item active">Suivi Gasoil</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <div class="row">

        



        <div class="col-md-10">
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


                        </div>
                    </div>

                </div>
            </div>
            <div class="card">

                <div class="card-body">

                    <div class="row">
                        <div class="col-md-10">
                            <h4 style=' font-weight: 700'>Liste de Matériels</h4>
                        </div>
                    
                        <div class="col-md-2">
                        <br/>
                            <button type="button" data-toggle="modal" data-target="#myModal" class="btn btn-outline-success">Liste Machine</button>
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
                                   Gasoil
                                </th>

                                <th>
                                    Huile H
                                </th>
                                <th>
                                    Huile M
                                </th>
                                <th>
                                   Compteur
                                </th>
                                <th>
                                    Etas
                                </th>
                                <th>
                                    Etas
                                </th>



                            </tr>
                        </thead>

                        <tbody id="myTablearticles">
                            <?php
                           


                           $resultENGINS= mysqli_query($cn, " SELECT sermat_engin.MATERIEL ,sermat_engin.CODE ,sermat_engin.MARQUE,
                           sermat_materiels_suivi.GASOIL,sermat_materiels_suivi.HUILE_H,sermat_materiels_suivi.ETAS,
                           sermat_materiels_suivi.HUILE_M,sermat_materiels_suivi.DATE,sermat_materiels_suivi.COMPTEUR FROM sermat_materiels_suivi 
                           INNER JOIN sermat_engin ON sermat_materiels_suivi.ID_M=sermat_engin.ID_M  GROUP BY  sermat_materiels_suivi.DATE ");
                           while ($row = mysqli_fetch_array( $resultENGINS)) {



                            
                                echo '<tr style="height: 10px; overflow:auto; font-size:small ; color:black ; ">';

                                echo "<td>" . $row['CODE'] . "</td>";
                                $GASOIL= $row['GASOIL'] ;
                                $HM= $row['HUILE_M'] ;
                                $HY= $row['HUILE_H'] ;
                                $COMPTEUR= $row['COMPTEUR'] ;
                                $ETAS= $row['ETAS'] ;
                                $DT= $row['DATE'] ;
                              
                                $ENC = "en cours";

                        
                                echo "<td>" . $row['MATERIEL'] . "</td>";
                                echo "<td>" . $row['MARQUE'] . "</td>";
                          
                                 echo '<td  style="width: 80px;" ><input type="number" name="CODE[]"  class="form-control CODE_list" style="width: 80px;"  value="'.$GASOIL.'" /></td>';
                                 echo '<td style="width: 80px;" ><input type="number" name="CODE[]"  class="form-control CODE_list"style="width: 80px;" value="'.$HM.'"  /></td>';
                                 echo '<td style="width: 80px;" ><input type="number" name="CODE[]"  class="form-control CODE_list"style="width: 80px;"  value="'.$HY.'" /></td>';
                                 echo '<td style="width: 100px;" ><input type="number" name="CODE[]"  class="form-control CODE_list" style="width: 100px;" value="'.$COMPTEUR.'" /></td>';
                                 echo '<td style="width: 100px;" ><input type="date" name="CODE[]"  class="form-control CODE_list" style="width: 120px;" value="'.$DT.'" /></td>';
                                
                                 echo '<td><select name="BC" id="BC" class="form-control"   >
                                 <option  >'.$ETAS.'</option>
                                 <option  >Panne</option>
                                 <option >Immobilisée</option>
                                 <option >Imtempérie</option>
                                 
                                 
                                 </select></td>';
                                 echo '<td> <button type="submit" name="submit" id="submit" class="btn btn-outline-success "><span class="glyphicon glyphicon-pencil" style="text-align:left ;font-weight: 750 "> </span> </button> </td>
                                 ';
                              
                           






                                '</tr>';
                            }
                            ?>





                        </tbody>
                    </table>
                </div>




            </div>






        </div>
    </div>





















 <!-- AJOUTER FOURNISSEUR-->

 <?php

$country1 = '';

$query1 = "SELECT  DISTINCT REF  FROM `references`WHERE TYPE='FOURNISSEUR_SERMAT'  ORDER BY REF  ";

$result1 = mysqli_query($cn, $query1);
while ($row = mysqli_fetch_array($result1)) {
    $country1 .= '<input value="' . $row["REF"] . '">';
}

?>
<script>
    $(document).ready(function() {
        var i = 1;
        $('#add3').click(function() {
            i++;
            $('#dynamic_fieldFR').append('<tr id="row' + i + '"> <td><button type="button" name="remove" id="' + i + '" class="btn btn-danger btn_remove btn-sm"><span class="glyphicon glyphicon-remove">   <td><input type="text" name="CODE[]" placeholder="Code" class="form-control code_list"  value="<?php echo $country1 ?>"/><td><input type="text" name="FOURNISSEUR[]" placeholder="Fournisseur" class="form-control FOURNISSEUR_list" /></td><td><select type="text" name="TYPE[]" placeholder="Référence" class="form-control TYPE_list"> <option value="">Référence</option> </select></td><td><input type="text" name="ADRESSE[]" placeholder="Adressse" class="form-control ADRESSE_list" /> <td><input type="text" name="CONTACT[]" placeholder="Contact" class="form-control CONTACT_list" /> </td></td></td> <td><input type="text" name="REF[]" placeholder="REF" class="hidden" value="SERMAT"  /> </td></td> </tr>');


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