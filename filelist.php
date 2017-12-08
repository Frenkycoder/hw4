<?php
$title = 'Список файлов';
$activeMenu = 5;
require_once 'php/functions.php';
include './tmpl/header.php' ?>
    <div class="container">
      <h2>Все файли</h2>
      <table class="table table-bordered">
        <tr>
          <th>Название файла</th>
          <th>Фотография</th>
          <th>Действия</th>
        </tr>
          <?php hello(); ?>
          <?php showFiles($connect); ?>
      </table>

    </div><!-- /.container -->

    <?php include './tmpl/footer.php' ?>
