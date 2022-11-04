<?php

$cn= mysqli_connect("localhost", "root", "", "vrd");


$IDAFF=$_POST['IDAFF'];
$budget=$_POST['BUDGET'];
$type=$_POST['TYPEB'];


 $query="INSERT INTO  budgets (  ID_AFF, BUDGET, TYPE)
                           VALUES ('$IDAFF', '$budget', '$type')";
                           
      $query_run=mysqli_query($cn,$query);

      if ($query_run){
        
        echo'<script>alert("Data saved");</script>';
                               header('Location:Affaires_details.php?id='.$IDAFF.'');
      }else{
        echo'<script>alert("Data not saved");</script>';
      }


?>
