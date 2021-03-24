<?php

$conn = new mysqli("localhost", "clem", "pass", "onzecord");

$data = json_decode(file_get_contents('php://input'), true);

$channelId = $data['channel_id'];
$lastId = $data['last_id'];

$stmt = $conn->prepare("SELECT id, body, author FROM posts WHERE channel_id = ? AND id > ?");
$stmt->bind_param('ii', $channelId, $lastId);
$stmt->execute();

$r = $stmt->get_result();

$results = [];
while($row = $r->fetch_assoc()) {
    $results[] = $row;
}
$conn->close();

echo json_encode($results);
