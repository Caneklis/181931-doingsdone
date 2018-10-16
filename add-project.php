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
$projects = [];
$tasks = [];
$user_id = isset($_SESSION['user']['id']) ? $_SESSION['user']['id'] : false;

if (!isset($_SESSION['user'])) {
	$page_content = include_template('guest.php', []);
	$layout_data = ['projects' => $projects, 'site_title' => $site_title, 'page_content' => $page_content, 'content' => $content, 'hide_aside' => $hide_aside, ];
	$layout_content = include_template('layout.php', $layout_data);
	print ($layout_content);
}
else {
    $hide_aside = null;

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $projects = $_POST;
        $required = ["name"];
        $now = date("Y-m-d H:i:s");
        $project_title = mysqli_real_escape_string($link, $_POST["name"]);
        $titleClear = $project_title;
        $sql = mysqli_query($link, "SELECT `title` FROM `projects` WHERE `title` = '$titleClear'");
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
                    `title` = '$project_title',
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

    $page_content = include_template("add-project.php", ['site_title' => $site_title, 'dict' => $dict, 'errors' => $errors, 'projects' => $projects, 'tasks' => $tasks, 'user_id' => $user_id]);
    $layout_data = ['projects' => $projects, 'site_title' => $site_title, 'page_content' => $page_content, 'content' => $content];
    $layout_content = include_template('layout.php', $layout_data);
    print ($layout_content);
}
