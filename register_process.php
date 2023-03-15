<?php
$dsn = "mysql:host=localhost;dbname=pemwebuts";
$kunci = new PDO($dsn, "root", "");

$namalengkap = $_POST['namalengkap'];
$username = $_POST['username'];
$password = $_POST['password'];
$email = $_POST['email'];
$role = $_POST['role'];
$temp_file = $_FILES['fotoprofil']['tmp_name'];
$filename = $_FILES['fotoprofil']['name'];

$en_pass = password_hash($password, PASSWORD_BCRYPT);

$file_ext = explode(".", $filename);
$file_ext = end($file_ext);
$file_ext = strtolower($file_ext);

switch($file_ext){
    case 'jpg':
    case 'jpeg':
    case 'png':
    case 'jpeg':
    case 'svg':
    case 'webp':
    case 'bmp':
    case 'gif':
        move_uploaded_file($temp_file, "assets/FotoUsers/{$filename}");
        break;
    case '':
        echo "Mohon pilih file foto.";
        break;
    default: echo "Mohon untuk hanya mengupload file foto.";
        break;
}

$sql = "INSERT INTO users (username, password, namalengkap, email, fotoprofil, role)
        VALUES (?, ?, ?, ?, ?, ?)";

$stmt = $kunci->prepare($sql);
$data = [$username, $en_pass, $namalengkap, $email, $filename, $role];

if(!$stmt->execute($data)){
    header("Location:register.php?err=1");
}else{
    header("Location:login.php");
}
?>