<?php

	/**
	* Process dynamic forms into arrays with nominal keys and values for easier manipulation.
	* @param   $inputLabel  - String   - The name of the label input;
	*          $inputValue  - String   - The name of the value input;
	* @return  $formArray   - String[] - Array containing the key-value pairings.
	*/
			/* vars for export */
	// database constants
	$table = '';
	$hostname = "localhost";
	$port = '5432';
	$user = "postgres";
	$password = "5L1ght1y";
	$database = "tweetdesk";

	function db_fetch1($query,$table){

	$db = get_db();
	//echo "<br/><br/>query in db_fetch: ".$query;
	$result = pg_exec($db, $query);
	// query to get data from database
	
	$field = pg_num_fields($result);

	while($row=pg_fetch_array($result)){	
		  // create line with field values
		  for($i = 0; $i < $field; $i++) {
		    $csv_export.= '"'.$row[pg_field_name($result,$i)].'",';
		  }

		return $returnArray;
		}
	}

	function get_db(){
		$db = pg_connect('host='.$hostname.' port='.$port.' dbname='.$database.' user='.$user.' password='.$password)
		or die('Could not connect database!');
		return $db;

	}
?>