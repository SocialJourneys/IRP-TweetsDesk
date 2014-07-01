<?php
/* vars for export */
// database record to be exported
$db_record = 'track_list';
// optional where query
$where = 'WHERE 1 ORDER BY 1';
// filename for export
$csv_filename = 'db_export_'.$db_record.'_'.date('Y-m-d').'.csv';

// database variables
$hostname = "localhost";
$port = '5432';
$user = "postgres";
$password = "5L1ght1y";
$database = "tweetdesk";

//$db = pg_connect('host=localhost port=5432 dbname=tweetdesk user=postgres password=5L1ght1y'); 
//http://dtp-24.sncs.abdn.ac.uk

$db = pg_connect('host=localhost port=5432 dbname=tweetdesk user=postgres password=5L1ght1y')
or die('Could not connect database!');

$query = 'SELECT * FROM track_list'; 

$result = pg_query($db,$query); 


$result = pg_exec($db, "select * from track_list");
$numrows = pg_num_rows($result);
  
  /*echo "<p>link = $link<br>
  result = $result<br>
  numrows = $numrows</p>
  ";
  ?>

  <table border="1">
  <tr>
   <th>Last name</th>
   <th>First name</th>
   <th>ID</th>
  </tr>
  <?

   // Loop on rows in the result set.

   for($ri = 0; $ri < $numrows; $ri++) {
    echo "<tr>\n";
    $row = pg_fetch_array($result, $ri);
    echo " <td>", $row["type"], "</td>
   <td>", $row["name"], "</td>
   <td>", $row["id"], "</td>
  </tr>
  ";
   }
   pg_close($link);
   echo "</table>";

*/


/*if (!$result) { 
    echo "Problem with query " . $query . "<br/>"; 
    echo pg_last_error(); 
    exit(); 
} */

//pg_close($db);

// create empty variable to be filled with export data
$csv_export = '';

// query to get data from database

$field = pg_num_fields($result);
//echo $numrows;
//exit();

// create line with field names
for($i = 0; $i < $field; $i++) {

	$csv_export.= pg_field_name($result,$i).',';
}

// newline (seems to work both on Linux & Windows servers)
$csv_export.= '
';

// loop through database query and fill export variable
while($row = pg_fetch_array($result)) {
  // create line with field values
  for($i = 0; $i < $field; $i++) {
    $csv_export.= '"'.$row[pg_field_name($result,$i)].'",';
  }	
  $csv_export.= '
';	
}

// Export the data and prompt a csv file for download
header("Content-type: text/x-csv");
header("Content-Disposition: attachment; filename=".$csv_filename."");
echo($csv_export);
?>