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

<title>Daftar Akun</title>

<div class="jumbotron vertical-center">
<div class="modal modal-signin position-static d-block bg-white py-5" tabindex="-1" role="dialog" id="modalSignin">
  <div class="modal-dialog" role="document">
    <div class="modal-content rounded-4 shadow">
      <div class="modal-header p-5 pb-4 border-bottom-0">
        <h1 class="fw-bold mb-0 fs-2">Daftar</h1>
      </div>

      <div class="modal-body p-5 pt-0">
        <?php
          if(isset($_GET['err'])){
        ?>
            <div class="alert alert-danger" role="alert">
              Username sudah terdaftar.
            </div>
        <?php
          }  
        ?>
        <form action="register_process.php" method="post" enctype="multipart/form-data">
        <div class="form-floating mb-3">
            <input type="text" name="namalengkap" class="form-control rounded-3" id="floatingInput" placeholder="" required pattern="[^()/><\][\\\x22,;|]+" title="Tidak boleh berisi simbol.">
            <label for="floatingInput">Nama Lengkap</label>
          </div>
        <div class="form-floating mb-3">
            <input type="text" name="username" class="form-control rounded-3" id="floatingInput" placeholder="name@example.com" min="4" max="20" required pattern="[^()/><\][\\\x22,;|]+" title="Tidak boleh berisi simbol.">
            <label for="floatingInput">Username</label>
            <small class="text-danger">Username tidak boleh diubah.</small>
          </div>
          <div class="form-floating mb-3">
            <input type="password" name="password" class="form-control rounded-3" id="floatingPassword" placeholder="Password" min="8" required>
            <label for="floatingPassword">Password</label>
            <small class="text-muted">Minimal 8 karakter.</small>
          </div>
        <div class="form-floating mb-3">
            <input type="email" name="email" class="form-control rounded-3" id="floatingInput" placeholder="name@example.com" required pattern="[^()/><\][\\\x22,;|]+" title="Tidak boleh berisi simbol, kecuali @.">
            <label for="floatingInput">Email</label>
          </div>

          <input type="hidden" name="role" class="form-control rounded-3" value="user">

          <div class="mb-3">
            <label for="floatingPassword">Foto Profil</label>
            <input type="file" name="fotoprofil" class="form-control rounded-3" required>
          </div>
          <button class="w-100 mb-2 btn btn-lg rounded-3 btn-primary" type="submit">Daftar</button>
          <small class="text-muted">Jika sudah memiliki akun, silahkan <a href="login.php">login</a></small>
        </form>
      </div>
    </div>
  </div>
</div>
</div>
    
  </body>
</html>
