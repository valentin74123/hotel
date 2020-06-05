<?php
	require "db.php";
	$data = $_POST;
	$errors = array();
	if (isset($data['do_login']))
	{	
		$us = $_SESSION['logged_user'];
		$user = R::findOne('users', $us->id);
		$user->login = $data['newlog'];
		R::store($user);
		$_SESSION['logged_user'] = $user;
	}
	if (isset($data['do_email']))
	{
		if( R::count('users','email = ?',array($data['newemail'])) > 0)
		{
			$errors = 'Пользователь с таким почтовым ящиком уже существует!';
			echo "<script>alert('Пользователь с таким почтовым ящиком уже существует!')</script>";
		}
		if( empty($errors))
		{
			$us = $_SESSION['logged_user'];
			$user = R::findOne('users', $us->id);
			$user->email = $data['newemail'];
			R::store($user);
			echo "<script>alert('Вы успешно сменили почту на)</script>";
		}
	}
	if (isset($data['do_pass']))
	{
		$us = $_SESSION['logged_user'];
		$user = R::findOne('users', $us->id);
		if( password_verify($data['oldpass'], $user->password))
		{	
			$user->password = password_hash($data['newpass'], PASSWORD_DEFAULT);
			R::store($user);
			unset($_SESSION['logged_user']);
			header('Location: /index.php');
		}
		else
		{
			echo "<script>alert('Старый пароль введен неверно!')</script>";
		}
	}
	if (isset($data['do_del'])){
		$us = $_SESSION['logged_user'];
		$user = R::findOne('users', $us->id);
		$delete = R::load('users', $us->id);
		R::trash($delete);
		unset($_SESSION['logged_user']);
		header('Location: /index.php');
	}
?>


<title>SMMLife | Настройки</title>
<link rel="stylesheet" href="style.css">
<?php if( isset($_SESSION['logged_user'])): ?>
	<body>
		<header>
			<div class = "wrapper">
				<div class = "menu">
					<a href="#" class="menu-btn">
						<span></span>
					</a>	
					<nav class="menu-list">
						
					</nav>
				</div>
				<div class="upmenu">
					<a href="logout.php">Выйти</a>
					<a href="main.php">Главная</a>
					<a>Добро пожаловать, <?php echo $_SESSION['logged_user']->login; ?></a>
				</div>
			</div>
		</header>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		<script src="btn.js"></script>
		<div class="cont" 
		    onclick="let b = arguments[0].target;
		    if(b.tagName == 'BUTTON')document.getElementById('map').setAttribute('data-showid',arguments[0].target.id)">
			<div id="left">   
			    <button id="but1">Сменить логин</button>
			    <button id="but2">Сменить почту</button>
			</div>
			<div id="right">
			    <button id="but3">Сменить пароль</button>
			    <button id="but4">Удалить аккаунт</button>
			</div>
		</div>
	    <div class="map" id="map" data-showid="but">
            <div class="goo-map" id="map1">
            	<form action="setting.php" method="POST" class="test1">
	            	<p>
						<p><strong>Введите новый логин</strong>:</p>
						<input type="text" name="newlog">
					</p>
					<p>
						<button type="submit" name="do_login">Изменить</button>
					</p>
				</form>
            </div>
            <div class="goo-map" id="map2">
            	<form action="setting.php" method="POST" class="test1">
	            	<p>
						<p><strong>Введите новую почту</strong>:</p>
						<input type="email" name="newemail">
					</p>
					<p>
						<button type="submit" name="do_email">Изменить</button>
					</p>
				</form>
            </div>
            <div class="goo-map" id="map3">
            	<form action="setting.php" method="POST" class="test1">
	            	<p>
						<p><strong>Введите старый пароль </strong>:</p>
						<input type="password" name="oldpass">
					</p>
					<p>
						<p><strong>Введите новый пароль </strong>:</p>
						<input required="" type="password" name="newpass">
					</p>
					<p>
						<button type="submit" name="do_pass">Изменить</button>
					</p>
				</form>
            </div>
            <div class="goo-map" id="map4">
            	<form action="setting.php" method="POST" class="test1">
	            	<button type="submit" name="do_del">Удалить</button>
				</form>
            </div>
	    </div>
	    <div class = "leftmenu">
			<ul class = "widget_leftmenu"> 
				<a href="calculate.php">
					<img src="img/calc.png" width="64" height="64" title="Калькулятор">
				</a>
				<a href="vygruzka.php">
					<img src="img/vig.png" width="64" height="64"  title="Выгрузка из ВК">
				</a>
				<a href="calculate.php">
					<img src="img/sokr.png" width="64" height="64"  title="Сокращатель ссылок">
				</a>
				<a href="calculate.php">
					<img src="img/utm.png" width="64" height="64"  title="Компоновщик UTM меток">
				</a>
			</ul>
		</div>

	</body>
<?php else: ?>
	<h1>Ошибка!Необходимо <a href="login.php">войти или зарегистрироваться</a></h1>
	<a href="index.php">ПЕРЕЙТИ НА ГЛАВНУЮ</a>
<?php endif;?>