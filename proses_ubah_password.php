<?php
session_start();
require_once('koneksi.php');

if (isset($_POST['ubah_password_validate'])) {
    $id_admin = $_SESSION['username'];
    $passwordlama = md5(htmlentities($_POST['passwordlama']));
    $passwordbaru = md5(htmlentities($_POST['passwordbaru']));
    $repasswordbaru = md5(htmlentities($_POST['repasswordbaru']));

    $query = mysqli_query($conn, "SELECT * FROM tb_user WHERE username = '$id_admin' AND password = '$passwordlama'");
    $hasil = mysqli_fetch_array($query);

    if ($hasil) {
        if ($passwordbaru == $repasswordbaru) {
             $query = mysqli_query($conn, "UPDATE tb_user SET password='$passwordbaru' WHERE username = '$id_admin'");

            if ($query) {
                $message = '<script>alert("Password berhasil diubah");window.history.back()</script>';
            } else {
                $message = '<script>alert("Password gagal diubah");window.history.back()</script>';
            }
        } else {
            $message = '<script>alert("Password baru tidak sesuai");window.history.back()</script>';
        }
    } else {
        $message = '<script>alert("Password lama tidak sesuai");window.history.back()</script>';
    }
} else {
    header('location: index.php');
}

echo $message;
?>
