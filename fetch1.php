<?php
//fetch.php
if(isset($_POST["action"]))
{


 $cn = mysqli_connect("localhost", "root", "", "vrd");
 if (isset($_GET['id'])) {
  $id = $_GET['id'];

}

 $output = '';
 

 if($_POST["action"] == "NPRODUIT")
 {
  $query = "SELECT CODE_PRODUIT FROM produits WHERE PRODUIT ='".$_POST["query"]."' ";
  $result = mysqli_query($cn, $query);
 
  while($row = mysqli_fetch_array($result))
  {
   $output .= '<option value="'.$row["CODE_PRODUIT"].'" selected  >'.$row["CODE_PRODUIT"].'</option>';
  }
 }



 if($_POST["action"] == "IMPUTATION")
 {
  $query = "SELECT ID_M FROM sermat_engin WHERE MATERIEL ='".$_POST["query"]."' ";
  $result = mysqli_query($cn, $query);
 
  while($row = mysqli_fetch_array($result))
  {
   $output .= '<option value="'.$row["ID_M"].'" selected  >'.$row["ID_M"].'</option>';
  }
 }



echo $output;
}


?>