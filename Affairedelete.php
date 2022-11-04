<?php
session_start();

$cn= mysqli_connect("localhost", "root", "", "vrd");


if(isset($_GET['id'])){
  $id=$_GET['id'];


                $query1="  SELECT COUNT(ID_AFF) FROM `budgets` WHERE ID_AFF='$id'";
                $query="  DELETE FROM `affaires` WHERE ID_AFF='$id'";
                $query_run1=mysqli_query($cn,$query1);
             
                if ($query1!=0){
                  $_SESSION['status']="Impossible de supprimer l'affaire Sélectionné!";
                  header('Location:Affaires.php');

                          } else {
                              $query_run=mysqli_query($cn,$query);

                                if ($query_run){
                        
                                echo'<script>alert("Data saved");</script>';
                                  header('Location:Affaires.php');
                                  }else{
                                  echo'<script>alert("Data not saved");</script>';
                                  }

                                }
                              }
                    





 
                     
   
?>
