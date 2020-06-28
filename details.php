<?php

// Вывод ошибок php
ini_set('display_errors',1);
ini_set('display_startup_erros',1);
error_reporting(E_ALL);

require_once 'classes/board.php';

$objBoard = new Board();


//GET
if(isset($_GET['details'])){
    $id = $_GET['details'];
    $stmt = $objBoard->runQuery("SELECT * FROM board WHERE id=:id");
    $stmt->execute(array(":id" => $id));
    $rowBoard = $stmt->fetch(PDO::FETCH_ASSOC);

    $vid = $rowBoard['id'];
    $vtitle = $rowBoard['title'];
    $vdesc = $rowBoard['desc'];
    $vprice = $rowBoard['price'];
    $vemail = $rowBoard['email'];
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
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6 mt-3 bg-info p-2 rounded">
            <h2 class="bg-light p-2 rounded text-dark">ID: <?= $vid; ?></h2>
            <h4 class="text-light">Название: <?= $vtitle; ?></h4>
            <h4 class="text-light">Описание: <?= $vdesc; ?></h4>
            <h4 class="text-light">Цена в белорусских рублях: <?= $vprice; ?></h4>
            <h4 class="text-light">Имейл для контакта: <?= $vemail; ?></h4>
        </div>
    </div>
</div>

        </main>
    </div>
</div>
<!-- Footer -->
<?php require_once 'includes/footer.php'; ?>

</body>
</html>

