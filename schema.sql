CREATE DATABASE doingsdone
    DEFAULT CHARACTER SET utf8
    DEFAULT COLLATE utf8_general_ci;

USE doingsdone;

CREATE TABLE projects (
    id       INT AUTO_INCREMENT PRIMARY KEY,
    title     CHAR(255),
    user_id INT NOT NULL
);

CREATE TABLE tasks (
    id INT AUTO_INCREMENT PRIMARY KEY,
    date_add DATETIME  NOT NULL,
    date_finish DATETIME NOT NULL,
    task_status TINYINT NOT NULL DEFAULT 0,
    title CHAR(255) NOT NULL,
    file CHAR(255),
    deadline DATETIME,
    project_id INT DEFAULT NULL,
    user_id INT NOT NULL
);

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    date_add DATETIME  NOT NULL,
    user_email CHAR(128) NOT NULL,
    user_name CHAR(128) NOT NULL,
    user_password CHAR(64) NOT NULL,
    user_contacts TEXT,
    UNIQUE INDEX (user_email)
);

CREATE UNIQUE INDEX emails ON users(user_email);
CREATE UNIQUE INDEX names ON users(user_name);
CREATE UNIQUE INDEX projects ON projects(title);
CREATE INDEX tasks_date_add ON tasks(date_add);
CREATE INDEX tasks_date_finish ON tasks(date_finish);
CREATE INDEX tasks_deadline ON tasks(deadline);
CREATE INDEX project ON projects(title, user_id);
CREATE INDEX task ON tasks(title, user_id);
