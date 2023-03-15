<?php
include('db.php');
include('navbar.php');

if(isset($_SESSION['user_id'], $_SESSION['username'], $_SESSION['user_role'])){

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
<h2 class="pb-2 border-bottom">Buat Post Baru</h2>
<div class="row g-5">
    <div class="col-md-8 p-3 bg-body rounded shadow-sm">
    <h6 class="border-bottom pb-2 mb-0">&nbsp;</h6>
   
    <form action="proses.php" method="post">
        <input name="cat" type="hidden" value="<?php if (isset($_GET['cat'])){ echo $_GET['cat']; }?>">
        <input name="user_id" type="hidden" value="<?=$_SESSION['user_id']?>">
        <input name="author" type="hidden" value="<?=$_SESSION['username']?>"> <!-- mengirim data author dengan input type hidden -->
        <div class="mb-3 pt-3">
            <label class="form-label">Judul</label>
            <input name="title" type="text" class="form-control fw-bold" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Body</label>
            <textarea name="body" class="form-control" maxlength="10000" required></textarea>
            <div class="form-text">Maks 10,000 kata</div>
        </div>
        <div class="mb-3">
            <label for="exampleInputPassword1" class="form-label">Kategori</label>
                <select name="topic_id" class="form-select" aria-label="Default select example">
                <!-- if else mengecek kategori dengan GET kategori, then selected -->
                <option value="1" <?php if (isset($_GET['cat'])){ if($_GET['cat'] == 'html'){ echo "selected";}}?>>HTML</option>
                <option value="2" <?php if (isset($_GET['cat'])){ if($_GET['cat'] == 'php'){ echo "selected";}}?>>PHP</option>
                <option value="3" <?php if (isset($_GET['cat'])){ if($_GET['cat'] == 'js'){ echo "selected";}}?>>JavaScript</option>
                <option value="4" <?php if (isset($_GET['cat'])){ if($_GET['cat'] == 'java'){ echo "selected";}}?>>Java</option>
                <option value="5" <?php if (isset($_GET['cat'])){ if($_GET['cat'] == 'c'){ echo "selected";}}?>>C</option>
                <option value="6" <?php if (isset($_GET['cat'])){ if($_GET['cat'] == 'cplus'){ echo "selected";}}?>>C++</option>
                <option value="7" <?php if (isset($_GET['cat'])){ if($_GET['cat'] == 'csharp'){ echo "selected";}}?>>C#</option>
                <option value="8" <?php if (isset($_GET['cat'])){ if($_GET['cat'] == 'python'){ echo "selected";}}?>>Python</option>
            </select>
            </div>
  <button type="submit" class="btn btn-primary">Upload Postingan</button>
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
