<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
require_once ('functions.php');

require_once ('data.php');

require_once ('init.php');

$link = mysqli_connect('localhost', 'root', '', 'doingsdone');
mysqli_set_charset($link, "utf8");
session_start();
$site_title = "Дела в порядке: Авторезируйтесь";
$user_id = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$form = $_POST;
	$required = ['email', 'password'];
	$errors = [];
	foreach($required as $field) {
		if (empty($form[$field])) {
			$errors[$field] = 'Это поле надо заполнить';
		}
	}

	if (!empty($errors)) {
		$error = mysqli_error($link);
		$page_content = include_template('add.php', ['error' => $error]);
	}
	else {
		$email = mysqli_real_escape_string($link, $form['email']);
		$sql = "SELECT * FROM users WHERE user_email = '$email'";
		$res = mysqli_query($link, $sql);
		$user = $res ? mysqli_fetch_array($res, MYSQLI_ASSOC) : null;
		if (!$res = mysqli_query($link, $sql)) {
			$error = mysqli_error($link);
			$page_content = include_template('auth.php', ['error' => $error]);
			$tasks = mysqli_fetch_all($res, MYSQLI_ASSOC);
		}

		if (!count($errors) and $user) {
			if (password_verify($form['password'], $user['user_password'])) {
				$_SESSION['user'] = $user;
			}
			else {
				$errors['password'] = 'Неверный пароль';
			}
		}
		else {
			$errors['email'] = 'Такой пользователь не найден';
		}

		if (count($errors)) {
			$page_content = include_template('auth.php', ['form' => $form, 'errors' => $errors]);
		}
		else {
			header("Location: /index.php");
			exit();
		}
	}
}

else {
	if (isset($_SESSION['user'])) {
		$page_content = include_template('index.php', ['user_name' => $_SESSION['user']['user_name'], 'user_id' => $_SESSION['user']['id'], 'site_title' => $site_title]);
	}
	else {
		$page_content = include_template('auth.php', ['site_title' => $site_title]);
	}
}

$layout_content = include_template('layout.php', ['page_content' => $page_content, 'categories' => [], 'site_title' => $site_title]);
print ($layout_content);
