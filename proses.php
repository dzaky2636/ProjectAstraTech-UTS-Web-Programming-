<?php
$dsn = "mysql:host=localhost;dbname=pemwebuts";
$kunci = new PDO($dsn, "root", "");

$cat = $_POST['cat'];

if($_POST['cat'] == 0){
    switch($_POST['topic_id']){
        case "1": $cat = 'html'; break;
        case "2": $cat = 'php'; break;
        case "3": $cat = 'js'; break;
        case "4": $cat = 'java'; break;
        case "5": $cat = 'c'; break;
        case "6": $cat = 'cplus'; break;
        case "7": $cat = 'csharp'; break;
        case "8": $cat = 'python'; break;
    }
}else{
    $cat = $_POST['cat'];
}

$topic_id = $_POST['topic_id'];
$user_id = $_POST['user_id'];
$author = $_POST['author'];
$title = $_POST['title'];
$body = $_POST['body'];

$sql = "INSERT INTO posts (topic_id, user_id, author, title, body)
            VALUES (?, ?, ?, ?, ?)";

$stmt = $kunci->prepare($sql);
$data = [$topic_id, $user_id, $author, $title, $body];
$stmt->execute($data);

header('Location: kategori.php?cat=' . $cat);
?>