

    <?php
    session_start();
    $cn = mysqli_connect("localhost", "root", "", "vrd");

    $PRODUIT = $_POST['PRODUIT1'];
    $FOURNISSEUR = $_POST['FOURNISSEUR1'];
    $BC = $_POST['BC1'];
    $MACHINE = $_POST['IDM'];

    $resultFR = mysqli_query($cn, "SELECT * FROM `fournisseurs`  WHERE FOURNISSEUR='$FOURNISSEUR'");
    while ($row = mysqli_fetch_array($resultFR)) {
      $IDFOURNISSEUR = $row['ID_FOURNISSEUR'];
    }


    $resultPRODUIT = mysqli_query($cn, "SELECT * FROM `produits`  WHERE PRODUIT='$PRODUIT'");


    while ($row = mysqli_fetch_array($resultPRODUIT)) {
      $CODE_PRODUIT = $row['CODE_PRODUIT'];
    }

    $resultBC = mysqli_query($cn, "SELECT * FROM `sermat_commandes`  WHERE N_COMMANDE='$BC'");

    while ($row = mysqli_fetch_array($resultBC)) {
      $IDCOM = $row['ID_COM'];
    }


    $resultMATERIAL = mysqli_query($cn, "SELECT  *FROM `sermat_engin` WHERE MATERIEL='$MACHINE'");


    while ($row = mysqli_fetch_array($resultMATERIAL)) {
      $MATERIEL = $row['ID_M'];
    }


    $IDMAG = $_POST['IDMAG'];
    $STCK = $_POST['QTE1'];
    $REF = $_POST['REF'];
    $DATE = $_POST['DATE'];
    $QTE = $_POST['QTE'];
    $BL = $_POST['BL'];
    $NOTE = $_POST['NOTE'];


    if ($REF == '' || $IDFOURNISSEUR == '' || $CODE_PRODUIT == '' || $QTE == '' || $BL == '' || $DATE == '') {

      $_SESSION['status'] = "merci de remplir tous les champs !";
      header('Location:SERMAT_MAGASIN-SUIVI.php?id=' . $IDMAG . '');

    } else {
      if ($QTE > $STCK) {


        $_SESSION['status'] = "Impossible Quantité disponible de l'article sélectionné est :$STCK  !";
        header('Location:SERMAT_MAGASIN-SUIVI.php?id=' . $IDMAG . '');
      } else {
        $query = "  INSERT INTO `sermat_stock`( `ID_MAG`, `ID_COM`,  `ID_FOURNISSEUR`,`ID_MACHINE`, `REF`, `DATE_L`, `CODE_PRODUIT`, `QTE_CONS`, `BL`, `NOTE`) VALUES
     ('$IDMAG','$IDCOM', '$IDFOURNISSEUR','$MATERIEL', '$REF', '$DATE','$CODE_PRODUIT' ,'$QTE','$BL','$NOTE')";

        $query_run = mysqli_query($cn, $query);

          header('Location:SERMAT_MAGASIN-SUIVI.php?id=' . $IDMAG . '');
       
      }
    }













    ?> 