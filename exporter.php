<?php include('core/init.core.php');?>
<?php
header("Content-Type: application/json");

$_SESSION['exporter']['progress'] = 0;
$_SESSION['exporter']['exportedFile'] = '';
$_SESSION['exporter']['progressMessage'] ='';

set_time_limit(100000);
ini_set('memory_limit', '1024M');

//prepare the SQL query from form
if ($_SERVER['REQUEST_METHOD'] == 'POST'){

      $query = 'SELECT ';
      $where = '';
      $fields= '';
      $tables;
      $table_tweet = 'tweet';
      $table_geolocation = 'geolocation';
      $join ='';

      $comb_criteria = ' '.$_POST['filters_criteria'].' '; //AND or OR
      $tables = $table_tweet;

      foreach($_POST['review-checkbox'] as $checkbox) {

          //$checkbox is the table field and $_POST[$checkbox] is the value

        
        //get all the field names
        /*if($checkbox==='limit' && (!empty($_POST['limit'])))
              $limit = ' LIMIT '.$_POST[$checkbox];
        elseif($checkbox!='limit')*/
          
        //handling first comma
           if($fields && $checkbox!='geolocation_fk') {
//              if($checkbox=='geolocation_fk')
  //              $fields = $fields.', geolocation.'.$checkbox;
    //          else
                $fields = $fields.',tweet.'.$checkbox;
            }
           else if($checkbox!='geolocation_fk'){
      //        if($checkbox=='geolocation_fk')
        //        $fields = $fields.', geolocation.'.$checkbox;
          //    else
              $fields = 'tweet.'.$checkbox;
            }
          

          //build the where clause
           switch ($checkbox) {
            case 'id':{
              if(trim($_POST[$checkbox])!=""){
                
                if($where)
                  $where = $where . $comb_criteria;

                $where = $where.' tweet.'.$checkbox. ' = '.trim($_POST[$checkbox]);
              }
               break;
             }
             case 'created_at':{
             if(trim($_POST[$checkbox.'_from'])!="" || trim($_POST[$checkbox.'_to'])!=""){

              // add AND if where already exists, otherwise its a new where clause
              if($where)
                $where = $where . ' AND ';

              //being Where
              $where = $where.' (';
                
              //$_POST[$checkbox.'_from'] = DateTime::createFromFormat('d/m/Y h:i A', $_POST[$checkbox.'_from'])->format('Y-m-d');

                //from date
              if(trim($_POST[$checkbox.'_from'])!=""){
                //add commas to string
                //$_POST[$checkbox.'_from'] = "'".trim($_POST[$checkbox.'_from'])."'";
                $from = "'".trim($_POST[$checkbox.'_from'])."'";
                //create where clause
                $where = $where.'tweet.'.$checkbox.' >= '.$from;
              }
              //to date
              if(trim($_POST[$checkbox.'_to'])!=""){
                //if from date set, create AND clause
                if(trim($_POST[$checkbox.'_from'])!="")
                     $where = $where . ' AND ';

                //add commas to string
                //$_POST[$checkbox.'_to'] = "'".trim($_POST[$checkbox.'_to'])."'";
                $to = "'".trim($_POST[$checkbox.'_to'])."'";
                //create where clause
                $where = $where.'tweet.'.$checkbox.' <= '.$to;
              }

              //close Where
                $where = $where.' )';
              }
               # code...
               break;
             }

             case 'time_stamp':{
             if(trim($_POST[$checkbox.'_from'])!="" || trim($_POST[$checkbox.'_to'])!=""){

              if($where)
                $where = $where . ' AND ';

              $where = $where.' (';
                
              //$_POST[$checkbox.'_from'] = DateTime::createFromFormat('d/m/Y h:i A', $_POST[$checkbox.'_from'])->format('Y-m-d');

              if(trim($_POST[$checkbox.'_from'])!=""){
//                $_POST[$checkbox.'_from'] = "'".trim($_POST[$checkbox.'_from'])."'";
                $from = "'".trim($_POST[$checkbox.'_from'])."'";
                $where = $where.'tweet.'.$checkbox.'>='.$from;
              }
              if(trim($_POST[$checkbox.'_to'])!=""){
                if(trim($_POST[$checkbox.'_from'])!="")
                     $where = $where . ' AND ';

                //$_POST[$checkbox.'_to'] = "'".trim($_POST[$checkbox.'_to'])."'";
                $to = "'".trim($_POST[$checkbox.'_to'])."'";
                $where = $where.'tweet.'.$checkbox.'<='.$to;
              }

                $where = $where.' )';
              }
               # code...
               break;
             }

             case 'favourite_count':{
              if(trim($_POST[$checkbox])!=""){
               // die();
                if($where)
                  $where = $where . $comb_criteria;

                $where = $where.' tweet.'.$checkbox. $_POST[$checkbox.'_condition'].trim($_POST[$checkbox]);
              }
               break;
             }

             case 're_tweeet_count':{
              if(trim($_POST[$checkbox])!=""){
                
                if($where)
                  $where = $where . $comb_criteria;

                $where = $where.' tweet.'.$checkbox. $_POST[$checkbox.'_condition'].trim($_POST[$checkbox]);
              }
               break;
             }

             case 'text':{
              $keywords = get_form_data_kv('textKeyword_condition_','text_');
              $text_comb_criteria = ' '.$_POST['textFilters_criteria'].' '; //AND or OR                

              if(trim($_POST[$checkbox])!="" || sizeof($keywords)>0){
                
                if($where) //if it is a continuong WHERE clause, append AND or OR
                  $where = $where . $comb_criteria;

                $where = $where.' (';

                if(trim($_POST[$checkbox])!=""){
                    if( ($_POST[$checkbox.'Keyword_condition'])==='~*' || ($_POST[$checkbox.'Keyword_condition']==='!~*'))
                  //    $_POST[$checkbox] = "'%".trim($_POST[$checkbox])."%'";
                        $text = "'[^[:alnum:]]".trim($_POST[$checkbox])."[^[:alnum:]]'"; 
                    else
                      $text = "'".trim($_POST[$checkbox])."'";

                    $where = $where.' tweet.'.$checkbox.' '.$_POST[$checkbox.'Keyword_condition'].' '.$text.' ';
                }

                //loop through dynamic boxes
                foreach ($keywords as $key => $value) {
                  if($value!=""){ //value is the input value
                    //extract the condition from key :e.g k1_LIKE
                    $condition = explode("_", $key);
                    $condition = $condition[1];
                    if(trim($text)!="") //if keyword already in the query, then add AND or OR
                      $where = $where.$text_comb_criteria;

                    if($condition==='~*' || $condition==='!~*')
                        $text = "'[^[:alnum:]]".trim($value)."[^[:alnum:]]'"; 
                    else
                      $text = "'".trim($value)."'";

                    $where = $where.' tweet.'.$checkbox.' '.$condition.' '.$text.' ';
                  }
                       // echo( 'condition: ' . $key.', value:'.$value.'<br/>' );
                    //    echo sizeof($keywords);
                }

                $where = $where.' )';

              //  die();
              }
               break;
             }

             case 'geolocation_fk':{

              //if(trim($_POST[$checkbox])!=""){
                //echo 'inside gelocation';
                //echo $_POST[$checkbox.'_condition'];

                switch ($_POST[$checkbox.'_condition']) {
                  case 'with':
                  if($where)
                    $where = $where . $comb_criteria;
                  $fields = $fields.',geolocation.latitude, geolocation.longitude';
                  $tables = $tables.','.$table_geolocation;
                  $where = $where.' (tweet.'.$checkbox.' is not null AND geolocation.id=tweet.'.$checkbox.')';
                 // --select tweet.text, geolocation.latitude, geolocation.longitude from tweet, geolocation where tweet.geolocation_fk is not null and geolocation.id = tweet.geolocation_fk
                    break;
                  case 'without':
                  if($where)
                    $where = $where . $comb_criteria;
                  $where = $where.' (tweet.'.$checkbox.' is null) ';
                    //select tweet.id, text, geolocation_fk from tweet where geolocation_fk is null
                    break;    
                  default: //All
                  $fields = $fields.',geolocation.latitude, geolocation.longitude';
                  $join = ' LEFT JOIN geolocation on geolocation.id=tweet.'.$checkbox;
                //--select tweet.id, tweet.text, geolocation.latitude, geolocation.longitude from tweet left join geolocation on geolocation.id = tweet.geolocation_fk where tweet.id > 326153
                    break;
                } //switch condition
              //}
               break;
             }

             default:{
              if(trim($_POST[$checkbox])!=""){
                
                $inpval = trim($_POST[$checkbox]);
                $condition = " = ";

                if($checkbox=='in_reply_to_screen_name' || $checkbox=='iso_language_code' || $checkbox=='source' || $checkbox=='author'){
                  //$_POST[$checkbox] = "'".trim($_POST[$checkbox])."'";
                    $inpval = "'%".$inpval."%'";
                    $condition = " LIKE ";
                  }
                
                if($where)
                  $where = $where . $comb_criteria;

                $where = $where.' LOWER(tweet.'.$checkbox.')'.$condition.'LOWER('.$inpval.')';
              }
               break;
             }
           }

        } // for loop

        //echo $fields;
        //echo "<br/>";
        //echo $where;
        if(empty($fields))
          $fields = '*';
        if(!empty($where))
          $where = ' WHERE '.$where;
        
        if(trim($_POST['split'])!="")
            $split = trim(($_POST['split']));
        else
            $split = 1;
        
        if(!empty($_POST['limit']))
          $limit = ' LIMIT '.trim($_POST['limit']);

        $query = $query .$fields.' from '. $tables.$join.$where." ORDER BY tweet.created_at DESC ".$limit;

        echo $query;

          $message_limit=$limit;
          session_start();
          $_SESSION['exporter']['progressMessage'] ='Retrieving tweets from database...';
          session_write_close();


        $returnArray = dbExport($query,intval($split));               
        
		if(!empty($returnArray)){
			http_response_code(200);
			$returnArray=array_reverse($returnArray);
			echo json_encode($returnArray);
		}
		else
			echo json_encode(array("errors"=>"Export error"));

  } //if post



//db fetch and csv creation

function dbExport($query,$split){

  // filename for export
  $csv_filename = 'db_exports/TMI_export_'.'_'.date('Y-m-d_H.i.s');


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
  
  $progress=100/$limit; //if 20, than each loop adds 0.2
  session_start();
  $_SESSION['exporter']['progress'] = 0;
  $_SESSION['exporter']['progressMessage'] ='Creating CSV data...';
  session_write_close();
  
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
          $progressLoop +=$progress;
          if($progressLoop%4==0){
          session_start();
          $_SESSION['exporter']['progress'] =$progressLoop;
          session_write_close();
        }
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
  else
    foreach ($file_names as $file){
       unlink($file);//delete the csv
  }

  //fclose($fp);
  pg_close();


  $returnArray = array("file"=>$zipname,"records"=>$limit);

  session_start();
  $_SESSION['exporter']['exportedFile']=$returnArray;
  session_write_close();

  // Export the data and prompt a csv file for download
  /*header("Content-type: text/x-csv");
  header("Content-Disposition: attachment; filename=".$csv_filename."");
  echo($csv_export);*/
  return  $returnArray;
  }
?>