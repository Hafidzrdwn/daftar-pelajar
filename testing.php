<?php
session_start();
if (!isset($_SESSION["login-daftar-pelajar"])) {
  header("Location: login.php");
  exit;
}

if ($_SESSION['username-users'] != 'tester') {
  header("Location: index.php");
}


// require_once("functions.php");

// $pelajar = query("SELECT * FROM pelajar");
?>
<!doctype html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

  <title>Halaman Testing</title>

  <!-- MY CSS -->
  <link rel="stylesheet" href="./css/style.css?v=<?php echo time(); ?>" />
</head>

<body class="bg-danger">

  <div class="container-fluid py-5">
    <!-- Card -->
    <div class="row justify-content-center">
      <div class="col-lg-5">
        <div class="card text-center border shadow">
          <img src="images/thanks.jpg" class="card-img-top" alt="...">
          <div class="card-body">
            <h5 class="fw-bold card-title mb-2">Halo Tester terimakasih sudah mengisi form!!</h5>
            <p>Apakah anda ingin logout?</p>
            <a href="index2.php" class="btn btn-success">Isi Data Lagi</a>
            <a href="logout.php" class="btn btn-danger">Logout</a>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
  <script src="https://kit.fontawesome.com/2e160f1ac0.js" crossorigin="anonymous"></script>
  <script src="script/script.js"></script>
  <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>

</html>