<div class="graph">
	<div class="line-content">
		<p>Marketing deals</p>
		<canvas id="canvas"></canvas>
	</div>
</div>

<script>
var lineChartData = {
	labels : [<?php for ($i=1; $i <=$daysInMonth ; $i++) {if($i==$daysInMonth) echo $i;else echo $i.",";} ?>],
	datasets : [
		{
			label: "My First dataset",
			fillColor : "rgba(0,255,204,0.2)",
			strokeColor : "rgba(0,255,204,1)",
			pointColor : "rgba(1,204,159,1)",
			pointStrokeColor : "#293B52",
			pointHighlightFill : "rgba(255,255,255,1)",
			pointHighlightStroke : "rgba(220,220,220,1)",
			data : [<?php for ($i=1; $i <=$daysInMonth ; $i++) {if($i==$daysInMonth) echo $dealsPerDay[$i];else echo $dealsPerDay[$i].",";} ?>]
		}
	]
}

var ctx = document.getElementById("canvas").getContext("2d");
Chart.defaults.global.scaleLineColor = "#37495E";
Chart.defaults.global.animationSteps = 60;
Chart.defaults.global.scaleFontColor = "rgb(255,255,255)";
var myLine = new Chart(ctx).Bar(lineChartData, {
	scaleGridLineColor : "#37495E",
	responsive: true,	
	datasetStrokeWidth : 2,
	pointDot: false
});
</script>