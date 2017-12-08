<?php
$title = 'Список пользиваталей';
$activeMenu = 4;
require_once 'php/functions.php';
include './tmpl/header.php' ?>
    <div class="container">
        <h2>Все пользиватели</h2>
      <table class="table table-bordered">
        <tr>
          <th>Пользователь(логин)</th>
          <th>Имя</th>
          <th>возраст</th>
          <th>описание</th>
          <th>Фотография</th>
          <th>Действия</th>
        </tr>
          <?php hello(); ?>
          <?php showUsers($connect);?>
      </table>

    </div><!-- /.container -->

    <?php include './tmpl/footer.php' ?>
