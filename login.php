<?php
session_start();
require_once("functions.php");
$errors = " ";

if (isset($_COOKIE['useaidi']) && isset($_COOKIE['usekey'])) {
  $useaidi = $_COOKIE['useaidi'];
  $usekey = $_COOKIE['usekey'];

  $result = mysqli_query($conn, "SELECT username FROM users WHERE id = $useaidi");
  $row = mysqli_fetch_assoc($result);

  if ($usekey === hash('sha256', $row['username'])) {
    $_SESSION['login-daftar-pelajar'] = true;
  }
}

//ketika user sudah login tetapi memaksa masuk ke halaman login lagi
if (isset($_SESSION["login-daftar-pelajar"])) {
  header("Location: index.php");
  exit;
}

//ketika tombol login ditekan
if (isset($_POST['login'])) {

  $username = $_POST["username"];
  $password = $_POST["password"];

  //cari didatabase apakah ada value field username yang sama seperti variabel $username
  $result = mysqli_query($conn, "SELECT * FROM users WHERE username = '$username'");

  if (!empty(trim($username)) || !empty(trim($password))) {

    //jika tidak kosong
    //cek apakah username yang dimasukkan terdapat di database atau belum
    //jika benar
    if (mysqli_num_rows($result) === 1) {

      //cek password
      $row = mysqli_fetch_assoc($result);
      if (password_verify($password, $row["password"])) {

        //set session
        $_SESSION['login-daftar-pelajar'] = true;
        $_SESSION['username-users'] = $username;

        if ($username == 'tester' && $password == 'orangbaik') {
          header("Location: tester/index2.php");
        }

        //cek remember me
        if (isset($_POST['remember'])) {

          setcookie('useaidi', $row['id'], time() + 3600 * 24 * 7);
          setcookie('usekey', hash('sha256', $row['username']), time() + 3600 * 24 * 7);
        }

        header("Location: index.php");
        exit;
      } else {
        //jika password salah
        $errors = "password";
      }
    } else {
      //jika username salah
      $errors = "username";
    }
  } else {
    //jika kosong
    $errors = "isEmpty";
  }
}



?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Login</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous" />
  <link rel="stylesheet" href="css/style.css?v=<?php echo time(); ?>" />
</head>

<body>
  <div class="container p-4 mt-4">
    <div class="row text-center mb-4">
      <div class="col">
        <h1>Login</h1>
      </div>
    </div>
    <div class="row justify-content-center">
      <div class="col-lg-6">
        <?php if ($errors === "isEmpty") : ?>
          <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Username / Password tidak boleh kosong!</strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        <?php endif; ?>
        <?php if ($errors === "username") : ?>
          <div class="alert alert-danger" role="alert">
            Kemungkinan akun anda belum terdaftar, silahkan <a href="registrasi.php" class="alert-link">Signup</a>.
          </div>
        <?php endif; ?>
      </div>
    </div>
    <div class="row justify-content-center">
      <div class="col-lg-6">
        <form action=" " method="POST" class="border p-4 bg-light rounded">
          <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">Username </label>
            <input type="text" name="username" class="form-control <?php if ($errors === "username" || $errors === "isEmpty") : ?> border border-danger <?php endif; ?>" <?php if ($errors === "password") : ?>value="<?= $_POST['username']; ?>" <?php endif; ?> id="exampleInputEmail1" required />
            <?php if ($errors === "username") : ?>
              <div class="form-text text-danger">
                Username yang anda masukkan salah!
              </div>
            <?php endif; ?>
          </div>
          <div class="passwordField mb-3">
            <i class="showPass <?php if ($errors === "password") : ?> eyeUpdatePosition <?php endif; ?> far fa-eye"></i>
            <i class="hidePass <?php if ($errors === "password") : ?> eyeUpdatePosition <?php endif; ?> far fa-eye-slash" style="display: none;"></i>
            <label for="exampleInputPassword1" class="form-label">Password</label>
            <input type="password" name="password" class="passForm form-control <?php if ($errors === "password" || $errors === "isEmpty") : ?> border border-danger <?php endif; ?>" <?php if ($errors === "username") : ?> value="<?= $_POST['password']; ?>" <?php endif; ?> required />
            <?php if ($errors === "password") : ?>
              <div class="form-text text-danger">
                Password yang anda masukkan salah!
              </div>
            <?php endif; ?>
          </div>
          <div class="mb-3 form-check">
            <input type="checkbox" name="remember" class="form-check-input" id="exampleCheck1" />
            <label class="form-check-label" for="exampleCheck1">Remember me</label>
          </div>
          <button type="submit" name="login" class="btn btn-primary w-100">Login</button>
          <div id="regisQuestion" class="form-text mt-4 text-center">
            Belum memiliki akun? <a href="registrasi.php"> Signup </a>
          </div>
        </form>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
  <script src="https://kit.fontawesome.com/2e160f1ac0.js" crossorigin="anonymous"></script>
  <script src="script/form.js"></script>
</body>

</html>