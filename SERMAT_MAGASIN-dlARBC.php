<?php

$cn= mysqli_connect("localhost", "root", "", "vrd");


if(isset($_GET['id'])){
  $id=$_GET['id'];
  $id1=$_GET['id1'];


$query="  DELETE FROM `bc_articles` WHERE ID_AR='$id'";
                           
                           $query_run=mysqli_query($cn,$query);

                           if ($query_run){
                             
                             echo'<script>alert("Data saved");</script>';
                               header('Location:SERMAT_MAGASIN-ARBC.php?id='.$id1.'');
                           }else{
                             echo'<script>alert("Data not saved");</script>';
                           }

}



 
                     
   
?>
