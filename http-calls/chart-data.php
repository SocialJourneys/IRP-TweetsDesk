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

$time_field = 'created_at';
$where = $_SESSION['where_query'];

//then it's a call from tracklist details page else chart refresh
if(strlen($tweets_query)!=0){
	//$from = date('Y-m-d H:i:s',strtotime('-1 day'));
	//$select = $tweets_query." AND ". $time_field.">="."'".$from."'"." ORDER BY ".$time_field." LIMIT 10000";
	$select = $tweets_query." ORDER BY ".$time_field." desc";
}
else{
	if(empty($from) && empty($to)){ //if selected dates or frequency
		$from = date('Y-m-d H:i:s',strtotime('-1 '.$frequency)-3600);
		$to = date('Y-m-d H:i:s',time()-3600);
	}
	
	$where = $_SESSION['where_query'];
	$select = "SELECT ".$time_field.",text, author from tweet ".$where." AND ".$time_field.">="."'".$from."'"." AND ".$time_field."<="."'".$to."'"." ORDER BY ".$time_field." desc";
}

	//$select = "SELECT ".$time_field.",author from tweet WHERE ".$time_field.">="."'".$from."'"." AND ".$time_field."<="."'".$to."'"." ORDER BY ".$time_field." LIMIT 10000";

//$select = "SELECT text,time_stamp,author,original_tweet_id from tweet WHERE time_stamp>= '2014-02-01 13:56:43' ORDER BY time_stamp LIMIT 10000";
	//$db_results = db_fetch($tweets_query);

//echo $select;
//die();

$db_results = db_fetch($select);
//echo $db_results;

$last_row = pg_fetch_array($db_results, 0);
$first_row = pg_fetch_array($db_results, (pg_num_rows($db_results)-1));


//echo $first_row;

$begin = strtotime($first_row[$time_field]);
$end = strtotime($last_row[$time_field]);

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
//$loop_time = $loop_time+$interval;

	while(($loop_time-$interval)<=$end && pg_num_rows($db_results)>0){
		//$intervals[]=date('Y-m-d H:i:s',$loop_time);

		//echo '<br/>time: '.	date('Y-m-d H:i:s',$loop_time);
		//echo '<br/>time: '.	gmdate('Y-m-d H:i:s',);

		$authors_query = "SELECT author from tweet ".$where." AND ".$time_field.">"."'".date('Y-m-d H:i:s.u',$loop_time-$interval)."'"." AND ".$time_field."<="."'".date('Y-m-d H:i:s.u',$loop_time)."'"."GROUP BY author";

		$db_results = db_fetch($authors_query);
		$author_count=pg_num_rows($db_results);
		

		
		//$author_count=sql_count($db_array,date('Y-m-d H:i:s',$loop_time-$interval),date('Y-m-d H:i:s',$loop_time),'author',true);

		$tweets_query = "SELECT count(text) from tweet ".$where." AND ".$time_field.">"."'".date('Y-m-d H:i:s.u',$loop_time-$interval)."'"." AND ".$time_field."<="."'".date('Y-m-d H:i:s.u',$loop_time)."'";
		
		$db_results = db_fetch($tweets_query);
		$tweets_count=0;
		if(pg_num_rows($db_results)>0)
			$tweets_count=pg_fetch_result($db_results,0);
		

		//$tweets_count=sql_count($db_array,date('Y-m-d H:i:s',$loop_time-$interval),date('Y-m-d H:i:s',$loop_time),'id',true);

		//echo $tweets_query;
		//echo '<br/>tweets_count'.$tweets_count;	
		//$intervals[] = $author_count.','.$tweets_count;
		//$intervals[$i]['timestamp'] = date('Y-m-d H:i:s',$loop_time);
		//$intervals[$i]['tweets_count'] = $tweets_count;
		//$intervals[$i]['author_count'] = $author_count;
		$intervals[] = array("timestamp"=>(string)date('Y-m-d H:i:s',$loop_time),
							"authors_count"=>$author_count,
							"tweets_count"=>$tweets_count);

		$loop_time = $loop_time+$interval;
	}



http_response_code(200);
echo json_encode($intervals);

//die();

?>