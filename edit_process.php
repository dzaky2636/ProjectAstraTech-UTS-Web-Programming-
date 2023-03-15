<?php
include('db.php');

$user_id = $_POST['user_id'];

$password = $_POST['password'];
$namalengkap = $_POST['namalengkap'];
$email = $_POST['email'];
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

$sql = "UPDATE users SET password = ?, namalengkap = ?, email = ?, fotoprofil = ?
            WHERE id = ?";

$stmt = $kunci->prepare($sql);
$data = [$en_pass, $namalengkap, $email, $filename, $user_id];

if(!$stmt->execute($data)){
    header("Location:index.php");
}else{
    include('logout.php');
}
?>