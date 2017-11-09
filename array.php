<?php
require 'vendor/autoload.php';
$connection =new MongoDB\Client;
$db=$connection->dat;
$mobj =$db->stor;
$cursor = $mobj->find(['values' => ['$all' => [0.1,3]]]);

?>
<?php
foreach($cursor as $document)
{
	$Positive[]=$document['values'];
	echo sprintf ("Positive=%d",$Positive);
	
}
?>
<?php


?>