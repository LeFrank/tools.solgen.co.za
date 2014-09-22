<?php

	function csvify($data, $expense_types, $payment_methods){
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
?>