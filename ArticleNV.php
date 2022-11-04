<?php

$cn= mysqli_connect("localhost", "root", "", "vrd");


$IDB=$_POST['IDB'];
$IDAFF=$_POST['IDAFF'];
$NPRIX=$_POST['NPRIX'];
$ARTICLE=$_POST['ARTICLE'];
$CHAPITRE=$_POST['CHAPITRE'];
$QTE=$_POST['QTE'];
$PUA=$_POST['PUA'];
$U=$_POST['U'];


 $query="  INSERT INTO articles (ID_B, ID_AFF, CHAPITRE, NPRIX, ARTICLE, U, QTE_A,PU_A)
                           VALUES ('$IDB','$IDAFF','$CHAPITRE', '$NPRIX', '$ARTICLE', '$U', '$QTE','$PUA')";
                           
                           $query_run=mysqli_query($cn,$query);

                           if ($query_run){
                             
                             echo'<script>alert("Data saved");</script>';
                               header('Location:Articles.php?id='.$IDB.'');
                           }else{
                             echo'<script>alert("Data not saved");</script>';
                           }
                     
   
?>
