<?php include('../core/init.core.php');?>
<?php
header("Content-Type: application/json");

$call = $_GET['call'];
$time_field = 'time_stamp';

$returnArray;

switch ($call) {
	case 'overview':
	$returnArray=system_overview($time_field);
		break;
	case 'chart':
	$returnArray=system_tweets_chart($time_field);
			break;
	default:
		# code...
		break;
}

http_response_code(200);
echo json_encode($returnArray);
?>
<?php

function system_overview($time_field){
	$select = "SELECT ".$time_field." FROM tweet ORDER BY ".$time_field;
	$db_results = db_fetch($select);

	$first_row = pg_fetch_array($db_results, 0);
	$last_row = pg_fetch_array($db_results, (pg_num_rows($db_results)-1));

	$begin = strtotime($first_row[$time_field]);
	$end = strtotime($last_row[$time_field]);

	$tweets_per_second = round(pg_num_rows($db_results)/($end-$begin),2);
	$total_tweets = pg_num_rows($db_results);

	return array("tweets_per_second"=>$tweets_per_second,
						"total_tweets"=>$total_tweets);
}



function system_tweets_chart($time_field){
	
	$from = $_GET['from'];
	$to = $_GET['to'];
	$frequency = $_GET['frequency'];
	$firstCall = $_GET['firstCall'];

	//var_dump($time_field);
	if($firstCall=="true")//if first call
		$where = '';

	else if($from!="" || $to!="") {
	       //begin Where
	      $where ='WHERE (';
	      //from date
	      if(trim($from)!=""){
	        $from = "'".$from."'";
	        //create where clause
	        $where = $where.$time_field.' >= '.$from;
	      }
	      //to date
	      if(trim($to)!=""){
	        //if from date set, create AND clause
	        if(trim($from)!="")
	             $where = $where . ' AND ';

	        //add commas to string
	        $to = "'".$to."'";
	        //create where clause
	        $where = $where.$time_field.' <= '.$to;
	      }
	      //close Where
	        $where = $where.' )';
	}

	else if ($from==="" && $to===""){ //if frequency
			$from = date('Y-m-d H:i:s',strtotime('-1 '.$frequency)-3600);
			$to = date('Y-m-d H:i:s',time()-3600);
			$where = "WHERE ".$time_field.">="."'".$from."'"." AND ".$time_field."<="."'".$to."'";	
	}


	$select = "SELECT text,".$time_field." FROM tweet ".$where." ORDER BY ".$time_field." desc";

	$main_db_results = db_fetch($select);


	$last_row = pg_fetch_array($main_db_results, 0);
	$first_row = pg_fetch_array($main_db_results, (pg_num_rows($main_db_results)-1));

	//echo $db_array;

	$begin = strtotime($first_row[$time_field]);
	$end = strtotime($last_row[$time_field]);


	$seconds = ($end-$begin);


	$interval = $seconds/23; //graph scale
	$loop_time = $begin; //initiale with begining timestamp
	$intervals=array();


	while(($loop_time)<=$end && pg_num_rows($main_db_results)>0){

		$tweet_count_query = "SELECT ".$time_field." from tweet WHERE ".$time_field." >= "."'".date('Y-m-d H:i:s',$loop_time)."'"." AND ".$time_field." < "."'".date('Y-m-d H:i:s',$loop_time+$interval)."' ORDER BY ".$time_field;		

		$db_results = db_fetch($tweet_count_query);

		$tweets_count=0;
		$tweets_per_second=0;

		if(pg_num_rows($db_results)>0){
			$tweets_count=pg_num_rows($db_results);

			$first_row = pg_fetch_array($db_results, 0);
			$last_row = pg_fetch_array($db_results, (pg_num_rows($db_results)-1));
		
			$t_begin = strtotime($first_row[$time_field]);
			$t_end = strtotime($last_row[$time_field]);
			$tweets_per_second = round(pg_num_rows($db_results)/($t_end-$t_begin),2);
		}
			//$hover = '<div class="morris-hover-row-label">'.(string)date("Y-m-d H:i:s",$loop_time).'</div><div class="morris-hover-point" style="color: #0b62a4">Tweets: '.$tweets_count.'</div>';

			
		$intervals[] = array("timestamp"=>(string)date('Y-m-d H:i:s',$loop_time),
								"tweets"=>$tweets_count,
								"tweets_per_second"=>$tweets_per_second);

		$loop_time = $loop_time+$interval;

	}

	return $intervals;
}
?>