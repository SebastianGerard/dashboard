<?php
class Dashboard_model extends CI_Model {
	public function __construct()
	{
		parent::__construct();
	}

	public function apiRequests($session_token)
	{
		//Current session token
		$token = $session_token;

		//Begin of the API request
		$service_url = 'http://api.hubapi.com/deals/v1/deal/recent/created?access_token='.$token.'&count=500';
		$curl = curl_init($service_url);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);		
		$curl_response = curl_exec($curl);
		if ($curl_response === false) 
		{
			//If the request fail, get the error and the number of the error
		   $error = curl_error($curl);
		   $errorNumber = curl_errno($curl);
		   curl_close($curl);
		   die('An error occurred during the request execution. Additional info: <br>Error: ' .$error.' <br>Error #: '.$errorNumber);
		}		
		curl_close($curl);

		//Putting the response into an array
		$decoded = json_decode($curl_response,true);
		if (isset($decoded->response->status) && $decoded->response->status == 'ERROR') 
		{
		    die('error occurred: ' . $decoded->response->errormessage);
		}

		print_r($decoded);
	}

}
?>