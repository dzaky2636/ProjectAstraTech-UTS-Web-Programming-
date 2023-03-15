<?php
include('db.php');

if(!isset($_SESSION['user_id'])){
    header('Location: login.php');
}

$action = $_POST['action'];
$user_id = $_POST['user_id'];
$post_id = $_POST['post_id'];

var_dump($action);

if($action == 'likepost'){
    $sql = "INSERT INTO likes_posts (post_id, user_id)
            VALUES (?, ?)";

    $stmt = $kunci->prepare($sql);
    $data = [$post_id, $user_id];

    if(!$stmt->execute($data)){
        echo "error";
    }else{
        header("Location:detailpost.php?id=" . $post_id);
    }
}elseif($action == 'unlikepost'){
    $sql = "DELETE FROM likes_posts WHERE post_id = ? AND user_id = ?";

    $stmt = $kunci->prepare($sql);
    $data = [$post_id, $user_id];

    if(!$stmt->execute($data)){
        echo "error";
    }else{
        header("Location:detailpost.php?id=" . $post_id);
    }

}elseif($action == 'likekomentar'){
    $replies_id = $_POST['replies_id'];
    $sql = "INSERT INTO likes_replies (replies_id, user_id)
            VALUES (?, ?)";

    $stmt = $kunci->prepare($sql);
    $data = [$replies_id, $user_id];

    if(!$stmt->execute($data)){
        echo "error";
    }else{
        header("Location:detailpost.php?id=" . $post_id);
    }
}elseif($action == 'unlikekomentar'){
    $replies_id = $_POST['replies_id'];
    $sql = "DELETE FROM likes_replies WHERE replies_id = ? AND user_id = ?";

    $stmt = $kunci->prepare($sql);
    $data = [$replies_id, $user_id];
    
    if(!$stmt->execute($data)){
        echo "error";
    }else{
        header("Location:detailpost.php?id=" . $post_id);
    } 
}
?>