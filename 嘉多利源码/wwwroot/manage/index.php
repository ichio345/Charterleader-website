<?php
$a = $_SERVER['REQUEST_URI']; 
$count=strpos($a,"/manage/"); 
$str=substr_replace($a,"",$count); 
header('location:'.$str.'/index.php?m=Manage');
?>
