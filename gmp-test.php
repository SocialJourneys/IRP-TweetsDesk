<?php include('core/init.core.php');?>
<?php


//$a = gmp_init(123456);
//echo $a;

	$query = "SELECT count(id) from tweet";

	$memcache = new Memcached();

	$memcache->addServer("127.0.0.1", 11211) or die ("Could not connect");

	//$memcache->connect("127.0.0.1", '11211') or die ("Could not connect");

	//echo 'hello';
	//var_dump($memcache->getStats());
	//echo 'hello';	//echo $memcache->getServerStats();
	

	$key = md5($query);
	$retrieveData = $memcache->get($key);
	
	var_dump($retrieveData);
	if($retrieveData){
		echo 'found it in cache';
		//var_dump($retrieveData);
	}
	else{
				
		echo 'did not find ';
		$db_data = db_fetch($query);
		//$memcache->set($key, $db_data,time() + 86400);
		//var_dump($db_data);

		/*for($ri = 0; $ri < pg_num_rows($db_data); $ri++) {
			$row = pg_fetch_array($db_data, $ri);
			 echo $row['text'];
		}*/
		
		//$retrieveData = $memcache->replace($key, $db_data); 
		//if( $result == false )  
		$memcache->set($key, pg_fetch_all($db_data),3600) or die ("Failed to save data at the server");
		

//		$memcache->set($key, $db_data,TRUE,300);
		//$memcache->replace($key, $db_data,300);
	}
	
	//echo $memcache->getServerStats('localhost','11211');

	//$memcache>flush();
?>