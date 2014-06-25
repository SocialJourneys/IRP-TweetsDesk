<?php

	/**
	* Process dynamic forms into arrays with nominal keys and values for easier manipulation.
	* @param   $inputLabel  - String   - The name of the label input;
	*          $inputValue  - String   - The name of the value input;
	* @return  $formArray   - String[] - Array containing the key-value pairings.
	*/
	function get_form_data_kv($inputLabel, $inputValue){
		
		$formArray  = array();
		$keys   	= array();
		$values 	= array();

		//Filter the form and put all property labels into a keys array:
		foreach ($_POST as $key => $value) {
			if(strpos($key, $inputLabel) === 0){
				$keys[]=$value;
			}
		}

		//Filter the form and put all property values into a keys array:
		foreach ($_POST as $key => $value) {
			if(strpos($key, $inputValue) === 0){
				$values[]=$value;
			}
		}

		for($index = 0; $index<sizeof($values); $index++){
			if(strlen($values[$index])>0)
				$formArray[$keys[$index]]=$values[$index];
		}

		return $formArray;
	}

	/**
	* Process dynamic forms into arrays with integer keys and values for easier manipulation.
	* @param   $inputValue  - String   - The name of the value input;
	* @return  $values      - String[] - Array containing the values of the inputs.
	*/
	function get_form_data_v($inputValue){

		$values 	= array();

		//Filter the form and put all property values into a keys array:
		foreach ($_POST as $key => $value) {
			if(strpos($key, $inputValue) === 0){
				$values[]=$value;
			}
		}

		return $values;
	}

?>