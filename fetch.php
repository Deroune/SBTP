<?php
//fetch.php
if(isset($_POST["action"]))
{


 $cn = mysqli_connect("localhost", "root", "", "vrd");
 if (isset($_GET['id'])) {
  $id = $_GET['id'];

}

 $output = '';
 

 if($_POST["action"] == "FOURNISSEUR")
 {
  $query = "SELECT sermat_commandes.N_COMMANDE FROM `sermat_commandes` INNER JOIN fournisseurs on sermat_commandes.ID_FOURNISSEUR=fournisseurs.ID_FOURNISSEUR 
            WHERE sermat_commandes.ID_MAG='$id' AND fournisseurs.FOURNISSEUR='".$_POST["query"]."'  ";
  $result = mysqli_query($cn, $query);
  $output .= '<option value="" style="color:blue">N-BC </option>';
  while($row = mysqli_fetch_array($result))
  {
   $output .= '<option value="'.$row["N_COMMANDE"].'">'.$row["N_COMMANDE"].'</option>';
  }
 }


 if($_POST["action"] == "BC")
 {
  $query = "SELECT produits.PRODUIT ,bc_articles.CODE_PRODUIT FROM bc_articles
   INNER JOIN produits on produits.CODE_PRODUIT=bc_articles.CODE_PRODUIT 
  INNER JOIN sermat_commandes on sermat_commandes.ID_COM=bc_articles.ID_COM
  WHERE sermat_commandes.N_COMMANDE ='".$_POST["query"]."'  ";
  $result = mysqli_query($cn, $query);
  $output .= '<option value="">produit </option>';
  while($row = mysqli_fetch_array($result))
  {
   $output .= '<option value="'.$row["PRODUIT"].'">'.$row["PRODUIT"].'</option>';
}
}





if($_POST["action"] == "FOURNISSEUR1")
{
 $query = "SELECT sermat_commandes.N_COMMANDE FROM `sermat_commandes` INNER JOIN fournisseurs on sermat_commandes.ID_FOURNISSEUR=fournisseurs.ID_FOURNISSEUR 
 WHERE  sermat_commandes.ID_MAG='$id' AND fournisseurs.FOURNISSEUR='".$_POST["query"]."'  ";
 $result = mysqli_query($cn, $query);
 $output .= '<option value="">N-BC </option>';
 while($row = mysqli_fetch_array($result))
 {
  $output .= '<option value="'.$row["N_COMMANDE"].'">'.$row["N_COMMANDE"].'</option>';
 }
}


if($_POST["action"] == "BC1")
{
    
 $query = "SELECT DISTINCT produits.PRODUIT ,sermat_stock.CODE_PRODUIT ,SUM(sermat_stock.QTE),SUM(sermat_stock.QTE_CONS) FROM sermat_stock
 INNER JOIN produits on produits.CODE_PRODUIT=sermat_stock.CODE_PRODUIT 
INNER JOIN sermat_commandes on sermat_commandes.ID_COM=sermat_stock.ID_COM 
WHERE  sermat_commandes.N_COMMANDE ='".$_POST["query"]."' GROUP BY produits.PRODUIT ,sermat_stock.CODE_PRODUIT  HAVING SUM(sermat_stock.QTE)-SUM(sermat_stock.QTE_CONS)>0   ";
 $result = mysqli_query($cn, $query);
 $output .= '<option value="">produit </option>';
 while($row = mysqli_fetch_array($result))
 {
  $output .= '<option value="'.$row["PRODUIT"].'">'.$row["PRODUIT"].'</option>';
}
}

if($_POST["action"] == "PRODUIT1")
{
    
 $query = "SELECT  produits.CODE_PRODUIT, produits.PRODUIT, produits.RUPTURE,  produits.U, SUM(sermat_stock.QTE),
 SUM(sermat_stock.QTE_CONS)  FROM `sermat_stock`            
 INNER JOIN produits ON sermat_stock.CODE_PRODUIT=produits.CODE_PRODUIT where  sermat_stock.ID_MAG='$id'
  AND produits.PRODUIT= '".$_POST["query"]."'  GROUP by  produits.CODE_PRODUIT, produits.PRODUIT, produits.RUPTURE,  produits.U";
 $result = mysqli_query($cn, $query);
 
 $output .= '<option value="">stock </option>';
 while($row = mysqli_fetch_array($result))
 {
 $stock= $row["SUM(sermat_stock.QTE)"]-$row["SUM(sermat_stock.QTE_CONS)"];
  $output .= '<option value="'.$stock.'" selected  >'.$stock.'</option>';
 
}
}

echo $output;
}


?>