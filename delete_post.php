<?php
include('db.php');

$id = $_POST['id'];

// Hapus post 
$sql = "DELETE FROM posts WHERE id = ?";

$stmt = $kunci->prepare($sql);
$data = [$id];
$stmt->execute($data);

// Hapus komentar dalam post yang dihapus
$sql = "DELETE FROM replies WHERE post_id = ?";

$stmt = $kunci->prepare($sql);
$data = [$id];
$stmt->execute($data);


header('location:index.php');
?>