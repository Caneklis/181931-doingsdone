CREATE DATABASE doingsdone
    DEFAULT CHARACTER SET utf8
    DEFAULT COLLATE utf8_general_ci;

USE doingsdone;
 
CREATE TABLE projects (
    id       INT AUTO_INCREMENT PRIMARY KEY,
    name     CHAR(255)
);

CREATE TABLE tasks (  
    id INT AUTO_INCREMENT PRIMARY KEY,
    date_add DATETIME  NOT NULL,
    date_finish DATETIME NOT NULL,
    task_status TINYINT NOT NULL DEFAULT 0,
    title CHAR(255) NOT NULL,
    file CHAR(255),
    deadline DATETIME
);

CREATE TABLE users (  
    id INT AUTO_INCREMENT PRIMARY KEY,
    date_add DATETIME  NOT NULL,
    user_email CHAR(128) NOT NULL,
    user_password CHAR(64) NOT NULL,
    user_contacts TEXT,
    UNIQUE INDEX (user_email)
);