<?php

$cn= mysqli_connect("localhost", "root", "", "vrd");


$ID_C=$_POST['id'];
$TYPE=$_POST['TYPE'];
$CODE=$_POST['CODE'];


 $query="INSERT INTO  sermat_type_engin (ID_C,TYPE, CODE)
                           VALUES ('$ID_C','$TYPE', '$CODE')";
                           
      $query_run=mysqli_query($cn,$query);

      if ($query_run){
        
        echo'<script>alert("Data saved");</script>';
          header('Location:SERMAT_MATERIELS.php');
      }else{
        echo'<script>alert("Data not saved");</script>';
      }
