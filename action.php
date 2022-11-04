

<?php

//action.php

$connect = new PDO("mysql:host=localhost;dbname=vrd", "root", "");

if(isset($_POST["action"]))
{
	if($_POST["action"] == 'fetch')
	{
		$order_column = array('order_number', 'order_total', 'order_date');

		$main_query = "
        SELECT   sermat_engin.ID_M ,sermat_materiels_suivi.ETAS,sermat_materiels_suivi.DATE AS MOIS,
        SUM(sermat_materiels_suivi.POINTAGE) , SUM(sermat_materiels_suivi.GASOIL) , SUM(sermat_materiels_suivi.HUILE_H) ,
        SUM(sermat_materiels_suivi.HUILE_M) ,sermat_materiels_suivi.ETAS FROM sermat_materiels_suivi
        INNER JOIN sermat_engin ON sermat_materiels_suivi.ID_M=sermat_engin.ID_M
		";

		$search_query = 'WHERE sermat_materiels_suivi.DATE <= "'.date('Y-m-d').'" AND ';


		if(isset($_POST["search"]["value"]))
		{
			$search_query .= '(order_number LIKE "%'.$_POST["search"]["value"].'%" OR order_total LIKE "%'.$_POST["search"]["value"].'%" OR sermat_materiels_suivi.DATE LIKE "%'.$_POST["search"]["value"].'%")';
		}

		$group_by_query = " GROUP BY sermat_materiels_suivi.DATE ";

		$order_by_query = "";

		if(isset($_POST["order"]))
		{
			$order_by_query = 'ORDER BY '.$order_column[$_POST['order']['0']['column']].' '.$_POST['order']['0']['dir'].' ';
		}
		else
		{
			$order_by_query = 'ORDER BY sermat_materiels_suivi.DATE DESC ';
		}

		$limit_query = '';

		if($_POST["length"] != -1)
		{
			$limit_query = 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
		}

		$statement = $connect->prepare($main_query . $search_query . $group_by_query . $order_by_query);

		$statement->execute();

		$filtered_rows = $statement->rowCount();

		$statement = $connect->prepare($main_query . $group_by_query);

		$statement->execute();

		$total_rows = $statement->rowCount();

		$result = $connect->query($main_query . $search_query . $group_by_query . $order_by_query . $limit_query, PDO::FETCH_ASSOC);

		$data = array();

		foreach($result as $row)
		{
			$sub_array = array();

			$sub_array[] = $row['order_number'];

			$sub_array[] = $row['order_total'];

			$sub_array[] = $row['sermat_materiels_suivi.DATE'];

			$data[] = $sub_array;
		}

		$output = array(
			"draw"			=>	intval($_POST["draw"]),
			"recordsTotal"	=>	$total_rows,
			"recordsFiltered" => $filtered_rows,
			"data"			=>	$data
		);

		echo json_encode($output);
	}
}

?>