<?php

$cn= mysqli_connect("localhost", "root", "", "vrd");
$id=$_GET['id'];

$MACHINE=addslashes($_POST['MACHINE']);
$CONS=addslashes($_POST['CONS']);
$UM=addslashes($_POST['UM']);
$COUT=addslashes($_POST['COUT']);
$DEVISE=addslashes($_POST['DEVISE']);
$LOCATION=addslashes($_POST['LOCATION']);



 $query="  INSERT INTO materiel ( `MATERIEL`, `COUT`, `DEVISE`, `U`, `CONS_G`, `LOCATION`)
                           VALUES ('$MACHINE','$COUT', '$DEVISE', '$UM', '$CONS', '$LOCATION')";
                           
                           $query_run=mysqli_query($cn,$query);

                           if ($query_run){
                             
                             echo'<script>alert("Data saved");</script>';
                               header('Location:Budget.php?id='.$id.'');
                           }else{
                             echo'<script>alert("Data not saved");</script>';
                           }
                     
   
?>
