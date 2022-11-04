


    <?php
   
     $cn = mysqli_connect("localhost", "root", "", "vrd");

    
     $IDMAG=$_POST['IDMAG'];
     $IDCOM=$_POST['IDCOM'];
  
     $CODEPRODUIT=$_POST['CODEPRODUIT'];
     $IMPUTATION1=$_POST['IMPUTATION1'];
     $QTE=$_POST['QTE'];
     $PU=$_POST['PU'];
     $NOTE=$_POST['NOTE'];
     


     $query="  INSERT INTO `bc_articles`(  `ID_COM`, `ID_MAG`,`ID_MACHINE`, `CODE_PRODUIT`, `QTE`, `PU`, `NOTE`) VALUES
     ('$IDCOM','$IDMAG', '$IMPUTATION1', '$CODEPRODUIT' ,'$QTE','$PU','$NOTE')";

$query_run=mysqli_query($cn,$query);

if ($query_run){

echo'<script>alert("Data saved");</script>';
header('Location:SERMAT_MAGASIN-ARBC.php?id='.$IDCOM.'');
}else{
echo'<script>alert("Data not saved");</script>';
}








     ?> 
   