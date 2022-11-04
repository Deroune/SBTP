



<?php  


 //filter.php  
 if(isset($_POST["from_date"], $_POST["to_date"], $_POST["idm1"]))  
 {  

     $connect = mysqli_connect("localhost", "root", "", "vrd");  

      $output = '';  
      $query = " SELECT   sermat_engin.ID_M ,sermat_materiels_suivi.ETAS,DATE_FORMAT(sermat_materiels_suivi.DATE, '%Y-%m') AS MOIS,
      SUM(sermat_materiels_suivi.POINTAGE) , SUM(sermat_materiels_suivi.GASOIL) , SUM(sermat_materiels_suivi.HUILE_H) ,
      SUM(sermat_materiels_suivi.HUILE_M) ,sermat_materiels_suivi.ETAS FROM sermat_materiels_suivi
      INNER JOIN sermat_engin ON sermat_materiels_suivi.ID_M=sermat_engin.ID_M
      where  sermat_materiels_suivi.ID_M ='".$_POST["idm1"]."' AND sermat_materiels_suivi.DATE  BETWEEN '".$_POST["from_date"]."' AND '".$_POST["to_date"]."'  GROUP BY MOIS,sermat_materiels_suivi.ETAS  ";  
      $result = mysqli_query($connect, $query);  
      $output .= '  
           <table class="table table-bordered">  
           <thead style="font-family: sans-serif;">
           <tr style="font-size:smaller">

               <th style="text-align:center">
                   Période
               </th>
               <th style="text-align:center">
                   Etas
               </th>
               <th style="text-align:center">
                   Pointage
               </th>

               <th style="text-align:center">
                   Gasoil
               </th>
               <th style="text-align:center">
                   Huile H.
               </th>
               <th style="text-align:center">
                   Huile M.
               </th>
           </tr>
       </thead>
      ';  
      if(mysqli_num_rows($result) > 0)  
      {  
           while($row = mysqli_fetch_array($result))  
           {  
               $ETAS2 = $row['ETAS'];
               $TGS2 = $row['SUM(sermat_materiels_suivi.GASOIL)'];
               $THY2 = $row['SUM(sermat_materiels_suivi.HUILE_H)'];
               $THM2 = $row['SUM(sermat_materiels_suivi.HUILE_M)'];
               $TPT2 = $row['SUM(sermat_materiels_suivi.POINTAGE)'];
               $DDT2 = $row['MOIS'];
                $output .= '  
               <tr >
               <td style="font-size:smaller ;">' . $DDT2 . '</td> 
               <td style="font-size:smaller ;">' . $ETAS2 . '</td> 

               <td style="font-size:smaller ;text-align:RIGHT" >' . number_format($TPT2, 2, ',', '.') . '</td> 
               <td style="font-size:smaller ;text-align:RIGHT" >' . number_format($TGS2, 2, ',', '.') . '</td> 
               <td style="font-size:smaller ;text-align:RIGHT" >' . number_format($THY2, 2, ',', '.') . '</td> 
               <td style="font-size:smaller ;text-align:RIGHT" >' . number_format($THM2, 2, ',', '.') . '</td> 

               </tr>
                ';  
           }  
      }  
      else  
      {  
           $output .= '  
                <tr>  
                     <td colspan="5">No Order Found</td>  
                </tr>  
           ';  
      }  
      $output .= '</table>';  
      echo $output;  
 }  
 ?>
 