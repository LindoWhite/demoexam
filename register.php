<?php
if($_SERVER['REQUEST_METHOD'] == 'POST') {
	$login = $_POST['login'];
	$password = $_POST['password'];
	$fullname = $_POST['fullname'];
	$phone = $_POST['phone'];
	$email = $_POST['email'];

	include('db.php');

	// Хеширования паролей нет
	$query = $con->query("INSERT INTO users (login, password, fullname, phone, email) VALUES ('$login', '$password', '$fullname', '$phone', '$email')"); // SQL-инъекция | обрати внимание на порядок полей!
	if(!$query) die('query error: ' . $con->error); // [необязательно] Проверка синтаксических ошибок или ошибок в данных (например, слишком длинная строка)

	header('Location: login.php');
}
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Регистрация</title>
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
		<!-- РЕГИСТРАЦИЯ -->
		<div class="container">
		<a href="index.html">Главная страница</a>
		<form action="" method="POST">
			<h1>Регистрация</h1>
			<label for="login">Логин:</label><br>
			<input required type="text" name="login" minlength="6" required><br>
			<label for="password">Пароль:</label><br>
			<input required type="password" name="password" minlength="8" required><br>
			<label for="fullname">ФИО:</label><br>
			<input required type="text" name="fullname" required><br>
			<label for="phone">Телефон:</label><br>
			<input required type="tel" name="phone" placeholder="8(000)000-00-00" pattern="\+7\[\(]\d{3}[\)]\d{3}[-]\d{2}[-]\d{2}" required><br>
			<label for="email">Email:</label><br>
			<input required type="email" name="email" required><br>
			<button class="btn-sub">Создать пользователя</button><br>
			<a href="login.php">Уже зарегистрированы? Авторизоваться</a><br>
	
		</form>
		</div>
	</body>
</html>
