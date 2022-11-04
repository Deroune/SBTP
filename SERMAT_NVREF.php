

    <?php
     $cn = mysqli_connect("localhost", "root", "", "vrd");
     $number = count($_POST["REF"]);
   
     if ($number > 0) {
          for ($i = 0; $i < $number; $i++) {
               if (trim($_POST["REF"][$i] == '')) {
                    echo "Merci de Remplir tous les champs! ";
               } else {
                    $sql = "INSERT INTO `references`( `TYPE`, `REF`) VALUES
               ('" . mysqli_real_escape_string($cn, $_POST["TYPE"][$i]) . "','" . mysqli_real_escape_string($cn, $_POST["REF"][$i]) . "')";
               $query_run=mysqli_query($cn, $sql);
                    if ($query_run) {
                       
                 
                    }
               }
          }
     }






     ?> 