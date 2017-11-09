<?php
require 'vendor/autoload.php';
$connection =new MongoDB\Client;
$db=$connection->dat;
$mobj =$db->stor;
$cursor = $mobj->find();
//echo 'connection successful';
//echo json_encode($cursor[0]['values']);
?>
<?php

foreach ($cursor as $k=>$row)
 {

	
	//echo json_encode($row['values']);
	//https://stackoverflow.com/questions/14232261/how-to-return-json-data-from-php-mongocursor

	$a=json_encode($row['values']);
	//echo $a;
	echo '<br/>';
	
 }
?>
<?php
require 'vendor/autoload.php';
$connection =new MongoDB\Client;
$db=$connection->dat1;
$mobj =$db->stor1;
$cursor = $mobj->find();
//echo 'connection successful';
//echo json_encode($cursor[0]['values']);
?>
<?php

 foreach ($cursor as $k=>$row)
 {

	
	//echo json_encode($row['values']);


	echo '<br/>';
	@$b=json_encode($row['values1']);
	//echo $b;
	
 }
?>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>Scatter Representation</title>

		<style type="text/css">

		</style>
	</head>
	<body>
<script src="highcharts.js"></script>
<script src="exporting.js"></script>

<div id="container" style="min-width: 310px; height: 400px; max-width: 600px; margin: 0 auto"></div>



		<script type="text/javascript">

Highcharts.chart('container', {
    chart: {
        type: 'scatter',
        zoomType: 'xy'
    },
	 credits: {
      enabled: false
  },
    title: {
        text: 'Scatter representation of positivity and negativity of tweets'
    },
       xAxis: {
        title: {
            enabled: true,
            text: 'Tweets',
			
        },
        startOnTick: true,
        endOnTick: true,
        showLastLabel: true,
		min:0
    },
    yAxis: {
        title: {
            text: 'Values'
			
        }
    },
    legend: {
        layout: 'vertical',
        align: 'left',
        verticalAlign: 'top',
        x: 100,
        y: 70,
        floating: true,
        backgroundColor: (Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF',
        borderWidth: 1
    },
    plotOptions: {
        scatter: {
            marker: {
                radius: 5,
                states: {
                    hover: {
                        enabled: true,
                        lineColor: 'rgb(100,100,100)'
                    }
                }
            },
            states: {
                hover: {
                    marker: {
                        enabled: false
                    }
                }
            },
            tooltip: {
                headerFormat: '<b>{series.name}</b><br>',
                pointFormat: '{point.x} , {point.y} '
            }
        }
    },
    series: [{
        name: 'Positive',
        color: 'rgba(223, 83, 83, .5)',
        data: <?php echo $a ?>

    }, {
        name: 'Negative',
        color: 'rgba(119, 152, 191, .5)',
        data: <?php echo $b ?>
    }]
});


</script>
<div id="center_button" align="right"><button onclick="location.href='output.php'">Previous</button></div>
<br>
<div id="center_button" align="right"><button onclick="location.href='tweezer.php'">Back to Home</button></div>
	</body>
</html>
