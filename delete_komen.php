<?php
include('db.php');

$id = $_POST['id'];
$post_id = $_POST['post_id'];

$sql = "DELETE FROM replies WHERE id=?";

$stmt = $kunci->prepare($sql);
$data = [$id];
$stmt->execute($data);


header('location:detailpost.php?id=' . $post_id);
?>