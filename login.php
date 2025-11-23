<?php
if($_SERVER['REQUEST_METHOD'] == 'POST') {
	$login = $_POST['login'];
	$password = $_POST['password'];

	include('db.php');

	$query = $con->query("SELECT * FROM users WHERE login='$login' AND password='$password'"); // SQL-инъекция
	if(!$query) die('query error: ' . $con->error);

	$user = $query->fetch_assoc();
	if(!$user) die('Неверный логин или пароль');

	session_start(); // Нет защиты от Session fixation атаки
	$_SESSION['user_id'] = $user['id'];
	$_SESSION['admin'] = $user['login'] == 'Admin';

	header('Location: index.php');
}
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Авторизация</title>
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
		<!-- АВТОРИЗАЦИЯ -->
		<div class="container">
		<a href="index.php">Главная страница</a>
		<form action="" method="POST">
			<h1>Авторизация</h1>
			<label for="login">Логин:</label><br>
			<input type="text" name="login"><br>
			<label for="password">Пароль:</label><br>
			<input type="password" name="password"><br>
			<button class="btn-sub">Войти</button><br>
			<a href="register.php">Еще не зарегистрированы? Регистрация</a><br>
		</form>
		</div>
	</body>
</html>

