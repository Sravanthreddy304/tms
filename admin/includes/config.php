<?php 
// DB credentials.
define('DB_HOST','sql306.infinityfree.com');
define('DB_USER','if0_42138111');
define('DB_PASS','Sravanthmsd304');
define('DB_NAME','if0_42138111_tms');
// Establish database connection.
try
{
$dbh = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME,DB_USER, DB_PASS,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
}
catch (PDOException $e)
{
exit("Error: " . $e->getMessage());
}
?>