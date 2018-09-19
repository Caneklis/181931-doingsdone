<?php
require_once('functions.php');
require_once('data.php');

$page_content = include_template('index.php', [$projects, $show_complete_tasks]);

$layout_content = include_template('layout.php', [$tasks, $site_title]);

print($layout_content);