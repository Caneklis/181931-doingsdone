<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
require_once ('functions.php');

require_once ('data.php');

require_once ('init.php');

session_start();
$link = mysqli_connect('localhost', 'root', '', 'doingsdone');
mysqli_set_charset($link, "utf8");
$site_title = "Дела в порядке: регистрация/вход";
$errors = [];
$dict = ['email' => 'email', 'name' => 'Имя', 'password' => 'пароль'];
$users = $_POST;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$required = ["email", "password", "name"];
	$now = date("Y-m-d H:i:s");
	$user_email = mysqli_real_escape_string($link, $_POST["email"]);
	$passwordHash = password_hash($_POST["password"], PASSWORD_DEFAULT);
	$user_name = mysqli_real_escape_string($link, $_POST["name"]);
	$emailClear = $user_email;
	$sql = mysqli_query($link, "SELECT `id` FROM `users` WHERE `user_email` = '$emailClear'");
	if (mysqli_num_rows($sql) > 0) {
		$errors['email'] = "Этот адрес уже зарегестрирован";
	}

	foreach($required as $key) {
		if (empty($_POST[$key])) {
			$errors[$key] = 'Это поле надо заполнить';
		}
	}

	if (!empty($errors)) {
		$error = mysqli_error($link);
	}
	else {
		$sql_insert = "INSERT INTO users SET
                `date_add` = '$now',
                `user_email` = '$user_email',
                `user_name` = '$user_name',
                `user_password` = '$passwordHash' ";
		if (!$res = mysqli_query($link, $sql_insert)) {
			$error = mysqli_error($link);
			$page_content = include_template('register.php', ['errors' => $errors]);
		}
		else {
			header('Location: /index.php');
		}
	}
}

$page_content = include_template("register.php", ['site_title' => $site_title, 'dict' => $dict, 'errors' => $errors, 'users' => $users]);
$layout_data = ['projects' => $projects, 'site_title' => $site_title, 'page_content' => $page_content, 'content' => $content];
$layout_content = include_template('layout.php', $layout_data);
print ($layout_content);