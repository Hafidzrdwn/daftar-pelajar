<?php
session_start();
if (!isset($_SESSION["login-daftar-pelajar"])) {
  header("Location: login.php");
  exit;
}

require_once("functions.php");

$id = $_GET['id'];
$pelajar = query("SELECT * FROM pelajar WHERE id= '$id'")[0];

if (!isset($id)) {
  header("Location: index.php");
}
?>
<!doctype html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

  <title>Detail Pelajar</title>

  <!-- MY CSS -->
  <link rel="stylesheet" href="./css/style.css?v=<?php echo time(); ?>" />
</head>

<body>

  <div class="container-fluid pb-4">
    <!-- header -->
    <div class="row justify-content-between bg-dark text-light align-items-center p-4 mb-5">
      <div class="col-4">
        <a href="index.php" class="btn btn-secondary">&laquo; Kembali</a>
      </div>
      <div class="col-4 text-center">
        <h3 class="welcomeText">Halaman Detail Pelajar</h3>
      </div>
      <div class="col-4 text-end">
        <a class="ms-5 btn btn-danger" href="logout.php">Logout</a>
      </div>
    </div>

    <div class="row justify-content-center px-5">
      <div class="col-lg-8 d-flex justify-content-center">
        <div class="card-detail-wrapper w-100 shadow rounded d-flex">
          <img width="45%" src="images/<?= $pelajar['gambar']; ?>" alt="">
          <div class="card-description-wrapper d-flex align-items-center p-4">
            <ul class="list-group list-group-flush">
              <li class="list-group-item">
                <h4><?= $pelajar['nama']; ?></h4>
              </li>
              <li class="list-group-item">
                <h6>Jenis Kelamin : <?= $pelajar['jenis_kelamin']; ?></h6>
              </li>
              <li class="list-group-item">
                <h6>Kelas : <?= $pelajar['kelas'] . " " . $pelajar['jurusan']; ?></h6>
              </li>
              <li class="list-group-item">
                <h6>Email : <?= $pelajar['email']; ?></h6>
              </li>
              <li class="list-group-item">
                <h6>No. Telp : <?= $pelajar['telp']; ?></h6>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>

    <!-- Button Group -->
    <div class="row px-5 mt-5">
      <div class="col text-center">
        <div class="btn-group" role="group" aria-label="Basic example">
          <a href="edit.php?id=<?= $pelajar['id']; ?>" class="btn btn-primary"><i class="me-2 far fa-edit"></i>Edit data</a>
          <button type="button" onclick="question()" class="btn btn-danger"><i class="me-2 far fa-trash-alt"></i>Hapus data</button>
        </div>
      </div>
    </div>

  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
  <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="https://kit.fontawesome.com/2e160f1ac0.js" crossorigin="anonymous"></script>
  <?php if ($_SESSION['username-users'] != 'tester') : ?>
    <script>
      const question = () => {
        Swal.fire({
          icon: 'question',
          title: 'Apakah anda yakin untuk menghapus data',
          confirmButtonColor: '#DC3545',
          confirmButtonText: 'Yakin',
          showCancelButton: true,
          cancelButtonText: 'Tidak'
        }).then((result) => {
          if (result.isConfirmed) {
            document.location.href = "hapus.php?id=<?= $id; ?>&gambar=<?= $pelajar["gambar"] ?>";
          } else {
            Swal.close();
          }
        });
      }
    </script>
  <?php endif; ?>
</body>

</html>