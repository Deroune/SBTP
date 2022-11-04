



<?php  
 //filter.php  
 if(isset($_POST["from_date"], $_POST["to_date"], $_POST["idm1"]))  
 {  
      $connect = mysqli_connect("localhost", "root", "", "vrd");  
      $output = '';  
      $query = "  
      SELECT   sermat_engin.ID_M ,sermat_materiels_suivi.ETAS,DATE_FORMAT(sermat_materiels_suivi.DATE, '%Y-%m') AS MOIS,
      SUM(sermat_materiels_suivi.POINTAGE) , SUM(sermat_materiels_suivi.GASOIL) , SUM(sermat_materiels_suivi.HUILE_H) ,
      SUM(sermat_materiels_suivi.HUILE_M) ,sermat_materiels_suivi.ETAS FROM sermat_materiels_suivi
      INNER JOIN sermat_engin ON sermat_materiels_suivi.ID_M=sermat_engin.ID_M
      where  sermat_materiels_suivi.ID_M ='".$_POST["idm1"]."'   AND sermat_materiels_suivi.DATE  BETWEEN '".$_POST["from_date"]."' AND '".$_POST["to_date"]."'  GROUP BY sermat_materiels_suivi.ETAS 
         
      ";  
      $result = mysqli_query($connect, $query);  
      $output .= '  
           <table class="table table-bordered">  
           <thead style="font-family: sans-serif;">
                                        <tr style="font-size:smaller">

                                            <th>
                                                Etas
                                            </th>
                                            <th>
                                                Total Pointage
                                            </th>

                                            <th>
                                                Total Gasoil
                                            </th>
                                            <th>
                                                Total Huile H.
                                            </th>
                                            <th>
                                                Total Huile M.
                                            </th>
                                        </tr>
                                    </thead>
      ';  
      if(mysqli_num_rows($result) > 0)  
      {  
           while($row = mysqli_fetch_array($result))  
           {  
            $ETAS1 = $row['ETAS'];
            $TGS1 = $row['SUM(sermat_materiels_suivi.GASOIL)'];
            $THY1 = $row['SUM(sermat_materiels_suivi.HUILE_H)'];
            $THM1 = $row['SUM(sermat_materiels_suivi.HUILE_M)'];
            $TPT1 = $row['SUM(sermat_materiels_suivi.POINTAGE)'];
            $DDT = $row['MOIS'];

                $output .= '  
               <tr >

               <td style="font-size:smaller ;">' . $ETAS1 . '</td> 

               <td style="font-size:smaller ;text-align:RIGHT" >' . number_format($TPT1, 2, ',', '.') . '</td> 
               <td style="font-size:smaller ;text-align:RIGHT" >' . number_format($TGS1, 2, ',', '.') . '</td> 
               <td style="font-size:smaller ;text-align:RIGHT" >' . number_format($THY1, 2, ',', '.') . '</td> 
               <td style="font-size:smaller ;text-align:RIGHT" >' . number_format($THM1, 2, ',', '.') . '</td> 

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
 