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

if ($_SERVER['REQUEST_METHOD'] == 'POST') { 
    $tasks = $_POST;
    
    $required = ['title', 'deadline', 'project_id'];
    
	
	foreach ($required as $key) {
		if (empty($_POST[$key])) {
            $errors[$key] = 'Это поле надо заполнить';
		}
	}
    
    if (!empty($errors)) {
        print('Ошибка');
		
	} else {
        $_POST['title'];
        $_POST['deadline'];
        $_POST['project_id'];
        
        $result = mysqli_query("INSERT INTO tasks (title, deadline, project_id) VALUES ('$title', '$deadline', '$project_id')");
        //Если запрос пройдет успешно то в переменную result вернется true
        if($result == 'true') 
        {echo "Ваши данные успешно добавлены";}
        else{echo "Ваши данные не добавлены";}
        header("Location: index.php");
        print('Все прошло хорошо, форма отправлена');
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

