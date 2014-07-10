<?php include('../core/init.core.php');?>
<?php

$from = $_GET['from'];
$to = $_GET['to'];

$tweets_query = $_SESSION['tweets_query'];

if($from || $to){

}
else{
	$from = '2014-02-01 19:56:43';
	$to = '2014-07-01 19:56:43';
}

$ret_array = array("query"=>$tweets_query);
$ret_array = json_encode($ret_array);

$select = "SELECT text,time_stamp,author,original_tweet_id from tweet WHERE time_stamp>= '2014-07-08 19:56:43' LIMIT 10000";

//$db_results = db_fetch($tweets_query);
$db_results = db_fetch($select);
$db_array = array();

$timestamps=array();

//60=1minute
//60*60=1hour (3600)
//60*60*24=1day (86400)
//60*60*24*10=10days (864000)

for($ri = 0; $ri < pg_num_rows($db_results); $ri++) {

    $row = pg_fetch_array($db_results, $ri);

    $db_array[$ri]=array('author'=>$row['author']);
    $db_array[$ri]=array('text'=>$row['text']);
    $db_array[$ri]=array('time_stamp'=>$row['time_stamp']);
    $timestamps[]=$row['time_stamp'];
}

$begin = strtotime($timestamps[0]);
$end = strtotime($timestamps[count($timestamps)-1]);

echo 'count: '. count($timestamps);
echo '<br/>first row date: '.($timestamps[0]);
echo '<br/>last row date: '.($timestamps[count($timestamps)-1]);
echo '<br/>time difference in seconds : '.($end-$begin);
echo '<br/>time difference in hours : '.($end-$begin)/3600;
echo '<br/>time difference in days : '.($end-$begin)/86400;

die();

$users = array();
$tweets = array();


//echo $_SESSION['tweets_query'];

//Declare the errors array:
/*$errors = array();

//Create the url
$url 	 = APIURL."/tracklist";

//Create the headers:
$headers = array("Content-Type: application/json","Authorization: ".$_SESSION['account']['apiKey']);

$dataArr = array(
	"name"=>$term_name,
	"type"=>$term_type
	);

$data 	 = json_encode($dataArr);

//Create the REST call:
$response  = rest_post($url,$data,$headers);

$userobj = json_decode($response);

if($status && $status!=201){
	$errors[] = $userobj->{'errors'}[0];
	$errors[] = $userobj->{'moreInfo'};
}
if(empty($errors)){
	http_response_code(200);
	echo $response;
}
else
	echo $errors;*/
?>