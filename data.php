<?php
$show_complete_tasks = rand(0, 1);

$site_title = 'Дела в порядке';

$projects = ['Входящие', 'Учеба', 'Работа', 'Домашние дела', 'Авто'];

$tasks = [
    0 => [
    'task' => 'Собеседование в IT компании',
    'date' => '01.12.2018',
    'category' => 'Работа',
    'done' => false
    ],
    1 => [
    'task' => 'Выполнить тестовое задание',
    'date' => '25.12.2018',
    'category' => 'Работа',
    'done' => false
    ],
    2 => [
    'task' => 'Сделать задание первого раздела',
    'date' => '21.12.2018',
    'category' => 'Учеба',
    'done' => true
    ],
    3 => [
    'task' => 'Встреча с другом',
    'date' => '22.12.2018',
    'category' => 'Входящие',
    'done' => false
    ],
    4 => [
    'task' => 'Купить корм для кота',
    'date' => 'Нет',
    'category' => 'Домашние дела',
    'done' => false
    ],
    5 => [
    'task' => 'Заказать пиццу',
    'date' => 'Нет',
    'category' => 'Домашние дела',
    'done' => false
    ]
];

$content_data = [
    'projects' => $projects,
    'show_complete_tasks' => $show_complete_tasks
];

$page_data = [
    'projects' => $projects,
    'site_title' => $site_title,
    'tasks' => $tasks
];

$page_content;
?>