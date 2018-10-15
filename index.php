<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
require_once ('functions.php');

require_once ('data.php');

require_once ('init.php');

$link = mysqli_connect('localhost', 'root', '', 'doingsdone');
mysqli_set_charset($link, "utf8");
session_start();
$user_id = $_SESSION['user']['id'];

if (!isset($_SESSION['user'])) {
    header('HTTP/1.0 403 Forbidden');
    exit();
}

if (!$link) {
	$error = mysqli_connect_error();
	$page_content = include_template('error.php', ['error' => $error]);
}
else {
	$sql = "SELECT `projects`.`id`, `projects`.`title`, `projects`.`user_id`, COUNT(`tasks`.`id`) AS tasks FROM `projects` LEFT JOIN `tasks` ON `tasks`.`project_id` =`projects`.`id` WHERE `projects`.`user_id` = '{$_SESSION['user']['id']}' GROUP BY `projects`.`id`, `projects`.`title`, `projects`.`user_id`";
	if (!$res = mysqli_query($link, $sql)) {
		$error = mysqli_error($link);
		$page_content = include_template('error.php', ['error' => $error]);
	}
	else {
		$projects = mysqli_fetch_all($res, MYSQLI_ASSOC);
	}

	$where = ''; 
    if (isset($_GET['project_id'])) { 
    $project_id = mysqli_real_escape_string($link, $_GET['project_id']); 
    $where = "AND `project_id` = " . $project_id; 
    } 

    $sql = "SELECT * FROM tasks WHERE `user_id` = '{$_SESSION['user']['id']}' {$where} ORDER BY date_add DESC";
	if (!$res = mysqli_query($link, $sql)) {
		$error = mysqli_error($link);
		$page_content = include_template('error.php', ['error' => $error]);
	}
	else {
		$tasks = mysqli_fetch_all($res, MYSQLI_ASSOC);
	}
}

$tasks = mysqli_fetch_all(mysqli_query($link, $sql) , MYSQLI_ASSOC);
$page_data = ['projects' => $projects, 'tasks' => esc($tasks) , 'show_complete_tasks' => $show_complete_tasks, 'page_content' => $page_content, 'content' => $content];
$page_content = include_template('index.php', $page_data);
$layout_data = ['projects' => $projects, 'site_title' => $site_title, 'page_content' => $page_content, 'content' => $content];
$layout_content = include_template('layout.php', $layout_data);
print ($layout_content);
?>