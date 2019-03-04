<?php
define('CURRENCY', '$');
define('WEB_URL', 'http://localhost/ams/');
define('ROOT_PATH', 'C:\wamp64\www\ams/');


define('DB_HOSTNAME', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_DATABASE', 'ams_final');
$link = mysqli_connect(DB_HOSTNAME,DB_USERNAME,DB_PASSWORD,DB_DATABASE) or die(mysql_error());mysqli_select_db($link,DB_DATABASE) or die(mysql_error());?> 