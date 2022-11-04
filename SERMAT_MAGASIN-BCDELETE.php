<?php
session_start();

$cn= mysqli_connect("localhost", "root", "", "vrd");


if(isset($_GET['id'])){
  $id=$_GET['id'];
  $id1=$_GET['id1'];

                $query1="  SELECT COUNT(ID_COM) FROM `bc_articles` WHERE ID_COM='$id'";
                $query="  DELETE FROM `sermat_commandes` WHERE ID_COM='$id'";
                $query_run1=mysqli_query($cn,$query1);
             
                if ($query1>0){
                  $_SESSION['status']="Impossible de supprimer La commande Sélectionnée!";
                  header('Location:SERMAT_MAGASIN-SUIVI.php?id='.$id1.'');

                          } else {
                              $query_run=mysqli_query($cn,$query);

                                if ($query_run){
                        
                                echo'<script>alert("Data saved");</script>';
                                  header('Location:SERMAT_MAGASIN-SUIVI.php?id='.$id1.'');
                                  }else{
                                  echo'<script>alert("Data not saved");</script>';
                                  }

                                }
                              }
                    




