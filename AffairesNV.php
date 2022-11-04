<?php

$cn= mysqli_connect("localhost", "root", "", "vrd");



$A=$_POST['AFFAIRE'];
$CLIENT=$_POST['CLIENT'];
$ADRESSE=$_POST['ADRESSE'];
$DELAI=$_POST['DELAI'];
$MONTANT=$_POST['MONTANT'];
$DEVISE=$_POST['DEVISE'];
$PAR=$_POST['PAR'];
$DEMARRAGE=$_POST['DEMARRAGE'];

 $query="INSERT INTO  affaires (  AFFAIRE, ADRESSE, CLIENT, DELAI, MONTANT, DEVISE, PAR, DEMARRAGE)
                           VALUES ('$A', '$ADRESSE', '$CLIENT', '$DELAI', '$MONTANT', '$DEVISE',' $PAR', '$DEMARRAGE')";
                           
      $query_run=mysqli_query($cn,$query);

      if ($query_run){
        
        echo'<script>alert("Data saved");</script>';
          header('Location:Affaires.php');
      }else{
        echo'<script>alert("Data not saved");</script>';
      }


?>
