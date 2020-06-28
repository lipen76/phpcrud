<?php
//Вывод ошбиок php
ini_set('display_errors',1);
ini_set('display_startup_erros',1);
error_reporting(E_ALL);

require_once 'classes/board.php';

$objBoard = new Board();

//GET
if(isset($_GET['delete_id'])){
    $id = $_GET['delete_id'];
    try{
        if($id != null){
            if($objBoard->delete($id)){
                $objBoard->redirect('index.php?deleted');
            }
        }else{
            var_dump($id);
        }
    }catch(PDOException $e){
        echo $e->getMessage();
    }
}

$page = isset($_GET['page']) ? $_GET['page']: 1;
$limit = 4;
$offset = $limit * ($page - 1);


//Сортировка

if(isset($_POST['ASC'])){
    $asc_query = "SELECT * FROM board ORDER BY price ASC";
    $stmt = $objBoard->runQuery($asc_query);
    $stmt->execute();
}elseif (isset($_POST['DESC'])) {
    $desc_query = "SELECT * FROM board ORDER BY price DESC";
    $stmt = $objBoard->runQuery($desc_query);
    $stmt->execute();
}else{
    $default_query = "SELECT * FROM board";
    $stmt = $objBoard->runQuery($default_query);
    $stmt->execute();
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
            <h1 style="margin-top: 10px">База объявлений</h1>
            <select name="page-select" id="page-select" class="form-control pull-right">
                <option value="1"><a href="index.php?page=1">1</a></option>
                <option value="2"><a href="index.php?page=1">2</a></option>
            </select>
            <div class="table-responsive">
                <input type="submit" name="ASC" value="Цена по возврасанию"><br>
                <input type="submit" name="DESC" value="Цена по убыванию"><br>
                <table class="table table-striped table-sm">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Название</th>
                        <th>Цена(руб.)</th>
                        <th>Имейл</th>
                        <th></th>
                    </tr>
                    </thead>
                    <?php
                    $query = "SELECT * FROM board LIMIT $limit OFFSET $offset";
                    $stmt = $objBoard->runQuery($query);
                    $stmt->execute();
                    ?>
                    <tbody>
                    <?php if($stmt->rowCount() > 0){
                        while($rowBoard = $stmt->fetch(PDO::FETCH_ASSOC)){
                            ?>
                            <tr>
                                <td><?php print($rowBoard['id']); ?></td>

                                <td>
                                    <a href="details.php?details=<?php print($rowBoard['id']); ?>">
                                        <?php print($rowBoard['title']); ?>
                                    </a>
                                </td>

                                <td><?php print($rowBoard['price']); ?></td>
                                <td><?php print($rowBoard['email']); ?></td>

                                <td>
                                    <a class="confirmation" href="index.php?delete_id=<?php print($rowBoard['id']); ?>">
                                        <span data-feather="trash"></span>
                                    </a> |

                                    <a href="form.php?edit_id=<?php print ($rowBoard['id']);?>" class="badge badge-success p-2">Изменить</a>
                                </td>
                            </tr>


                        <?php } } ?>
                    </tbody>
                </table>

        </main>
    </div>
</div>
<!-- Footer -->
<?php require_once 'includes/footer.php'; ?>

<script>
    // JQuery confirmation
    $('.confirmation').on('click', function () {
        return confirm('Вы уверены что хотите удалить свое объявление?');
    });
</script>

</body>
</html>
