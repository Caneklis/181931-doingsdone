<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
require_once ('functions.php');

require_once ('data.php');

require_once ('init.php');

session_start();

$link = mysqli_connect('localhost', 'root', '', 'doingsdone');
mysqli_set_charset($link, "utf8");
$site_title = "Дела в порядке: Добавить проект";
$errors = [];
$dict = ['name' => 'Название проекта'];
$user_id = $_SESSION['user']['id'];
if (!isset($_SESSION['user'])) {
    header('HTTP/1.0 403 Forbidden');
    exit();
}
$projects = $_POST;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$required = ["name"];
	$now = date("Y-m-d H:i:s");
	$project_title = mysqli_real_escape_string($link, $_POST["name"]);
	$titleClear = $project_title;
	$sql = mysqli_query($link, "SELECT `title` FROM `projects` WHERE `project_title` = '$titleClear'");
	if (mysqli_num_rows($sql) > 0) {
		$errors['name'] = "Такой проект уже существует";
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
		$sql_insert = "INSERT INTO projects SET
                `date_add` = '$now',
                `project_title` = '$project_title',
                `user_id` = '$user_id'";
		if (!$res = mysqli_query($link, $sql_insert)) {
			$error = mysqli_error($link);
			$page_content = include_template('add-project.php', ['errors' => $errors]);

		}
		else {
			header('Location: /index.php');
		}
	}
}

$page_content = include_template("add-project.php", ['site_title' => $site_title, 'dict' => $dict, 'errors' => $errors, 'projects' => $projects, 'user_id' => $user_id]);
$layout_data = ['projects' => $projects, 'site_title' => $site_title, 'page_content' => $page_content, 'content' => $content];
$layout_content = include_template('layout.php', $layout_data);
print ($layout_content);