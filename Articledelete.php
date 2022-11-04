<?php

$cn= mysqli_connect("localhost", "root", "", "vrd");


if(isset($_GET['id'])){
  $id=$_GET['id'];
  $id1=$_GET['id1'];


$query="  DELETE FROM `articles` WHERE ID_A='$id1'";
                           
                           $query_run=mysqli_query($cn,$query);

                           if ($query_run){
                             
                             echo'<script>alert("Data saved");</script>';
                               header('Location:Articles.php?id='.$id.'');
                           }else{
                             echo'<script>alert("Data not saved");</script>';
                           }

}



 
                     
   
?>
