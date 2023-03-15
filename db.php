<?php
session_start();

$dsn = "mysql:host=localhost;dbname=pemwebuts";
$kunci = new PDO($dsn, "root", "");
?>