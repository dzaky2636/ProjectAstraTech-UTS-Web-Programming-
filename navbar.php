<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>

<header class="p-3 bg-dark text-white">
    <div class="container">
      <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
        <a href="index.php" class="d-flex align-items-center mb-2 mb-lg-0 text-white text-decoration-none">
          <img src="assets/logo.png" width="40" height="40"><use xlink:href="#bootstrap"/></img>
        </a>

        <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0 p-1">
          <li><a href="index.php" class="nav-link px-2 text-white">Dashboard</a></li>
        </ul>

        <!-- <form class="col-12 col-lg-auto mb-3 mb-lg-0 me-lg-3">
          <input type="search" class="form-control form-control-dark" placeholder="Search..." aria-label="Search">
        </form> -->

        <?php
            if (!isset($_SESSION['user_id'])){
        ?>

        <div class="text-end">
            <a class="btn btn-outline-light me-2" href="login.php" role="button">Login</a>
            <a type="button" href="register.php" class="btn btn-warning" role="button">Daftar</a>
        </div>

        <?php
        }else{
        ?>

        <div class="dropdown text-end">
        <a href="#" class="d-block link-light text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
            <img src="assets/FotoUsers/<?=$_SESSION['fotoprofil']?>" alt="mdo" width="32" height="32" class="rounded-circle">
        </a>
        <ul class="dropdown-menu text-small" aria-labelledby="dropdownUser1">
            <li><a class="dropdown-item" href="infouser.php?id=<?=$_SESSION['user_id']?>">Profil Saya</a></li>
            <li><a class="dropdown-item" href="buatpost.php">Buat Post</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item text-danger" href="logout.php">Keluar</a></li>
        </ul>

        <?php
        }
        ?>

      </div>
    </div>
  </header>