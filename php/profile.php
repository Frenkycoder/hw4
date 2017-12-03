<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 20.11.2017
 * Time: 22:09
 */

//db file
require_once 'db.php';

//data from register form
$name = strip_tags($_POST['name']);
$name = (string)$name;
$age = strip_tags($_POST['age']);
$age = preg_replace( '/[^0-9]/', '', $age );
$age = (int)$age;
$desc = strip_tags($_POST['desc']);
if($name != '' && $age != '' && $desc != '') {
    //Проверка,картинка ли ето
    echo $name;
    echo $age;
    echo $desc;
    if ( 0 < $_FILES['photo']['error'] ) {
        echo 'Error: ' . $_FILES['photo']['error'] . '<br>';
    } else {
        echo $_FILES['photo']['name'];
    }
    $file = empty($_FILES['photo']) ? null : $_FILES['photo'];
    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    $img_type = ['png', 'jpg', 'jpeg', 'gif'];
if( ! in_array($ext, $img_type)) {
    die();
} else {
    echo $file['name'];
}




} else {
    echo "Пожалуйста, заполните все поля";
}