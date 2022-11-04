<?php
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
    $result1 = mysqli_query($cn, "select *from articles where ID_B='$id'");
    $result2 = mysqli_query($cn, "select *from budgets where ID_B='$id'");
    $resultSUMARTICLE = mysqli_query($cn, "SELECT SUM(QTE_D*PU) FROM `depenses` WHERE ID_B='$id' AND REF='Budget' ");
$resultMONTANT = mysqli_query($cn, "SELECT SUM(QTE_A*PU_A) FROM `articles` WHERE ID_B='$id' ");
}


while ($row = mysqli_fetch_array($resultSUMARTICLE)) {
    $total = $row['SUM(QTE_D*PU)'];
}
while ($row = mysqli_fetch_array($resultMONTANT)) {
    $montant = $row['SUM(QTE_A*PU_A)'];
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
            while ($row = mysqli_fetch_array($result2)) {


                echo '<div class="card ">';
                echo '<div class="card-body">';


                echo '<div class="row">';

                echo '<div class="col-xs-12">';
                echo '<h4 class="card-title" style="text-align:LEFT" >Budget :' . "  " . $row['ID_B'] . " - " . $row['BUDGET'] . '</h4>';
                echo "</div>";



                echo "</div>";



                echo '<div class="form-group row">';

                echo '<div class="col-xs-12 " style="font-weight: bolder ; font-family:Microsoft Tai Le ">';
                echo '<dl>';


                echo '<dt class="card-text"  >Type :' . '</dt>';
                echo '<dd class="card-text" >' . " " . $row['TYPE'] . '</dd>';

                echo '<dt class="card-text"  > Montant  Total :' . '</dt>';
                echo '<dd class="card-text" >' . " " . number_format($montant, 2, ',', '.') . '</dd>';


                echo '<dt class="card-text"  > Coût  Total :' . '</dt>';
                echo '<dd class="card-text" >' . " " . number_format($total, 2, ',', '.') . '</dd>';








                echo '</dl>';





            ?>
                <!-- Vertical Bar Chart -->
                <div class="card ">
                    <div class="card-body">
                        <div id="verticalBarChart" style="min-height: 400px;" class="echart"></div>

                        <script>
                            document.addEventListener("DOMContentLoaded", () => {
                                echarts.init(document.querySelector("#verticalBarChart")).setOption({
                                    title: {
                                        text: 'MARGE'
                                    },
                                    tooltip: {
                                        trigger: 'axis',
                                        axisPointer: {
                                            type: 'shadow'
                                        }
                                    },
                                    legend: {},
                                    grid: {
                                        left: '3%',
                                        right: '4%',
                                        bottom: '3%',
                                        containLabel: true
                                    },
                                    xAxis: {
                                        type: 'value',
                                        boundaryGap: [0, 0.01]
                                    },
                                    yAxis: {
                                        type: 'category',

                                        data: ['A-1', 'A-2', 'A-3', 'A-4']
                                    },
                                    series: [{
                                            name: 'DS',
                                            type: 'bar',
                                            data: [18203, 23489, 29034, 29034]


                                        },
                                        {
                                            name: 'PV',
                                            type: 'bar',
                                            data: [19325, 23438, 31000, 121594]
                                        }
                                    ]
                                });
                            });
                        </script>
                    </div>
                </div>
                <!-- End Vertical Bar Chart -->






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
                            <h4 style='color: blue; font-weight: 700'>Liste des Articles</h4>
                        </div>
                        <div class="col-md-2">
                            <button type="button" data-toggle="modal" data-target="#myModal" class="btn btn-outline-success">Nouveau Article</button>
                        </div>

                    </div>
                    <table id="hoverable-data-table" class="table display nowrap ">
                        <thead style="background-color:aliceblue">
                            <tr>
                                <th>
                                    #
                                </th>
                                <th>
                                    Chapitre
                                </th>
                                <th>
                                    N° Prix
                                </th>
                                <th>
                                    Article
                                </th>
                                <th>
                                    Unité
                                </th>
                                <th>
                                    Quantité
                                </th>
                                <th>
                                    PU HT
                                </th>
                                <th>
                                    PT HT
                                </th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="myTablearticles">
                            <?php
                            while ($row = mysqli_fetch_array($result1)) {
                                $PTHT = $row['PU_A'] * $row['QTE_A'];
                                $id1 = $row['ID_A'];
                                echo '<tr style="height: 10px; overflow:auto; font-size:small ; color:black ; ">';

                                echo "<td>" . $row['ID_B'] . "</td>";




                                echo "<td>" . $row['CHAPITRE'] . "</td>";
                                echo "<td>" . $row['NPRIX'] . "</td>";
                                echo "<td>" . $row['ARTICLE'] . "</td>";
                                echo "<td>" . $row['U'] . "</td>";
                                echo "<td>" . $row['QTE_A'] . "</td>";
                                echo "<td>" . $row['PU_A'] . "</td>";
                                echo "<td>" .  number_format($PTHT, 2, ',', '.')  . "</td>";

                                echo "<td> 
                                <a class='btn btn-outline-primary btn-sm' href='Budget.php?id=" . $id1 . "' role='button'> Modifier </a> 
                                <a class='btn btn-outline-danger btn-sm' href='Articledelete.php?id=" . $id . "&id1=" . $id1 . "' role='button'> Supprimer </a> 
                                <a class='btn btn-outline-info btn-sm' href='Budget.php?id=" . $id1 . "' role='button'> Budget </a> 
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
                <div class="modal-header" style="background-color:whitesmoke">

                    <h4 class="modal-title" style=" font-weight: 700" >Nouveau Article</h4>
                </div>
                <div class="modal-body">
                   


                        <div class="card-body">
                            <br />


                            <form action="ArticleNV.php" method="POST" class="row g-3">


                                <div class="form-group row ">
                                    <?php
                                    if (isset($_GET['id'])) {
                                        $id = $_GET['id'];

                                        $result1 = mysqli_query($cn, "select *from budgets where ID_B='$id'");
                                    }
                                    while ($row = mysqli_fetch_array($result1)) {
                                        $IDB = $row['ID_B'];
                                        $IDAFF = $row['ID_AFF'];
                                        $NONBUDGET = $row['BUDGET'];
                                    }


                                    echo '<input class="hidden" name="IDB" type="text" value="' . $IDB . '">';
                                    echo '<input class="hidden" name="IDAFF" type="text" value="' . $IDAFF . '">';
                                    echo ' <h5 class="modal-title" style=" font-weight: 700" > Budget :' .$NONBUDGET.'</h5>';

                                    ?>
                                    <br/>
                                    <br/>
                                    <div class="col-xs-8">
                                        <label for="ARTICLE" class="col-form-label">Article</label>
                                        <input class="form-control" name="ARTICLE" type="text">
                                    </div>
                                    <div class="col-xs-4">
                                        <label for="CHAPITRE" class="col-form-label">Chapitre</label>
                                        <input class="form-control" name="CHAPITRE" type="text">
                                    </div>

                                </div>

                                <div class="form-group row ">
                                    <div class="col-xs-3 ">
                                        <label for="NPRIX" class="col-form-label">N° Prix</label>
                                        <input class="form-control" name="NPRIX" type="text">
                                    </div>

                                    <div class="col-xs-4">
                                        <label for="QTE" class="col-form-label">Quantité</label>
                                        <input class="form-control" name="QTE" type="number">
                                    </div>
                                    <div class="col-xs-2">
                                        <label for="U" class="col-form-label">U</label>
                                        <input class="form-control" name="U" type="text">
                                    </div>
                                    <div class="col-xs-3 ">
                                        <label for="PUA" class="col-form-label">Prix U</label>
                                        <input class="form-control" name="PUA" type="number">
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




  <!-- PAGINATION TABLE POSTE-->
    <script>
        $(document).ready(function() {
            $("#myInputarticles").on("keyup", function() {
                var value = $(this).val().toLowerCase();
                $("#myTablearticles tr").filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });
        });
    </script>

  
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