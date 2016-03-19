<?php
	$timeZoneNY = new DateTimeZone('America/New_York');
	$NY = new DateTime("now",$timeZoneNY);
	$offset = $NY->getOffset()/3600;
?>

<div>
	<div align="center">
		<h2 class="clocktitle">New York</h2>
	</div>
	<div align="center" style="margin-top:-9%">
		<canvas class="canvasclock" id="canvasElementNY" width="500" height="500"></canvas>
	</div>
</div>

<script type="text/javascript">
$(document).ready(function(){
  initNY(<? echo $offset;?>);
});
</script>