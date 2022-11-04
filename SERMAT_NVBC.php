<?php

$cn= mysqli_connect("localhost", "root", "", "vrd");

$FOURNISSEUR=$_POST['FOURNISSEUR'];
$resultFR = mysqli_query($cn, "SELECT * FROM `fournisseurs`  WHERE FOURNISSEUR='$FOURNISSEUR'");

while ($row = mysqli_fetch_array($resultFR)) {
  $IDFOURNISSEUR = $row['ID_FOURNISSEUR'];

}
$IDMAG1=$_POST['IDMAG1'];
$CODE=$_POST['CODE'];
$DATE=$_POST['DATE'];
$DATEL=$_POST['DATEL'];
$MODEP=$_POST['MODEP'];
$TVA=$_POST['TVA'];
$REF=$_POST['REF'];



 $query="  INSERT INTO `sermat_commandes`(`ID_MAG`, `N_COMMANDE`, `ID_FOURNISSEUR`, `DATE_COMMANDE`, `DATE_LIV`, `M_PAIMENT`, `TVA`,`REF`) VALUES
                                         ('$IDMAG1','$CODE', '$IDFOURNISSEUR', '$DATE', '$DATEL','$MODEP' ,'$TVA','$REF')";
                           
                           $query_run=mysqli_query($cn,$query);

                           if ($query_run){
                             
                             echo'<script>alert("Data saved");</script>';
                               header('Location:SERMAT_MAGASIN-SUIVI.php?id='.$IDMAG1.'');
                           }else{
                             echo'<script>alert("Data not saved");</script>';
                           }
                     
   
?>
