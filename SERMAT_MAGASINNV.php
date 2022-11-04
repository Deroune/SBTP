<?php

$cn= mysqli_connect("localhost", "root", "", "vrd");


$MAGASIN=addslashes($_POST["MAGASIN"]);
$ADRESSE=addslashes($_POST["ADRESSE"]);
$RESPONSABLE=addslashes($_POST["RESPONSABLE"]);
$TYPE=addslashes($_POST["TYPE"]);


 $query="INSERT INTO  magasins (MAGASIN,ADRESSE,RESPONSABLE,TYPE)
                           VALUES ('$MAGASIN','$ADRESSE', '$RESPONSABLE', '$TYPE')";
                           
      $query_run=mysqli_query($cn,$query);

      if ($query_run){
        
        echo'<script>alert("Data saved");</script>';
          header('Location:SERMAT_MAGASIN.php');
      }else{
        echo'<script>alert("Data not saved");</script>';
      }
