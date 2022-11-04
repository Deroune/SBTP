



<?php  
 //filter.php  
 if(isset($_POST["from_date"], $_POST["to_date"] , $_POST["idm1"]))  
 {  
      $connect = mysqli_connect("localhost", "root", "", "vrd");  
      $output = '';  
      $query = " SELECT  sermat_engin.MATERIEL, sermat_engin.CODE, produits.PRODUIT,produits.GROUPE,  produits.U, sermat_stock.DATE_L, sermat_stock.REF, bc_articles.PU,
      SUM(sermat_stock.QTE), SUM(sermat_stock.QTE_CONS), SUM(sermat_stock.QTE*bc_articles.PU), SUM(sermat_stock.QTE_CONS*bc_articles.PU) AS CONSOM   FROM bc_articles
      left  JOIN produits ON bc_articles.CODE_PRODUIT=produits.CODE_PRODUIT
              INNER JOIN sermat_stock ON sermat_stock.CODE_PRODUIT=bc_articles.CODE_PRODUIT AND sermat_stock.ID_COM=bc_articles.ID_COM
              INNER JOIN sermat_engin ON sermat_stock.ID_MACHINE=sermat_engin.ID_M
      where  sermat_engin.ID_M ='".$_POST["idm1"]."' AND sermat_stock.DATE_L  BETWEEN '".$_POST["from_date"]."' AND '".$_POST["to_date"]."'
       GROUP BY  produits.GROUPE  ORDER BY CONSOM DESC    
         
      ";  
      $result = mysqli_query($connect, $query);  
      $output .= '  
           <table class="table table-bordered">  
           <thead style="font-family: sans-serif;">
           <tr style="font-size:smaller">
               <th>
                   Code
               </th>

               <th>
                   Qté
               </th>

               <th>
                   MONTANT
               </th>
           </tr>
       </thead>
      ';  
      if(mysqli_num_rows($result) > 0)  
      {  
           while($row = mysqli_fetch_array($result))  
           {  
            $GROUPE = $row['GROUPE'];
            $PRODUIT = $row['PRODUIT'];
            $U = $row['U'];
            $PU = $row['PU'];

            $STOCKCONST2 = $row['SUM(sermat_stock.QTE_CONS)'];
            $STOCKMTCONST2 = $row['CONSOM'];

                $output .= '  
               <tr >

               <td style="font-size:smaller ;">' . $GROUPE . '</td> 

               <td style="font-size:smaller ;text-align:RIGHT" >' . number_format($STOCKCONST2, 2, ',', '.') . '</td> 
               <td style="font-size:smaller ;text-align:RIGHT" >' . number_format($STOCKMTCONST2, 2, ',', '.') . '</td> 

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
 