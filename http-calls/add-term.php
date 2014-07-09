<?php include('../core/init.core.php');?>
<?php
header("Content-Type: application/json");
$term_name = $_GET['term_name'];
$term_type = $_GET['term_type'];

//Declare the errors array:
$errors = array();

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
	echo $errors;
?>