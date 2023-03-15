<?php
include('db.php');

if (!isset($_GET['id'])) {
  $username = $_GET['name'];

  $sql = "SELECT id FROM users WHERE username = '$username'";
  $hasil = $kunci->query($sql);
  $arrayid = $hasil->fetch(PDO::FETCH_ASSOC);

  $id = implode("", $arrayid);
} else {
  $id = $_GET['id'];
}

// Ambil data pribadi user sesuai id 
$sql = "SELECT * FROM users WHERE id = ?";

$stmt = $kunci->prepare($sql);
$data = [$id];
$stmt->execute($data);
$userdata = $stmt->fetch(PDO::FETCH_ASSOC);

$userjoindate = substr($userdata['date_added'], 0, 10);

if (isset($_SESSION['user_id'])) {
  if ($userdata['id'] == $_SESSION['user_id']) {      // Jika bukan profil user, sensor data pribadi
    $namalengkap = $userdata['namalengkap'];
    $email = $userdata['email'];
  } else {
    $namalengkap = "****************";
    $email = "************";
  }
} else {
  $namalengkap = "****************";
  $email = "************";
}

// Ambil data postingan user
$sql = $sql = "SELECT posts.*, COUNT(replies.post_id) AS TotalKomentar, 
(SELECT COUNT(likes_posts.id) FROM likes_posts WHERE likes_posts.post_id = posts.id) AS TotalLikes 
FROM posts 
LEFT JOIN replies ON posts.id = replies.post_id 
WHERE posts.user_id = $id GROUP BY posts.id";

$hasil = $kunci->query($sql);

?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <title>Dashboard</title>

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs5/dt-1.12.1/b-2.2.3/fc-4.1.0/r-2.3.0/datatables.min.css" />

  <style type="text/css">
    /* SweetAlert2 */
    body.swal2-shown>[aria-hidden="true"] {
      transition: 0.1s filter;
      filter: blur(10px);
    }

    .colored-toast.swal2-icon-success {
      background-color: #a5dc86 !important;
    }

    .colored-toast.swal2-icon-error {
      background-color: #f27474 !important;
    }

    .colored-toast .swal2-title,
    .colored-toast .swal2-close,
    .colored-toast .swal2-html-container {
      color: white;
    }

    /* DataTable */
    table.dataTable tbody td {
      vertical-align: middle;
    }
  </style>
</head>

<body>

  <?php
  include('navbar.php');
  ?>

  <main class="container">
    <br>

    <h6 class="pb-2 border-bottom"><a href="index.php" class="text-decoration-none">Forum</a> > Users > <?= $userdata['username'] ?></h2>
      <div class="row g-5">
        <div class="col-md-8 p-3 bg-body rounded shadow-sm">
          <h6 class="border-bottom pb-2 pt-2 mb-0 fw-bold">@<?= nl2br(htmlspecialchars($userdata['username'], ENT_QUOTES, 'UTF-8')) ?></h6>

          <div class="d-flex text-muted pt-3">
            <img src="assets/FotoUsers/<?= $userdata['fotoprofil'] ?>" class="bd-placeholder-img flex-shrink-0 me-2 rounded" width="150" height="150"></img>

            <p class="pb-3 mb-0 small lh-sm  text-black">
              <strong class="d-block text-black pb-2">Nama Lengkap: <?= nl2br(htmlspecialchars($namalengkap, ENT_QUOTES, 'UTF-8')) ?></strong>
              <strong class="d-block text-black pb-2">Email: <?= nl2br(htmlspecialchars($email, ENT_QUOTES, 'UTF-8')) ?></strong>
              <strong class="d-block text-black pb-2">Role: <?= ucwords($userdata['role']) ?></strong>
              <strong class="d-block text-black pb-2">&nbsp;</strong>
              <strong class="d-block text-black pb-2">Tanggal Join: <?= $userjoindate ?></strong>
            </p>
          </div>
          <br>

          <?php
          if (isset($_SESSION['user_id']) && $_SESSION['user_id'] == $id) {
          ?>
            <form action="editprofil.php" method="post">
              <input type="hidden" name="user_id" value="<?= $_SESSION['user_id']; ?>">
              <input type="submit" class="btn btn-warning" value="Edit Profil">
              <br>
              <br>
            <?php
          }
            ?>

            <h6 class="border-bottom pb-1 pt-1 mb-0">Postingan User</h6>
            <br>
            <table class="table table-striped table-bordered p-3">
              <thead class="thead-light">
                <tr>
                  <th scope="col" class="forum-col">Postingan</th>
                  <th scope="col">Like</th>
                  <th scope="col">Komentar</th>
                  <th scope="col" class="last-post-col">Info </th>
                </tr>
              </thead>
              <tbody>

                <?php
                while ($row = $hasil->fetch(PDO::FETCH_ASSOC)) {
                ?>

                  <tr>
                    <td>
                      <h5 class="mb-0"><a href="detailpost.php?id=<?= $row['id'] ?>"><?= nl2br(htmlspecialchars($row['title'], ENT_QUOTES, 'UTF-8')) ?></a></h3>
                        <p class="mb-0">

                          <?php
                          // Jika teks post > 140, sisanya replace dengan '...';
                          if (strlen($row['body']) > 140) {
                            echo nl2br(htmlspecialchars(substr($row['body'], 0, 97), ENT_QUOTES, 'UTF-8')) . '...';
                          } else {
                            echo nl2br(htmlspecialchars($row['body'], ENT_QUOTES, 'UTF-8'));
                          }
                          ?>

                        </p>
                    </td>
                    <td>
                      <div><?= $row['TotalLikes'] ?></div>
                    </td>
                    <td><?= $row['TotalKomentar'] ?></td>
                    <td>
                      <h4 class="h6 mb-0"></h4>
                      <div> by <a href="infouser.php?id=<?= $row['user_id'] ?>">@<?= $row['author'] ?></a></div>
                      <div> <?= $row['created_at'] ?></div>
                    </td>
                  </tr>
                <?php
                }
                ?>
              </tbody>
            </table>
            <small class="d-block text-end border-top p-2 mt-3">
              <a href="index.php">Kembali</a>
            </small>
        </div>

        <!-- SIDEBAR -->

        <div class="col-md-4">
          <div class="position" style="top: 2rem;">

            <?php
            if (isset($_SESSION['user_id'])) {
              if ($_SESSION['user_role'] == 'admin') {
            ?>

                <div class="p-4 mb-3 bg-light rounded">
                  <h4 class="text-danger">Kendali Admin</h4>

                  <button type="button" class="btn btn-dark mt-3" data-bs-toggle="modal" data-bs-target="#userListModal" data-toggle="tooltip" data-placement="top" title="Menampilkan daftar semua akun">
                    <i class="bi bi-table"></i> List Akun
                  </button>

                  <!-- <span id="testBtn"><i class="bi bi-fullscreen" role="button" data-fullscreen></i></span> -->
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
      ?>

  </main>

  <div class="modal fade" id="userListModal" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1" aria-labelledby="userListModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl modal-fullscreen-xxl-down">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="userListModalLabel">List User</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <table id="userListTable" class="table table-striped table-hover" style="width:100%">
            <thead>
              <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <!-- SCRIPT -->
            </tbody>
          </table>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary ms-auto" data-bs-dismiss="modal">Close</button>

          <div class="ms-auto">
            <span class="me-3" role="button" onclick="userList_refresh()" data-toggle="tooltip" data-placement="top" title="Refresh">
              <i class="bi bi-arrow-clockwise"></i>
            </span>
            <span id="userListModalFullscreenBtn" role="button">
              <i class="bi bi-fullscreen" data-toggle="tooltip" data-placement="top" title="Fullscreen"></i>
            </span>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.1/dist/jquery.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
  <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap5.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.5.0/dist/sweetalert2.all.min.js" integrity="sha256-7Aj3hR8VjszIO1+v+ehR706sD5wpug0foOso7pqP4OY=" crossorigin="anonymous"></script>

  <script type="text/javascript">
    $(document).ready(() => {
      const userListTable = $('#userListTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
          url: './users_handle.php',
          method: 'POST',
          data: {
            task: 'get_users_list'
          },
          xhrFields: {
            withCredentials: true
          }
        },
        columns: [{
          data: 'id'
        }, {
          data: 'name'
        }, {
          data: 'username'
        }, {
          data: 'email'
        }, {
          data: null,
          render: (data, type, row) => {
            return `
              <div class="row">
                <div class="col-6">
                  <button class="btn btn-${data.is_banned ? 'success' : 'danger'}" onclick="user_toggle_ban(${data.id}, ${data.is_banned})">${data.is_banned ? 'Unban' : 'Ban'}</button>
                </div>
                <div class="col-6">
                  <button class="btn btn-danger" onclick="user_delete(${data.id})">Hapus</button>
                </div>
              </div>
            `;
          }
        }]
      });
    });

    const Toast = Swal.mixin({
      toast: true,
      position: 'top-right',
      iconColor: 'white',
      customClass: {
        popup: 'colored-toast'
      },
      showConfirmButton: false,
      timer: 1500,
      timerProgressBar: true,
      didOpen: (toast) => {
        toast.addEventListener('mouseenter', Swal.stopTimer);
        toast.addEventListener('mouseleave', Swal.resumeTimer);
      }
    });

    const user_toggle_ban = (id, is_banned) => {
      Swal.fire({
        title: `Anda yakin ingin ${is_banned ? 'unban' : 'ban'} akun ini?`,
        confirmButtonText: is_banned ? 'Unban' : 'Ban',
        allowEnterKey: false,
        showCancelButton: true,
        cancelButtonText: 'Kembali',
        // reverseButtons: true,
        buttonsStyling: false,
        customClass: {
          confirmButton: 'btn btn-danger me-2',
          cancelButton: 'btn btn-secondary'
        }
      }).then((result) => {
        if (result.isConfirmed) {
          $.post({
            url: './users_handle.php',
            data: {
              task: is_banned ? 'unban_user' : 'ban_user',
              id: id
            },
            success: (success) => {
              if (success == 1) {
                Toast.fire({
                  icon: 'success',
                  title: `Berhasil ${is_banned ? 'unban' : 'ban'} user`
                }).then(() => {
                  location.reload();
                });
              } else {
                Toast.fire({
                  icon: 'error',
                  title: `Gagal ${is_banned ? 'unban' : 'ban'} user`
                });
              }
            },
            error: () => {
              Toast.fire({
                icon: 'error',
                title: `Gagal ${is_banned ? 'unban' : 'ban'} user`
              });
            }
          });
        }
      });
    };

    const user_delete = (id) => {
      Swal.fire({
        title: `Anda yakin ingin menghapus akun ini?`,
        confirmButtonText: 'Hapus',
        allowEnterKey: false,
        showCancelButton: true,
        cancelButtonText: 'Kembali',
        // reverseButtons: true,
        buttonsStyling: false,
        customClass: {
          confirmButton: 'btn btn-danger me-2',
          cancelButton: 'btn btn-secondary'
        }
      }).then((result) => {
        if (result.isConfirmed) {
          $.post({
            url: './users_handle.php',    
            data: {
              task: 'delete_user',
              id: id
            },
            success: (success) => {
              if (success == 1) {
                Toast.fire({
                  icon: 'success',
                  title: `Berhasil menghapus user`
                }).then(() => {
                  location.reload();
                });
              } else {
                Toast.fire({
                  icon: 'error',
                  title: `Gagal menghapus user`
                });
              }
            },
            error: () => {
              Toast.fire({
                icon: 'error',
                title: `Gagal menghapus user`
              });
            }
          });
        }
      });
    };
  </script>
</body>

</html>