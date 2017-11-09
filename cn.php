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

	$a=json_encode($row['values']);
	echo $a;
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
	echo $b;
	
 }
?>