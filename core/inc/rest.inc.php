<?php
	
	/**
	* The REST GET call function.
	* @param  $url      - String   - The URL of the call.
	*		  $headers  - String[] - The array of headers.
	* @return $response - JSON obj - The response as a JSON object.
	*/
	function rest_get($url, $headers){
		$handle = curl_init();

		curl_setopt($handle, CURLOPT_URL, $url);
		curl_setopt($handle, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($handle, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, false);

		$response = curl_exec($handle);
		$code = curl_getinfo($handle, CURLINFO_HTTP_CODE);
		curl_close($handle);
		return $response;
	}

	/**
	* The REST POST call function.
	* @param  $url      - String   - The URL of the call.
	*		  $headers  - String[] - The string array of headers.
	*         $data     - JSON obj - The input data as a JSON object.
	* @return $response - JSON obj - The response as a JSON object.
	*/
	function rest_post($url, $data, $headers){
		$handle = curl_init();

		curl_setopt($handle, CURLOPT_URL, $url);
		curl_setopt($handle, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($handle, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($handle, CURLOPT_POST, true);
		curl_setopt($handle, CURLOPT_POSTFIELDS, $data);

		$response = curl_exec($handle);

		if(curl_errno($handle))
		{
		    echo 'curl error:' . curl_error($handle);
		}

		$code = curl_getinfo($handle, CURLINFO_HTTP_CODE);
		curl_close($handle);
		return $response;
	}

	/**
	* The REST POST call function, but instead of returning a JSON, returns a status code.
	* @param  $url      - String   - The URL of the call.
	*		  $headers  - String[] - The string array of headers.
	*         $data     - JSON obj - The input data as a JSON object.
	* @return $code - int - The response as a JSON object.
	*/
	function rest_post_status($url, $data, $headers){
		$handle = curl_init();

		curl_setopt($handle, CURLOPT_URL, $url);
		curl_setopt($handle, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($handle, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($handle, CURLOPT_POST, true);
		curl_setopt($handle, CURLOPT_POSTFIELDS, $data);

		$response = curl_exec($handle);
		$code = curl_getinfo($handle, CURLINFO_HTTP_CODE);
		curl_close($handle);
		return $code;
	}

	/**
	* The REST PUT call function.
	* @param  $url      - String   - The URL of the call.
	*		  $headers  - String[] - The string array of headers.
	*         $data     - JSON obj - The input data as a JSON object.
	* @return $response - JSON obj - The response as a JSON object.
	*/
	function rest_put($url, $data, $headers){
		$handle = curl_init();

		curl_setopt($handle, CURLOPT_URL, $url);
		curl_setopt($handle, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($handle, CURLOPT_CUSTOMREQUEST, "PUT");
		curl_setopt($handle, CURLOPT_HEADER, false);
		curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($handle, CURLOPT_POSTFIELDS, $data);

		$response = curl_exec($handle);

		$code = curl_getinfo($handle,CURLINFO_HTTP_CODE);
		curl_close($handle);
		return $response;
	}

	/**
	* The REST DELETE call function.
	* @param  $url      - String   - The URL of the call.
	*		  $headers  - String[] - The string array of headers.
	* @return $response - JSON obj - The response as a JSON object.
	*/
	function rest_delete($url, $headers){
		$handle = curl_init();

		curl_setopt($handle, CURLOPT_URL, $url);
		curl_setopt($handle, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($handle, CURLOPT_CUSTOMREQUEST, "DELETE");
		curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);

		$response = curl_exec($handle);
		$code = curl_getinfo($handle, CURLINFO_HTTP_CODE);
		curl_close($handle);
		return $response;
	}

?>