<?php
require_once('functions.php');
require_once('data.php');

$page_content = include_template('index.php', $content_data);

$layout_content = include_template('layout.php', $page_data);

print($layout_content);
?>