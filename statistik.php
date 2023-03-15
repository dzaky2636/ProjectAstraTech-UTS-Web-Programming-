<?php
$sql = "SELECT * FROM users";
$hasil = $kunci->query($sql);
$pdoakun = $hasil->rowCount();


$sql = "SELECT * FROM posts";
$hasil = $kunci->query($sql);
$pdoposts = $hasil->rowCount();


$sql = "SELECT * FROM users WHERE role ='admin'";
$hasil = $kunci->query($sql);
$pdoadmin = $hasil->rowCount();


$sql = "SELECT * FROM users WHERE role ='user'";
$hasil = $kunci->query($sql);
$pdouser = $hasil->rowCount();

?>

<div class="p-4 mb-3 bg-light rounded">
          <h4>Statistik Forum</h4>
          <p class="mb-0">Total Posts: <?= $pdoposts ?></p>
          <p class="mb-0">&nbsp;</p>
          <p class="mb-0">Total Terdaftar: <?= $pdoakun ?></p>
          <p class="mb-0">Total Users: <?= $pdouser ?></p>
          <p class="mb-0">Total Admin: <?= $pdoadmin ?></p>
        </div>