<?php
include('db.php');

// Autentikasi login dan data post
if(isset($_SESSION['user_id']) && isset($_POST['user_id'])){
    $id = $_POST['user_id'];
    
    $sql = "SELECT * FROM users WHERE id = ?";

    $stmt = $kunci->prepare($sql);
    $data = [$id];
    $stmt->execute($data);
    $userdata = $stmt->fetch(PDO::FETCH_ASSOC);
?>


<!doctype html>
<html lang="en">
    <head>
    <meta charset="utf-8">
        <title>Dashboard</title>
    </head>
<body>

<?php
include('navbar.php');
?>

<main class="container">
    <br><br>
<h2 class="pb-2 border-bottom">Edit Profil</h2>
<div class="row g-5">
    <div class="col-md-8 p-3 bg-body rounded shadow-sm">
    <h6 class="border-bottom pb-2 mb-0">&nbsp;</h6>
   
    <form action="edit_process.php" method="post" enctype="multipart/form-data">
        <input name="user_id" type="hidden" value="<?=$_SESSION['user_id']?>">
        <div class="mb-2 pt-2">
            <label class="form-label">Username</label>
            <input name="username" type="text" class="form-control" value="<?=$userdata['username']?>" disabled required>
            <small class="text-muted">Username tidak bisa diubah.</small>
        </div>
        <div class="mb-2 pt-2">
            <label class="form-label">Password</label>
            <input name="password" type="password" class="form-control rounded-3" value="" required>
        </div>
        <div class="mb-2 pt-2">
            <label class="form-label">Nama Lengkap</label>
            <input name="namalengkap" type="text" class="form-control rounded-3" value="<?=$userdata['namalengkap']?>" required>
        </div>
        <div class="mb-2 pt-2">
            <label class="form-label">Email</label>
            <input name="email" type="email" class="form-control rounded-3" value="<?=$userdata['email']?>" required>
        </div>
        <div class="mb-2 pb-2">
            <label class="form-label">Foto Profil</label>
            <input type="file" name="fotoprofil" class="form-control rounded-3" required>
            <small class="text-danger">Mohon memilih ulang foto profil.</small>
        </div>
  <button type="submit" class="btn btn-primary">Update Profil</button>
</form>

<small class="d-block text-end mt-3">
      <a href="index.php">Kembali</a>
    </small>
  </div>

<!-- SIDEBAR -->

<div class="col-md-4">
      <div class="position-sticky" style="top: 2rem;">
        <div class="p-4 mb-3 bg-light rounded">
          <h4>Peraturan</h4>
          <p class="mb-0">1. Bahasa Indonesia dianjurkan.</a></p>
          <p class="mb-0">2. Hormati sesama user.</a></p>
          <p class="mb-0">3. Tidak diperbolehkan spam.</a></p>
          <p class="mb-0">4. Jangan toxic, rasis, dan lain-lain.</a></p>
          <p class="mb-0">5. Jaga konten post sesuai kategori.</a></p>
          <p class="mb-0">&nbsp;</a></p>
          <p class="mb-0">Jika melanggar, maka akan mendapat sanksi</a></p>
        </div>
          
          <?php
          include('statistik.php');
          ?>

        
      </div>
    </div>
  </div>

<!-- END SIDEBAR -->

<br><br>

<script src="/docs/5.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<script src="offcanvas.js"></script>


<?php
  include('footer.php');
?>

</main>
  </body>
</html>


<?php
}
?>
