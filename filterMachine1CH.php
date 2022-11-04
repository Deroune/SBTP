



<?php  
 //filter.php  
 if(isset($_POST["from_date"], $_POST["to_date"], $_POST["idm1"]))  
 {  
      $connect = mysqli_connect("localhost", "root", "", "vrd");  
      $output = '';  
      $queryP = "SELECT   sermat_engin.ID_M ,sermat_materiels_suivi.ETAS,DATE_FORMAT(sermat_materiels_suivi.DATE, '%Y-%m') AS MOIS,
      SUM(sermat_materiels_suivi.POINTAGE) AS POINTAGE , SUM(sermat_materiels_suivi.GASOIL) , SUM(sermat_materiels_suivi.HUILE_H) ,
      SUM(sermat_materiels_suivi.HUILE_M) ,sermat_materiels_suivi.ETAS FROM sermat_materiels_suivi
      INNER JOIN sermat_engin ON sermat_materiels_suivi.ID_M=sermat_engin.ID_M
      where  sermat_materiels_suivi.ID_M ='".$_POST["idm1"]."'  AND sermat_materiels_suivi.ETAS = 'Panne' 
      AND sermat_materiels_suivi.DATE  BETWEEN '".$_POST["from_date"]."' AND '".$_POST["to_date"]."'   ";
     
   

 $resultP= mysqli_query($connect, $queryP);  
      
      $output .= '  
          
      ';

      if(mysqli_num_rows($resultP) > 0)  
      {  
       
        while($row = mysqli_fetch_array($resultP)) {
            $ETTP = $row['ETAS'];
            $POINTAGEP = number_format($row['POINTAGE'], 2);
       
        ?><div id="pieChart1"></div>

        <script>
            document.addEventListener("DOMContentLoaded", () => {
                new ApexCharts(document.querySelector("#pieChart1"), {

                    series: [<?php echo $POINTAGEP ?>, <?php echo $POINTAGEM ?>, <?php echo $POINTAGEimm ?>, <?php echo $POINTAGEt ?>],

                    chart: {
                        height: 250,
                        type: 'pie',
                        toolbar: {
                            show: true
                        }
                    },
                    labels: ['Panne ', 'Marche', 'Immobulisée', 'Intemperie']
                }).render();
            });
        </script>
        <?php 
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
 