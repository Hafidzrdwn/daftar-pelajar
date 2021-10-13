<?php
session_start();
$_SESSION = [];
session_unset();
session_destroy();

setcookie('useaidi', '', time() - 3600);
setcookie('usekey', '', time() - 3600);

header("Location: login.php");
exit;
