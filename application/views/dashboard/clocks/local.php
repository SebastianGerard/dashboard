<?php
	$timeZoneBOL = new DateTimeZone('America/La_Paz');
	$BOL = new DateTime("now",$timeZoneBOL);
	$offset = $BOL->getOffset()/3600;
?>
<div>
	<div align="center">
		<h2 class="clocktitle">Cochabamba</h2>
	</div>
	<div align="center" style="margin-top:-9%">
		<canvas class="canvasclock" id="canvasElementlocal" width="500" height="500"></canvas>
	</div>
</div>

<script type="text/javascript">
$(document).ready(function(){
  init(<?php echo $offset;?>);
});
</script>