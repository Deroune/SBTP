

    <?php
     $cn = mysqli_connect("localhost", "root", "", "vrd");
     $number = count($_POST["CODE"]);
   
     if ($number > 0) {
          for ($i = 0; $i < $number; $i++) {
               if (trim($_POST["CODE"][$i] == '')) {
                    echo "Merci de Remplir tous les champs! ";
               } else {
                    $sql = "INSERT INTO `produits`( `CODE_PRODUIT`, `PRODUIT`, `REF`, `U`, `RUPTURE`, `GROUPE`) VALUES
               ('" . mysqli_real_escape_string($cn, $_POST["CODE"][$i]) . "','" . mysqli_real_escape_string($cn, $_POST["PRODUIT"][$i]) . "',
               '" . mysqli_real_escape_string($cn, $_POST["TYPE"][$i]) . "',
               '" . mysqli_real_escape_string($cn, $_POST["U"][$i]) . "','" . mysqli_real_escape_string($cn, $_POST["RUPTURE"][$i]) . "'
               ,'" . mysqli_real_escape_string($cn, $_POST["GROUPE"][$i]) . "')";
               $query_run=mysqli_query($cn, $sql);
                    if ($query_run) {
                       
                 
                    }
               }
          }
     }






     ?> 