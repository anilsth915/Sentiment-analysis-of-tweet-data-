<!DOCTYPE HTML>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>Bar Graph Representation</title>

		<style type="text/css">

		</style>
	</head>
	<?php
require 'vendor/autoload.php';
$connection =new MongoDB\Client;
$db=$connection->data;
$mobj =$db->data_store;
$cursor = $mobj->find();

?>
<?php

foreach($cursor as $document)
{
	$Positive=$document['pcount'];
	$Negative=$document['ncount'];
}
?>
<?php

	$Pp=$Positive;
	$Pn=$Negative;
	
?>
	<body>
<script src="highcharts.js"></script>
<script src="exporting.js"></script>


<div id="container" style="min-width: 150px; max-width: 600px; height: 400px; margin: 0 auto"></div>



		<script type="text/javascript">

Highcharts.chart('container', {
    chart: {
        type: 'bar'
    },
    title: {
        text: '<b>Bar Graph Representation'
    },
    xAxis: {
        categories: ['Positive','Negative'],
        title: {
            text: null
        }
    },
    yAxis: {
        min: 0,
        title: {
            text: 'Tweets',
            align: 'high'
        },
        labels: {
            overflow: 'justify'
        }
    },
    tooltip: {
        valueSuffix: ' tweets'
    },
    plotOptions: {
        bar: {
            dataLabels: {
                enabled: true
            }
        }
    },
    legend: {
        layout: 'vertical',
        align: 'right',
        verticalAlign: 'top',
        x: -40,
        y: 80,
        floating: true,
        borderWidth: 1,
        backgroundColor: ((Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF'),
        shadow: true
    },
    credits: {
        enabled: false
    },
	 
    series: [{
		 //series 1 by default was shown...it was unwanted to us ...so using below one line code it hides series 1 :) :) 
		 showInLegend: false,           
         data: [<?php echo $Pp; ?>,<?php echo $Pn; ?>]
    }]
});
		</script>
	</body>
</html>
