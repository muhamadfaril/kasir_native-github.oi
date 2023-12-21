<?php
session_start();
require_once("koneksi.php");
if (isset($_POST['input_user1'])){
    $level = $_POST['level'];
    $username = $_POST['username'];
    $password = md5($_POST['password']);
    $query = "INSERT INTO tb_user values( 
             '',
             '$username',
             '$password',
             '$level'
            )";
            
           
    if (mysqli_query($conn,$query)) {
        // Operasi INSERT berhasil
        header('Location: user.php');
    } else {
        // Operasi INSERT gagal
        echo "Gagal menambahkan pengguna: " . mysqli_error($conn);
    }
}

// update user
if (isset($_POST['update_user'])){
    $id_user = $_POST['id_user'];
    $username = $_POST['username'];
    $level = $_POST['level'];
    $query ="UPDATE tb_user SET
             username = '$username',
             level = '$level'
             WHERE id_user = '$id_user'";
    if (mysqli_query($conn, $query)) {
        header("Location: user.php");
    } 
}
// delete user
if (isset($_GET["delete"])) {
  
    $id_user = $_GET['delete'];
    $query = "DELETE FROM tb_user WHERE id_user ='$id_user'";
    
    if(mysqli_query($conn, $query)) {
        header('Location: user.php');
    } else {

    // Tutup koneksi
    mysqli_close($conn);
}
}
?>
