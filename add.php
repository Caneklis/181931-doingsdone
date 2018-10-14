<?php
ini_set('display_errors',1);
error_reporting(E_ALL);
require_once('functions.php');
require_once('data.php');
require_once ('init.php');


$link = mysqli_connect('localhost', 'root', '', 'doingsdone');
mysqli_set_charset($link, "utf8");

$errors = [];
$dict = ['title' => 'Название', 'deadline' => 'Срок выполнения', 'project_id' => 'Выбирите проект'];
$title = mysqli_real_escape_string($link, $_POST['title'] ?? '');
$deadline = date('Y-m-d', strtotime( mysqli_real_escape_string($link, $_POST['deadline'] ?? '')));
$project_id = mysqli_real_escape_string($link, $_POST['project_id'] ?? '');
$user_id = '1';
//$user_id = $_POST['user_id'];



if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $tasks = $_POST;

    $required = ['title', 'deadline', 'project_id'];

    if (!empty($_FILES['preview']['name'])) {
        $tmp_name = $_FILES['preview']['tmp_name'];
        $path = $_FILES['preview']['name'];
        $extension = pathinfo($_FILES['preview']['name'], PATHINFO_EXTENSION);
        $new_name = uniqid().'.'.$extension;
        move_uploaded_file($tmp_name, 'uploads/' . $new_name);
        $task['file'] = $new_name;
	}
	else {
		$task['file'] = '';
	}

	foreach ($required as $key) {
		if (empty($_POST[$key])) {
            $errors[$key] = 'Это поле надо заполнить';
		}
	}

    if (!empty($errors)) {
        $error = mysqli_error($link);
        $page_content = include_template('add.php', ['error' => $error]);

	} else {

        $sql_insert = "INSERT INTO tasks SET
            `date_add` = NOW(),
            `title` = '$title',
            `file` = '{$task['file']}',
            `deadline` =  '$deadline',
            `user_id` = '$user_id',
            `project_id` = '$project_id'
        ";

        if (!$res = mysqli_query($link, $sql_insert)) {
            $error = mysqli_error($link);
            $page_content = include_template('add.php', ['error' => $error]);
            $tasks = mysqli_fetch_all($res, MYSQLI_ASSOC);
        } else {
            header('Location: /index.php');
        }
    }
}

if (!$link) {
    $error = mysqli_connect_error();
    $page_content = include_template('error.php', ['error' => $error]);
} else {
    $sql = "SELECT `projects`.`id`, `projects`.`title`, `projects`.`user_id`, COUNT(`tasks`.`id`) AS tasks FROM `projects` LEFT JOIN `tasks` ON `tasks`.`project_id` =`projects`.`id` GROUP BY `projects`.`id`, `projects`.`title`, `projects`.`user_id`";

    if (!$res = mysqli_query($link, $sql)) {
        $error = mysqli_error($link);
        $page_content = include_template('error.php', ['error' => $error]);
    } else {
        $projects = mysqli_fetch_all($res, MYSQLI_ASSOC);
    }
    $where = '';

    if (isset($_GET['project_id'])) {
        $project_id = mysqli_real_escape_string($link, $_GET['project_id']);
        $where = " WHERE project_id = " . $project_id;
    }

    $sql = "SELECT * FROM tasks" . $where;
    if (!$res = mysqli_query($link, $sql)) {
        $error = mysqli_error($link);
        $page_content = include_template('error.php', ['error' => $error]);
    } else {
        $tasks = mysqli_fetch_all($res, MYSQLI_ASSOC);
    }
}

$tasks = mysqli_fetch_all(mysqli_query ($link, $sql), MYSQLI_ASSOC);

$page_content = include_template("form-task.php", ['tasks' => $tasks, 'errors' => $errors, 'dict' => $dict, "projects" => $projects]);

$layout_data = [
    'projects' => $projects,
    'site_title' => $site_title,
    'page_content' => $page_content,
    'content' => $content
];

$layout_content = include_template('layout.php', $layout_data);

print($layout_content);