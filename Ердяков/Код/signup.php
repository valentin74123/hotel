<?php
	require "db.php";

	$data = $_POST;
	if( isset($data['do_signup']))
	{	
		$errors = array();
		if( trim($data['login']) == '')
		{
			$errors = 'Введите логин!';
		}

		if( trim($data['email']) == '')
		{
			$errors = 'Введите почту!';
		}

		
		if( $data['password'] == '')
		{
			$errors = 'Введите пароль!';
		}

		if( $data['password2'] != $data['password'] )
		{
			$errors = 'Повторный пароль введен неверно!';
			echo "<script>alert('Повторный пароль введен неверно!')</script>";
		}

		if( R::count('users','login = ?',array($data['login'])) > 0)
		{
			$errors = 'Пользователь с таким логином уже существует!';
			echo "<script>alert('Пользователь с таким логином уже существует!')</script>";
		}

		if( R::count('users','email = ?',array($data['email'])) > 0)
		{
			$errors = 'Пользователь с таким почтовым ящиком уже существует!';
			echo "<script>alert('Пользователь с таким почтовым ящиком уже существует!')</script>";
		}

		if( empty($errors))
		{
			$user = R::dispense('users');
			$user->login = $data['login'];
			$user->email = $data['email'];
			$user->password = password_hash($data['password'], PASSWORD_DEFAULT);
			R::store($user);
			echo "<script>alert('Вы успешно зарегистрировались!')</script>";
		}
		else
		{
			echo "<script>alert('Заполните все пункты!')</script>";
		}
	}
?>
<link rel="stylesheet" href="style.css">
<form action="signup.php" method="POST"id="zatemnenie">
	<div id="window">
	<p>
		<p><strong>Придумайте логин</strong>:</p>
		<input type="text" name="login" value="<?php echo @$data['login']; ?>">
	</p>
	<p>
		<p><strong>Введите почту</strong>:</p>
		<input type="email" name="email" value="<?php echo @$data['email']; ?>">
	</p>
	
	<p>
		<p><strong>Придумайте пароль</strong>:</p>
		<input type="password" name="password" value="<?php echo @$data['password']; ?>">
	</p>
	<p>
		<p><strong>Повторите пароль</strong>:</p>
		<input type="password" name="password2" value="<?php echo @$data['password2']; ?>">
	</p>
	<p>
		<button type="submit" name="do_signup">Зарегистрироваться</button>
	</p>
	<br>
	<a href="login.php" id="reg">Закрыть окно</a>
</div>
</form>