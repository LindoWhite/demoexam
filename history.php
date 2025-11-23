<?php
session_start();
if(!isset($_SESSION['user_id'])) die('Чтобы посмотреть историю заявок, надо войти в аккаунт.');

include('db.php');


if($_SERVER['REQUEST_METHOD'] == 'POST') {

	$query = $con->query("UPDATE applications SET feedback='{$_POST['feedback']}' WHERE id='{$_POST['application_id']}'");
	if(!$query) die('update error: ' . $con->error);
}


	$query = $con->query("SELECT * FROM applications WHERE users_id='{$_SESSION['user_id']}'");
	if(!$query) die('query error: ' . $con->error);
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>История заявок</title>
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
		<!-- ЗАЯВКИ -->
		<div class="applications">
			<h1>История заявок</h1>
			<?php
			$i = 0;
			while($request = $query->fetch_assoc()) {
				$i++;
			
				echo "
				<div class='applications-card'>
				<h2>Заявка $i</h2>
				<b>Наименование курса:</b><br>{$request['course_name']}<br><br>
				<b>Дата: <br></b>{$request['data']}<br><br>
				<b>Тип оплаты: <br></b>{$request['payment']}<br><br>
				<b>Статус: <br></b>{$request['status']}<br><br>" ;
				if($request['status'] === 'Обучение завершено'){
					echo"
						<form action='' method='POST'>
					<input type='hidden' name='application_id' value='{$request['id']}'>
					<label for='feedback'><b>Отзыв: <br></b></label>
					<input type='text' name='feedback' value='{$request['feedback']}'>
					<button class='btn-sub'>Сохранить</button>
				</form><br>";	
				}
				echo "</div>";
			
			}
		?>
		</div>
		
	</body>
</html>
	




