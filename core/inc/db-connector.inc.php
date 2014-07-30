<?php 

function get_db(){
		// database constants
		$table = '';
		//$hostname = "localhost";
		$hostname = "dtp-24.sncs.abdn.ac.uk";
		$port = '5432';
		$user = "postgres";
		$password = "5L1ght1y";
		//$database = "tweetdesk";
		$database = "tmi";
		
		$db = pg_connect('host='.$hostname.' port='.$port.' dbname='.$database.' user='.$user.' password='.$password)
		or 0; //die('Could not connect to database');
		
		return $db;

	}

function get_memcache(){
	$memcache = new Memcached();

	//for memcached
	$memcache->addServer("127.0.0.1", 11211) or die ("Could not connect");

	//for memcache
	//$memcache->connect("127.0.0.1", '11211') or die ("Could not connect");

	return $memcache;
}

function db_fetch_cached($query){

	$memcache = get_memcache();

	$key = md5($query);
	$retrieveData = $memcache->get($key);
	
	//var_dump($retrieveData);
	if($retrieveData){
		//echo 'found it in cache';
		//var_dump($retrieveData);
		return $retrieveData;
	}
	else{
				
//		echo 'did not find ';
		$db_data = db_fetch($query);

		/*for($ri = 0; $ri < pg_num_rows($db_data); $ri++) {
			$row = pg_fetch_array($db_data, $ri);
			 echo $row['text'];
		}*/
		
		$retrieveData = $memcache->replace($key, $db_data); 
		if( $retrieveData == false )  
			$memcache->set($key, pg_fetch_all($db_data),3600) or die ("Failed to save data at the server");
		
		$retrieveData = $memcache->get($key);

		return $retrieveData;
	}


}
	function db_fetch($query){

	$db = get_db();
	//echo "<br/><br/>query in db_fetch: ".$query;
	//exit();

//pg_query
	$result = pg_query($db, $query);
	//$result = pg_exec($db, $query);
	// query to get data from database

// 	$rows = 

	//$field = pg_num_fields($result);
	//$returnArray = pg_copy_to($db, $table);

/*		while($row=pg_fetch_array($result)){	
			$returnArray[]=$row;
			
		}
	
	*/
	pg_close();
	return $result;
	}


	//get available records in database
	function db_count(){
		$db = get_db();
		if($db ==0)
			return 'DB Connection Error!';

		//$result = pg_query($db, 'SELECT count (id) from tweet');
		$result = db_fetch_cached('SELECT count (id) from tweet');
		//return pg_fetch_result($result,0);
		return $result[0]['count'];
	}


	function set_cache_data($data, $ky){
		$memcache = get_memcache();

		$key = md5($ky);
		$retrieveData = $memcache->get($key);
		
		if($retrieveData)
			$retrieveData = $memcache->replace($key, $data);
		else
			$memcache->set($key,data,1) or die ("Failed to save data at the server");

	}

	function get_cache_data($ky){
		$memcache = get_memcache();

		$key = md5($ky);
		$retrieveData = $memcache->get($key);
		return $retrieveData;
	}

?>