<?php

$start = microtime(true);
// These variables define the connection information for your MySQL database 
$username = "rbcpapp";
$password = "rbcpapp";
$host = "192.168.72.40";
$dbname = "wugms";
$iserror = false;
echo " 1.0 ";
echo number_format(microtime(true) - $start, 3);
echo "<br>";
$options = array(
    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'
);
echo " 2.0 ";
echo number_format(microtime(true) - $start, 3);
echo "<br>";
try {
    echo " 3.0 ";
    echo number_format(microtime(true) - $start, 3);
    echo "<br>";
    $db = new PDO("mysql:host={$host};dbname={$dbname};charset=utf8", $username, $password, $options);
    echo " 4.0 ";
    echo number_format(microtime(true) - $start, 3);
    echo "<br>";
} catch (PDOException $ex) {
    $iserror = true;
    $SQLerrorcode = $ex->getMessage();
//    $logger = Logger::getLogger(basename(__FILE__));
//    $logger->debug(htmlspecialchars(str_replace(PHP_EOL, '', $SQLerrorcode)));
}
echo " 5.0 ";
echo number_format(microtime(true) - $start, 3);
echo "<br>";
if (!$iserror) {
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} else {
    die();
}

//header('Content-Type: text/html; charset=utf-8'); 
?>