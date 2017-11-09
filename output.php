<?php
//checks session is matched or not
//if it is matched then it destroys session and redirects to tweezer.php
//else redirects to main page
//session_start();
//if (isset($_SESSION['name']))
//{
//	session_destroy();
//}
//else
//{
//	header ("Location: tweezer.php");
//}

?>
<html>
	<head>
		<title>Results of Analysis</title>
		<script src="jquery-2.1.4.min.js"></script>
		<script src="Chart.js"></script>
	</head>
<body>
<table width=100%>
<tr>
<td>
<?php
require 'vendor/autoload.php';
$connection =new MongoDB\Client;
$db=$connection->data;
$mobj =$db->data_store;
$cursor = $mobj->find();
#php driver:::#https://pecl.php.net/package/mongodb
#php_mongodb.dll is added in php\ext#php-ini has been modified by adding extension=php_mongodb.dll#Compser for making connection between mongodb and php:::#https://getcomposer.org/download/
?>
<?php
foreach($cursor as $document)
{
//https://stackoverflow.com/questions/10252418/how-to-pass-variables-from-one-php-page-to-another-without-form
//to get veriable from get.php we started session and stored as $_SESSION['search']=$_GET['name']. This is done is get.php
	$Positive=$document['Positive'];
	//echo sprintf ("Positive=%d",$Positive); //echo '<br/>';
	$Negative=$document['Negative'];
	//echo sprintf ("Negative=%d",$Negative);//echo '<br/>';//$total=$Positive+$Negative;//echo sprintf("Total=%d",$total);	
}
?>
<?php
	session_start();
	$a=$_SESSION['search'];
	$Pp=$Positive;
	$Pn=$Negative;
    echo sprintf("From the analysis made on <b>%s</b> ",$a);
    echo sprintf ("about %d percentage was found to be positive",$Pp);
	echo '<br/>';
    echo sprintf (" and about %d percentage was found to be negative",$Pn);
?>

<h3>Pie-Chart Representation</h3>
<canvas id="mycanvas" width="300" height="300">
			<script>
			$(document).ready(function(){
				var ctx = $("#mycanvas").get(0).getContext("2d");

				//pie chart data
				//sum of values = 360
		
				var data = [
					//{
					//	value: <?php echo $Pn; ?>,
					//	color: "cornflowerblue",
					//	highlight: "lightskyblue",
					//	label: "Negative"
					//},
					{
						value: <?php echo $Pp; ?>,
						color: "lightgreen",
						highlight: "yellowgreen",
						label: "Positive"
					},
					{
						value: <?php echo $Pn; ?>,
						color: "orange",
						highlight: "darkorange",
						label: "Negative"
					}
				];

				//draw
				var piechart = new Chart(ctx).Pie(data);
			});
		    </script>
</td>

<td width=50%>
<?php 
include 'bar.php';
?>
<div id="center_button" align="right"><button onclick="location.href='scatter.php'">Next</button></div>
<br>
<div id="center_button" align="right"><button onclick="location.href='tweezer.php'">Back to Home</button></div>
	</body>
	</td>
	</tr>

</table>
</html>
