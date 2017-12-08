<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 17.11.2017
 * Time: 10:19
 */
//db file
require_once 'db.php';

function regist($connect)
{
    //data from register form
    $login = strip_tags($_POST['login']);
    $pas = strip_tags($_POST['pas']);
    $pas2 = strip_tags($_POST['pas2']);
    if($login != '' && $pas != '') {
        if ($pas == $pas2) {
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
                //header('Location: index.php');
                echo '<div class="alert alert-success" role="alert">Ура, ви зарегистрировани <a href="index.php">Авторизуйтесь</a> </div>';
                return true;
            } else {
                echo '<div class="alert alert-info" role="alert">Извените, такой логин уже занят</div>';
            }
        } else {
            echo '<div class="alert alert-warning" role="alert">Пароли должни совпадать</div>';
        }

    } else {
        echo '<div class="alert alert-danger" role="alert">Введите все данние</div>';

    }

}

//data from register form
function autorise($connect)
{
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
                $val = $login;
                $_SESSION['login'] = $val;
            } else {
                echo '<div class="alert alert-danger" role="alert">Пароль не верен</div>';
            }
        } else {
            echo '<div class="alert alert-danger" role="alert">Логина не существует, зарегестрируйтесь</div>';

        }
    } else {
        echo '<div class="alert alert-danger" role="alert">Введите все данние</div>';
    }
}


function hello()
{
    if (isset($_SESSION['login'])) {
        echo '<div class="alert alert-success" role="alert">Добро пожаливать ' . $_SESSION['login'] .
            ', Ви авторизовани, <a href="php/logout.php">Вийти</a></div>';
    }
}


function profile($connect)
{
//data from register form
    $name = strip_tags($_POST['name']);
    $name = (string)$name;
    $age = strip_tags($_POST['age']);
    $age = preg_replace('/[^0-9]/', '', $age);
    $age = (int)$age;
    $desc = strip_tags($_POST['desc']);
    if ($name != '' && $age != '' && $desc != '') {
        //Узнаем ID записи для именования картинки
        $selID = $connect->prepare("SELECT id FROM auto WHERE login=:login");
        $selID->execute(array(':login' => $_SESSION['login']));
        $row = $selID->fetch(PDO::FETCH_ASSOC);
        $IDrow = $row['id'];
        //проверка фото
        try {
            $file = empty($_FILES['photo']) ? null : $_FILES['photo'];
            if (!isset($file['error']) || is_array($file['error'])) {
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
            if ($file['size'] > 10485760) {
                throw new RuntimeException('Перевишен размер файла, файл должен бить менше 10 Мегабайт');
            } elseif ($file['size'] == 0) {
                throw new RuntimeException('Файл пустой');
            }
            //Проверка расширения файла
            $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
            $img_type = ['png', 'jpg', 'jpeg', 'gif'];
            if (!in_array($ext, $img_type)) {
                throw new RuntimeException("Ето не картинка, только такие формати - 'png', 'jpg', 'jpeg', 'gif'");
            }
            //Изменение имени картинки
            $cut = explode(".", $file['name']);
            $fileName = $IDrow . '.' . end($cut);
            if (!move_uploaded_file($file['tmp_name'], 'photos/' . $fileName)) {
                throw new RuntimeException('Не вийшло загрузить файл');
            }
            $fileDest = 'photos/' . $fileName;

            echo '<div class="alert alert-success" role="alert">Файл успешно загружен</div>';

        } catch (RuntimeException $e) {
            echo $e->getMessage();
        }
        //Обновляем данние профиля
        $prof = $connect->prepare("UPDATE auto SET name=:username, age=:age, description=:description, photo=:photo WHERE login=:login");
        $prof->execute(array(':username' => $name, ':age' => $age, ':description' => $desc, ':login' => $_SESSION['login'], ':photo' => $fileDest));
    } else {
        echo '<div class="alert alert-danger" role="alert">Пожалуйста, заполните все поля</div>';
    }
}


function showUsers($connect)
{
    $show = $connect->prepare("SELECT * FROM auto");
    $show->execute();
    $row = $show->fetchAll(PDO::FETCH_ASSOC);
    foreach ($row as $item) {
        if(isset($item['id'])) {
            echo "<tr>";
            echo "<td>" . $item['login'] . "</td>";
            echo "<td>" . $item['name'] . "</td>";
            echo "<td>" . $item['age'] . "</td>";
            echo "<td>" . $item['description'] . "</td>";
            echo "<td><img style='max-width: 100px' src=" . $item['photo'] . " alt=''></td>";
            echo "<td><form method='post'><input type='hidden' name='userID' value=" . $item['id'] . "><input type=\"submit\"
  class=\"delBut\" name=\"delete_row\" value=\"Удалить пользователя\"/></form></td>";
            echo "</tr>";
        }
    }
    $loginId = $_POST['userID'];
    $delBut = $_POST['delete_row'];
    if (isset($delBut)) {
        $img = $connect->prepare("SELECT photo FROM auto WHERE id=:id");
        $img->execute(array(':id' => $loginId));
        $imgArr = $img->fetch(PDO::FETCH_ASSOC);
        $del = $connect->prepare("DELETE FROM auto WHERE id=:id");
        $del->execute(array(':id' => $loginId));
        file_exists($imgArr['photo']) ? unlink($imgArr['photo']) : false;
    }
}

function showFiles($connect)
{
    $show = $connect->prepare("SELECT photo, id FROM auto");
    $show->execute();
    $row = $show->fetchAll(PDO::FETCH_ASSOC);
    foreach ($row as $item) {
        if(isset($item['photo'])) {
            echo "<tr>";
            echo "<td>" . $item['photo'] . "</td>";
            echo "<td><img style='max-width: 100px' src=" . $item['photo'] . " alt=''></td>";
            echo "<td><form method='post'><input type='hidden' name='logID' value=" . $item['id'] . "><input type=\"submit\"
  class=\"delPic\" name=\"delete_pic\" value=\"Удалить аватарку пользователя\"/></form></td>";
            echo "</tr>";
        }

    }

    $logID = $_POST['logID'];
    $delPic = $_POST['delete_pic'];

    if (isset($delPic)) {
        $selImg = $connect->prepare("SELECT photo FROM auto WHERE id=:id");
        $selImg->execute(array(':id' => $logID));
        $rowImg = $selImg->fetch(PDO::FETCH_ASSOC);
        file_exists($rowImg['photo']) ? unlink($rowImg['photo']) : false;
        print_r($rowImg);
        $del = $connect->prepare("UPDATE auto SET photo = NULL WHERE id=:id");
        $del->execute(array(':id' => $logID));
    }
}