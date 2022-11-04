

    <?php
     $cn = mysqli_connect("localhost", "root", "", "vrd");
     $number = count($_POST["CODE"]);
   
     if ($number > 0) {
          for ($i = 0; $i < $number; $i++) {
               if (trim($_POST["CODE"][$i] == '')) {
                    echo "Merci de Remplir tous les champs! ";
               } else {
                    $sql = "INSERT INTO `fournisseurs`( `FOURNISSEUR`, `REF`, `ADRESSE`, `CONTACT`, `TYPE`, `CODE_FR`) VALUES
               ('" . mysqli_real_escape_string($cn, $_POST["FOURNISSEUR"][$i]) . "','" . mysqli_real_escape_string($cn, $_POST["REF"][$i]) . "','" . mysqli_real_escape_string($cn, $_POST["ADRESSE"][$i]) . "',
               '" . mysqli_real_escape_string($cn, $_POST["CONTACT"][$i]) . "','" . mysqli_real_escape_string($cn, $_POST["TYPE"][$i]) . "'
               ,'" . mysqli_real_escape_string($cn, $_POST["CODE"][$i]) . "')";
               $query_run=mysqli_query($cn, $sql);
                    if ($query_run) {
                       
                 
                    }
               }
          }
     }






     ?> 