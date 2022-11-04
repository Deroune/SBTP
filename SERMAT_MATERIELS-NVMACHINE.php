<?php

$cn= mysqli_connect("localhost", "root", "", "vrd");



$IDT=$_POST['IDT'];
$IDC=$_POST['IDC'];
$CODE=$_POST['CODE'];
$MACHINE=$_POST['MACHINE'];
$PU=$_POST['PU'];
$U=$_POST['U'];
$MODEL=$_POST['MODEL'];
$MARQUE=$_POST['MARQUE'];
$SERIE=$_POST['SERIE'];
$TLOC=$_POST['TLOC'];
$CONSOMMATION=$_POST['CONSOMMATION'];
$COMPTEUR=$_POST['COMPTEUR'];
$DEVISE=$_POST['DEVISE'];
$DATE=$_POST['DATE'];


$IMAGE1=$_FILES['image']['name'];
$upload ="IMGMACHINES/".$IMAGE1;
move_uploaded_file($_FILES['image']['tmp_name'],$upload);



 $query="  INSERT INTO `sermat_engin`(`ID_T`, `ID_C`, `CODE`, `MATERIEL`, `MARQUE`, `MODEL`, `SERIE`, `PU`, `DEVISE`, 
                                       `U`, `CONS_G`, `COMPTEUR`, `DATE`, `IMAGE`, `TYPE_LOC`) VALUES 
                                         ('$IDT','$IDC', '$CODE', '$MACHINE', '$MARQUE','$MODEL' ,'$SERIE','$PU','$DEVISE'
                                         ,'$U','$CONSOMMATION','$COMPTEUR','$DATE','$IMAGE1','$TLOC'  )";
                           
                           $query_run=mysqli_query($cn,$query);
                           if ($query_run){

                            echo'<script>alert("Data saved");</script>';
                            header('Location:SERMAT_MATERIELS_LISTE.php?id='.$IDT.'');
                            }else{
                            echo'<script>alert("Data not saved");</script>';
                            }

                         
   
?>
