<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 20.11.2017
 * Time: 22:09
 */

//db file
require_once 'db.php';

if(isset($_COOKIE['log'])) {
//data from register form
    $name = strip_tags($_POST['name']);
    $name = (string)$name;
    $age = strip_tags($_POST['age']);
    $age = preg_replace( '/[^0-9]/', '', $age );
    $age = (int)$age;
    $desc = strip_tags($_POST['desc']);
    if($name != '' && $age != '' && $desc != '') {
        //Узнаем ID записи для именования картинки
        $selID = $connect->prepare("SELECT id FROM auto WHERE login=:login");
        $selID->execute(array(':login' => $_COOKIE["log"]));
        $row = $selID->fetch(PDO::FETCH_ASSOC);
        $IDrow = $row['id'];
        //проверка фото
        try {
            $file = empty($_FILES['photo']) ? null : $_FILES['photo'];
            if( !isset($file['error']) || is_array($file['error'])) {
                throw new RuntimeException('Invalid parameters.');
            }
            //Проверка на ошибки
            switch ($file['error']) {
                case UPLOAD_ERR_OK:
                    break;
                case UPLOAD_ERR_NO_FILE:
                    throw new RuntimeException('Файл не отправлен.');
                case UPLOAD_ERR_INI_SIZE:
                case UPLOAD_ERR_FORM_SIZE:
                    throw new RuntimeException('Перевишен лимит размера файла.');
                default:
                    throw new RuntimeException('Неизвсетние ошибки.');
            }
            //Проверка размеров файла
            if($file['size'] > 10485760) {
                throw new RuntimeException('Перевишен размер файла, файл должен бить менше 10 Мегабайт');
            } elseif($file['size'] == 0) {
                throw new RuntimeException('Файл пустой');
            }
            //Проверка расширения файла
            $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
            $img_type = ['png', 'jpg', 'jpeg', 'gif'];
            if( ! in_array($ext, $img_type)) {
                throw new RuntimeException("Ето не картинка, только такие формати - 'png', 'jpg', 'jpeg', 'gif'");
            }
            //Изменение имени картинки
            $cut = explode(".", $file['name']);
            $fileName = $IDrow. '.' . end($cut);
            if(!move_uploaded_file($file['tmp_name'], '../photos/' . $fileName)) {
                throw new RuntimeException('Не вийшло загрузить файл');
            }
            $fileDest = 'photos/' . $fileName;

            echo "Файл корректен и был успешно загружен.\n";

        } catch (RuntimeException $e) {
            echo $e->getMessage();
        }
        //Обновляем данние профиля
        $prof = $connect->prepare("UPDATE auto SET name=:username, age=:age, description=:description, photo=:photo WHERE login=:login");
        $prof->execute(array(':username' => $name, ':age' => $age, ':description' => $desc, ':login' => $_COOKIE["log"], ':photo' => $fileDest));
    } else {
        echo "Пожалуйста, заполните все поля";
    }
}
