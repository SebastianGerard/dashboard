<?php
	$timeZoneBEL = new DateTimeZone('Europe/Brussels');
	$BEL = new DateTime("now",$timeZoneBEL);
	$offset = $BEL->getOffset()/3600;
?>

<div>
	<div align="center">
		<h2 class="clocktitle">Brussels</h2>
	</div>
	<div align="center" style="margin-top:-9%">
		<canvas class="canvasclock" id="canvasElementBL" width="500" height="500"></canvas>
	</div>
</div>
<script type="text/javascript">
$(document).ready(function(){
  initBL(<?php echo $offset;?>);
});
</script>

