<?php
// Вывод ошибок php
ini_set('display_errors',1);
ini_set('display_startup_erros',1);
error_reporting(E_ALL);

require_once 'classes/board.php';

$objBoard = new Board();


//GET
if(isset($_GET['edit_id'])){
    $id = $_GET['edit_id'];
    $stmt = $objBoard->runQuery("SELECT * FROM board WHERE id=:id");
    $stmt->execute(array(":id" => $id));
    $rowBoard = $stmt->fetch(PDO::FETCH_ASSOC);
}else{
    $id = null;
    $rowBoard = null;
}



//POST

if(isset($_POST['btn_save'])) {
    $title = strip_tags($_POST['title']);
    $desc = strip_tags($_POST['desc']);
    $price = strip_tags($_POST['price']);
    $email = strip_tags($_POST['email']);

    try{
        if($id != null){
            if($objBoard->update($title, $desc, $price, $email, $id)){
                $objBoard->redirect('index.php?updated');
            }
        }else{
            if($objBoard->insert($title, $desc, $price, $email)){
                $objBoard->redirect('index.php?inserted');
            }else{
                $objBoard->redirect('index.php?error');
            }
        }
    }catch(PDOException $e){
echo $e->getMessage();
    }

}
?>



<!doctype html>
<html lang="en">
<head>
    <!-- Head metas, css, and title -->
    <?php require_once 'includes/head.php'; ?>
</head>
<body>
<!-- Header banner -->
<?php require_once 'includes/header.php'; ?>
<div class="container-fluid">
    <div class="row">
        <!-- Sidebar menu -->
        <?php require_once 'includes/sidebar.php'; ?>
        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
            <h1 style="margin-top: 10px">Добавить\Изменить объявление</h1>
            <p>Обязательные поля для ввода данных (*)</p>
            <form  method="post">
                <div class="form-group">
                    <label for="id">ID</label>
                    <input class="form-control" type="text" name="id" id="id" value="<?php print(isset($rowBoard['id'])); ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="title">Заголовок *</label>
                    <input class="form-control" type="text" name="title" id="title" value="<?php print(isset($rowBoard['title'])); ?>">
                </div>
                <div class="form-group">
                    <label for="desc">Описание *</label>
                    <input class="form-control" type="text" name="desc" id="desc" value="<?php print(isset($rowBoard['desc'])); ?>">
                </div>
                <div class="form-group">
                    <label for="price">Введите цену(руб.) *</label>
                    <input class="form-control" type="number" name="price" id="price" value="<?php print(isset($rowBoard['price'])); ?>">
                </div>
                <div class="form-group">
                    <label for="email">Email *</label>
                    <input class="form-control" type="text" name="email" id="email" value="<?php print(isset($rowBoard['email'])); ?>">
                </div>
                <input class="btn btn-primary mb-2" type="submit" name="btn_save" value="Сохранить">
            </form>
        </main>
    </div>
</div>
<!-- Footer -->
<?php require_once 'includes/footer.php'; ?>
</body>
</html>