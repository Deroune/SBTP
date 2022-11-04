<?php

$cn= mysqli_connect("localhost", "root", "", "vrd");


$IDAFF=$_POST['ID_AFF'];
$IDB=$_POST['ID_B'];
$IDA=$_POST['ID_A'];
$TYPE=$_POST['TYPE'];
$REF=$_POST['REF'];
$DEPENSE=$_POST['DEPENSE'];
$QTEA=$_POST['QTE_A'];
$CADENCE=$_POST['CADENCE'];
$COEF=$_POST['COEF'];
$U=$_POST['U'];
$PU=$_POST['PU'];
$NOTE=$_POST['NOTE'];
$DATE=date('m/d/Y');
$QTED=($_POST['QTE_A']/$_POST['CADENCE'])*$_POST['COEF'];


 $query="INSERT INTO depenses (ID_AFF, ID_B, ID_A, DEPENSE, TYPE, REF, DATE, QTE_A, CADENCE, COEF_D, QTE_D, U, PU, NOTE)
  VALUES ('$IDAFF','$IDB','$IDA','$DEPENSE','$TYPE','$REF','$DATE=','$QTEA','$CADENCE','$COEF','$QTED','$U','$PU','$NOTE')";
                           
      $query_run=mysqli_query($cn,$query);

      if ($query_run){
        
        echo'<script>alert("Data saved");</script>';
                               header('Location:Budget.php?id='.$IDA.'');
      }else{
        echo'<script>alert("Data not saved");</script>';
      }


?>
