<?php
$dsn = "mysql:host=localhost;dbname=pemwebuts";
$kunci = new PDO($dsn, "root", "");

session_start();

$username = $_POST['username'];
$password = $_POST['password'];

$sql = "SELECT * FROM users
        WHERE username = ?";

$stmt = $kunci->prepare($sql);
$stmt->execute([$username]);
$row = $stmt->fetch(PDO::FETCH_ASSOC);

if(!$row){
    header('location: login.php?err=notfound'); 
}elseif($row['is_banned'] == 1){
    header('location: login.php?err=banned'); 
}else{
    echo "USERNAME ada di database. <br>";
    echo "Password yang diinput di form login: " . $password;
    echo "<br> Password yang tersimpan di database: " . $row['password'];
    if(!password_verify($password, $row['password'])){
        echo "<br>Password yang dimasukkan salah.";
        header('location: login.php');
    }else{
        $_SESSION['user_id'] = $row['id'];
        $_SESSION['user_role'] = $row['role'];
        $_SESSION['username'] = $row['username'];
        $_SESSION['fotoprofil'] = $row['fotoprofil'];
        header('location: index.php');
    }
}



?>