<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 18.11.2017
 * Time: 18:28
 */

//db file
require_once 'db.php';

//data from register form
$login = strip_tags($_POST['login']);
$pas = strip_tags($_POST['pas']);

if($login != '' && $pas != '') {
    $check = $connect->prepare("SELECT login FROM auto WHERE login=:login");
    $check->execute(array(':login' => $login));
    $row = $check->fetchAll(PDO::FETCH_ASSOC );
    if(count($row) == 1) {
        $check = $connect->prepare("SELECT password FROM auto WHERE login=:login");
        $check->execute(array(':login' => $login));
        $row = $check->fetch(PDO::FETCH_ASSOC );
        $pasDB = $row['password'];
        if(password_verify($pas, $pasDB)) {
            echo "<script>$(document).ready(function(){window.location.replace(\"http://d4/profile.html\");});</script>";
        } else {
            echo "Пароль не верен";
        }
    } else {
        echo "Логина не существует, зарегистрируйтесь";
    }
}