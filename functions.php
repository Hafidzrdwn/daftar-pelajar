<?php

//Koneksi database
// Development Connection
// $conn = mysqli_connect("localhost", "root", "", "phpapp");

// Remote Database Connection
$conn = mysqli_connect("remotemysql.com", "7PyCt8grYU", "U4nv7AzN97", "7PyCt8grYU");

function query($query)
{
    global $conn;
    $result = mysqli_query($conn, $query);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }

    return $rows;
}

//FUNCTION REGISTRASI
function registrasi($data)
{

    global $conn;

    $username = strtolower(stripslashes($data["username"]));
    $password = mysqli_real_escape_string($conn, $data["password"]);
    $password2 = mysqli_real_escape_string($conn, $data["password2"]);

    // cek username sudah ada atau belum?
    $result = mysqli_query($conn, "SELECT username FROM users WHERE username = '$username'");

    if (mysqli_fetch_assoc($result)) {
        // echo "<script>
        //     alert('username sudah terdaftar!');
        // </script>"; 

        return -1;
    }

    // cek username kosong atau tidak
    if (empty(trim($username)) || empty(trim($password))) {
        // echo "<script>
        //     alert('username / password harus diisi tidak boleh kosong!');
        // </script>";

        return -2;
    }

    // cek apakah username angka dan mengandung spasi atau tidak
    if (!preg_match("/^[a-zA-Z]*$/", $username)) {
        return -3;
    }

    // cek panjang password
    if (strlen($password) < 8) {

        return -4;
    }

    // cek konfirmasi password
    if ($password != $password2) {
        // echo "<script>
        //     alert('konfirmasi password tidak sesuai!');
        // </script>";

        return -5;
    }


    //enkripsi password
    $password = password_hash($password, PASSWORD_DEFAULT);

    //tambahkan user baru ke database
    mysqli_query($conn, "INSERT INTO users VALUES(null,'$username','$password')");


    return mysqli_affected_rows($conn);
}

// FUNCTION UPLOAD
function upload()
{
    $namaFile = $_FILES['gambar']['name'];
    $tipeFile = $_FILES['gambar']['type'];
    $ukuranFile = $_FILES['gambar']['size'];
    $error = $_FILES['gambar']['error'];
    $tmpName = $_FILES['gambar']['tmp_name'];

    //cek apakah ada / tidak ada gambar yang diupload
    if ($error === 4) {

        return 'nophoto.png';
    }

    //cek apakah yang diupload adalah gambar
    $ekstensiGambarValid = ['jpg', 'jpeg', 'png'];
    $format = strtolower(pathinfo($namaFile, PATHINFO_EXTENSION));
    if (!in_array($format, $ekstensiGambarValid)) {
        return -7;
    }

    // cek type file
    if ($tipeFile != 'image/jpg' && $tipeFile != 'image/jpeg' && $tipeFile != 'image/png') {
        return -7;
    }

    //lolos pengecekan, gambar siap diupload
    //generate nama gambar baru
    $namaFileBaru = uniqid();
    $namaFileBaru .= '.';
    $namaFileBaru .= $format;


    move_uploaded_file($tmpName, 'images/' . $namaFileBaru);

    return $namaFileBaru;
}

//FUNCTION TAMBAH DATA
function tambah($data)
{
    global $conn;

    $nama = htmlspecialchars($data["nama"]);
    $jenis_kelamin = $data["jenis_kelamin"];
    $kelas = $data["kelas"];
    $jurusan = $data["jurusan"];
    $email = htmlspecialchars($data["email"]);
    $telp = htmlspecialchars($data["telp"]);

    //cek : nama tidak boleh kosong dan tidak boleh mengandung angka
    if (empty(trim($nama)) || !preg_match("/^[a-zA-Z\s]*$/", $nama)) {
        return -1;
    }

    if ($jurusan === "NULL") {

        return -2;
    }

    $trimmed = str_replace('@gmail.com', '', $email);

    if (empty(trim($email)) || !preg_match('/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/', $trimmed)) {

        return -3;
    }

    if (empty(trim($telp)) || !preg_match("/^[0-9]*$/", $telp)) {

        return -4;
    }

    //Upload Gambar
    $gambar = upload();

    if ($gambar < 0) {
        return $gambar;
    }

    //query insert data
    $query = "INSERT INTO pelajar
                VALUES
              (null, '$nama' , '$jenis_kelamin' , '$kelas' , '$jurusan', '$email', '$telp', '$gambar')";

    mysqli_query(
        $conn,
        $query
    );

    echo mysqli_error($conn);

    return mysqli_affected_rows($conn);
}

// FUNCTION HAPUS DATA
function hapus($id, $gambar)
{
    global $conn;

    if ($gambar != 'nophoto.png') {
        unlink('images/' . $gambar);
    }

    mysqli_query($conn, "DELETE FROM pelajar WHERE id = $id");

    return mysqli_affected_rows($conn);
}

// FUNCTION EDIT DATA
function edit($data)
{
    global $conn;

    $id = $data['id'];
    $nama = htmlspecialchars($data["nama"]);
    $jenis_kelamin = $data["jenis_kelamin"];
    $kelas = $data["kelas"];
    $jurusan = $data["jurusan"];
    $email = htmlspecialchars($data["email"]);
    $telp = htmlspecialchars($data["telp"]);
    $gambar_lama = htmlspecialchars($data["gambar_lama"]);

    //cek : nama tidak boleh kosong dan tidak boleh mengandung angka
    if (empty(trim($nama)) || !preg_match("/^[a-zA-Z\s]*$/", $nama)) {
        return -1;
    }

    if ($jurusan === "NULL") {

        return -2;
    }

    // tugas : kita akan mengecek panjang email dan cek : email tidak boleh terdiri dari angka saja / huruf saja.
    // email tidak boleh kosong

    $trimmed = str_replace('@gmail.com', '', $email);

    if (empty(trim($email)) || !preg_match('/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/', $trimmed)) {

        return -3;
    }

    if (empty(trim($telp)) || !preg_match("/^[0-9]*$/", $telp)) {

        return -4;
    }

    $gambar = upload();

    if ($gambar < 0) {
        return $gambar;
    }

    //cek apakah user pilih gambar baru atau tidak
    if ($gambar == 'nophoto.png') {
        $gambar = $gambar_lama;
    } else {
        if ($gambar_lama != 'nophoto.png') {
            unlink('images/' . $gambar_lama);
        }
    }

    //query insert data
    $query = "UPDATE pelajar SET
                nama = '$nama',
                jenis_kelamin = '$jenis_kelamin',
                kelas = '$kelas',
                jurusan = '$jurusan',
                email = '$email',
                telp = '$telp',
                gambar = '$gambar'
                WHERE id = '$id'";

    mysqli_query(
        $conn,
        $query
    );

    echo mysqli_error($conn);

    return mysqli_affected_rows($conn);
}

// FUNCTION CARI DATA
function search($keyword)
{
    $query = "SELECT * FROM pelajar 
                WHERE 
              nama LIKE '%$keyword%' OR
              jenis_kelamin LIKE '%$keyword%' OR
              kelas LIKE '%$keyword%' OR
              jurusan LIKE '%$keyword%' OR
              email LIKE '%$keyword%' OR
              telp LIKE '%$keyword%'";

    return query($query);
}
