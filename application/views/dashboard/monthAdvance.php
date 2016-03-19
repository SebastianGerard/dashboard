<div class="monthly">
	<p>Monthly goals</p>
		<div class="percent month">
		<strong></strong>
		<span><?php echo date('F')?></span>
	</div>

	<div class="goals month small">
		<strong></strong>
		<span>Marketing</span>
	</div>

	<div class="production month small">
		<strong></strong>
		<span>Production</span>
	</div>

	<div class="payments month small">
		<strong></strong>
		<span>Payments</span>
	</div>
</div>

<!--
<p style="float:right"><?php print_r($monthAdvance); echo '<br>'; print_r($monthProduction); echo '<br>'; print_r($monthPayment); ?></p>
-->
<script>
$('.percent.month').circleProgress({
    value: <?php echo $monthAdvance['month']/100; ?>,
    fill: {gradient:['#0043B8','#00CD9F']},
    emptyFill: "rgba(56, 71, 92, 1)",
    thickness: 15,
    lineCap: "round",
    size: 140
}).on('circle-animation-progress', function(event, progress) {
    $(this).find('strong').html(parseInt(100 * <?php echo $monthAdvance['month']/100; ?>) + '<i>%</i>');
});

if(<?php echo $monthAdvance['goal']/100?> >= <?php echo $monthAdvance['month']/100; ?>)
{
	$('.goals.month.small').circleProgress({
   value: <?php echo $monthAdvance['goal']/100?>,
   fill: {gradient:['#00CEA0']},
   emptyFill: "rgba(56, 71, 92, 1)",
   thickness: 10,
   lineCap: "round",
   size: 90
	}).on('circle-animation-progress', function(event, progress) {
	    $(this).find('strong').html(parseInt(100 * <?php echo $monthAdvance['goal']/100?>) + '<i>%</i>');
	});;
}
else
{
	$('.goals.month.small').circleProgress({
   value: <?php echo $monthAdvance['goal']/100?>,
   fill: {gradient:['#e50b0b']},
   emptyFill: "rgba(56, 71, 92, 1)",
   thickness: 10,
   lineCap: "round",
   size: 90
	}).on('circle-animation-progress', function(event, progress) {
	    $(this).find('strong').html(parseInt(100 * <?php echo $monthAdvance['goal']/100?>) + '<i>%</i>');
	});;
}

if(<?php echo $monthProduction['production']/100?> >= <?php echo $monthAdvance['month']/100; ?>)
{
	$('.production.month.small').circleProgress({
   value: <?php echo $monthProduction['production']/100?>,
   fill: {gradient:['#00CEA0']},
   emptyFill: "rgba(56, 71, 92, 1)",
   thickness: 10,
   lineCap: "round",
   size: 90
	}).on('circle-animation-progress', function(event, progress) {
	    $(this).find('strong').html(parseInt(100 * <?php echo $monthProduction['production']/100?>) + '<i>%</i>');
	});
}
else
{
	$('.production.month.small').circleProgress({
   value: <?php echo $monthProduction['production']/100?>,
   fill: {gradient:['#e50b0b']},
   emptyFill: "rgba(56, 71, 92, 1)",
   thickness: 10,
   lineCap: "round",
   size: 90
	}).on('circle-animation-progress', function(event, progress) {
	    $(this).find('strong').html(parseInt(100 * <?php echo $monthProduction['production']/100?>) + '<i>%</i>');
	});
}

if(<?php echo $monthPayment['payment']/100?> >= <?php echo $monthAdvance['month']/100; ?>)
{
	$('.payments.month.small').circleProgress({
		value: <?php echo $monthPayment['payment']/100?>,
		fill: {gradient:['#00CEA0']},
		emptyFill: "rgba(56, 71, 92, 1)",
		thickness: 10,
		lineCap: "round",
		size: 90
	}).on('circle-animation-progress', function(event, progress) {
	    $(this).find('strong').html(parseInt(100 * <?php echo $monthPayment['payment']/100?>) + '<i>%</i>');
	});
}
else
{
	$('.payments.month.small').circleProgress({
    value: <?php echo $monthPayment['payment']/100?>,
    fill: {gradient:['#e50b0b']},
    emptyFill: "rgba(56, 71, 92, 1)",
    thickness: 10,
    lineCap: "round",
    size: 90
	}).on('circle-animation-progress', function(event, progress) {
	    $(this).find('strong').html(parseInt(100 * <?php echo $monthPayment['payment']/100?>) + '<i>%</i>');
	});
}
</script>



