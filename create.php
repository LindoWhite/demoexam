<?php
session_start();
if(!isset($_SESSION['user_id'])) die('Чтобы оставить заявку, надо войти в аккаунт.');

if($_SERVER['REQUEST_METHOD'] == 'POST') {
	$course_name = $_POST['course_name'];
	$data = $_POST['data'];
	$payment = $_POST['payment'];

	include('db.php');

	$query = $con->query("INSERT INTO applications (course_name, data, payment, users_id) VALUES ('$course_name', '$data', '$payment', '{$_SESSION['user_id']}')"); // SQL-инъекция / чтобы понять КТО оставил заявку, нам нужен $_SESSION['user_id'] - это  foreign key
	if(!$query) die('query error: ' . $con->error);

	header('Location: history.php');
}
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Создание заявки</title>
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
		<!-- СОЗДАНИЕ ЗАЯВКИ -->
		<div class="container">
		<h1>Создание заявки</h1>
		<form action="" method="POST">
			<label for="course_name">Наименование курса:</label><br>
			<select name="course_name">
				<option value="Основы алгоритмизации и программирования">Основы алгоритмизации и программирования</option>
				<option value="Основы веб-дизайна">Основы веб-дизайна</option>
				<option value="Основы проектирования баз данных">Основы проектирования баз данных</option>
			</select>
			<label for="data">Дата начала обучения:</label><br>
			<input type="date" name="data"><br>
			<label for="payment">Способ оплаты:</label><br>
			<select name="payment">
				<option value="наличными">наличными</option>
				<option value="переводом по номеру телефона">переводом по номеру телефона</option>
			</select>
			<br>
			<button class="btn-sub">Отправить</button><br>
		</form>
		</div>
	</body>
</html>
