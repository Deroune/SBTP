

<?php

$cn= mysqli_connect("localhost", "root", "", "vrd");


$CODE=$_POST['CODE'];
$CATEGORIE=$_POST['CATEGORIE'];




 $query=" INSERT INTO `categorie`( `CATEGORIE`, `CODE`)  VALUES
                                         ('$CATEGORIE','$CODE')";
                           
                           $query_run=mysqli_query($cn,$query);

                           if ($query_run){
                             
                             echo'<script>alert("Data saved");</script>';
                               header('Location:SERMAT_MATERIELS.php');
                           }else{
                             echo'<script>alert("Data not saved");</script>';
                           }
                     
   
?>
