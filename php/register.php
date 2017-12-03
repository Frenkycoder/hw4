<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 16.11.2017
 * Time: 19:49
 */

//db file
require_once 'db.php';

//data from register form
$login = strip_tags($_POST['login']);
$pas = strip_tags($_POST['pas']);
$pas2 = strip_tags($_POST['pas2']);


if($login != '' && $pas != '' && $pas == $pas2) {
    $check = $connect->prepare("SELECT login FROM auto WHERE login=:login");
    $check->execute(array(':login' => $login));
    $row = $check->fetchAll(PDO::FETCH_ASSOC );
    if(count($row) == 0) {
//      password hash
        $pas = password_hash($pas, PASSWORD_DEFAULT);
        //Prepared Statements
        $ps = $connect->prepare("INSERT INTO auto (login, password) VALUES (:login, :password)");
        $ps->bindParam(':login', $login);
        $ps->bindParam(':password', $pas);
        $ps->execute();
    }
}