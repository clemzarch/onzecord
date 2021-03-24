<?php

$conn = new mysqli("localhost", "clem", "pass");
$r = $conn->query('CREATE DATABASE onzecord');
if ($r !== true) {
    var_dump($conn->error);
}
$conn->close();

$conn = new mysqli("localhost", "clem", "pass", "onzecord");

$r = $conn->query('
CREATE TABLE channels (
id INT NOT NULL AUTO_INCREMENT,
name VARCHAR(255) NOT NULL,
PRIMARY KEY (id)
);
');
if ($r !== true) {
    var_dump($conn->error);
}

$r = $conn->query('
CREATE TABLE posts (
id INT NOT NULL AUTO_INCREMENT,
body TEXT NOT NULL,
author VARCHAR(255) NOT NULL,
channel_id INT NOT NULL,
PRIMARY KEY (id)
);
');
if ($r !== true) {
    var_dump($conn->error);
}

$r = $conn->query('
ALTER TABLE posts
ADD CONSTRAINT post_channel
FOREIGN KEY (channel_id)
REFERENCES channels (id)
ON DELETE CASCADE
ON UPDATE CASCADE;
');

if ($r !== true) {
    var_dump($conn->error);
}
$conn->close();
