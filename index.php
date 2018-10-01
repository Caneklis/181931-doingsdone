<?php
error_reporting(E_ALL);
require_once('functions.php');
require_once('data.php');
require_once ('init.php');

$link = mysqli_connect('localhost', 'root', '', 'doingsdone');
mysqli_set_charset($link, "utf8");

$projects = [];
$content = '';

if (!$link) {
    $error = mysqli_connect_error();
    $content = include_template('error.php', ['error' => $error]);
}
else {
    $sql = 'SELECT `id`, `title` FROM projects';
    $result = mysqli_query($link, $sql);

    if ($result) {
        $projects = mysqli_fetch_all($result, MYSQLI_ASSOC);
    }
    
    $sql = "SELECT * FROM tasks projects";
    
    if ($result) {
        $tasks = mysqli_fetch_all($result, MYSQLI_ASSOC);
    }
}

if (!$link) {
    $error = mysqli_connect_error();
    $page_content = include_template('error.php', ['error' => $error]);
} else {
    
    $sql = "SELECT `id`, `title` FROM projects";
    if (!$res = mysqli_query($link, $sql)) {
        $error = mysqli_error($link);
        $page_content = include_template('error.php', ['error' => $error]);
    } else {
        $projects = mysqli_fetch_all($res, MYSQLI_ASSOC);
    }
    //получаем список задач
    $sql = "SELECT * FROM tasks";
    if (!$res = mysqli_query($link, $sql)) {
        $error = mysqli_error($link);
        $page_content = include_template('error.php', ['error' => $error]);
    } else {
        $tasks = mysqli_fetch_all($res, MYSQLI_ASSOC);
    }
}

$page_data = [
    'projects' => $projects,
    'tasks' => esc($tasks),
    'show_complete_tasks' => $show_complete_tasks,
    'page_content' => $page_content,
    'content' => $content
];

$page_content = include_template('index.php', $page_data);

$layout_data = [
    'projects' => $projects,
    'site_title' => $site_title,
    'page_content' => $page_content,
    'content' => $content
];

$layout_content = include_template('layout.php', $layout_data);

print($layout_content);
?>