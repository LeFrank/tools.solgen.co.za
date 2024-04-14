<?php

	function csvify_expenses($data, $expense_types, $payment_methods){
		$exportData[0] = array("Number","Date", "Expense_Type", "Payment_method", "Description", "Location", "Amount");
		$count = 1;
		foreach($data as $k=>$v){
			$exportData[$count]	= 
				array( 
					$count, 
					$v["expense_date"],
					$expense_types[$v["expense_type_id"]]["description"],
					$expense_types[$v["payment_method_id"]]["description"],
					$v["description"],
					$v["location"],
					$v["amount"]
				);
			$count++;
		}
		return $exportData;
	}

	function csvify_budget_items($data, $expense_types, $payment_methods){
		$exportData[0] = array("Number","Date", "Expense_Type", "Limit_Amount", "Description", "Comment");
		$count = 1;
		// echo "<pre>";
		// print_r($data);
		// echo "</pre>";
		foreach($data as $k=>$v){
			$exportData[$count]	= 
				array( 
					$count, 
					$v["create_date"],
					ucfirst($expense_types[$v["expense_type_id"]]["description"]),
					$v["limit_amount"],
					$v["description"],
					$v["comment"]					
				);
			$count++;
		}
		// echo "<pre>";
		// print_r($exportData);
		// echo "</pre>";
		// exit;
		return $exportData;
	}
?>