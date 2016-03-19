<?php
	$timeZoneAU = new DateTimeZone('Australia/Sydney');
	$SYD = new DateTime("now",$timeZoneAU);
	$offset = $SYD->getOffset()/3600;
?>

<div>
	<div align="center">
		<h2 class="clocktitle">Sydney</h2>
	</div>
	<div align="center" style="margin-top:-9%">
		<canvas class="canvasclock" id="canvasElementAus" width="500" height="500"></canvas>
	</div>
</div>
<script type="text/javascript">
$(document).ready(function(){
  initAus(<?php echo $offset;?>);
});
</script>