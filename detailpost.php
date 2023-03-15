<?php
include('db.php');

$id = $_GET['id'];

if(isset($_SESSION['user_id'])){
  $user_id = $_SESSION['user_id'];
}else{
  $user_id = -1;
}


// Ambil data post
$sql = "SELECT posts.*, 
(SELECT COUNT(likes_posts.id) FROM likes_posts WHERE likes_posts.post_id = posts.id) AS JumlahLikes,
likes_posts.user_id FROM posts 
LEFT JOIN likes_posts ON likes_posts.post_id = posts.id AND likes_posts.user_id = $user_id
WHERE posts.id = $id GROUP BY posts.id";

$hasil = $kunci->query($sql);
$postdata = $hasil->fetch(PDO::FETCH_ASSOC);

$kategori = $postdata['topic_id'];

$kontenpost = nl2br($postdata['body']);

// Ambil nama kategori
$sql = "SELECT name FROM topics WHERE id = $kategori";
$hasil = $kunci->query($sql);

$arraykategori = $hasil->fetch(PDO::FETCH_ASSOC);
$namakategori = implode("", $arraykategori);

$date = substr($postdata['created_at'], 0, 10);


// Ambil data pembuat post
$sql = "SELECT * FROM users WHERE username = ?";  

$stmt = $kunci->prepare($sql);
$author = $postdata['author'];
$data = [$author];
$stmt->execute($data);
$dataauthor = $stmt->fetch(PDO::FETCH_ASSOC);


// Total komentar
$sql = "SELECT COUNT(replies.post_id) AS TotalKomentar FROM posts 
LEFT JOIN replies ON posts.id = replies.post_id WHERE replies.post_id = $id GROUP BY posts.id";
$hasil = $kunci->query($sql);

$arraytotalkomentar = $hasil->fetch(PDO::FETCH_ASSOC);

if($arraytotalkomentar == false){                   // Jika total komentar NULL, jadikan nol.
  $totalkomentar = 0;
}else{
  $totalkomentar = implode("", $arraytotalkomentar);
}


// Ambil data komentar
$sql = "SELECT replies.*, 
(SELECT users.fotoprofil FROM users WHERE users.username = replies.author) AS fotoprofil,
(SELECT COUNT(likes_replies.id) FROM likes_replies WHERE likes_replies.replies_id = replies.id) AS TotalLikes,
likes_replies.user_id
FROM replies
LEFT JOIN likes_replies ON likes_replies.replies_id = replies.id AND likes_replies.user_id = $user_id
WHERE replies.post_id = $id
ORDER BY replies.id ASC";
$hasil = $kunci->query($sql);

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
    <br>

    <h6 class="pb-2 border-bottom no-text-decoration  text-black"><a href="index.php" class="text-decoration-none">Forum</a> > Post > <?= $namakategori ?></h2>
  <div class="row g-5">
    <div class="col-md-8 p-3 bg-body rounded shadow-sm">
    <h6 class="border-bottom pb-2 pt-2 mb-0 fw-bold"><?= nl2br(htmlspecialchars($postdata['title'], ENT_QUOTES, 'UTF-8')) ?> </h6>

    <div class="d-flex text-muted pt-3">
      <img src="assets/FotoUsers/<?= nl2br(htmlspecialchars($dataauthor['fotoprofil'], ENT_QUOTES, 'UTF-8')) ?>" class="bd-placeholder-img flex-shrink-0 me-2 rounded" width="60" height="60" role="img"></img>

      <p class="pb-3 mb-0 small lh-sm  text-black">
        <strong class="d-block text-black pb-1"><a href="infouser.php?id=<?= $postdata['user_id'] ?>" class="text-decoration-none text-black">
        <?= $postdata['author']; ?></a> &middot; <?= $date; ?> &middot; <?= $postdata['JumlahLikes']; ?> likes </strong>
        
        <?= nl2br(htmlspecialchars($kontenpost, ENT_QUOTES, 'UTF-8'))?>
    
      </p>
    </div>
        <small class="d-block text-end border-top p-2 mt-3">

                <!-- Like Post -->
                <?php
                  if(!isset($postdata['user_id'])){
                ?>
                  <form action="like_process.php" method="POST" style="display:inline">
                  <input type="hidden" name="action" value="likepost">
                  <input type="hidden" name="post_id" value="<?=$postdata['id']?>">
                  
                  <?php
                  if(isset($_SESSION['user_id'])){
                  ?>

                      <input type="hidden" name="user_id" value="<?=$_SESSION['user_id']?>">

                  <?php
                  }
                  ?>
                  <input type="submit" class="btn btn-primary btn-sm" value="Like">
                </form>
                
                <?php
                  }else{
                ?>

                  <form action="like_process.php" method="POST" style="display:inline">
                  <input type="hidden" name="action" value="unlikepost">
                  <input type="hidden" name="post_id" value="<?=$postdata['id']?>">

                  <?php
                  if(isset($_SESSION['user_id'])){
                  ?>

                      <input type="hidden" name="user_id" value="<?=$_SESSION['user_id']?>">

                  <?php
                  }
                  ?>

                  <input type="submit" class="btn btn-outline-primary btn-sm" value="Unlike">

                <?php
                }
                ?>

            &middot; 
            <a href="buatkomentar.php?id=<?= $postdata['id'] ?>" class="btn btn-primary btn-sm" role="button">Komentar</a>

            <!-- Delete Post -->
            <?php
            if(isset($_SESSION['user_id'])){
              if($_SESSION['user_role'] == 'admin'){
                ?>
                  &middot; 
                  <form action="delete_post.php" method="POST" style="display:inline">
                  <input type="hidden" name="id" value="<?=$postdata['id']?>">
                  <input type="submit" class="btn btn-danger btn-sm" value="Hapus Post" onclick="return confirm('Hapus post dan komentar di dalamnya. Apa anda yakin?')">
                  </form>
        <?php
              }
            }
            ?>

        </small>
        
<!-- KOMENTAR -->

<h6 class="border-bottom pb-2 pt-2 mb-0">Komentar</h6>

    <?php
    while($datakomentar = $hasil->fetch(PDO::FETCH_ASSOC)){
    ?>

    <div class="d-flex text-muted pt-3">
      <img src="assets/FotoUsers/<?=nl2br(htmlspecialchars($datakomentar['fotoprofil'], ENT_QUOTES, 'UTF-8'))?>" class="bd-placeholder-img flex-shrink-0 me-2 rounded" width="32" height="32"></img>

      <div class="pb-3 mb-0 small lh-sm border-bottom w-100">
        <div class="d-flex justify-content-between">
          <strong class="text-black"><a href="infouser.php?name=<?= nl2br(htmlspecialchars($datakomentar['author'], ENT_QUOTES, 'UTF-8'))?>" class="text-decoration-none text-black">
          <?=nl2br(htmlspecialchars($datakomentar['author'], ENT_QUOTES, 'UTF-8'))?></a> &middot; <?= $datakomentar['created_at']?> &middot; <?= $datakomentar['TotalLikes']?> likes</strong>
          <div>

          <!-- Like Komentar -->
          <?php
                  if(!isset($datakomentar['user_id'])){
                ?>
                  <form action="like_process.php" method="POST" style="display:inline">
                  <input type="hidden" name="action" value="likekomentar">
                  <input type="hidden" name="post_id" value="<?=$postdata['id']?>">
                  <input type="hidden" name="replies_id" value="<?=$datakomentar['id']?>">
                  
                  <?php
                  if(isset($_SESSION['user_id'])){
                  ?>

                      <input type="hidden" name="user_id" value="<?=$_SESSION['user_id']?>">

                  <?php
                  }
                  ?>
                  <input type="submit" class="btn btn-primary btn-sm" value="Like">
                </form>
                
                <?php
                  }else{
                ?>

                  <form action="like_process.php" method="POST" style="display:inline">
                  <input type="hidden" name="action" value="unlikekomentar">
                  <input type="hidden" name="post_id" value="<?=$postdata['id']?>">
                  <input type="hidden" name="replies_id" value="<?=$datakomentar['id']?>">

                  <?php
                  if(isset($_SESSION['user_id'])){
                  ?>

                      <input type="hidden" name="user_id" value="<?=$_SESSION['user_id']?>">

                  <?php
                  }
                  ?>

                  <input type="submit" class="btn btn-outline-primary btn-sm" value="Unlike">

                <?php
                }
                ?>

          <!-- Delete Komentar -->
          <?php
            if(isset($_SESSION['user_id'])){
              if($_SESSION['user_role'] == 'admin'){
                ?>
                    &middot; <form action="delete_komen.php" method="POST" style="display:inline">
                    <input type="hidden" name="id" value="<?=$datakomentar['id']?>">
                    <input type="hidden" name="post_id" value="<?= $postdata['id'] ?>">
                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Hapus komentar. Apa anda yakin?')">Delete</button>
                </form>
                <?php
              }
            }
            ?>

        </div>
        </div>
        <span class="d-block"><?= nl2br(htmlspecialchars($datakomentar['body'], ENT_QUOTES, 'UTF-8'))?></span>
      </div>
    </div>

    <?php
    }
    ?>
    
    <small class="d-block text-end mt-3">
      <a href="#">Back to top</a>
    </small>
    
</div>

<!-- END KOMENTAR -->

<!-- SIDEBAR -->

<div class="col-md-4">
      <div class="position-sticky" style="top: 2rem;">
        <div class="p-4 mb-3 bg-light rounded">
          <h4>Info Post</h4>
          <p class="mb-0">Kategori: <?= $namakategori ?></p>
          <p class="mb-0">&nbsp;</p>
          <p class="mb-0">Jumlah Like: <?= $postdata['JumlahLikes'] ?></p>
          <p class="mb-0">Jumlah Komentar: <?= $totalkomentar ?></p>
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
