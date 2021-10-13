<?php
session_start();
require_once("functions.php");
if (!isset($_SESSION["login-daftar-pelajar"])) {
  header("Location: login.php");
  exit;
}

if ($_SESSION['username-users'] == 'tester') {
  header("Location: index2.php");
}

if (!isset($_GET['id'])) {
  header("Location: index.php");
  exit;
}

$id = $_GET['id'];
$gambar = $_GET['gambar'];

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Hapus Data</title>
  <link rel="stylesheet" href="./css/style.css?v=<?php echo time(); ?>" />
</head>

<body>
  <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <?php if (hapus($id, $gambar) > 0) : ?>
    <script>
      Swal.fire({
        icon: 'success',
        title: 'Hapus Data Berhasil!',
        text: 'Data pelajar berhasil dihapus',
      }).then((result) => {
        document.location.href = 'index.php';
      });
    </script>
  <?php else : ?>
    <script>
      Swal.fire({
        icon: 'error',
        title: 'Hapus Data Gagal!',
        text: 'Data pelajar gagal dihapus',
      }).then((result) => {
        document.location.href = 'index.php';
      });
    </script>
  <?php endif; ?>
</body>

</html>