<?php
include('db.php');
include('navbar.php');

// Jika kategori tidak masuk dalam URL, maka error.
if(isset($_GET['cat']) ){
  if($_GET['cat'] == 'html' || $_GET['cat'] == 'php' || $_GET['cat'] == 'js' || $_GET['cat'] == 'java' || 
  $_GET['cat'] == 'c' || $_GET['cat'] == 'cplus' || $_GET['cat'] == 'csharp' || $_GET['cat'] == 'python'){

  switch($_GET['cat']){
      case 'html':
          $id = "1";
          $name = "HTML";
          $img = "html.png";
          $description = "Tempat berdiskusi untuk pemrogramman HTML. HTML digunakan sebagai dasar dalam pembentukan tampilan dan struktur website.";
          $color = "text-black bg-light";
          break;
      case 'php':
          $id = "2";
          $name = "PHP";
          $img = "php.svg";
          $description = "Tempat berdiskusi untuk pemrogramman PHP. Hypertext Preprocessor, Utamanya digunakan oleh user sabagai pembuatan website dengan loading cepat,
          Karena fungsi utama PHP, Sekarang ini PHP digunakan untuk GUI dan Control Robotic Drone.";
          $color = "text-white bg-dark";
          break;
      case 'js':
          $id = "3";
          $name = "JavaScript";
          $img = "js.png";
          $description = "Tempat berdiskusi untuk pemrogramman JavaScript. JS atau biasa di kenal dengan JavaScript, Bahasa ini digunakan untuk mengexsekusi code yang ada pada user,
          Bahasa ini masuk ke High-Level karena memiliki API untuk menhubungkan informasi antar website.";
          $color = "text-white bg-warning";
          break;
      case 'java':
          $id = "4";
          $name = "Java";
          $img = "java.png";
          $description = "Tempat berdiskusi untuk pemrogramman Java. Bahasa ini diciptakan dengan tujuan untuk user menulis code dan dapat dijalankan dari semua device,
          Java ini adalah sebuah bahasa pemogramman website inti dari JavaScript, Java ini umurnya lebih tua setahun dari Javascript.";
          $color = "text-white bg-danger";
          break;
      case 'c':
          $id = "5";
          $name = "C";
          $img = "c.png";
          $description = "Tempat berdiskusi untuk pemrogramman C. Diciptakan pada tahun 1972, Bahasa progamming ini umumnya dibentuk untuk arsitektur komputer dari yang dibuat khusus hingga hingga embed system,
          Hingga sekarang ini bahasa ini sering digunakan karena mudah dipahami dan juga arsitektur komputer masih terus.";
          $color = "text-white bg-primary";
          break;
      case 'cplus':
          $id = "6";
          $name = "C++";
          $img = "c++.png";
          $description = "Tempat berdiskusi untuk pemrogramman C++. Diciptakan pada tahun 1985, C++ merupakan sebuah extensi dari C yang memiliki tingkat yang lebih complex dan sering kena kritik, Karena bahasa programming tersebut
          sering digunakan tetapi hanya fungsi dasar yang terdapat di C, sementara fungsi khusus C++ sangat jarang digunakan.";
          $color = "text-white bg-primary";
          break;
      case 'csharp':
          $id = "7";
          $name = "C#";
          $img = "csharp.png";
          $description = "Tempat berdiskusi untuk pemrogramman C#. Diciptakan pada tahun 2000, Diciptakan sebagai bahasa pemogramman modern yang dapat digunakan oleh Sistem Operasi dan menggunakan resource dengan hemat.";
          $color = "text-white bg-primary";
          break;
      case 'python':
          $id = "8";
          $name = "Python";
          $img = "python.png";
          $description = "Tempat berdiskusi untuk pemrogramman Python. Diciptakan pada 20-Febuari-1991 ,Phython merupakan bahasa progamming yang dikenal memiliki tujuan untuk development, 
          Baik untuk sebuah aplikasi 3D, 2D, Audio, dan juga sebuah keamanan informasi dalam sebuah industri,";
          $color = "text-black bg-light";
          break;
  }

if(isset($_GET['sort'])){
  if($_GET['sort'] == 'trending'){
    $sql = "SELECT posts.*, COUNT(replies.post_id) AS TotalKomentar, 
    ((SELECT COUNT(likes_posts.id) FROM likes_posts WHERE likes_posts.post_id = posts.id * 0.3) + (COUNT(replies.post_id * 0.7))) AS TrendPoint,
    (SELECT COUNT(likes_posts.id) FROM likes_posts WHERE likes_posts.post_id = posts.id) AS TotalLikes
    FROM posts 
    LEFT JOIN replies ON posts.id = replies.post_id 
    WHERE topic_id = $id GROUP BY posts.id ORDER BY TrendPoint DESC";
  }else{
    $sql = "SELECT posts.*, COUNT(replies.post_id) AS TotalKomentar, 
    (SELECT COUNT(likes_posts.id) FROM likes_posts WHERE likes_posts.post_id = posts.id) AS TotalLikes 
    FROM posts 
    LEFT JOIN replies ON posts.id = replies.post_id 
    WHERE topic_id = $id GROUP BY posts.id";
  }
}else{
    $sql = "SELECT posts.*, COUNT(replies.post_id) AS TotalKomentar, 
    (SELECT COUNT(likes_posts.id) FROM likes_posts WHERE likes_posts.post_id = posts.id) AS TotalLikes 
    FROM posts 
    LEFT JOIN replies ON posts.id = replies.post_id 
    WHERE topic_id = $id GROUP BY posts.id";
}


$hasil = $kunci->query($sql);

?>

<!doctype html>
<html lang="en">
    <head>
    <meta charset="utf-8">
        <title>Kategori</title>
    </head>
<body>

<main class="container">
    <div class="d-flex align-items-center p-3 my-3 <?= $color ?> rounded shadow-sm">
        <img class="me-3" src="assets/<?= $img ?>" alt="" width="120" height="120">
        <div class="lh-1">
        <h1 class="h3 mb-0 <?= $color ?> lh-1"><?= $name ?></h1>
        <p></p>
        <small> <?=$description?> </small>
        </div>
    </div>


    <div class="row g-5">
    <div class="col-md-8 p-3 bg-body rounded shadow-sm">
    <?php
        if(isset($_GET['sort'])){
          if($_GET['sort'] == 'trending'){
            echo '<h6 class="border-bottom pb-2 mb-0 fw-bold">Postingan Trending</h6>';
          }else{
            echo '<h6 class="border-bottom pb-2 mb-0 fw-bold">Postingan Terbaru</h6>';
          }
        }else{
          echo '<h6 class="border-bottom pb-2 mb-0 fw-bold">Postingan Terbaru</h6>';
        }
        ?>
   
    <table class="table table-striped table-bordered p-3">
          <thead class="thead-light">
              <tr>
                  <th scope="col" class="forum-col">Postingan</th>
                  <th scope="col">Like</th>
                  <th scope="col">Komentar</th>
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
                    // Jika konten post > 140, sisanya replace dengan '...';
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
                  <td><?= $row['TotalKomentar']?></td>
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

  </div>

<!-- SIDEBAR -->

<div class="col-md-4">
      <div class="position-sticky" style="top: 2rem;">
        <div class="p-4 mb-3 bg-light rounded">
          <h4>Forum <?= $name ?></h4>
          <p class="mb-0"><a class="text-decoration-none" href="kategori.php?cat=<?=$_GET['cat']?>&sort=terbaru">Sorting Terbaru</a></p>
          <p class="mb-0"><a class="text-decoration-none" href="kategori.php?cat=<?=$_GET['cat']?>&sort=trending">Sorting Trending</a></p>
          <p></p>
          <p class="mb-0 "><a class="text-decoration-none" href="buatpost.php?cat=<?=$_GET['cat']?>">Buat Post</a></p>          
        </div>

        <?php
          if(isset($_SESSION['user_id'])){
            if($_SESSION['user_role'] == 'admin'){
              ?>

              <div class="p-4 mb-3 bg-light rounded text-danger">
                <h4>Kendali Admin</h4>
                <p class="mb-0"><a class="text-decoration-none" href="exportexcel.php?cat=<?=$id?>">Export Data Kategori ke Excel</a></p>
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

<!-- END SIDEBAR -->

<br><br>

<script src="/docs/5.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<script src="offcanvas.js"></script>

<?php
  include('footer.php');
  }else{
    include('error.php');
  }
  

        
}else{
  include('error.php');
}

?>

</main>
  </body>
</html>
