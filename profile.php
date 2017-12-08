<?php
$title = 'Профайл';
$activeMenu = 3;
require_once 'php/functions.php';
include './tmpl/header.php' ?>
<div class="container">
    <div class="form-container">
        <form class="form-horizontal" enctype="multipart/form-data" method="POST">
            <?php hello(); ?>
            <?php (isset($_POST['prof'])) ? profile($connect) : false; ?>
            <div class="form-group">
                <label for="name" class="col-sm-2 control-label">Имя</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="name" id="name" placeholder="Имя" required>
                </div>
            </div>
            <div class="form-group">
                <label for="age" class="col-sm-2 control-label">Возраст</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="age" id="age" placeholder="Возраст" required>
                </div>
            </div>
            <div class="form-group">
                <label for="desc" class="col-sm-2 control-label">О себе</label>
                <div class="col-sm-10">
                    <textarea class="form-control" id="desc" name="desc" placeholder="О себе" required>
                    </textarea>
                </div>
            </div>
            <div class="form-group">
                <label for="desc" class="col-sm-4 control-label">Фотография</label>
                <div class="col-sm-8">
                    <input name="photo" id="photo" type="file" class="form-control">
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <input type="submit" name="prof" class="btn btn-default save" value="Сохранить">
                </div>
            </div>
        </form>
    </div>

</div><!-- /.container -->
<?php include './tmpl/footer.php' ?>