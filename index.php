<?php
require_once('functions.php');
require_once('data.php');

$page_data = [
    'projects' => $projects,
    'tasks' => $tasks,
    'show_complete_tasks' => $show_complete_tasks
];

$page_content = include_template('index.php', $page_data);

$layout_data = [
    'projects' => $projects,
    'site_title' => $site_title,
    'page_content' => $page_content
];

$layout_content = include_template('layout.php', $layout_data);

print($layout_content);
?>