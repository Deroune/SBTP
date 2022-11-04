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
if (isset($_GET['id'])) {
    $id = $_GET['id'];
}
$result = mysqli_query($cn, "select *from sermat_type_engin WHERE ID_C='$id'");




?>
<main id="main" class="main">

    <div class="col-7">

      


        <div class="card">
            <div class="card-body">
  <h5 class="card-title">Liste des Groupes</h5>
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
                                        Type
                                    </th>
                                    <th>
                                        Code
                                    </th>

                                    <th>

                                    </th>
                                </tr>
                            </thead>

                            <tbody style="font-size:small ;">

                                <?php

                                while ($row = mysqli_fetch_array($result)) {

                                    echo '<tr >';
                                    echo '<td>'

                                        . $row['ID_TE'] . '

                                                                       </td> ';
                                    echo '<td style="text-align:left ;font-weight: 800 ">'

                                        . $row['TYPE'] . '

                                                                      </td> ';
                                    echo '<td>'

                                        . $row['CODE'] . '

                                                                      </td> ';

                                    echo '<td>

                                                                   <a  href="SERMAT_MAGASIN-BCDELETE.php?id=' . $id . '  "
           
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

            <!-- AJOUTER groupe-->


            <script>
                $(document).ready(function() {
                    var i = 1;
                    $('#add3').click(function() {
                        i++;
                        $('#dynamic_fieldFR').append('<tr id="row' + i + '"> <td><button type="button" name="remove" id="' + i + '" class="btn btn-danger btn_remove btn-sm"><span class="glyphicon glyphicon-remove">   <td><input type="text" name="GROUPE[]" placeholder="GROUPE" class="form-control GROUPE_list" /><td><input type="text" name="CODE[]" placeholder="CODE" class="form-control CODE_list"  /></td><td class="hidden"><input IDC="text" name="IDC[]" placeholder="IDC" class="form-control IDC_list"  value=" <?php echo  $id ?>"/> <td> </tr>');


                    });
                    $(document).on('click', '.btn_remove', function() {
                        var button_id = $(this).attr("id");
                        $('#row' + button_id + '').remove();
                    });
                    $('#submit3').click(function() {
                        $.ajax({
                            url: "SERMAT_NVGROUP.php",
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
            <script src="assets1/plugins/data-tables/jquery.datatables.min.js"></script>
            <script src="assets1/plugins/data-tables/datatables.bootstrap4.min.js"></script>
            <link href="assets1/plugins/data-tables/datatables.bootstrap4.min.css" rel="stylesheet">
</main>