<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>

<style>
.vertical-center {
  min-height: 100%;  
  min-height: 100vh; 

  display: flex;
  align-items: center;
}
</style>

<?php
include('db.php');

// Jika sudah login, otomatis ke index.
if(isset($_SESSION['user_id'])){
  header('Location: index.php');
}
?>

<title>Login</title>

<div class="jumbotron vertical-center">
<div class="modal modal-signin position-static d-block bg-white py-5" tabindex="-1" role="dialog" id="modalSignin">
  <div class="modal-dialog" role="document">
    <div class="modal-content rounded-4 shadow">
      <div class="modal-header p-5 pb-4 border-bottom-0">
        <h1 class="fw-bold mb-0 fs-2">Login</h1>
      </div>
      
      <div class="modal-body p-5 pt-0">

      <?php
          if(isset($_GET['err'])){
            if($_GET['err'] == "banned"){
              echo '
                  <div class="alert alert-danger" role="alert">
                    Maaf, akun anda di ban.
                  </div>';
            }elseif($_GET['err'] == "notfound"){
              echo '
                  <div class="alert alert-danger" role="alert">
                    Akun tidak ditemukan.
                  </div>';
            }
          }
        ?>

        <form action="login_process.php" class="" method="post">
          <div class="form-floating mb-3">
            <input type="text" name="username" class="form-control rounded-3" id="floatingInput" placeholder="name@example.com">
            <label for="floatingInput">Username</label>
          </div>
          <div class="form-floating mb-3">
            <input type="password" name="password" class="form-control rounded-3" id="floatingPassword" placeholder="Password">
            <label for="floatingPassword">Password</label>
          </div>
          <button class="w-100 mb-2 btn btn-lg rounded-3 btn-primary" role="button" type="submit">Login</button>
          <small class="text-muted">Pastikan anda memiliki akun terlebih dahulu.</small>
          <hr class="my-4">
          <h2 class="fs-5 fw-bold mb-3 text-center">Atau daftar akun baru</h2>
          <a class="w-100 py-2 mb-2 btn btn-outline-primary rounded-3" href="register.php" role="button">
            Daftar
          </a>
          <small class="text-muted content-center"><a href="index.php">Kembali</a></small>
        </form>
      </div>
    </div>
  </div>
</div>
</div>

    
  </body>
</html>
