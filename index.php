<?php
include('db.php');

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
    
<div class="container px-4 py-5" id="icon-grid">
    <div class="p-5 mb-4 bg-light rounded-3">
        <div class="container-fluid py-5">

          <?php
              if(!isset($_SESSION['user_id'])){
                echo '<h1 class="display-5 fw-bold">Selamat Datang!</h1>';
              }else{
                echo '<h1 class="display-5 fw-bold">Selamat Datang Kembali, ' . $_SESSION['username'] . '!</h1>';
              }
            ?>

            <p class="col-md-8 fs-4">Selamat datang ke forum Atras Technologies! Website ini merupakan sebuah forum khusus bahasa 
              pemrogramman yang sering di digunakan dalam era modern. Silahkan posting di sini!</p>
        </div>
    </div>

    <h2 class="pb-2 border-bottom">Forum Bahasa Pemrograman</h2>
    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4 py-5">
      <div class="col d-flex align-items-start">
      <a href="kategori.php?cat=html" class="text-black text-decoration-none">
        <img src="assets/html.png" class="bi text-muted flex-shrink-0 me-3" width="50" height="50"></img>
        <div>
          <h4 class="fw-bold mb-0">HTML</h4>
          <p>1993, digunakan sebagai struktur tampilan website.</p>
          </a>
          </div>
      </div>
      <div class="col d-flex align-items-start">
        <a href="kategori.php?cat=php" class="text-black text-decoration-none">
        <img src="assets/php.svg" class="bi text-muted flex-shrink-0 me-3" width="50" height="50"></img>        
        <div>
          <h4 class="fw-bold mb-0">PHP</h4>
          <p>1995, PHP: Hypertext Preprocessor, scripting language populer untuk website.</p>
          </a>
        </div>
      </div>
      <div class="col d-flex align-items-start">
        <a href="kategori.php?cat=js" class="text-black text-decoration-none">
        <img src="assets/js.png" class="bi text-muted flex-shrink-0 me-3" width="50" height="50"></img>
        <div>
          <h4 class="fw-bold mb-0">JavaScript</h4>
          <p>1995, JS / Javascript, terdapat built-in API.</p>
          </a>
        </div>
        </a>
      </div>
      <div class="col d-flex align-items-start">
        <a href="kategori.php?cat=java" class="text-black text-decoration-none">
        <img src="assets/java.png" class="bi text-muted flex-shrink-0 me-3" width="50" height="50"></img>
        <div>
          <h4 class="fw-bold mb-0">Java</h4>
          <p>1995, Asal dari JS, untuk eksekusi jarak jauh.</p>
          </a>
        </div>
      </div>
      <div class="col d-flex align-items-start">
      <a href="kategori.php?cat=c" class="text-black text-decoration-none">
        <img src="assets/c.png" class="bi text-muted flex-shrink-0 me-3" width="50" height="50"></img>
        <div>
          <h4 class="fw-bold mb-0">C</h4>
          <p>1972, digunakan khusus untuk Arsitektur komputer.</p>
          </a>
        </div>
      </div>
      <div class="col d-flex align-items-start">
      <a href="kategori.php?cat=cplus" class="text-black text-decoration-none">
        <img src="assets/c++.png" class="bi text-muted flex-shrink-0 me-3" width="50" height="50"></img>
        <div>
          <h4 class="fw-bold mb-0">C++</h4>
          <p>1985, C++ terdapat fungsi lebih lengkap dari C.</p>
          </a>
        </div>
      </div>
      <div class="col d-flex align-items-start">
      <a href="kategori.php?cat=csharp" class="text-black text-decoration-none">
        <img src="assets/csharp.png" class="bi text-muted flex-shrink-0 me-3" width="50" height="50"></img>
        <div>
          <h4 class="fw-bold mb-0">C#</h4>
          <p>2000, Bahasa C++ yang lebih modern.</p>
          </a>
        </div>
      </div>
      <div class="col d-flex align-items-start">
      <a href="kategori.php?cat=python" class="text-black text-decoration-none">
        <img src="assets/python.png" class="bi text-muted flex-shrink-0 me-3" width="50" height="50"></img>
        <div>
          <h4 class="fw-bold mb-0">Python</h4>
          <p>1991, Khusus kegiatan development dan security.</p>
          </a>
        </div>
      </div>
    </div>

  <div class="row g-5">
    <div class="col-md-8 p-3 bg-body rounded shadow-sm">
<?php
if(isset($_SESSION['user_id'])){
  $user_id = $_SESSION['user_id'];

  if(!isset($_GET['sort'])){
    $sql = "SELECT posts.*, COUNT(replies.post_id) AS TotalKomentar, 
    (SELECT COUNT(likes_posts.id) FROM likes_posts WHERE likes_posts.post_id = posts.id) AS TotalLikes 
    FROM posts 
    LEFT JOIN replies ON posts.id = replies.post_id 
    WHERE posts.user_id = $user_id GROUP BY posts.id";
  }elseif($_GET['sort'] !== 'trending' ){
    $sql = "SELECT posts.*, COUNT(replies.post_id) AS TotalKomentar, 
    (SELECT COUNT(likes_posts.id) FROM likes_posts WHERE likes_posts.post_id = posts.id) AS TotalLikes 
    FROM posts 
    LEFT JOIN replies ON posts.id = replies.post_id 
    WHERE posts.user_id = $user_id GROUP BY posts.id";
  }elseif($_GET['sort'] == 'trending'){
    $sql = "SELECT posts.*, COUNT(replies.post_id) AS TotalKomentar, 
    ((SELECT COUNT(likes_posts.id) FROM likes_posts WHERE likes_posts.post_id = posts.id * 0.3) + (COUNT(replies.post_id * 0.7))) AS TrendPoint,
    (SELECT COUNT(likes_posts.id) FROM likes_posts WHERE likes_posts.post_id = posts.id) AS TotalLikes
    FROM posts 
    LEFT JOIN replies ON posts.id = replies.post_id 
    WHERE posts.user_id = $user_id GROUP BY posts.id ORDER BY TrendPoint DESC";
  }

  $hasil = $kunci->query($sql);  
?>
  <br>

<h6 class="border-bottom pb-2 mb-0 fw-bold">Postingan Anda</h6>
    <table class="table table-striped table-bordered p-3">
          <thead class="thead-light">
              <tr>
                  <th scope="col" class="forum-col">Postingan</th>
                  <th scope="col">Like</th>
                  <th scope="col">Komentar</th>
                  <!-- <th scope="col">Kategori</th> -->
                  <th scope="col" class="last-post-col">Info</th>
              </tr>
          </thead>
          <tbody>

            <?php
            while($row = $hasil->fetch(PDO::FETCH_ASSOC)){ 
            ?>

              <tr>
                <td>
                <h5 class="mb-0"><a href="detailpost.php?id=<?= $row['id']?>"><?= nl2br(htmlspecialchars($row['title'], ENT_QUOTES, 'UTF-8'))?></a></h3>
                <p class="mb-0">

                    <?php 
                    // Jika teks post > 140, sisanya replace dengan '...';
                      if (strlen($row['body']) > 140){
                        echo nl2br(htmlspecialchars(substr($row['body'], 0, 97), ENT_QUOTES, 'UTF-8')) . '...';
                      }else{
                      echo nl2br(htmlspecialchars($row['body'], ENT_QUOTES, 'UTF-8'));
                      } 
                      ?>

                  </p>
                  </td>
                  <td>
                      <div><?= $row['TotalLikes']?></div>
                  </td>
                  <td><?=$row['TotalKomentar']?></td>
                  <td>
                      <h4 class="h6 mb-0"></h4>
                      <div> by <a href="infouser.php?id=<?= $row['user_id']?>">@<?= nl2br(htmlspecialchars($row['author'], ENT_QUOTES, 'UTF-8'))?></a></div>
                      <div> <?= $row['created_at']?></div>
                  </td>
              </tr>
              <?php
            }
            ?>       
  </tbody>
</table>

<?php
}
?>

<?php
        if(isset($_GET['sort'])){
          if($_GET['sort'] == 'trending'){
            $sql = "SELECT posts.*, COUNT(replies.post_id) AS TotalKomentar, 
            ((SELECT COUNT(likes_posts.id) FROM likes_posts WHERE likes_posts.post_id = posts.id * 0.3) + (COUNT(replies.post_id * 0.7))) AS TrendPoint,
            (SELECT COUNT(likes_posts.id) FROM likes_posts WHERE likes_posts.post_id = posts.id) AS TotalLikes
            FROM posts 
            LEFT JOIN replies ON posts.id = replies.post_id 
            GROUP BY posts.id ORDER BY TrendPoint DESC";
          }else{
            $sql = "SELECT posts.*, COUNT(replies.post_id) AS TotalKomentar, 
            (SELECT COUNT(likes_posts.id) FROM likes_posts WHERE likes_posts.post_id = posts.id) AS TotalLikes 
            FROM posts 
            LEFT JOIN replies ON posts.id = replies.post_id 
            GROUP BY posts.id";
          }
        }else{
            $sql = "SELECT posts.*, COUNT(replies.post_id) AS TotalKomentar, 
            (SELECT COUNT(likes_posts.id) FROM likes_posts WHERE likes_posts.post_id = posts.id) AS TotalLikes 
            FROM posts 
            LEFT JOIN replies ON posts.id = replies.post_id 
            GROUP BY posts.id";
        }

        $hasil = $kunci->query($sql);

        if(isset($_GET['sort'])){
          if($_GET['sort'] == 'trending'){
            echo '<h6 class="border-bottom pb-2 mb-0 fw-bold">Postingan di Forum yang Trending</h6>';
          }else{
            echo '<h6 class="border-bottom pb-2 mb-0 fw-bold">Postingan di Forum yang Terbaru</h6>';
          }
        }else{
          echo '<h6 class="border-bottom pb-2 mb-0 fw-bold">Postingan di Forum yang Terbaru</h6>';
        }
        ?>
   
    <table class="table table-striped table-bordered p-3">
          <thead class="thead-light">
              <tr>
                  <th scope="col" class="forum-col">Postingan</th>
                  <th scope="col">Like</th>
                  <th scope="col">Komentar</th>
                  <!-- <th scope="col">Kategori</th> -->
                  <th scope="col" class="last-post-col">Info</th>
              </tr>
          </thead>
          <tbody>

            <?php
            while($row = $hasil->fetch(PDO::FETCH_ASSOC)){ 
            ?>

              <tr>
                <td>
                <h5 class="mb-0"><a href="detailpost.php?id=<?= $row['id']?>"><?= nl2br(htmlspecialchars($row['title'], ENT_QUOTES, 'UTF-8'))?></a></h3>
                <p class="mb-0">

                    <?php 
                    // Jika teks post > 140, sisanya replace dengan '...';
                      if (strlen($row['body']) > 140){
                        echo nl2br(htmlspecialchars(substr($row['body'], 0, 97), ENT_QUOTES, 'UTF-8')) . '...';
                      }else{
                      echo nl2br(htmlspecialchars($row['body'], ENT_QUOTES, 'UTF-8'));
                      } 
                      ?>

                  </p>
                  </td>
                  <td>
                      <div><?= $row['TotalLikes']?></div>
                  </td>
                  <td><?=$row['TotalKomentar']?></td>
                  <td>
                      <h4 class="h6 mb-0"></h4>
                      <div> by <a href="infouser.php?id=<?= $row['user_id']?>">@<?= nl2br(htmlspecialchars($row['author'], ENT_QUOTES, 'UTF-8')) ?></a></div>
                      <div> <?= $row['created_at']?></div>
                  </td>
              </tr>
              <?php
            }
            ?>       
  </tbody>
</table>

</div>


<!-- SIDEBAR -->

<div class="col-md-4">
      <div class="position-sticky" style="top: 2rem;">
        <div class="p-4 mb-3 bg-light rounded">
          <h4>Dashboard</h4>
          <p class="mb-0"><a class="text-decoration-none" href="index.php?sort=terbaru">Sorting Terbaru</a></p>
          <p class="mb-0"><a class="text-decoration-none" href="index.php?sort=trending">Sorting Trending</a></p>
          <p></p>
          <p class="mb-0 "><a class="text-decoration-none" href="buatpost.php">Buat Post</a></p>
        </div>
          
          <?php
          if(isset($_SESSION['user_id'])){
            if($_SESSION['user_role'] == 'admin'){
              ?>

              <div class="p-4 mb-3 bg-light rounded text-danger">
                <h4>Kendali Admin</h4>
                <p class="mb-0"><a class="text-decoration-none" href="exportexcel.php">Export Data ke Excel</a></p>
              </div>

              <?php
            }
          }
          ?>

          <?php
          include('statistik.php');
          ?>

        </div>
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
