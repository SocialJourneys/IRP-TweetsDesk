<?php include('core/init.core.php');

set_time_limit(20000);
ini_set('memory_limit', '112M');


$returnArray = dbExport('select * from tweet',1);

var_dump($returnArray);


//db fetch and csv creation

function dbExport($query,$split){

  // filename for export
  $csv_filename = 'db_exports/TMI_export_'.'_'.date('Y-m-d_H.i.s');


  $db = get_db();
  //$query = 'SELECT * FROM track_list'; 


  //echo "<br/><br/>query in exporter: ".$query;
  $result = pg_query($db, $query);
   

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
  
  $progress=100/$limit; //if 20, than each loop adds 0.2
  
  $progressLoop = 0;

     

  while($curr_split<=$split){
    $csv_export = '';
      // create line with field names
      for($i = 0; $i < $field; $i++) {
      //  $fields_array[]=pg_field_name($result,$i);
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
      
      //$p_file = fopen($file,"w");
      //fwrite($p_file,$csv_export);
      //fclose($p_file);
      file_put_contents($file, $csv_export);
      $file_names[]=$file;


      $curr_loop=0;
      $curr_split=$curr_split+1;
  }

  $curr_split = 1;

  $result = pg_query($db, $query);

while($curr_split<=$split){
    $csv_export = '';
      // create line with field names
      for($i = 0; $i < $field; $i++) {
      //  $fields_array[]=pg_field_name($result,$i);
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
        //}

        //$progressLoop+=$progress;
      }
      //sleep(1);

      //sleep(0.1);
      if($split>1)
        $file = $csv_filename.'-part'.$curr_split.'.csv';
      else
        $file = $csv_filename.'1.csv';
      // Open the file to get existing content
      // Write the contents back to the file
      file_put_contents($file, $csv_export);
      //$p_file = fopen($file,"w");
      //fwrite($p_file,$csv_export);
      //fclose($p_file);
      $file_names[]=$file;


      $curr_loop=0;
      $curr_split=$curr_split+1;
  }

  $curr_split = 1;

  $result = pg_query($db, $query);

while($curr_split<=$split){
    $csv_export = '';
      // create line with field names
      for($i = 0; $i < $field; $i++) {
      //  $fields_array[]=pg_field_name($result,$i);
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
        //}

        //$progressLoop+=$progress;
      }
      //sleep(1);

      //sleep(0.1);
      if($split>1)
        $file = $csv_filename.'-part'.$curr_split.'.csv';
      else
        $file = $csv_filename.'2.csv';
      // Open the file to get existing content
      // Write the contents back to the file
      file_put_contents($file, $csv_export);
      //      $p_file = fopen($file,"w");
      //fwrite($p_file,$csv_export);
      //fclose($p_file);
      $file_names[]=$file;


      $curr_loop=0;
      $curr_split=$curr_split+1;
  }

  $curr_split = 1;

  $result = pg_query($db, $query);

while($curr_split<=$split){
    $csv_export = '';
      // create line with field names
      for($i = 0; $i < $field; $i++) {
      //  $fields_array[]=pg_field_name($result,$i);
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
        //}

        //$progressLoop+=$progress;
      }
      //sleep(1);

      //sleep(0.1);
      if($split>1)
        $file = $csv_filename.'-part'.$curr_split.'.csv';
      else
        $file = $csv_filename.'3.csv';
      // Open the file to get existing content
      // Write the contents back to the file
      file_put_contents($file, $csv_export);
            //$p_file = fopen($file,"w");
      //fwrite($p_file,$csv_export);
      //fclose($p_file);

      $file_names[]=$file;


      $curr_loop=0;
      $curr_split=$curr_split+1;
  }

echo "after loop";

  $zipname = $csv_filename.'.zip';
  $zip = new ZipArchive;
  $zip->open($zipname, ZipArchive::CREATE);

echo "before zip loop";

  foreach ($file_names as $file) {
    $zip->addFile($file);
  }

  $zip->close();

echo "after zip loop";

  if(file_exists($zipname)==false)
    $zipname=0;
  else
    foreach ($file_names as $file){
       //unlink($file);//delete the csv
  }

  //fclose($fp);
  pg_close();


  $returnArray = array("file"=>$zipname,"records"=>$limit);


  // Export the data and prompt a csv file for download
  /*header("Content-type: text/x-csv");
  header("Content-Disposition: attachment; filename=".$csv_filename."");
  echo($csv_export);*/
  return  $returnArray;
  }
?>