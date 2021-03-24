<?php

$conn = new mysqli("localhost", "clem", "pass", "onzecord");

$data = json_decode(file_get_contents('php://input'), true);

$body = $data['body'];
$author = $data['author'];
$channel_id = $data['channel_id'];

$stmt = $conn->prepare('INSERT INTO posts (body, author, channel_id) VALUES (?, ?, ?)');
$stmt->bind_param('ssi', $body, $author, $channel_id);
$stmt->execute();
$stmt->close();

echo 'okay';
