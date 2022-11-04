

    <?php
     $cn = mysqli_connect("localhost", "root", "", "vrd");
     $number = count($_POST["CODE"]);
   
     if ($number > 0) {
          for ($i = 0; $i < $number; $i++) {
               if (trim($_POST["CODE"][$i] == '')) {
                    echo "Merci de Remplir tous les champs! ";
               } else {
                    $sql = "INSERT INTO `sermat_type_engin`( `ID_C`, `TYPE`, `CODE`) VALUES
               ('" . mysqli_real_escape_string($cn, $_POST["IDC"][$i]) . "','" . mysqli_real_escape_string($cn, $_POST["GROUPE"][$i]) . "',
               '" . mysqli_real_escape_string($cn, $_POST["CODE"][$i]) . "')";
               $query_run=mysqli_query($cn, $sql);
                    if ($query_run) {
                       
                 
                    }
               }
          }
     }






     ?> 