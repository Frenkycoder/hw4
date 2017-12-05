<?php
/**
 * Created by PhpStorm.
 * User: Андрій Михайлов
 * Date: 04.12.2017
 * Time: 16:01
 */

require_once 'db.php';

if(isset($_COOKIE["log"])) {
    echo "Добро пожаливать " . $_COOKIE["log"] . ". Ви, авторизовани ";
    echo "<a href='/php/logout.php'>Вийти</a>";
    $show = $connect->prepare("SELECT * FROM auto");
    $show->execute();
    $row = $show->fetchAll(PDO::FETCH_ASSOC);
    foreach ($row as $item) {
        echo "<tr>";
        echo "<td>" .$item['login'] . "</td>";
        echo "<td>" .$item['name'] . "</td>";
        echo "<td>" .$item['age'] . "</td>";
        echo "<td>" .$item['description'] . "</td>";
        echo "<td><img style='max-width: 100px' src=" .$item['photo'] . " alt=''></td>";
        echo "<td><form method='post'><input type='hidden' name='userID' value=".$item['id']."><input type=\"button\"
  class=\"delBut\" name=\"delete_row\" value=\"Удалить пользователя\"/></form></td>";
        echo "</tr>";
    }

    $loginId = $_POST['userID'];
    $delBut = $_POST['delBut'];

    if (isset($delBut)) {

        $img = $connect->prepare("SELECT photo FROM auto WHERE id=:id");
        $img->execute(array(':id' => $loginId));
        $imgArr = $img->fetch(PDO::FETCH_ASSOC);
        $del = $connect->prepare("DELETE FROM auto WHERE id=:id");
        $del->execute(array(':id' => $loginId));


        //unlink();
//    header('Location: '.$_SERVER['REQUEST_URI']);
    }
} else {
    echo "<h1>Информация доступна только авторизированному пользователю, пожалуйста авторизируйтесь</h1>";
    echo "<a href='index.html'>Авторизация</a>";
    echo "<a href='reg.html'>Регистрация</a>";
}

