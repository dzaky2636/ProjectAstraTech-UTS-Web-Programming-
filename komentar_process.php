<?php
$dsn = "mysql:host=localhost;dbname=pemwebuts";
$kunci = new PDO($dsn, "root", "");

$post_id = $_POST['post_id'];
$author = $_POST['author'];
$body = $_POST['body'];

$sql = "INSERT INTO replies (post_id, author, body)
            VALUES (?, ?, ?)";

$stmt = $kunci->prepare($sql);
$data = [$post_id, $author, $body];
$stmt->execute($data);

$stmt = $kunci->prepare($sql);
$data = [$post_id];
$stmt->execute($data);

header('Location: detailpost.php?id=' . $post_id);
?>