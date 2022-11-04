<?php
include 'index.php';
?>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.0/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

<?php

$cn = mysqli_connect("localhost", "root", "", "vrd");
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $result1 = mysqli_query($cn, "SELECT *from affaires where ID_AFF='$id'");
    $result2 = mysqli_query($cn, "SELECT *from budgets where ID_AFF='$id'");
    $resultnbbudget = mysqli_query($cn, "SELECT COUNT(ID_B) from budgets where ID_AFF='$id'");
    $resultnbArticle = mysqli_query($cn, "SELECT COUNT(ID_AFF) from articles where ID_AFF='$id'");


    $resultSUMMOD = mysqli_query($cn, "SELECT SUM(QTE_D*PU) FROM `depenses` WHERE ID_AFF='$id' AND TYPE='MainOeuvre'AND REF='Budget' ");
    $resultSUMMATERIEL = mysqli_query($cn, "SELECT SUM(QTE_D*PU) FROM `depenses` WHERE ID_AFF='$id' AND TYPE='Materiel'AND REF='Budget' ");
    $resultSUMFOURNITURE = mysqli_query($cn, "SELECT SUM(QTE_D*PU) FROM `depenses` WHERE ID_AFF='$id' AND TYPE='Fourniture'AND REF='Budget' ");
    $resultSUMST = mysqli_query($cn, "SELECT SUM(QTE_D*PU) FROM `depenses` WHERE ID_AFF='$id' AND TYPE='Fourniture'AND REF='ST' ");
    $resultSUM = mysqli_query($cn, "SELECT SUM(QTE_D*PU) FROM `depenses` WHERE ID_AFF='$id' AND REF='Budget' ");
}

while ($row = mysqli_fetch_array($resultSUMMOD)) {

    $totalMOD1 = $row['SUM(QTE_D*PU)'];
}
while ($row = mysqli_fetch_array($resultSUMMATERIEL)) {

    $totalMAT = $row['SUM(QTE_D*PU)'];
}
while ($row = mysqli_fetch_array($resultSUMFOURNITURE)) {

    $totalFR = $row['SUM(QTE_D*PU)'];
}
while ($row = mysqli_fetch_array($resultSUMST)) {

    $totalst = $row['SUM(QTE_D*PU)'];
}

while ($row = mysqli_fetch_array($resultSUM)) {
    $total = $row['SUM(QTE_D*PU)'];
}

?>
<main id="main" class="main">



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
            while ($row = mysqli_fetch_array($result1)) {
                $montant = $row['MONTANT'];
                echo '<div class="card ">';
                echo '<div class="card-body">';


                echo '<div class="row">';

                echo '<div class="col-xs-12">';
                echo '<h4 class="card-title" style="text-align:LEFT" >' . $row['ID_AFF'] . "  " . $row['AFFAIRE'] . '</h4>';
                echo "</div>";



                echo "</div>";



                echo '<div class="form-group row">';
                $devise = 200;
                echo '<div class="col-xs-12 " style="font-weight: bolder ; font-family:Microsoft Tai Le ">';
                echo '<dl>';
                echo '<dt class="card-text"  >Montant :' . '</dt>';
                echo '<dd class="card-text"  > ' . " " . number_format($row['MONTANT'], 2, ',', '.') . " " . $row['DEVISE'] . '</dd>';

                echo '<dt class="card-text"  >Client :' . '</dt>';
                echo '<dd class="card-text" >' . " " . $row['CLIENT'] . '</dd>';

                echo '<dt class="card-text"  >Délai  :' . ' </dt>';
                echo '<dd class="card-text"  >' . " " . $row['DELAI'] . 'Mois</dd>';

                echo '<dt class="card-text"  >Démarrage  :' . '</dt>';
                echo '<dd class="card-text"  >' . " " . $row['DEMARRAGE'] . '</dd>';

                echo '<dt class="card-text"  >Adresse :' . '</dt>';
                echo '<dd class="card-text"  >' . " " . $row['ADRESSE'] . '</dd>';

                echo '<dt class="card-text"  >Créer par :' . '</dt>';
                echo '<dd class="card-text" >' . " " . $row['PAR'] . '</dd>';


                    echo '<dt class="card-text"  > Coût  Total :' . '</dt>';
                    echo '<dd class="card-text" >' . " " . number_format($total, 2, ',', '.') . '</dd>';
          



                echo '<button type="button" data-toggle="modal" data-target="#myModal" class="btn btn-outline-primary">Ajouter un Budget</button>';



                echo '</dl>';





            ?>
                <div class="row">
                    <!-- Pie Chart -->
                    <h5 class="card-title">Cout par type </h5>

                    <div id="pieChart"></div>
                    <script>
                        document.addEventListener("DOMContentLoaded", () => {
                            new ApexCharts(document.querySelector("#pieChart"), {
                                series: [<?php echo $totalMOD1 ?>, <?php echo  $totalMAT ?>, <?php echo  $totalFR ?>, <?php echo $totalst ?>],
                                chart: {
                                    height: 350,
                                    type: 'pie',
                                    toolbar: {
                                        show: true
                                    }
                                },
                                labels: ['MOD', 'Matériel', 'Matériaux', 'S. Traitant']
                            }).render();
                        });
                    </script>


                </div>
        


            <?php
                echo "</div>";
                echo "</div>";
                echo "</div>";
                echo "</div>";
            }




            ?>

        </div>





        <div class="col-md-9">
            <div class="row">

                <div class="col-md-3">

                    <?php

                    if ($total == 0) {
                        $pourcentagemat = 0;
                    } else {
                        $pourcentagemat = ($totalMOD1 / $total) * 100;
                    }

                    echo '<div class="card ">';

                    echo '<div class="card-body">';
                    echo '<div class="row">';

                    echo '<div class="col-2 ">';
                    echo ' <img src="Image/mod.png" alt="Italian Trulli" style="width:55px;height:55px;">';
                    echo '</div>';
                    echo '<div class="col-10">';
                    echo "<h4 class='card-title' style='text-align:LEFT' >Coût de la main-d'œuvre" . "</h4>";
                    echo '</div>';

                    echo '</div>';
                    echo '<div class="row">';

                    echo '<div class="col-8 ">';
                    echo "<h4 style='color: blue; font-weight: 700'>" . number_format($totalMOD1, 2, ',', '.') . "</H4>";
                    echo '</div>';

                    echo '<div class="col-4 ">';
                    echo "<h4 style='color: orange; font-weight: bold '>" . number_format($pourcentagemat, 2, ',', '.') . '%' . "</H4>";
                    echo '</div>';

                    echo '</div>';

                    echo "</div>";
                    echo "</div>";


                    ?>


                </div>

                <div class="col-md-3">

                    <?php



                    if ($total == 0) {
                        $pourcentagemat = 0;
                    } else {
                        $pourcentagemat = ($totalMAT / $total) * 100;
                    }

                    echo '<div class="card ">';

                    echo '<div class="card-body">';
                    echo '<div class="row">';

                    echo '<div class="col-3 ">';
                    echo ' <img src="Image/MAT.png" alt="Italian Trulli" style="width:55px;height:55px;">';
                    echo '</div>';
                    echo '<div class="col-9">';
                    echo '<h4 class="card-title" style="text-align:LEFT" > Coût de matériel' . '</h4>';
                    echo '</div>';

                    echo '</div>';


                    echo '<div class="row">';

                    echo '<div class="col-8 ">';
                    echo "<h4 style='color: blue; font-weight: 700'>" . number_format($totalMAT, 2, ',', '.') . "</H4>";
                    echo '</div>';

                    echo '<div class="col-4 ">';
                    echo "<h4 style='color: orange; font-weight: bold '>" . number_format($pourcentagemat, 2, ',', '.') . '%' . "</H4>";
                    echo '</div>';

                    echo '</div>';

                    echo "</div>";
                    echo "</div>";




                    ?>



                </div>

                <div class="col-md-3">

                    <?php



                    if ($total == 0) {
                        $pourcentagemat = 0;
                    } else {
                        $pourcentagemat = ($totalFR / $total) * 100;
                    }

                    echo '<div class="card ">';

                    echo '<div class="card-body">';
                    echo '<div class="row">';

                    echo '<div class="col-3 ">';
                    echo ' <img src="Image/FOUR.png" alt="Italian Trulli" style="width:55px;height:55px;">';
                    echo '</div>';
                    echo '<div class="col-9">';
                    echo '<h4 class="card-title" style="text-align:LEFT" > Coût des matériaux' . '</h4>';
                    echo '</div>';

                    echo '</div>';

                    echo '<div class="row">';

                    echo '<div class="col-8 ">';
                    echo "<h4 style='color: blue; font-weight: 700'>" . number_format($totalFR, 2, ',', '.') . "</H4>";
                    echo '</div>';

                    echo '<div class="col-4 ">';
                    echo "<h4 style='color: orange; font-weight: bold '>" . number_format($pourcentagemat, 2, ',', '.') . '%' . "</H4>";
                    echo '</div>';

                    echo '</div>';

                    echo "</div>";
                    echo "</div>";




                    ?>



                </div>
                <div class="col-md-3">

                    <?php


                    if ($total == 0) {
                        $pourcentagemat = 0;
                    } else {
                        $pourcentagemat = ($totalst / $total) * 100;
                    }

                    echo '<div class="card ">';

                    echo '<div class="card-body">';
                    echo '<div class="row">';

                    echo '<div class="col-2 ">';
                    echo ' <img src="Image/st.png" alt="Italian Trulli" style="width:52px;height:52px;">';
                    echo '</div>';
                    echo '<div class="col-10">';
                    echo '<h4 class="card-title" style="text-align:LEFT" >  . coût de sous-traitance' . '</h4>';
                    echo '</div>';

                    echo '</div>';


                    echo '<div class="row">';

                    echo '<div class="col-8 ">';
                    echo "<h4 style='color: blue; font-weight: 700'>" . number_format($totalst, 2, ',', '.') . "</H4>";
                    echo '</div>';

                    echo '<div class="col-4 ">';
                    echo "<h4 style='color: orange; font-weight: bold '>" . number_format($pourcentagemat, 2, ',', '.') . '%' . "</H4>";
                    echo '</div>';

                    echo '</div>';

                    echo "</div>";
                    echo "</div>";




                    ?>



                </div>

            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="card ">
                        <div class="card-body">


                            <table id="AFFAIRE" class="table table-sm ">
                                <thead style="background-color:whitesmoke;color:black ;width:100%">

                                    <tr>
                                        <th>
                                            #
                                        </th>
                                        <th>
                                            Budget
                                        </th>
                                        <th>
                                            Type
                                        </th>

                                        <th>
                                            Coût Mod
                                        </th>
                                        <th>
                                            CoûtMatériel
                                        </th>
                                        <th>
                                            Coût Matériaux
                                        </th>
                                        <th>
                                            Coût S.Traitance
                                        </th>
                                        <th>
                                            Budget Engagé
                                        </th>

                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="myTableAFF">
                                    <?php
                                    while ($row = mysqli_fetch_array($result2)) {

                                        $id = $row['ID_B'];
                                        echo '<tr style=" font-size:small ; color:black  ">';

                                        echo "<td>" . $row['ID_B'] . "</td>";
                                        echo "<td >" . $row['BUDGET'] . "</td>";
                                        echo "<td>" . $row['TYPE'] . "</td>";
                                        $resultSUM = mysqli_query($cn, "SELECT SUM(QTE_D*PU) FROM `depenses` WHERE ID_B='$id' ");
                                        $resultSUMMOD = mysqli_query($cn, "SELECT SUM(QTE_D*PU) FROM `depenses` WHERE ID_B='$id' AND TYPE='MainOeuvre'");
                                        $resultSUMMATERIEL = mysqli_query($cn, "SELECT SUM(QTE_D*PU) FROM `depenses` WHERE ID_B='$id' AND TYPE='Materiel'");
                                        $resultSUMFOURNITURE = mysqli_query($cn, "SELECT SUM(QTE_D*PU) FROM `depenses` WHERE ID_B='$id' AND TYPE='Fourniture'");
                                        $resultSUMST = mysqli_query($cn, "SELECT SUM(QTE_D*PU) FROM `depenses` WHERE ID_B='$id' AND TYPE='Sous traitant'");



                                        while ($row = mysqli_fetch_array($resultSUMMOD)) {
                                            $totalMOD = $row['SUM(QTE_D*PU)'];
                                            echo "<td>" . number_format($totalMOD, 2, ',', '.') . "</td>";

                                            while ($row = mysqli_fetch_array($resultSUMMATERIEL)) {
                                                $totalMAT = $row['SUM(QTE_D*PU)'];
                                                echo "<td>" . number_format($totalMAT, 2, ',', '.') . "</td>";

                                                while ($row = mysqli_fetch_array($resultSUMFOURNITURE)) {
                                                    $totalFR = $row['SUM(QTE_D*PU)'];
                                                    echo "<td>" . number_format($totalFR, 2, ',', '.') . "</td>";

                                                    while ($row = mysqli_fetch_array($resultSUMST)) {
                                                        $totalst = $row['SUM(QTE_D*PU)'];
                                                        echo "<td>" . number_format($totalst, 2, ',', '.') . "</td>";
                                                        while ($row = mysqli_fetch_array($resultSUM)) {
                                                            $total1 = $row['SUM(QTE_D*PU)'];
                                                      
                                                            echo "<td style='font-weight: 600; color:blue'>" . number_format($total1, 2, ',', '.') . "</td>";
                                                            echo "<td>
                                                                <a class='btn btn-outline-info btn-sm' href='Articles.php?id=" . $id . "' > Articles </a>
                                                                 </td>";

                                                            '</tr>';
                                                        }
                                                        }
                                                    }
                                                }
                                            }
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


                            <form action="BudgetNV.php" method="POST" class="row g-3">
                                <?php
                                if (isset($_GET['id'])) {
                                    $id = $_GET['id'];

                                    $result1 = mysqli_query($cn, "select *from affaires where ID_AFF='$id'");
                                }
                                while ($row = mysqli_fetch_array($result1)) {

                                    $IDAFF = $row['ID_AFF'];
                                    $AFFAIRE = $row['AFFAIRE'];
                                }

                                echo '<input class="hidden" name="IDAFF" type="text" value="' . $IDAFF . '">';

                                echo '<label  class="col-form-label" style="font-weight: bold ">' . $AFFAIRE . '</label>'

                                ?>

                                <div class="col-xs-10">
                                    <label for="BUDGET" class="col-form-label">Désignation</label>
                                    <input class="form-control" name="BUDGET" type="text">
                                </div>
                                <div class="col-xs-10 ">
                                    <label for="TYPEB" class="col-form-label">Type Budget</label>
                                    <select class="form-select form-select-lg" name="TYPEB" type="text">
                                        <option selected>Couts directs</option>
                                        <option>Couts Indirects</option>


                                    </select>
                                </div>






                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary" name="NVBUDGET">Enregistré</button>
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

    <script src="assets1/plugins/data-tables/jquery.datatables.min.js"></script>
    <script src="assets1/plugins/data-tables/datatables.bootstrap4.min.js"></script>
    <link href="assets1/plugins/data-tables/datatables.bootstrap4.min.css" rel="stylesheet">
</main>