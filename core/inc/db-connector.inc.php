<?php 

function get_db(){
		// database constants
		$table = '';
		//$hostname = "localhost";
		$hostname = "dtp-24.sncs.abdn.ac.uk";
		$port = '5432';
		$user = "postgres";
		$password = "5L1ght1y";
		$database = "tweetdesk";

		$db = pg_connect('host='.$hostname.' port='.$port.' dbname='.$database.' user='.$user.' password='.$password)
		or die('Could not connect database!');
		return $db;

	}

	function db_fetch($query){

	$db = get_db();
	//echo "<br/><br/>query in db_fetch: ".$query;
	//exit();

	$result = pg_exec($db, $query);
	// query to get data from database

// 	$rows = 

	//$field = pg_num_fields($result);
	//$returnArray = pg_copy_to($db, $table);

/*		while($row=pg_fetch_array($result)){	
			$returnArray[]=$row;
			
		}

	
	*/
	pg_close();
	return $result;
	}

	//get available records in database
	function db_count(){
		$db = get_db();
		$result = pg_exec($db, 'SELECT count (id) from tweet');

		return pg_fetch_result($result,0);
	}



	function dbExport($query,$split,$basePath,$progressBar){

	// filename for export
	$csv_filename = $basePath.'/TMI_export_'.'_'.date('Y-m-d_H.i.s');


	$db = get_db();
	//$query = 'SELECT * FROM track_list'; 


	//echo "<br/><br/>query in exporter: ".$query;
	$result = pg_exec($db, $query);
	 

	// create empty variable to be filled with export data

	// query to get data from database

	$field = pg_num_fields($result);

	//echo $numrows;
	//exit();
	//$fields_array = array();
	$limit=0;
	if($result)
		$limit = pg_num_rows($result);

	$loop = ceil($limit/$split);
	$curr_loop = 0;
	$curr_split = 1;
	$file_names=array();

	//echo "<br/><br/>query in exporter: ".$query. ' split : '.$split. ' loop : '.$loop;

	//echo 'records: '. $limit;
	//die();
	session_start();
	$progress=100/$limit; //if 20, than each loop adds 0.2
	$_SESSION['progressBarValue']=0;

	$progressLoop = 0;

	while($curr_split<=$split){
		$csv_export = '';
			// create line with field names
			for($i = 0; $i < $field; $i++) {
			//	$fields_array[]=pg_field_name($result,$i);
				$csv_export.= pg_field_name($result,$i).',';
			}

			// newline (seems to work both on Linux & Windows servers)
			$csv_export.= '
			';

			// loop through database query and fill export variable
			while($curr_loop<$loop && ($row=pg_fetch_array($result))) {	
			  // create line with field values
			  for($i = 0; $i < $field; $i++) {
			  	$csv_value = $row[pg_field_name($result,$i)];
			  	$csv_value = str_replace('"', '""', $csv_value);
			    $csv_export.= '"'.$csv_value.'",';
			  }	
			    $csv_export.= '
			';	
			  //echo "<br/>curr loop: ".$curr_loop;
			$curr_loop=$curr_loop+1;
			
			//if(($progressLoop%5)<=0 && $_SESSION['progressBarValue']<100){
					session_start();
					$_SESSION['progressBarValue']+=$progress;
					session_write_close();
				//}

				//$progressLoop+=$progress;
			}
			//sleep(1);

			//sleep(0.1);
			if($split>1)
				$file = $csv_filename.'-part'.$curr_split.'.csv';
			else
				$file = $csv_filename.'.csv';
			// Open the file to get existing content
			// Write the contents back to the file
			file_put_contents($file, $csv_export);
			$file_names[]=$file;


			$curr_loop=0;
			$curr_split=$curr_split+1;
	}
	
	$zipname = $csv_filename.'.zip';
	$zip = new ZipArchive;
	$zip->open($zipname, ZipArchive::CREATE);

	foreach ($file_names as $file) {
	  $zip->addFile($file);
	}

	$zip->close();

	if(file_exists($zipname)==false)
		$zipname=0;

	//fclose($fp);
	pg_close();

	$returnArray = array("file"=>$zipname,"records"=>$limit);

	session_start();
	$_SESSION['exportedFile']=$returnArray;
	session_write_close();
	
	// Export the data and prompt a csv file for download
	/*header("Content-type: text/x-csv");
	header("Content-Disposition: attachment; filename=".$csv_filename."");
	echo($csv_export);*/
	return  $returnArray;
	}
?>