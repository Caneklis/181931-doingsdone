USE `doingsdone`;

INSERT INTO projects (title, user_id)
VALUES
      ('Входящие', 1),
      ('Учеба', 1),
      ('Работа', 1),
      ('Домашние дела', 2),
      ('Авто', 2);

INSERT INTO tasks (project_id, date_add, deadline, title, task_status, user_id)
VALUES
      (1, '2018-09-30 00:00', '2018-12-01 00:00',  'Собеседование в IT компании', 0, 1),
      (1, '2018-08-23 12:00', '2018-08-25 00:00', 'Выполнить тестовое задание', 1, 1),
      (2,  '2018-09-30 01:00',  '2018-12-21 00:00',  'Сделать задание первого раздела', 1, 1),
      (4,  '2018-09-30 02:00', '2018-12-22 00:00', 'Встреча с другом', 0, 1),
      (4,  '2018-09-02 12:00', NULL, 'Купить корм для кота', 0, 1),
      (4, '2018-09-03 12:00', NULL, 'Заказать пиццу',  0, 1);

INSERT INTO users (date_add, user_email, user_name, user_password)
VALUES
      ('2018-09-30 00:00', 'ivanov_ivan@google.com', 'Иван', 'password'),
      ('2018-09-29 00:0', 'petrov_petr@google.com', 'Петр', 'superpassword');

SELECT * FROM projects WHERE user_id = 1;

SELECT * FROM tasks WHERE id = 2;

UPDATE tasks SET task_status = 1 WHERE id = 1;

SELECT * FROM tasks WHERE DATEDIFF(deadline, CURDATE()) = 1;

UPDATE tasks SET title='Посмотреть интенсив' WHERE id = 6;
