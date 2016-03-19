<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$baseURL = 'http://' . $_SERVER['SERVER_NAME'].$_SERVER['SCRIPT_NAME'];
$baseURL = str_replace('/index.php', '/dashboard', $baseURL);
$data = array();
$monthly_goal = 8000;
$architecture_goal = 6500;
$development_goal = 1500;
$API = array();

class Dashboard extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('session');  
		$this->load->helper('url');  
		$this->load->model('dashboard/Dashboard_model');     
		$this->load->database();       
		date_default_timezone_set('America/La_Paz');
	}
   
	public function index2()
	{
		$this->Dashboard_model->apiRequests($this->session->userdata()['token']);
		//$this->load->view('dashboard/index');
	}
	
	public function refreshToken()
	{
		$client_id = 'b022e25b-8d34-11e5-97d1-352c5b3ae3b8';
		$query = "SELECT * FROM accessing ORDER BY token_id DESC LIMIT 1";
		$get_token = $this->db->query($query);
		$token_refresh = "";
		foreach ($get_token->result() as $row) {
			$token_refresh = $row->refresh_token;
			unset($get_token);
		}
		$service_url = 'https://api.hubapi.com/auth/v1/refresh?refresh_token='.$token_refresh.'&client_id='.$client_id.'&grant_type=refresh_token';		
		$curl = curl_init($service_url);

		curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
	   curl_setopt($curl, CURLOPT_HTTPHEADER, array(
	    'Content-Type: application/x-www-form-urlencoded'
	   ));

		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);		
		$curl_response = curl_exec($curl);
		if ($curl_response === false) {
		   //If the request fail, get the error and the number of the error
		   $error = curl_error($curl);
		   $errorNumber = curl_errno($curl);
		   curl_close($curl);
		   die('An error occurred during the request execution. Additional info: <br>Error: ' .$error.' <br>Error #: '.$errorNumber);
		}
		
		curl_close($curl);
		$decoded = json_decode($curl_response,true);
		if (isset($decoded->response->status) && $decoded->response->status == 'ERROR') {
		    die('error occurred: ' . $decoded->response->errormessage);
		}				

		$access_token = $decoded['access_token'];
		$refresh_token = $decoded['refresh_token'];
		$expires = date('m/d/Y g:i A',$decoded['expires_at']/1000);
		$created_at = date('m/d/Y g:i A');
		$query = 'INSERT INTO accessing (token,refresh_token,created_at,expires) VALUES ("'.$access_token.'","'.$refresh_token.'","'.$created_at.'","'.$expires.'")';
		$this->db->query($query);
		unset($decoded);
	}

	public function index()
	{
		if(isset($_GET['m']))
			$m = $_GET['m'];	
		if(isset($_GET['y']))	
			$y = $_GET['y'];		
	
		//Token created for today
		$today = false;

		//Request OAuth Token properties
		$portalId = '1654671';//'1787115';
		$client_id = 'b022e25b-8d34-11e5-97d1-352c5b3ae3b8';//'1893042f-8899-11e5-97d1-352c5b3ae3b8';		
		$url = $GLOBALS['baseURL'].'/'.$this->uri->segment(1).'/getToken';
		$scope = 'contacts-rw+offline';

		//Check if a token has been already created
		$query = "SELECT * FROM accessing ORDER BY token_id DESC LIMIT 1";
		$get_token = $this->db->query($query);
		$token_date = "";
		$token_end = "";
		$token_refresh = "";
		foreach ($get_token->result() as $row) {
			$token_date = $row->created_at;
			$token_end = $row->expires;
			$token_refresh = $row->refresh_token;
			unset($get_token);
		}

		//Check if the token has been created today and if it doesn't have to be updated
		if(date('m/d/Y') == date('m/d/Y',strtotime($token_date)))
		{
			if(strtotime(date('m/d/Y g:i A')) < strtotime($token_end))
			{
				//echo "Current date: ".date('m/d/Y').". Token creation date: ".date('m/d/Y',strtotime($token_date)).". <br>Current date and time: ".date('m/d/Y g:i A').". Token expiration date and time: ".date('m/d/Y g:i A',strtotime($token_end));
				$today = true;	
			}	
			
			else
			{
				//Begin of the API request
				$service_url = 'https://api.hubapi.com/auth/v1/refresh?refresh_token='.$token_refresh.'&client_id='.$client_id.'&grant_type=refresh_token';		
				$curl = curl_init($service_url);

				curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
			   curl_setopt($curl, CURLOPT_HTTPHEADER, array(
			    'Content-Type: application/x-www-form-urlencoded'
			   ));

				curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);		
				$curl_response = curl_exec($curl);
				if ($curl_response === false) {
				   //If the request fail, get the error and the number of the error
				   $error = curl_error($curl);
				   $errorNumber = curl_errno($curl);
				   curl_close($curl);
				   die('An error occurred during the request execution. Additional info: <br>Error: ' .$error.' <br>Error #: '.$errorNumber);
				}
				
				curl_close($curl);
				$decoded = json_decode($curl_response,true);
				if (isset($decoded->response->status) && $decoded->response->status == 'ERROR') {
				    die('error occurred: ' . $decoded->response->errormessage);
				}				

				$access_token = $decoded['access_token'];
				$refresh_token = $decoded['refresh_token'];
				$expires = date('m/d/Y g:i A',$decoded['expires_at']/1000);
				$created_at = date('m/d/Y g:i A');
				$query = 'INSERT INTO accessing (token,refresh_token,created_at,expires) VALUES ("'.$access_token.'","'.$refresh_token.'","'.$created_at.'","'.$expires.'")';
				unset($decoded);
				if($this->db->query($query))
				{
					$today = true;
				}
			}							
		}

		//URL and redirection action to the function getToken inside this controller
		$service_url = ""; 
		
		//Redirect to create a new token 
		if(!$today)
		{
			$service_url = 'https://app.hubspot.com/auth/authenticate?client_id='.$client_id.'&portalId='.$portalId.'&redirect_uri='.$url.'&scope='.$scope;
			header('Location: '.$service_url);
		}

		//Redirect to the dashboard
		else
		{
			$query="";
			if(isset($m) && isset($y))
			{
				$service_url = $GLOBALS['baseURL'].'/'.$this->uri->segment(1).'views?m='.$m.'&y='.$y;									
			}	
			else
			{
				$service_url = $GLOBALS['baseURL'].'/'.$this->uri->segment(1).'views';
								
			}						
			header("Location: ".$service_url);
		}		
	}

	public function getToken()
	{
		//Headers sent from the HubSpot login page
		$access_token = $_GET['access_token']; //HubSpot token
		$refresh_token = $_GET['refresh_token']; //HubSpot refresh token
		$expires_in = $_GET['expires_in']; //Seconds than the token is valid
		
		$cmpURL = $GLOBALS['baseURL'].'/'.$this->uri->segment(1).'/views';

		//Setting the token into a local session variable
		/*$session_data = array(
			'token' => $access_token			
			);
		$this->session->set_userdata($session_data);*/

		//Adding the token to the database
		$created_at = date('m/d/Y g:i A');
		$expires = date('m/d/Y g:i A', strtotime('+'.($expires_in/3600).'hours', strtotime($created_at)));
		$query = 'INSERT INTO accessing (token,refresh_token,created_at,expires) VALUES ("'.$access_token.'","'.$refresh_token.'","'.$created_at.'","'.$expires.'")';
		
		if($this->db->query($query))
		{
			header('Location: '.$cmpURL);
		}
		else
		{
			echo "Any record was inserted";
		}		
	}

	/*public function getCompanies()
	{
		//Getting the token from the current session
		$query = "SELECT * FROM accessing ORDER BY token_id DESC LIMIT 1";
		$get_token = $this->db->query($query);
		$token= "";
		foreach ($get_token->result() as $row) {
			$token = $row->token;
		}

		//Begin of the API request
		$service_url = 'https://api.hubapi.com/companies/v2/companies/recent/created?access_token='.$token;		
		$curl = curl_init($service_url);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);		
		$curl_response = curl_exec($curl);
		if ($curl_response === false) {
		   //If the request fail, get the error and the number of the error
		   $error = curl_error($curl);
		   $errorNumber = curl_errno($curl);
		   curl_close($curl);
		   die('An error occurred during the request execution. Additional info: <br>Error: ' .$error.' <br>Error #: '.$errorNumber);
		}
		
		curl_close($curl);
		$decoded = json_decode($curl_response,true);
		if (isset($decoded->response->status) && $decoded->response->status == 'ERROR') {
		    die('error occurred: ' . $decoded->response->errormessage);
		}

		$companyinfo = $decoded[0]['properties']['name'];
		print_r($companyinfo);
		
		//Print the variable with a readable format
		//var_export($decoded);
	}*/

	public function getDeals($m=null, $y=null)
	{
		if(isset($m))
		{
			$month = $m;
			$dateObj   = DateTime::createFromFormat('!m', $month);
			$month_name = $dateObj->format('F');			
		}
		else
		{
			$month = date('m'); //e.g. 1
			$month_name = date('F'); //e.g. January
		}
		if(isset($y))
			$year = $y;
		else
			$year = date('Y'); //e.g. 2015

		$query = "SELECT * FROM goals WHERE month=".$month." AND year=".$year;
		$get_goals = $this->db->query($query);
		foreach ($get_goals->result() as $row) {
			$GLOBALS['monthly_goal'] = $row->goal;
			$GLOBALS['architecture_goal'] = $row->architecture;
			$GLOBALS['development_goal'] = $row->developing;
			unset($get_goals);
		}	

		//Current token
		$query = "SELECT * FROM accessing ORDER BY token_id DESC LIMIT 1";
		$get_token = $this->db->query($query);
		$token= "";
		foreach ($get_token->result() as $row) {
			$token = $row->token;
			unset($get_token);
		}					

		//Begin of the API request
		$service_url = 'http://api.hubapi.com/deals/v1/deal/recent/created?access_token='.$token.'&count=10';
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

		$count = 500;
		$total = $decoded['total'];
		$offset = 0;
		unset($decoded);
		$decoded = array();

		while($total>0)
		{
			$service_url = 'http://api.hubapi.com/deals/v1/deal/recent/created?access_token='.$token.'&count='.$count.'&offset='.$offset;
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
			$decoded_aux = json_decode($curl_response,true);
			if (isset($decoded_aux->response->status) && $decoded_aux->response->status == 'ERROR') 
			{
			    die('error occurred: ' . $decoded_aux->response->errormessage);
			}			

			$decoded = array_merge($decoded,$decoded_aux['results']);			
			$total = $total-$count;
			$offset+=$count;
			if($total<=$count)
				$count = $total;	
			unset($decoded_aux);	
		}
		

		$deals = array();
		$finished = array();
		$paid = array();
		$architecture = array();
		$developing = array();

		$cd = 0; //Aux counter to the previous array

		for($i=0;$i<count($decoded);$i++)
		{			
			$dealstage = $decoded[$i]['properties']['dealstage']['value'];
			if(isset($decoded[$i]['properties']['closedate']['value']))
			{
				$closedate = $decoded[$i]['properties']['closedate']['value'];
			}		

			//Filtering the deals by stage and close date month
			if($dealstage=='closedwon' || $dealstage=='finished' || $dealstage == 'contractpayed')
			{				
				if(isset($closedate) && $month==date('m',$closedate/1000) && $year==date('Y',$closedate/1000))
				{					
					//Putting the results into 'deals' array
					$deals[$cd]=$decoded[$i]['properties'];		
					$cd++;			
				}							
			}			
		}
		$cd=0;
		for($i=0;$i<count($decoded);$i++)
		{			
			$dealstage = $decoded[$i]['properties']['dealstage']['value'];
			if(isset($decoded[$i]['properties']['finished_project_date']['value']))
			{
				$finishdate = $decoded[$i]['properties']['finished_project_date']['value'];
			}
			//Filtering the deals by stage and close date month
			if($dealstage=='finished' || $dealstage == 'contractpayed')
			{
				if(isset($finishdate) && $month==date('m',$finishdate/1000) && $year==date('Y',$closedate/1000))
				{
					//Putting the results into 'deals' array
					$finished[$cd]=$decoded[$i]['properties'];		
					$cd++;			
				}							
			}			
		}
		$cd=0;
		for($i=0;$i<count($decoded);$i++)
		{			
			$dealstage = $decoded[$i]['properties']['dealstage']['value'];
			if(isset($decoded[$i]['properties']['project_payment_date']['value']))
			{
				$paymentdate = $decoded[$i]['properties']['project_payment_date']['value'];
			}
			//Filtering the deals by stage and close date month
			if($dealstage == 'contractpayed')
			{
				if(isset($paymentdate) && $month==date('m',$paymentdate/1000) && $year==date('Y',$paymentdate/1000))
				{
					//Putting the results into 'deals' array
					$paid[$cd]=$decoded[$i]['properties'];		
					$cd++;			
				}							
			}			
		}

		$cd=0;
		for($i=0;$i<count($decoded);$i++)
		{			
			$dealstage = $decoded[$i]['properties']['dealstage']['value'];
			if(isset($decoded[$i]['properties']['dealtype']['value']))
				$dealtype = $decoded[$i]['properties']['dealtype']['value'];
			if(isset($decoded[$i]['properties']['finished_project_date']['value']))
			{
				$finishdate = $decoded[$i]['properties']['finished_project_date']['value'];
			}
			//Filtering the deals by stage and close date month
			if(($dealstage=='finished' || $dealstage == 'contractpayed') && $dealtype == "Architecture")
			{
				if(isset($finishdate) && $month==date('m',$finishdate/1000) && $year==date('Y',$finishdate/1000))
				{
					//Putting the results into 'deals' array
					$architecture[$cd]=$decoded[$i]['properties'];		
					$cd++;			
				}							
			}			
		}
		
		

		$cd=0;
		for($i=0;$i<count($decoded);$i++)
		{			
			$dealstage = $decoded[$i]['properties']['dealstage']['value'];
			if(isset($decoded[$i]['properties']['dealtype']['value']))
				$dealtype = $decoded[$i]['properties']['dealtype']['value'];
			if(isset($decoded[$i]['properties']['project_payment_date']['value']))
			{
				$finishdate = $decoded[$i]['properties']['finished_project_date']['value'];
			}
			//Filtering the deals by stage and close date month
			if(($dealstage=='finished' || $dealstage == 'contractpayed') && ($dealtype == "Graphic Design" || $dealtype == "Web and mobile"))
			{
				if(isset($finishdate) && $month==date('m',$finishdate/1000) && $year==date('Y',$finishdate/1000))
				{
					//Putting the results into 'deals' array
					$developing[$cd]=$decoded[$i]['properties'];		
					$cd++;			
				}							
			}			
		}

		unset($decoded);

		function monthAdvance($deals_array,$month,$year,$month_name)
		{
			//Array than will store all the results
			$output = array();
			//Month information
			if($year != date('Y') || $month != date('m'))
			{
				$days_in_month = cal_days_in_month(CAL_GREGORIAN, $month, $year);
				$current_day = $days_in_month;
			}
			else
			{	
				$days_in_month = date('t'); //The amount of days in the month e.g. January has 31 days
				$current_day = date('j'); //The numeric value of the current date of the month e.g. January 14th = 14
			}		

			//Values of the monthly goal and the amount earned
			
			$total_amount_earned = 0;

			//Calculate the percentage of the month
			$calc = round(($current_day/$days_in_month)*100,0,PHP_ROUND_HALF_UP);
			
			$output['month'] = $calc;
			unset($calc);

			//Get the close date of each deal and calculate the earnings of the current month
			for ($i=0; $i < count($deals_array) ; $i++) 
			{				
				if(isset($deals_array[$i]['closedate']) && date('m',$deals_array[$i]['closedate']['value']/1000)==$month && date('Y',$deals_array[$i]['closedate']['value']/1000)==$year)
				{					
					//$close_date = date('m/d/Y',$deals_array[$i]['closedate']['value']/1000); //Aux to get the close date of each deal
					$total_amount_earned+=$deals_array[$i]['amount']['value'];
				} 
			}

			//Calculate the percentage achieved of the current goal
			$goal_percent = round(($total_amount_earned/$GLOBALS['monthly_goal'])*100,2,PHP_ROUND_HALF_UP);

			//Assign the results to the array
			$output['goal'] = $goal_percent;
			$output['name'] = $month_name;

			unset($total_amount_earned);
			unset($goal_percent);

			return $output;
		}
		
		function monthProduction($production_array,$month,$year)
		{
			//Array than will store all the results
			$output = array();

			///Month information
			if($year != date('Y') || $month != date('m'))
			{
				$days_in_month = cal_days_in_month(CAL_GREGORIAN, $month, $year);
				$current_day = $days_in_month;
			}
			else
			{	
				$days_in_month = date('t'); //The amount of days in the month e.g. January has 31 days
				$current_day = date('j'); //The numeric value of the current date of the month e.g. January 14th = 14
			}		

			//Values of the monthly goal and the amount earned
			$total_amount_earned = 0;

			//Get the close date of each deal and calculate the earnings of the current month
			for ($i=0; $i < count($production_array) ; $i++) 
			{				
				if(isset($production_array[$i]['finished_project_date']) && date('m',$production_array[$i]['finished_project_date']['value']/1000)==$month && date('Y',$production_array[$i]['finished_project_date']['value']/1000)==$year)
				{					
					//$close_date = date('m/d/Y',$deals_array[$i]['closedate']['value']/1000); //Aux to get the close date of each deal
					$total_amount_earned+=$production_array[$i]['amount']['value'];
				} 
			}

			//Calculate the percentage achieved of the current goal
			$goal_percent = round(($total_amount_earned/$GLOBALS['monthly_goal'])*100,2,PHP_ROUND_HALF_UP);

			//Assign the results to the array
			$output['production'] = $goal_percent;

			unset($total_amount_earned);
			unset($goal_percent);

			return $output;
		}

		function monthPayment($payment_array,$month,$year)
		{
			//Array than will store all the results
			$output = array();

			//Month information
			if($year != date('Y') || $month != date('m'))
			{
				$days_in_month = cal_days_in_month(CAL_GREGORIAN, $month, $year);
				$current_day = $days_in_month;
			}
			else
			{	
				$days_in_month = date('t'); //The amount of days in the month e.g. January has 31 days
				$current_day = date('j'); //The numeric value of the current date of the month e.g. January 14th = 14
			}		

			//Values of the monthly goal and the amount earned
			$total_amount_earned = 0;

			//Get the close date of each deal and calculate the earnings of the current month
			for ($i=0; $i < count($payment_array) ; $i++) 
			{				
				if(isset($payment_array[$i]['project_payment_date']) && date('m',$payment_array[$i]['project_payment_date']['value']/1000)==$month && date('Y',$payment_array[$i]['project_payment_date']['value']/1000)==$year)
				{					
					//$close_date = date('m/d/Y',$deals_array[$i]['project_payment_date']['value']/1000); //Aux to get the close date of each deal
					$total_amount_earned+=$payment_array[$i]['amount']['value'];
				} 
			}

			//Calculate the percentage achieved of the current goal
			$goal_percent = round(($total_amount_earned/$GLOBALS['monthly_goal'])*100,2,PHP_ROUND_HALF_UP);

			//Assign the results to the array
			$output['payment'] = $goal_percent;

			unset($total_amount_earned);
			unset($goal_percent);

			return $output;
		}

		function monthArchitecture($architecture_array,$month,$year)
		{
			//Array than will store all the results
			$output = array();

			//Month information
			if($year != date('Y') || $month != date('m'))
			{
				$days_in_month = cal_days_in_month(CAL_GREGORIAN, $month, $year);
				$current_day = $days_in_month;
			}
			else
			{	
				$days_in_month = date('t'); //The amount of days in the month e.g. January has 31 days
				$current_day = date('j'); //The numeric value of the current date of the month e.g. January 14th = 14
			}		

			//Values of the monthly goal and the amount earned
			$total_amount_earned = 0;

			//Get the close date of each deal and calculate the earnings of the current month
			for ($i=0; $i < count($architecture_array) ; $i++) 
			{				
				if(isset($architecture_array[$i]['finished_project_date']) && date('m',$architecture_array[$i]['finished_project_date']['value']/1000)==$month && date('Y',$architecture_array[$i]['finished_project_date']['value']/1000)==$year)
				{					
					//$close_date = date('m/d/Y',$deals_array[$i]['project_payment_date']['value']/1000); //Aux to get the close date of each deal					
					$total_amount_earned+=$architecture_array[$i]['amount']['value'];
					/*print_r($architecture_array[$i]['dealname']['value']);
					echo"<br>";*/
				} 
			}

			//Calculate the percentage achieved of the current goal
			$goal_percent = round(($total_amount_earned/$GLOBALS['architecture_goal'])*100,2,PHP_ROUND_HALF_UP);

			//Assign the results to the array
			$output['payment'] = $goal_percent;

			unset($total_amount_earned);
			unset($goal_percent);

			return $output;
		}

		function monthDeveloping($developing_array,$month,$year)
		{
			//Array than will store all the results
			$output = array();

			//Month information
			if($year != date('Y') || $month != date('m'))
			{
				$days_in_month = cal_days_in_month(CAL_GREGORIAN, $month, $year);
				$current_day = $days_in_month;
			}
			else
			{	
				$days_in_month = date('t'); //The amount of days in the month e.g. January has 31 days
				$current_day = date('j'); //The numeric value of the current date of the month e.g. January 14th = 14
			}		

			//Values of the monthly goal and the amount earned
			$total_amount_earned = 0;

			//Get the close date of each deal and calculate the earnings of the current month
			for ($i=0; $i < count($developing_array) ; $i++) 
			{				
				if(isset($developing_array[$i]['finished_project_date']) && date('m',$developing_array[$i]['finished_project_date']['value']/1000)==$month && date('Y',$developing_array[$i]['finished_project_date']['value']/1000)==$year)
				{					
					//$close_date = date('m/d/Y',$deals_array[$i]['project_payment_date']['value']/1000); //Aux to get the close date of each deal
					$total_amount_earned+=$developing_array[$i]['amount']['value'];
				} 
			}

			//Calculate the percentage achieved of the current goal
			$goal_percent = round(($total_amount_earned/$GLOBALS['development_goal'])*100,2,PHP_ROUND_HALF_UP);

			//Assign the results to the array
			$output['payment'] = $goal_percent;

			unset($total_amount_earned);
			unset($goal_percent);

			return $output;
		}

		$GLOBALS['data']['monthAdvance'] = monthAdvance($deals,$month,$year,$month_name);
		$GLOBALS['data']['monthProduction'] = monthProduction($finished,$month,$year);
		$GLOBALS['data']['monthPayment'] = monthPayment($paid,$month,$year);
		$GLOBALS['data']['monthArchitecture'] = monthArchitecture($architecture,$month,$year);
		$GLOBALS['data']['monthDeveloping'] = monthDeveloping($developing,$month,$year);

		unset($deals);
		unset($finished);
		unset($paid);
		unset($architecture);
		unset($developing);
		
		/*$mem = memory_get_usage()/1048576;
		echo "<h1 style='color:white'>Circles: ".$mem." Mb</h1>";*/

		$this->load->view('dashboard/monthAdvance',$GLOBALS['data']);
	}	

	public function dealsPerMonth($m=null, $y=null)
	{
		if(isset($m))
		{
			$month = $m;
			$dateObj   = DateTime::createFromFormat('!m', $month);
			$month_name = $dateObj->format('F');
		}
		else
		{
			$month = date('m'); //e.g. 1
			$month_name = date('F'); //e.g. January
		}
		if(isset($y))
			$year = $y;
		else
			$year = date('Y'); //e.g. 2015

		if($year != date('Y') || $month != date('m'))
			$days_in_month = cal_days_in_month(CAL_GREGORIAN, $month, $year);
		else
			$days_in_month = date('t'); //The amount of days in the month e.g. January has 31 days
			
		//Current token
		$query = "SELECT * FROM accessing ORDER BY token_id DESC LIMIT 1";
		$get_token = $this->db->query($query);
		$token= "";
		foreach ($get_token->result() as $row) {
			$token = $row->token;
			unset($get_token);
		}

		//Begin of the API request
		$service_url = 'http://api.hubapi.com/deals/v1/deal/recent/created?access_token='.$token.'&count=10';
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

		$count = 500;
		$total = $decoded['total'];
		$offset = 0;
		unset($decoded);
		$decoded = array();

		while($total>0)
		{
			$service_url = 'http://api.hubapi.com/deals/v1/deal/recent/created?access_token='.$token.'&count='.$count.'&offset='.$offset;
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
			$decoded_aux = json_decode($curl_response,true);
			if (isset($decoded_aux->response->status) && $decoded_aux->response->status == 'ERROR') 
			{
			    die('error occurred: ' . $decoded_aux->response->errormessage);
			}			

			$decoded = array_merge($decoded,$decoded_aux['results']);			
			$total = $total-$count;
			$offset+=$count;
			if($total<=$count)
				$count = $total;		
			unset($decoded_aux);
		}

		$created = array();

		//Array than will store all the deals filtered by stage (closed won, finished & contract payed)
		$cr = 0; //Aux counter to the previous array

		for($i=0;$i<count($decoded);$i++)
		{			
			if(isset($decoded[$i]['properties']['createdate']['value']))
			{
				$createdate = $decoded[$i]['properties']['createdate']['value'];
			}
			//Filtering the deals by stage and close date month
			if(isset($createdate) && $month==date('m',$createdate/1000) && $year==date('Y',$createdate/1000))
			{
				//Putting the results into 'deals' array
				$created[$cr]=$decoded[$i]['properties'];		
				$cr++;			
			}				
		}		

		unset($decoded);

		function dealsPerDay($deals_array,$month,$year)
		{
			//Array than will store all the results
			$output = array();

			///Month information
			if($year != date('Y') || $month != date('m'))
			{
				$days_in_month = cal_days_in_month(CAL_GREGORIAN, $month, $year);
				$current_day = $days_in_month;
			}
			else
			{	
				$days_in_month = date('t'); //The amount of days in the month e.g. January has 31 days
				$current_day = date('j'); //The numeric value of the current date of the month e.g. January 14th = 14
			}			

			for ($i=1; $i <= $days_in_month; $i++) { 
				$output[$i]=0;
			}			

			for ($j=1; $j <= $days_in_month ; $j++)	
			{
				for ($i=0; $i < count($deals_array); $i++) 
				{			
					if(date('j',$deals_array[$i]['createdate']['value']/1000)==$j)	 
					{						
						$output[$j]++;
					}
				}
			}
			return $output;
		}

		$data['dealsPerDay'] = dealsPerDay($created,$month,$year);
		$data['daysInMonth'] = $days_in_month;

		unset($created);

		/*$mem = memory_get_usage()/1048576;
		echo "<h1 style='color:white'>Bars: ".$mem." Mb</h1>";*/

		$this->load->view('dashboard/test-linechart',$data);
	}

	public function earningsChart($m=null, $y=null)
	{
		if(isset($m))
		{
			$month = $m;
			$dateObj   = DateTime::createFromFormat('!m', $month);
			$month_name = $dateObj->format('F');
		}
		else
		{
				$month = date('m'); //e.g. 1
				$month_name = date('F'); //e.g. January
		}
		if(isset($y))
			$year = $y;
		else
			$year = date('Y'); //e.g. 2015

		if($year != date('Y') || $month != date('m'))
			$days_in_month = cal_days_in_month(CAL_GREGORIAN, $month, $year);
		else
			$days_in_month = date('t'); //The amount of days in the month e.g. January has 31 days
			
		//Current session token
		$query = "SELECT * FROM accessing ORDER BY token_id DESC LIMIT 1";
		$get_token = $this->db->query($query);
		$token= "";
		foreach ($get_token->result() as $row) {
			$token = $row->token;
			unset($get_token);
		}

		//Begin of the API request
		$service_url = 'http://api.hubapi.com/deals/v1/deal/recent/created?access_token='.$token.'&count=10';
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

		$count = 500;
		$total = $decoded['total'];
		unset($decoded);
		$offset = 0;
		$decoded = array();

		while($total>0)
		{
			$service_url = 'http://api.hubapi.com/deals/v1/deal/recent/created?access_token='.$token.'&count='.$count.'&offset='.$offset;
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
			$decoded_aux = json_decode($curl_response,true);
			if (isset($decoded_aux->response->status) && $decoded_aux->response->status == 'ERROR') 
			{
			    die('error occurred: ' . $decoded_aux->response->errormessage);
			}			

			$decoded = array_merge($decoded,$decoded_aux['results']);			
			$total = $total-$count;
			$offset+=$count;
			if($total<=$count)
				$count = $total;
			unset($decoded_aux);		
		}

		$deals = array();
		$finished = array();
		$paid = array();

		//Array than will store all the deals filtered by stage (closed won, finished & contract paid)
		$cd = 0; //Aux counter to the previous array

		for($i=0;$i<count($decoded);$i++)
		{			
			$dealstage = $decoded[$i]['properties']['dealstage']['value'];
			if(isset($decoded[$i]['properties']['closedate']['value']))
			{
				$closedate = $decoded[$i]['properties']['closedate']['value'];
			}
			//Filtering the deals by stage and close date month
			if($dealstage=='closedwon' || $dealstage=='finished' || $dealstage == 'contractpayed')
			{
				if(isset($closedate) && $month==date('m',$closedate/1000) && $year==date('Y',$closedate/1000))
				{
					//Putting the results into 'deals' array
					$deals[$cd]=$decoded[$i]['properties'];		
					$cd++;			
				}							
			}			
		}
		$cd=0;
		for($i=0;$i<count($decoded);$i++)
		{			
			$dealstage = $decoded[$i]['properties']['dealstage']['value'];
			if(isset($decoded[$i]['properties']['finished_project_date']['value']))
			{
				$finishdate = $decoded[$i]['properties']['finished_project_date']['value'];
			}
			//Filtering the deals by stage and close date month
			if($dealstage=='finished' || $dealstage == 'contractpayed')
			{
				if(isset($finishdate) && $month==date('m',$finishdate/1000) && $year==date('Y',$finishdate/1000))
				{
					//Putting the results into 'deals' array
					$finished[$cd]=$decoded[$i]['properties'];		
					$cd++;			
				}							
			}			
		}
		$cd=0;
		for($i=0;$i<count($decoded);$i++)
		{			
			$dealstage = $decoded[$i]['properties']['dealstage']['value'];
			if(isset($decoded[$i]['properties']['project_payment_date']['value']))
			{
				$paymentdate = $decoded[$i]['properties']['project_payment_date']['value'];
			}
			//Filtering the deals by stage and close date month
			if($dealstage == 'contractpayed')
			{
				if(isset($paymentdate) && $month==date('m',$paymentdate/1000) && $year==date('Y',$paymentdate/1000))
				{
					//Putting the results into 'deals' array
					$paid[$cd]=$decoded[$i]['properties'];		
					$cd++;			
				}							
			}			
		}

		unset($decoded);

		function totalDeals($total_deals,$month,$year)
		{
			//Array than will store all the results
			$output = array();

			///Month information
			if($year != date('Y') || $month != date('m'))
			{
				$days_in_month = cal_days_in_month(CAL_GREGORIAN, $month, $year);
				$current_day = $days_in_month;
			}
			else
			{	
				$days_in_month = date('t'); //The amount of days in the month e.g. January has 31 days
				$current_day = date('j'); //The numeric value of the current date of the month e.g. January 14th = 14
			}		

			for ($i=1; $i <= $days_in_month; $i++) { 
				$output[$i]=0;
			}			

			for ($j=1; $j <= $days_in_month ; $j++)	
			{
				for ($i=0; $i < count($total_deals); $i++) 
				{			
					if(isset($total_deals[$i]['closedate']) && date('j',$total_deals[$i]['closedate']['value']/1000)==$j)	 
					{						
						$output[$j]++;
					}
				}
			}

			return $output;
		}

		function finishedDeals($finished_deals,$month,$year)
		{
			//Array than will store all the results
			$output = array();

			///Month information
			if($year != date('Y') || $month != date('m'))
			{
				$days_in_month = cal_days_in_month(CAL_GREGORIAN, $month, $year);
				$current_day = $days_in_month;
			}
			else
			{	
				$days_in_month = date('t'); //The amount of days in the month e.g. January has 31 days
				$current_day = date('j'); //The numeric value of the current date of the month e.g. January 14th = 14
			}		

			for ($i=1; $i <= $days_in_month; $i++) { 
				$output[$i]=0;
			}			

			for ($j=1; $j <= $days_in_month ; $j++)	
			{
				for ($i=0; $i < count($finished_deals); $i++) 
				{			
					if(isset($finished_deals[$i]['finished_project_date']) && date('j',$finished_deals[$i]['finished_project_date']['value']/1000)==$j)	 
					{						
						$output[$j]++;
					}
				}
			}

			return $output;
		}

		function paidDeals($paid_deals,$month,$year)
		{
			//Array than will store all the results
			$output = array();

			///Month information
			if($year != date('Y') || $month != date('m'))
			{
				$days_in_month = cal_days_in_month(CAL_GREGORIAN, $month, $year);
				$current_day = $days_in_month;
			}
			else
			{	
				$days_in_month = date('t'); //The amount of days in the month e.g. January has 31 days
				$current_day = date('j'); //The numeric value of the current date of the month e.g. January 14th = 14
			}		

			for ($i=1; $i <= $days_in_month; $i++) { 
				$output[$i]=0;
			}			

			for ($j=1; $j <= $days_in_month ; $j++)	
			{
				for ($i=0; $i < count($paid_deals); $i++) 
				{			
					if(isset($paid_deals[$i]['project_payment_date']) && date('j',$paid_deals[$i]['project_payment_date']['value']/1000)==$j)	 
					{						
						$output[$j]++;
					}
				}
			}
			return $output;
		}

		$data['totalDeals'] = totalDeals($deals,$month,$year);
		$data['finishedDeals'] = finishedDeals($finished,$month,$year);
		$data['paidDeals'] = paidDeals($paid,$month,$year);
		$data['daysInMonth'] = $days_in_month;

		unset($deals);
		unset($finished);
		unset($paid);

		/*$mem = memory_get_usage()/1048576;
		echo "<h1 style='color:white'>Lines: ".$mem." Mb</h1>";*/

		$this->load->view('dashboard/earningsChart',$data);
	}

	public function views()
	{		
 		if(isset($_GET['m']) && isset($_GET['y']))
		{
			$m = $_GET['m'];	
			$y = $_GET['y'];	
			$data['myMonth'] = $m;
			$data['myYear'] = $y;
			$this->load->view('dashboard/template_view',$data);	
		}
		else
		{			
			$this->load->view('dashboard/template_view');	
		}
	}
	
	public function clock()
	{
		$this->load->view("dashboard/clocks/local");
	}
	public function clockAustralia()
	{
		$this->load->view("dashboard/clocks/australia");	
	}
	public function clockNY()
	{
		$this->load->view("dashboard/clocks/newyork");	
	}

	public function clockBelgium()
	{
		$this->load->view("dashboard/clocks/brussels");		
	}
	public function clockIndia()
	{
		$this->load->view("dashboard/clocks/calcuta");		
	}

	public function memory()
	{
		echo memory_get_usage();
	}
}
?>