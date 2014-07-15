<?php include('../core/init.core.php');?>
<?php
header("Content-Type: application/json");

$from = $_GET['from'];
$to = $_GET['to'];
$frequency = $_GET['frequency'];
$tweets_query="";

//if query exists in the session
if(strlen($_SESSION['tweets_query'])!=0){
	$tweets_query = $_SESSION['tweets_query'];
	$_SESSION['tweets_query']="";
}

$time_field = 'time_stamp';
$where = $_SESSION['where_query'];

//then it's a call from tracklist details page else chart refresh
if(strlen($tweets_query)!=0){
	//$from = date('Y-m-d H:i:s',strtotime('-1 day'));
	//$select = $tweets_query." AND ". $time_field.">="."'".$from."'"." ORDER BY ".$time_field." LIMIT 10000";
	$select = $tweets_query." ORDER BY ".$time_field." desc LIMIT 10000";
}
else{
	if(empty($from) && empty($to)){ //if selected dates or frequency
		$from = date('Y-m-d H:i:s',strtotime('-1 '.$frequency));
		$to = date('Y-m-d H:i:s',time());
	}
	
	$where = $_SESSION['where_query'];
	$select = "SELECT ".$time_field.",text, author from tweet ".$where." AND ".$time_field.">="."'".$from."'"." AND ".$time_field."<="."'".$to."'"." ORDER BY ".$time_field." desc LIMIT 10000";
}

	//$select = "SELECT ".$time_field.",author from tweet WHERE ".$time_field.">="."'".$from."'"." AND ".$time_field."<="."'".$to."'"." ORDER BY ".$time_field." LIMIT 10000";
//$select = "SELECT ".$time_field.",author,text from tweet ORDER BY ".$time_field." desc LIMIT 500";
//$select = "SELECT text,time_stamp,author,original_tweet_id from tweet WHERE time_stamp>= '2014-02-01 13:56:43' ORDER BY time_stamp LIMIT 10000";
	//$db_results = db_fetch($tweets_query);

//echo $select;
//die();

$db_results = db_fetch($select);
$db_array=array();
//echo $db_results;

$timestamps=array();
$authors = array();

//60=1minute
//60*60=1hour (3600)
//60*60*24=1day (86400)
//60*60*24*10=10days (864000)

for($ri = 0; $ri < pg_num_rows($db_results); $ri++) {

    $row = pg_fetch_array($db_results, $ri);

    //$db_array[$ri]=array('author'=>$row['author']);
    //$db_array[$ri]=array('text'=>$row['text']);
    //$db_array[$ri]=array($time_field=>$row[$time_field]);
    $timestamps[]=$row[$time_field];
    $authors[]=$row['author'];
}

$db_array=array_reverse($db_array);
$timestamps=array_reverse($timestamps);

//echo $db_array;

$begin = strtotime($timestamps[0]);
$end = strtotime($timestamps[count($timestamps)-1]);

$seconds = ($end-$begin);
$hours = ($end-$begin)/3600;
$days = ($end-$begin)/86400;

/*echo 'count: '. count($timestamps);
echo '<br/>first row date: '.($timestamps[0]);
echo '<br/>last row date: '.($timestamps[count($timestamps)-1]);
echo '<br/>time difference in seconds : '.$seconds;
echo '<br/>time difference in hours : '.$hours;
echo '<br/>time difference in days : '.$days;
*/

$interval = $seconds/23; //graph scale
$loop_time = $begin; //initiale with begining timestamp
$intervals=array();

$index_interval = count($timestamps)/23;

//$loop_time = $loop_time+$interval;
$queries = '';
$i = 0;
//$intervals[]=$timestamps;

while($loop_time<$end){
	//$intervals[]=date('Y-m-d H:i:s',$loop_time);

	//echo '<br/>time: '.	date('Y-m-d H:i:s',$loop_time);
	//echo '<br/>time: '.	gmdate('Y-m-d H:i:s',);

	//$authors_query = "SELECT ".$i." as tag, author from tweet ".$where." AND ".$time_field.">="."'".date('Y-m-d H:i:s',$loop_time-$interval)."'"." AND ".$time_field."<="."'".date('Y-m-d H:i:s',$loop_time)."'"."GROUP BY author;";
	//$queries.=$authors_query;
	//$i++;
	$from=date('Y-m-d H:i:s.u',$loop_time-$interval);
	$to=date('Y-m-d H:i:s.u',$loop_time);
	$db_intervals = findInterval($timestamps,floor($i),$from,$to);
	$i+=$index_interval;

	if($db_intervals['from']===$db_intervals['to']){
		$author_count=0;
		$tweets_count=0;
	}
	else{
		$authors_array = array_slice($authors, $db_intervals['from'],$db_intervals['to']);
		$authors_unique_array = array_unique($authors_array);
		$author_count = count($authors_unique_array);

		$tweets_count = count($authors_array);
	}
	//$intervals[]=array("db_from "=>(string)date('Y-m-d H:i:s',strtotime($timestamps[$db_intervals['from']])),"db_to "=>(string)date('Y-m-d H:i:s',strtotime($timestamps[$db_intervals['to']])),"loop from"=>(string)date('Y-m-d H:i:s',$loop_time),"loop to"=>(string)date('Y-m-d H:i:s',$loop_time+$interval));
	//$intervals[]=$db_intervals;
	
//	$db_results = db_fetch($authors_query);
//	$author_count=pg_num_rows($db_results);
	

	
	//$author_count=sql_count($db_array,date('Y-m-d H:i:s',$loop_time-$interval),date('Y-m-d H:i:s',$loop_time),'author',true);

	//$tweets_query = "SELECT count(text) from tweet ".$where." AND ".$time_field.">="."'".date('Y-m-d H:i:s',$loop_time-$interval)."'"." AND ".$time_field."<="."'".date('Y-m-d H:i:s',$loop_time)."'";
	
	//$db_results = db_fetch($tweets_query);
	//$tweets_count=pg_fetch_result($db_results,0);
	
	//$intervals[] = array("timestamp"=>(string)date('Y-m-d H:i:s',$loop_time));

	//$intervals[]=$db_intervals;
	$intervals[] = array("timestamp"=>(string)date('Y-m-d H:i:s',$loop_time),
						"authors_count"=>$author_count,
						"tweets_count"=>$tweets_count);

	
	$loop_time = $loop_time+$interval;
}

	//$db_results = db_fetch($queries);
http_response_code(200);
echo json_encode($intervals);

//die();
?>
<?php
function findInterval($source_array,$index,$from,$to){
	$db_date = date('Y-m-d H:i:s.u',strtotime($source_array[$index]));
	
	$db_index_from=0;
	$db_index_to=0;


	//finding from
	if($from==$db_date)
		$db_index_from = $index;
	else if($db_date>$from){
		$zk = $index;
		while($db_date>$from && $zk>0){
			$zk--;
			$db_date=date('Y-m-d H:i:s.u',strtotime($source_array[$zk]));
		}
		$db_index_from=$zk-1;
	}
	else if($db_date<$from){
		$zk = $index;

		while($db_date<$from && $zk<=(count($source_array))-1){
			$zk++;
			$db_date=date('Y-m-d H:i:s.u',strtotime($source_array[$zk]));
		}
		$db_index_from=$zk-1;
	}

	$zk = $index;
	$db_date = date('Y-m-d H:i:s.u',strtotime($source_array[$index]));
	//finding to
	if($to==$db_date)
		$db_index_to = $index;
	else if($db_date<$to){
		$zk = $index;
		while($db_date<$to && $zk<=(count($source_array))-1){
			$zk++;
			$db_date=date('Y-m-d H:i:s.u',strtotime($source_array[$zk]));
		}
		$db_index_to=$zk-1;
	}
	else if($db_date>$to){
		$zk = $index;
		while($db_date>$to && $zk>0){
			$zk--;
			$db_date=date('Y-m-d H:i:s.u',strtotime($source_array[$zk]));
		}
		$db_index_to=$zk-1;
	} 


	return array("index"=>$index,"from"=>$db_index_from,"to"=>$db_index_to, "value from"=>$source_array[$db_index_from],"value to"=>$source_array[$db_index_to], "interval from"=>$from,"interval to"=>$to);
}
?>