<!DOCTYPE html>
<html lang="ru">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Корочки.есть - онлайн курсы дополнительного профессионального образования</title>
        <link rel="stylesheet" href="styles/style.css">
    </head>
    <body>
        <!-- ШАПКА -->
        <div class="header">
            <div class="nav">
                <a href="index.php" class="logo">Корочки.есть</a>
                <?php 
                session_start();
                if(isset($_GET['index'])){
                    session_destroy();
                    header('Location:index.php');
                    exit;
                }
                if(!isset($_SESSION['user_id'])){
                    echo'
                    <div class="nav-btn">
                        <a href="login.php" class="btn-login">Вход</a>
                        <a href="register.php" class="btn-register">Регистрация</a>
                    </div>
                    ';
                }
                elseif($_SESSION['admin']){                                     
                    echo'
                    <div class="nav-btn">
                        <a href="admin.php" class="btn-admin">Панель администратора</a>
                        <a href="?index=1" name="index" class="btn-exit">Выход</a>
                    </div>
                    ';
                }
                else{
                    echo'
                    <div class="nav-btn">
                        <a href="history.php" class="btn-history">История заявок</a>
                        <a href="create.php" class="btn-create">Создать заявку</a>
                        <a href="?index=1" name="index" class="btn-exit">Выход</a>
                    </div>
                    ';
                }
                ?>
            </div>
        </div>
        <!-- СЛАЙДЕР -->
        <div class="info_gallery">
            <div class="gallery"></div>
            <a class="prev control" data-action="prev">❮</a>
            <a class="next control" data-action="next">❯</a>
        </div>
        <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
        <script src="./js/fun.js" async></script>
    </body>
</html>