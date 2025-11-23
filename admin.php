<?php
include('db.php');
session_start();

if(!$_SESSION['admin']) die('Чтобы посмотреть панель администратора, надо войти в его аккаунт.');

if($_SERVER['REQUEST_METHOD'] == 'POST') {
	echo "Заявка {$_POST['application_id']} обновлена.<br><br>";

	$query = $con->query("UPDATE applications SET status='{$_POST['status']}' WHERE id={$_POST['application_id']}");
	if(!$query) die('update error: ' . $con->error);
}

// JOIN-запрос
$query = $con->query("SELECT applications.*, users.login, users.fullname, users.email FROM applications INNER JOIN users WHERE applications.users_id = users.id");
if(!$query) die('query error: ' . $con->error);
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Панель администратора</title>
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
		<div class="applications">
			<h1>Панель администратора</h1>
			<?php
				$i = 0;
				while($request = $query->fetch_assoc()) {
					$i++;
				
					echo "
					<div class='applications-card'>
					<h2>Заявка $i от {$request['login']}</h2>
					<b>ФИО: </b><br>{$request['fullname']}<br><br>
					<b>Почта: </b><br>{$request['email']}<br><br>
					<b>Наименование курса: </b><br>{$request['course_name']}<br><br>
					<b>Дата: </b><br>{$request['data']}<br><br>
					<b>Тип оплаты: </b><br>{$request['payment']}<br><br>
					<b>Отзыв: </b>{$request['feedback']}<br><br>
					<form action='' method='POST'>
						<label for='status'><b>Установить статус:</b></label>
						<input type='hidden' name='application_id' value='{$request['id']}'>
						<select name='status'>
							<option " . ($request['status'] == 'Новая' ? 'selected' : '') . " value='Новая'>Новая</option>
							<option " . ($request['status'] == 'Идет обучение' ? 'selected' : '') . " value='Идет обучение'>Идет обучение</option>
							<option " . ($request['status'] == 'Обучение завершено' ? 'selected' : '') . " value='Обучение завершено'>Обучение завершено</option>
						</select>
						<button class='btn-sub'>Сохранить</button>
					</form>";
					echo"</div>";
				}
			?>
		</div>
	</body>
</html>

