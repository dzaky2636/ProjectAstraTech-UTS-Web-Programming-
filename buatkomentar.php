<?php
include('db.php');
include('navbar.php');

if(isset($_SESSION['user_id'], $_SESSION['username'], $_SESSION['user_role'])){

$id = $_GET['id'];

$sql = "SELECT * FROM posts WHERE id = ?";  

$stmt = $kunci->prepare($sql);
$data = [$id];
$stmt->execute($data);
$postdata = $stmt->fetch(PDO::FETCH_ASSOC);

?>

<!doctype html>
<html lang="en">
    <head>
    <meta charset="utf-8">
        <title>Dashboard</title>
    </head>
<body>

<?php

?>

<main class="container">
    <br><br>
<h2 class="pb-2 border-bottom">Membalas ke Post: <?= nl2br(htmlspecialchars($postdata['title'], ENT_QUOTES, 'UTF-8')) ?> oleh <?= nl2br(htmlspecialchars($postdata['author'], ENT_QUOTES, 'UTF-8')) ?> </h2>
<div class="row g-5">
    <div class="col-md-8 p-3 bg-body rounded shadow-sm">
    <h6 class="border-bottom pb-2 mb-0">&nbsp;</h6>
    <form action="komentar_process.php" method="post">
        <input name="post_id" type="hidden" value="<?=$postdata['id']?>">
        <input name="author" type="hidden" value="<?=$_SESSION['username']?>"> <!-- mengirim data author dengan input type hidden -->
        
        <div class="mb-3 pt-3">
            <label class="form-label">Komentar</label>
            <textarea name="body" class="form-control" maxlength="5000" required></textarea>
            <div class="form-text">Maks 5000 kata</div>
        </div>
  <button type="submit" class="btn btn-primary">Upload Komentar</button>
</form>

<small class="d-block text-end mt-3 border-bottom pb-5">
      <a href="detailpost.php?id=<?= $id ?>">Kembali</a>
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
}else{
?>
<div class="d-flex justify-content-center">
        <div class="alert alert-primary" role="alert">
            Mohon <a href="login.php">login</a> terlebih dahulu.
        </div>  
    </div>
</div>

<?php
}
?>
</main>
  </body>
</html>
