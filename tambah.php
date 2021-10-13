<?php
session_start();
if (!isset($_SESSION["login-daftar-pelajar"])) {
  header("Location: login.php");
  exit;
}

if ($_SESSION['username-users'] == 'tester') {
  header("Location: index.php");
}

require_once("functions.php");

$pelajar = query("SELECT * FROM pelajar");
$data_jurusan = query("SELECT * FROM data_jurusan");
$errors = " ";

//cek tombol submit apakah sudah ditekan atau belum
if (isset($_POST["tambah"])) {

  //cek apakah data berhasil di tambahkan atau tidak
  if (tambah($_POST) > 0) {
    $success = true;
  } else {
    switch (tambah($_POST)) {
      case -1:
        $errors = "nameErrors";
        break;
      case -2:
        $errors = "emptyJurusan";
        break;
      case -3:
        $errors = "emailErrors";
        break;
      case -4:
        $errors = "telpErrors";
        break;
      case -7:
        $errors = "notAnImage";
        break;
      default:
        echo "gagal menambahkan data";
        break;
    }
  }
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

  <title>Tambah Data Pelajar</title>

  <!-- MY CSS -->
  <link rel="stylesheet" href="./css/style.css?v=<?php echo time(); ?>" />
</head>

<body>

  <div class="container-fluid pb-5">
    <!-- header -->
    <div class="row justify-content-between bg-dark text-light align-items-center p-4 mb-5">
      <div class="col-4">
        <a href="index.php" class="btn btn-secondary">&laquo; Kembali</a>
      </div>
      <div class="col-4 text-center">
        <h3 class="welcomeText">Tambah Data Pelajar</h3>
      </div>
      <div class="col-4 text-end">
        <a class="ms-5 btn btn-danger" href="logout.php">Logout</a>
      </div>
    </div>

    <div class="row justify-content-center">
      <div class="col-lg-6">
        <?php if ($errors === "nameErrors") : ?>
          <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Nama tidak boleh kosong dan tidak boleh mengandung angka!</strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        <?php elseif ($errors === "emptyJurusan") : ?>
          <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Jurusan tidak boleh kosong, harus dipilih!</strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        <?php elseif ($errors === "emailErrors") : ?>
          <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Email kurang valid, coba lagi!</strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        <?php elseif ($errors === "telpErrors") : ?>
          <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>No Telp tidak boleh kosong dan tidak boleh mengandung huruf!</strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        <?php elseif ($errors === "notAnImage") : ?>
          <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>File yang anda upload bukan gambar, silahkan upload ulang!</strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        <?php endif; ?>
      </div>
    </div>

    <!-- form -->
    <div class="row form-tambah px-5 mt-4 justify-content-center">
      <div class="col-lg-6">
        <form action=" " method="POST" enctype="multipart/form-data" class="bg-light border p-4">
          <!-- NAMA -->
          <div class="mb-3">
            <label for="nama" class="form-label">Nama Lengkap</label>
            <input autofocus type="text" name="nama" value="<?php if ($errors === "emptyJurusan" || $errors === "telpErrors" || $errors === "emailErrors" || $errors === "notAnImage") : ?><?= $_POST['nama']; ?><?php endif; ?>" class="<?php if ($errors === "nameErrors") : ?> border border-danger <?php endif; ?>form-control" id="nama" required>
          </div>
          <!-- JENIS KELAMIN -->
          <div class="mb-3">
            <label for="radio1" class="form-label">Jenis Kelamin</label>
            <div class="radioBtnGroup d-flex">
              <div class="form-check me-3">
                <input checked class="form-check-input" type="radio" value="Laki - laki" name="jenis_kelamin" id="radio1">
                <label class="form-check-label" for="radio1">
                  Laki - laki
                </label>
              </div>
              <div class="form-check me-3">
                <input <?php if (($errors === "nameErrors" || $errors === "emptyJurusan" || $errors === "telpErrors" || $errors === "emailErrors" || $errors === "notAnImage") && $_POST['jenis_kelamin'] == "Perempuan") : ?> checked <?php endif; ?> class="form-check-input" type="radio" value="Perempuan" name="jenis_kelamin" id="radio2">
                <label class="form-check-label" for="radio2">
                  Perempuan
                </label>
              </div>
              <div class="form-check">
                <input <?php if (($errors === "nameErrors" || $errors === "emptyJurusan" || $errors === "telpErrors" || $errors === "emailErrors" || $errors === "notAnImage") && $_POST['jenis_kelamin'] == "Other") : ?> checked <?php endif; ?> class="form-check-input" type="radio" value="Other" name="jenis_kelamin" id="radio3">
                <label class="form-check-label" for="radio3">
                  Other
                </label>
              </div>
            </div>
          </div>
          <!-- KELAS -->
          <div class="mb-3">
            <label for="radio4" class="form-label">Kelas</label>
            <div class="radioBtnGroup d-flex">
              <div class="form-check me-3">
                <input checked class="form-check-input" type="radio" value="10" name="kelas" id="radio4">
                <label class="form-check-label" for="radio4">
                  10
                </label>
              </div>
              <div class="form-check me-3">
                <input <?php if (($errors === "nameErrors" || $errors === "emptyJurusan" || $errors === "telpErrors" || $errors === "emailErrors" || $errors === "notAnImage") && $_POST['kelas'] == "11") : ?> checked <?php endif; ?> class="form-check-input" type="radio" value="11" name="kelas" id="radio5">
                <label class="form-check-label" for="radio5">
                  11
                </label>
              </div>
              <div class="form-check">
                <input <?php if (($errors === "nameErrors" || $errors === "emptyJurusan" || $errors === "telpErrors" || $errors === "emailErrors" || $errors === "notAnImage") && $_POST['kelas'] == "12") : ?> checked <?php endif; ?> class="form-check-input" type="radio" value="12" name="kelas" id="radio6">
                <label class="form-check-label" for="radio6">
                  12
                </label>
              </div>
            </div>
          </div>
          <!-- JURUSAN -->
          <div class="mb-3">
            <label for="jurusan" class="form-label">Jurusan</label>
            <select name="jurusan" class="<?php if ($errors === "emptyJurusan") : ?> border border-danger <?php endif; ?> form-select" id="jurusan" aria-label="Default select example" required>
              <option selected value="NULL">Pilih jurusan anda</option>
              <?php foreach ($data_jurusan as $jurusan) : ?>
                <option <?php if (($errors === "nameErrors" || $errors === "telpErrors" || $errors === "emailErrors" || $errors === "notAnImage") && $_POST['jurusan'] == $jurusan['jurusan']) : ?>selected value="<?= $_POST['jurusan']; ?> <?php else : ?> <?= $jurusan['jurusan']; ?> <?php endif; ?>"><?= $jurusan['jurusan']; ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <!-- EMAIL -->
          <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" value="<?php if ($errors === "nameErrors" || $errors === "emptyJurusan" || $errors === "telpErrors" || $errors === "notAnImage") : ?><?= $_POST['email']; ?><?php endif; ?>" class="<?php if ($errors === "emailErrors") : ?>border border-danger <?php endif; ?> form-control" id="email" aria-describedby="emailHelp" required>
            <?php if ($errors === "emailErrors") : ?>
              <div id="emailHelp" class="form-text">panjang email harus 10 karakter / lebih dan kombinasi huruf + angka.</div>
            <?php endif; ?>
          </div>
          <!-- NO TELP -->
          <div class="mb-3">
            <label for="telp" class="form-label">No. Telp</label>
            <input type="text" name="telp" value="<?php if ($errors === "nameErrors" || $errors === "emptyJurusan" || $errors === "emailErrors" || $errors === "notAnImage") : ?><?= $_POST['telp']; ?><?php endif; ?>" class="<?php if ($errors === "telpErrors") : ?> border border-danger <?php endif; ?> form-control" id="telp" aria-describedby="emailHelp" required>
          </div>
          <!-- GAMBAR -->
          <div class="mb-3">
            <img src="images/nophoto.png" class="imgPreview w-25 img-thumbnail d-block mb-2" alt="">
            <label for="formFile" class="form-label">Gambar</label>
            <input class="gambar form-control <?php if ($errors === "notAnImage") : ?> border border-danger <?php endif; ?>" onchange="previewImage()" name="gambar" type="file" id="formFile">
            <div class="form-text <?php if ($errors === "notAnImage") : ?> text-danger <?php endif; ?>">
              Info : size maksimal = 3mb, ektensi = jpg/jpeg/png , Anda bisa saja tidak mengupload gambar.
            </div>
          </div>
          <button type="submit" name="tambah" class="w-100 mt-2 btn btn-primary">Tambah Data</button>
        </form>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
  <script src="https://kit.fontawesome.com/2e160f1ac0.js" crossorigin="anonymous"></script>
  <script src="script/script.js"></script>
  <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <?php if (isset($success)) :
  ?>
    <script>
      Swal.fire({
        icon: 'success',
        title: 'Tambah Data Berhasil!',
        text: 'Data baru telah ditambahkan'
      }).then((result) => {
        document.location.href = 'index.php';
      });
    </script>
  <?php endif;
  ?>
</body>

</html>