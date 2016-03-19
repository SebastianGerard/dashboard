<?php
//$this->load->view('dashboard/monthAdvance');
?>
<title>DashboardTV</title>
<link href='https://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet' type='text/css'>
<link rel="stylesheet" type="text/css" href="css/widget.css">
<link href='http://fonts.googleapis.com/css?family=Orbitron' rel='stylesheet' type='text/css'>
<link href='http://fonts.googleapis.com/css?family=Roboto:400,100,300,500,700' rel='stylesheet' type='text/css'>
<link href="css/clocks.css" rel="stylesheet" type="text/css">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script type="text/javascript" src="js/circles/dist/circle-progress.js"></script>
<script type="text/javascript" src="js/Chart.js"></script>
<script type="text/javascript" src="js/clocks.js"></script>


<header>
	<div class="logo">
		<img src="img/logo.png">
	</div>
</header>

<div id="data">
</div>
<div id="data2">
</div>
<div id="data3">
</div>

<div id="clocks">
	<div id="local" class="clock"></div>
	<div id="aus" class="clock"></div>
	<div id="usa" class="clock"></div>
	<div id="belgium" class="clock"></div>
	<div id="india" class="clock"></div>
</div>

<div class="videoplayer">
	<iframe width="500" height="50" src="https://www.youtube.com/embed/videoseries?list=PLH30k6CwlcgK8C-LET6_ZrAWwYGLqT8R-&autoplay=1&controls=0&loop=1&index=<?php echo mt_rand(0,130);?>" frameborder="0" >
	</iframe>
</div>



<script type="text/javascript">
$(document).ready(function(){

	function loadMonthProgress(){
		$.ajax({
			url: 'index.php/dashboard/getDeals',
			type: "POST", 
			success: function(result){
			   $("#data").html(result);
			}
		});
	}

	function loadMonthDeals(){
		$.ajax({
			url: 'index.php/dashboard/dealsPerMonth',
			type: "POST", 
			success: function(result){
			   $("#data2").html(result);
			}
		});
	}

	function loadEarningsChart(){
		$.ajax({
			url: 'index.php/dashboard/earningsChart',
			type: "POST", 
			success: function(result){
			   $("#data3").html(result);
			}
		});
	}
	
	
	function clockLocal(){
		$.ajax({
			url: 'index.php/dashboard/clock',
			type: "POST", 
			success: function(result){
			   $("#local").html(result);
			}
		});
	}

	function clockAustralia(){
		$.ajax({
			url: 'index.php/dashboard/clockAustralia',
			type: "POST", 
			success: function(result){
			   $("#aus").html(result);
			}
		});
	}

	function clockNY(){
		$.ajax({
			url: 'index.php/dashboard/clockNY',
			type: "POST", 
			success: function(result){
			   $("#usa").html(result);
			}
		});
	}

	function clockBL(){
		$.ajax({
			url: 'index.php/dashboard/clockBelgium',
			type: "POST", 
			success: function(result){
			   $("#belgium").html(result);
			}
		});
	}
	
	function clockIndia(){
		$.ajax({
			url: 'index.php/dashboard/clockIndia',
			type: "POST", 
			success: function(result){
			   $("#india").html(result);
			}
		});
	}


	loadMonthProgress();
	loadMonthDeals();
	loadEarningsChart()
	
	clockLocal();
	clockAustralia();
	clockNY();
	clockBL();
	clockIndia();

	setInterval(loadMonthProgress,80000);
	setInterval(loadMonthDeals,50000);
	setInterval(loadEarningsChart,60000);
});
</script>