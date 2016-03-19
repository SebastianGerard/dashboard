<?php
	$timeZoneIN = new DateTimeZone('Asia/Kolkata');
	$IN = new DateTime("now",$timeZoneIN);
	$offset = $IN->getOffset()/3600;
?>

<div>
	<div align="center">
		<h2 class="clocktitle">New Delhi</h2>
	</div>
	<div align="center" style="margin-top:-9%">
		<canvas class="canvasclock" id="canvasElementIndia" width="500" height="500"></canvas>
	</div>
</div>
<script type="text/javascript">
$(document).ready(function(){
  initIndia(<?php echo $offset;?>);
});
</script>