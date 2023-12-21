<?php
include("koneksi.php");
$id_user = (isset($_POST['id_user'])) ? htmlentities($_POST['id_user']) : '';
$message = '';

if (!empty($_POST['reset_password_user'])) {
    $new_password = 'password'; // Kata sandi bawaan sistem

    $user = mysqli_query($conn, "SELECT * FROM tb_user WHERE id_user = '$id_user'");
    $user_data = mysqli_fetch_assoc($user);

    if ($user_data['username'] == $_SESSION['username']) {
        $message = '<script>alert("Anda tidak dapat mereset password sendiri");</script>';
    } else {
        $password = md5($new_password);

        $query = mysqli_query($conn, "UPDATE tb_user SET password='$password' WHERE id_user='$id_user'");

        if ($query) {
            $message = '<script>alert("Password berhasil direset"); window.location.href="user.php";</script>';
        } else {
            $message = '<script>alert("Password gagal direset");</script>';
        }
    }
}

echo $message;
?>
