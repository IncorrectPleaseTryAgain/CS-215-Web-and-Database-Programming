<?php

$db_host = "localhost";
$db_name = "";
$db_user = "";
$db_pwd = "";
$chars = "utf8mb4";

$dsn = "mysql:host=$db_host;port=3307;dbname=$db_name;charset=$chars";
$opts = [
   PDO::ATTR_ERRMODE               => PDO::ERRMODE_EXCEPTION,
   PDO::ATTR_DEFAULT_FETCH_MODE    => PDO::FETCH_ASSOC,
   PDO::ATTR_EMULATE_PREPARES      => false
];

try{
    $db = new PDO($dsn, $db_user, $db_pwd, $opts);
} catch(PDOException $e){
    die ("PDO Error >> " . $e->getMessage() . "\n<br />");
}