<?php

require_once 'config.php';

$db=mysql_connect($host,$sqlusername,$sqlpassword);
	if(!mysql_select_db($dbname,$db)) {
    	echo 'Упс! Что то пошло не так. Попробуйте обновить страницу.';
    };
	
?>