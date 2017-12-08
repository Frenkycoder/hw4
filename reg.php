<?php
$title = 'Регистрация';
$activeMenu = 2;
require_once 'php/functions.php';
include './tmpl/header.php'; ?>
    <div class="container">
      <div class="form-container register">
        <form class="form-horizontal" action="" method="post">
            <?php hello(); ?>
            <?php (isset($_POST['go'])) ? regist($connect) : false; ?>
          <div class="form-group">
            <label for="inputEmail3" class="col-sm-2 control-label">Логин</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" name="login" placeholder="Логин" required>
            </div>
          </div>
          <div class="form-group">
            <label for="inputPassword3" class="col-sm-2 control-label">Пароль</label>
            <div class="col-sm-10">
              <input type="password" class="form-control" name="pas" placeholder="Пароль" required>
            </div>
          </div>
          <div class="form-group">
            <label for="inputPassword4" class="col-sm-2 control-label">Пароль (Повтор)</label>
            <div class="col-sm-10">
              <input type="password" class="form-control" name="pas2" placeholder="Пароль" required>
            </div>
          </div>
          <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
              <button type="submit" name="go" class="btn btn-default btn__reg">Зарегистрироваться</button>
              <br><br>
              Зарегистрированы? <a href="index.php">Авторизируйтесь</a>
            </div>
          </div>
        </form>
      </div>

    </div><!-- /.container -->

<?php


//data from register form
//$login = strip_tags($_POST['login']);
//$pas = strip_tags($_POST['pas']);
//$pas2 = strip_tags($_POST['pas2']);
//
//if($login != '' && $pas != '') {
//    if ($pas == $pas2) {
//        $check = $connect->prepare("SELECT login FROM auto WHERE login=:login");
//        $check->execute(array(':login' => $login));
//        $row = $check->fetchAll(PDO::FETCH_ASSOC );
//        if(count($row) == 0) {
////      password hash
//            $pas = password_hash($pas, PASSWORD_DEFAULT);
//            //Prepared Statements
//            $ps = $connect->prepare("INSERT INTO auto (login, password) VALUES (:login, :password)");
//            $ps->bindParam(':login', $login);
//            $ps->bindParam(':password', $pas);
//            $ps->execute();
//            header('Location: index.php');
//        } else {
//            echo '<div class="alert alert-info" role="alert">Извените, такой логин уже занят</div>';
//        }
//    } else {
//        echo '<div class="alert alert-warning" role="alert">Пароли должни совпадать</div>';
//    }
//
//} else {
//   // echo '<div class="alert alert-danger" role="alert">Введите все данние</div>';
//}
?>

<?php include './tmpl/footer.php' ?>