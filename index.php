<?php
session_start();
if (!isset($_SESSION["login-daftar-pelajar"])) {
  header("Location: login.php");
  exit;
}

require_once("functions.php");

$pelajar = query("SELECT * FROM pelajar");
$result = mysqli_query($conn, "SELECT * FROM pelajar");
$jumlah_baris_database = mysqli_num_rows($result);

?>
<!doctype html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

  <title>Daftar Pelajar</title>

  <!-- MY CSS -->
  <link rel="stylesheet" href="./css/style.css?v=<?php echo time(); ?>" />
</head>

<body>

  <div class="container-fluid pb-5">
    <!-- header -->
    <div class="row justify-content-between bg-dark text-light align-items-center p-4 mb-5">
      <div class="col-6">
        <h3 class="welcomeText"><?= 'Selamat datang, ' . ucwords($_SESSION['username-users']); ?></h3>
      </div>
      <div class="col-6 text-end">
        <a class="ms-5 btn btn-danger" href="logout.php">Logout</a>
      </div>
    </div>
    <!-- judul halaman -->
    <div class="row">
      <div class="col">
        <h1 class="text-center mb-4">Daftar Pelajar</h1>
      </div>
    </div>
    <!-- button-top -->
    <div class="row justify-content-between align-items-center px-5 mt-5">
      <div class=" col-lg-6">
        <form action="" method="POST">
          <div class="input-group rounded form-search w-75 me-auto">
            <input type="search" class="form-control rounded" placeholder="Cari data pelajar.." aria-label="Search" aria-describedby="search-addon" id="keyword" />
            <span class="input-group-text border-0" id="search-addon">
              <i class="fas fa-search"></i>
            </span>
          </div>
        </form>
      </div>
      <div class="col-lg-6 text-end btn-add">
        <?php if ($_SESSION['username-users'] != 'tester') : ?>
          <a href="tambah.php" class="ms-auto btn btn-success">Tambah Data Pelajar<i class="ms-2 fas fa-plus-circle"></i></a>
        <?php else : ?>
          <a href="testing.php" class="ms-auto btn btn-success">Kembali Ke Halaman Testing</a>
        <?php endif; ?>
      </div>
    </div>
    <!-- jumlah data -->
    <div class="row my-4 px-5 countData">
      <div class="col">
        <h6>Jumlah data : <?= count($pelajar); ?></h6>
        <?php if ($_SESSION['username-users'] == 'tester') : ?>
          <p class="text-danger"><span class="fw-bold">Info :</span> Fitur edit data dan hapus data hanya bisa dilakukan oleh admin.</p>
        <?php endif; ?>
      </div>
    </div>
    <!-- tabel -->
    <div class="table-container mx-5">
      <div class="row tableDiv <?php if ($jumlah_baris_database === 0) : ?> emptyTable <?php elseif ($jumlah_baris_database === 1) : ?> oneData <?php endif; ?>">
        <table class="table table-striped ">
          <thead>
            <tr class="text-center">
              <th scope="col">No</th>
              <th scope="col">Gambar</th>
              <th scope="col">Nama</th>
              <th scope="col">Aksi</th>
            </tr>
          </thead>

          <?php $i = 1; ?>

          <tbody class="align-middle text-center">
            <?php foreach ($pelajar as $row) : ?>
              <tr>
                <th scope="row"><?= $i++; ?></th>
                <td>
                  <img class="imageData" src="images/<?= $row['gambar']; ?>" width="100" alt="">
                </td>
                <td><?= $row['nama']; ?></td>
                <td><a href="detail.php?id=<?= $row['id']; ?>" class="btn btn-primary"><i class="me-2 fas fa-info-circle"></i>Lihat Detail</a></td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
        <?php if ($jumlah_baris_database === 0) : ?>
          <div class="row px-5 text-center justify-content-center">
            <div class="col-10">
              <img src="emptyTable.svg" class="w-25 mt-4 mb-3" alt="">
              <h2 class="text-secondary">Data Kosong</h2>
            </div>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </div>

  <script type="text/javascript" src="./script/script.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
  <script src="https://kit.fontawesome.com/2e160f1ac0.js" crossorigin="anonymous"></script>
</body>

</html>