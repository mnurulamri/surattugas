<?php
if(!session_id()) session_start();
//echo 'tes 123..';
//echo 'action='.$_POST['action'];
$_SESSION = [];
$_SESSION = array();
session_destroy();

header("location:https://".$_SERVER['HTTP_HOST']."/surattugas/");
exit();
?>