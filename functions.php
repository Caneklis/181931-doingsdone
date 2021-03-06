<?php

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

function esc($arr) {
    $res = array();

    foreach($arr as $key => $item){
        if(is_array($item)){
            $res[$key] = esc($item);
        } else {
            $res[$key] = htmlspecialchars($item);
        }
    }

    return $res;
};

function importantTaskCheck($checking_date) {
    $marker = false;
    if (is_numeric(strtotime($checking_date))) {
        $checking_timestamp = strtotime($checking_date);
        $now = time();
        $checking_timestamp = floor(($checking_timestamp - $now)/3600);
        if ($checking_timestamp <= 24) {
            $marker = true;
        }
    }
    return $marker;
};

function show_error(&$content, $error) {
    $content = include_template('error.php', ['error' => $error]);
}

?>
