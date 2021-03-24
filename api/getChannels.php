<?php

$conn = new mysqli("localhost", "clem", "pass", "onzecord");

$stmt = $conn->prepare("SELECT name, id FROM channels");
$stmt->execute();

$r = $stmt->get_result();

$results = [];
while($row = $r->fetch_assoc()) {
    $results[] = $row;
}
$conn->close();

echo json_encode($results);
