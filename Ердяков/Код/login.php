<?php
	require "db.php";

	$data = $_POST;

	$errors = '';
	$user = R::findOne('users','login = ?',array($data['login']));
	if( $user)
	{
		if( password_verify($data['password'], $user->password))
		{
			$_SESSION['logged_user'] = $user;
			exit('main');
		} else
		{
			$errors = 'Введён неверный пароль!';
		}
	} else
	{
		$errors = 'Пользователя с таким логином не существует!';
	}
	if(! empty($errors))
		{
			// echo "<script>alert('$errors')</script>";
			echo $errors;
		}
?>