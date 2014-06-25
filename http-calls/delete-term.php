<?php include('../core/init.core.php');?>
<?php
$term_id = $_GET['term_id'];

//Declare the errors array:
$errors = array();

//Create the url
$url 	 = APIURL."/tracklist/".$term_id;

//Create the headers:
$headers = array("Content-Type: application/json","Authorization: ".$_SESSION['account']['apiKey']);

//Create the REST call:
$response  = rest_delete($url,$headers);

$userobj = json_decode($response);

if($status && $status!=200){
	$errors[] = $userobj->{'errors'}[0];
	$errors[] = $userobj->{'moreInfo'};
}

if(empty($errors)){
	echo 'success';
	//header("Location: ../tracklist.php?delete=YES");	//echo $response;
//	die();
}
else{
	//header("Location: ../tracklist.php?delete=NO");
	echo 'failure';
	//echo $errors;
//die();
}
?>