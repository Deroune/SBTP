

    <?php
     $cn = mysqli_connect("localhost", "root", "", "vrd");
     $PRODUIT=$_POST['PRODUIT'];
     $FOURNISSEUR=$_POST['FOURNISSEUR'];
     $BC=$_POST['BC'];
     $resultFR = mysqli_query($cn, "SELECT * FROM `fournisseurs`  WHERE FOURNISSEUR='$FOURNISSEUR'");
     $resultPRODUIT = mysqli_query($cn, "SELECT * FROM `produits`  WHERE PRODUIT='$PRODUIT'");
     $resultBC = mysqli_query($cn, "SELECT * FROM `sermat_commandes`  WHERE N_COMMANDE='$BC'");
     
     
     while ($row = mysqli_fetch_array($resultFR)) {
       $IDFOURNISSEUR = $row['ID_FOURNISSEUR'];
     
     }
     while ($row = mysqli_fetch_array($resultPRODUIT)) {
          $CODE_PRODUIT = $row['CODE_PRODUIT'];
        
        }
        while ($row = mysqli_fetch_array($resultBC)) {
          $IDCOM = $row['ID_COM'];
        
        }
     $IDMAG=$_POST['IDMAG'];
  
     $REF=$_POST['REF'];
     $DATE=$_POST['DATE'];
     $QTE=$_POST['QTE'];
     $BL=$_POST['BL'];
     $NOTE=$_POST['NOTE'];
     


     $query="  INSERT INTO `sermat_stock`( `ID_MAG`, `ID_COM`,  `ID_FOURNISSEUR`, `REF`, `DATE_L`, `CODE_PRODUIT`, `QTE`, `BL`, `NOTE`) VALUES
     ('$IDMAG','$IDCOM', '$IDFOURNISSEUR', '$REF', '$DATE','$CODE_PRODUIT' ,'$QTE','$BL','$NOTE')";

$query_run=mysqli_query($cn,$query);

if ($query_run){

echo'<script>alert("Data saved");</script>';
header('Location:SERMAT_MAGASIN-SUIVI.php?id='.$IDMAG.'');
}else{
echo'<script>alert("Data not saved");</script>';
}








     ?> 