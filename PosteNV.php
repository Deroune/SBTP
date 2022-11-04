<?php

$cn= mysqli_connect("localhost", "root", "", "vrd");
$id=$_GET['id'];

$POSTE=$_POST['POSTE'];
$NIVEAU=$_POST['NIVEAU'];
$UP=$_POST['UP'];
$SALAIRE=$_POST['SALAIRE'];
$DEVISE=$_POST['DEVISE'];



 $query="  INSERT INTO poste (`POSTE`, `NIVEAU`, `SALAIRE`, `U`, `DEVISE`)
                           VALUES ('$POSTE','$NIVEAU', '$SALAIRE', '$UP', '$DEVISE')";
                           
                           $query_run=mysqli_query($cn,$query);

                           if ($query_run){
                             
                             echo'<script>alert("Data saved");</script>';
                               header('Location:Budget.php?id='.$id.'');
                           }else{
                             echo'<script>alert("Data not saved");</script>';
                           }
                     
   
?>
