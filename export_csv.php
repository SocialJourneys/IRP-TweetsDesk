<?php
function dbExport($query,$split){

/* vars for export */
// database record to be exported
$table = 'track_list';
// optional where query
// filename for export
$csv_filename = 'db_exports/TMI_export_'.'_'.date('Y-m-d_H.i.s');

// database variables
//$hostname = "localhost";
$hostname = 'dtp-24.sncs.abdn.ac.uk';
$port = '5432';
$user = "postgres";
$password = "5L1ght1y";
$database = "tweetdesk";

//$db = pg_connect('host=localhost port=5432 dbname=tweetdesk user=postgres password=5L1ght1y'); 
//http://dtp-24.sncs.abdn.ac.uk

$db = pg_connect('host='.$hostname.' port='.$port.' dbname='.$database.' user='.$user.' password='.$password)
or die('Could not connect database!');

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
		}

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

if(!$zip)
	$zipname=-1;

foreach ($file_names as $file) {
  $zip->addFile($file);
}

$zip->close();

//fclose($fp);
pg_close();

$returnArray = array($zipname,$limit);

// Export the data and prompt a csv file for download
/*header("Content-type: text/x-csv");
header("Content-Disposition: attachment; filename=".$csv_filename."");
echo($csv_export);*/
return  $returnArray;
}
?>