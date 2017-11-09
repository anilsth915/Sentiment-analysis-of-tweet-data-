<?php
session_start();
$_SESSION['name']='start';
?>
<?php
   exec('python init.py "'.$_GET['name'].'"', $output);
   header("Location: output.php");
   $_SESSION['search']=$_GET['name'];
?>