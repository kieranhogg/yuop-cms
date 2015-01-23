<?php
require 'config.inc.php';
require 'Database.class.php';

$db = new Database(DB_SERVER, DB_USER, DB_PASS, DB_DATABASE);
$db->connect();
mysql_set_charset('utf8');
header('Content-Type: text/html; charset=utf-8');
?>
