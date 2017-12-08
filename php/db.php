<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 16.11.2017
 * Time: 19:53
 */
session_start();
//DB Host
$db_hostname = 'localhost';
$db_database = 'reg';
$db_user = 'root';
$db_pass = '';

//PDO connection
try {
$connect = new PDO("mysql:host=$db_hostname;dbname=$db_database", $db_user,$db_pass);
//$connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch (PDOException $e) {
    print "Error!: " . $e->getMessage() . "<br/>";
//    file_put_contents('PDOerrors.txt', $e->getMessage());
    die();
}


