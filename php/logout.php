<?php
/**
 * Created by PhpStorm.
 * User: Андрій Михайлов
 * Date: 05.12.2017
 * Time: 15:48
 */

require_once 'db.php';
unset($_SESSION["login"]);
header('Location: /');