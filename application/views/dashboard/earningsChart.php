<div class="bigchart">
	<div class="bigline-content">
		<p>Deals</p>
		<div id="legend" class="legend">
		</div>
		<canvas id="canvas2"></canvas>			
	</div>	
</div>

<script>
var lineChartData = {
	labels : [<?php for ($i=1; $i <=$daysInMonth ; $i++) {if($i==$daysInMonth) echo $i;else echo $i.",";} ?>],
	datasets : [
		{
			label: "Marketing",
			fillColor : "rgba(0,255,204,0.2)",
			strokeColor : "rgba(0,255,204,1)",
			pointColor : "rgba(1,204,159,1)",
			pointStrokeColor : "#293B52",
			pointHighlightFill : "rgba(255,255,255,1)",
			pointHighlightStroke : "rgba(220,220,220,1)",
			data : [<?php for ($i=1; $i <=$daysInMonth ; $i++) {if($i==$daysInMonth) echo $totalDeals[$i];else echo $totalDeals[$i].",";} ?>]
		},
		{
			label: "Production",
			fillColor : "rgba(23,131,160,0.2)",
			strokeColor : "rgba(23,131,160,1)",
			pointColor : "rgba(1,204,159,1)",
			pointStrokeColor : "#293B52",
			pointHighlightFill : "rgba(255,255,255,1)",
			pointHighlightStroke : "rgba(220,220,220,1)",
			data : [<?php for ($i=1; $i <=$daysInMonth ; $i++) {if($i==$daysInMonth) echo $finishedDeals[$i];else echo $finishedDeals[$i].",";} ?>]
		},
		{
			label: "Payment",
			fillColor : "rgba(200,203,208,0.2)",
			strokeColor : "rgba(200,203,208,1)",
			pointColor : "rgba(1,204,159,1)",
			pointStrokeColor : "#293B52",
			pointHighlightFill : "rgba(255,255,255,1)",
			pointHighlightStroke : "rgba(220,220,220,1)",
			data : [<?php for ($i=1; $i <=$daysInMonth ; $i++) {if($i==$daysInMonth) echo $paidDeals[$i];else echo $paidDeals[$i].",";} ?>]
		}
	]
}

var ctx = document.getElementById("canvas2").getContext("2d");
Chart.defaults.global.scaleLineColor = "#37495E";
Chart.defaults.global.animationSteps = 60;
Chart.defaults.global.scaleFontColor = "rgb(255,255,255)";
var myLine = new Chart(ctx).Line(lineChartData, {
	scaleGridLineColor : "#37495E",
	responsive: true,	
	datasetStrokeWidth : 2,
	pointDot: false,
	legendTemplate : "<ul style=\"list-style:none\" class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<datasets.length; i++){%><li><span style=\"background-color:<%=datasets[i].strokeColor%>;color:<%=datasets[i].strokeColor%>\">info</span><i style=\"color:white\"><%if(datasets[i].label){%>   <%=datasets[i].label%><%}%></i></li><%}%></ul>"
});

document.getElementById('legend').innerHTML = myLine.generateLegend();
</script>