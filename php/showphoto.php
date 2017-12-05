<?php
/**
 * Created by PhpStorm.
 * User: Андрій Михайлов
 * Date: 04.12.2017
 * Time: 18:41
 */

require_once 'db.php';

if(isset($_COOKIE["log"])) {
    echo "Добро пожаливать " . $_COOKIE["log"] . ". Ви, авторизовани ";
    echo "<a href='/php/logout.php'>Вийти</a>";
$show = $connect->prepare("SELECT photo FROM auto");
$show->execute();
$row = $show->fetchAll(PDO::FETCH_ASSOC);
foreach ($row as $item) {
    echo "<tr>";
    echo "<td>" .$item['photo'] . "</td>";
    echo "<td><img style='max-width: 100px' src=" .$item['photo'] . " alt=''></td>";
    echo "<td><form method='post'><input type='hidden' name='logID' value=".$item['id']."><input type=\"button\"
  class=\"delPic\" name=\"delete_pic\" value=\"Удалить аватарку пользователя\"/></form></td>";
    echo "</tr>";
}

$logID = $_POST['logID'];
$delPic = $_POST['delPic'];

if (isset($delPic)) {
    $logID = $_POST['logID'];
    $selImg = $connect->prepare("SELECT photo FROM auto WHERE id=:id");
    $selImg->execute(array(':id' => $logID));
    $rowImg = $selImg->fetch(PDO::FETCH_ASSOC);
    print_r($rowImg);
   // unlink();
}
} else {
    echo "<h1>Информация доступна только авторизированному пользователю, пожалуйста авторизируйтесь</h1>";
    echo "<a href='index.html'>Авторизация</a>";
    echo "<a href='reg.html'>Регистрация</a>";
}