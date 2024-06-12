CREATE DATABASE IF NOT EXISTS docker_doc;
CREATE DATABASE IF NOT EXISTS docker_doc_dev;

USE docker_doc_dev;

CREATE TABLE IF NOT EXISTS article (
    id BIGINT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(32),
    body TEXT
);

INSERT INTO article (id, title, body) VALUES
(1, 'Docker overview', 'Docker is an open platform for developing, shipping, and running applications. Docker enables you to separate your applications from your infrastructure so you can deliver software quickly.'),
(2, 'What is a container?', 'Imagine you’re developing a killer web app that has three main components - a React frontend, a Python API, and a PostgreSQL database. If you wanted');

USE docker_doc;

CREATE TABLE IF NOT EXISTS article (
    id BIGINT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(32),
    body TEXT
);

GRANT ALL PRIVILEGES ON docker_doc.* TO 'db_client'@'%';
GRANT ALL PRIVILEGES ON docker_doc_dev.* TO 'db_client'@'%';
