<?php
require_once("functions.php");
session_start();

if (mysqli_connect_errno()) {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

if (isset($_SESSION["login-daftar-pelajar"])) {
  header("Location: index.php");
  exit;
}

$errors = " ";

if (isset($_POST["signup"])) {
  if (registrasi($_POST) > 0) {
    $success = true;
  } else {
    switch (registrasi($_POST)) {
      case -1:
        $errors = "isRegist";
        break;
      case -2:
        $errors = "isEmpty";
        break;
      case -3:
        $errors = "isNumeric";
        break;
      case -4:
        $errors = "passSizeError";
        break;
      case -5:
        $errors = "falsePassConfirm";
        break;
      default:
        echo mysqli_error($conn);
        break;
    }
  }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Signup</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous" />
  <link rel="stylesheet" href="css/style.css?v=<?php echo time(); ?>" />
</head>

<body>
  <div class="container p-3 mt-4">
    <div class="row text-center mb-4">
      <div class="col">
        <h1>Halaman Registrasi</h1>
      </div>
    </div>
    <div class="row justify-content-center">
      <div class="col-lg-6">
        <?php switch ($errors):
          case "isRegist": ?>
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
              <strong>Username telah terdaftar!</strong>
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php break; ?>
          <?php
          case "isEmpty": ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
              <strong>Username / Password tidak boleh kosong!</strong>
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php break; ?>
          <?php
          case "isNumeric": ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
              <strong>Username tidak boleh menggunakan angka dan spasi!</strong>
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php break; ?>
          <?php
          case "passSizeError": ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
              <strong>Minimal panjang password harus 8 karakter</strong>
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php break; ?>
          <?php
          case "falsePassConfirm": ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
              <strong>Konfirmasi password tidak sesuai!</strong>
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php break; ?>
          <?php
          default: ?>
            <?php echo mysqli_error($conn); ?>
            <?php break; ?>
        <?php endswitch; ?>
      </div>
    </div>
    <div class="row justify-content-center">
      <div class="col-lg-6">
        <form action=" " method="POST" class="border p-4 bg-light rounded">
          <input type="hidden" name="isRegist" value="true">
          <div class="mb-3">
            <label for="username" class="form-label">Username </label>
            <input type="text" class="form-control <?php if ($errors === "isRegist" || $errors === "isEmpty" || $errors === "isNumeric") : ?> border border-danger <?php endif; ?>" <?php if ($errors === "falsePassConfirm" || $errors === "passSizeError") : ?> value="<?= $_POST['username'] ?>" <?php endif; ?> id="username" name="username" required />
          </div>
          <div class="passwordField mb-3">
            <i class="showPass far fa-eye"></i>
            <i class="hidePass far fa-eye-slash" style="display: none;"></i>
            <label for="password" class="form-label">Password</label>
            <input type="password" class="passForm form-control <?php if ($errors === "isEmpty" || $errors === "passSizeError") : ?> border border-danger <?php endif; ?>" <?php if ($errors === "falsePassConfirm" || $errors === "isNumeric" || $errors === "isRegist") : ?> value="<?= $_POST['password'] ?>" <?php endif; ?> id="password" name="password" required />
          </div>
          <div class="passwordField mb-3">
            <label for="password2" class="form-label">Konfirmasi password</label>
            <input type="password" class="form-control <?php if ($errors === "isEmpty" || $errors === "falsePassConfirm") : ?> border border-danger <?php endif; ?>" <?php if ($errors === "isNumeric" || $errors === "isRegist") : ?> value="<?= $_POST['password2'] ?>" <?php endif; ?> id="password2" name="password2" required />
          </div>
          <button id="signup" type="submit" class="btn btn-primary w-100" name="signup">Sign up</button>
          <div id="regisQuestion" class="form-text mt-4 text-center">
            Sudah memiliki akun? <a href="login.php"> Login </a>
          </div>
        </form>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
  <script src="https://kit.fontawesome.com/2e160f1ac0.js" crossorigin="anonymous"></script>
  <script src="script/form.js"></script>
  <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <?php if (isset($success)) : ?>
    <script>
      Swal.fire({
        icon: 'success',
        title: 'Registrasi Berhasil!',
        text: 'User baru telah ditambahkan',
        confirmButtonColor: '#0b5ed7',
        confirmButtonText: 'Login'
      }).then((result) => {
        document.location.href = 'login.php';
      });
    </script>
  <?php endif; ?>
</body>

</html>