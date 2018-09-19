<?php

function count_tasks($project_title, $task_list) {
    $sum = 0;
    foreach( $task_list as $task ) {    
        if ( $task['category'] == $project_title ) {$sum++;}
    }
    return $sum;
};

function include_template($name, $data) {
    $name = 'templates/' . $name;
    $result = '';

    if (!file_exists($name)) {
        return $result;
    }

    ob_start();
    extract($data);
    require_once $name;

    $result = ob_get_clean();

return $result;
};

function esc($str) {
	$text = htmlspecialchars($str);
	//$text = strip_tags($str);

	return $text;
};
