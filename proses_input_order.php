<?php
session_start();
require_once("koneksi.php");
if (isset($_POST['input_order'])) {
    $randomOrderCode = $_POST['kode_order'];
    $meja = $_POST['meja'];
    $pelanggan = $_POST['pelanggan'];
    $pelayan = $_SESSION['username'];

    // Perhatikan penggunaan tanda kutip untuk nilai string
    $query = "INSERT INTO tb_order (kode_order, meja, pelanggan, pelayan) VALUES ('$randomOrderCode', '$meja', '$pelanggan','$pelayan')";
         
    if (mysqli_query($conn, $query)) {
        // Operasi INSERT berhasil
        header('Location: order_item.php?code='.$randomOrderCode);
    } else {
        // Operasi INSERT gagal
        echo "Gagal menambahkan order: " . mysqli_error($conn);
    }
}



if (isset($_POST['update_order'])) {
    $randomOrderCode = $_POST['kode_order'];
    $meja = $_POST['meja'];
    $pelanggan = $_POST['pelanggan'];
    $pelayan = $_SESSION['username'];

    // Syntax SQL untuk operasi UPDATE
    $query = "UPDATE tb_order SET meja = '$meja', pelanggan = '$pelanggan', pelayan = '$pelayan' WHERE kode_order = '$randomOrderCode'";
         
    if (mysqli_query($conn, $query)) {
        // Operasi UPDATE berhasil
        header('Location: order.php?code='.$randomOrderCode);
    } else {
        // Operasi UPDATE gagal
        echo "Gagal mengupdate order: " . mysqli_error($conn);
    }
}



// delete user
if (isset($_GET["delete"])) {
  
    $id_order = $_GET['delete'];
    $query = "DELETE FROM tb_order WHERE id_order ='$id_order'";
    
    if(mysqli_query($conn, $query)) {
        header('Location: order.php');
    } else {

    // Tutup koneksi
    mysqli_close($conn);
}
}
?>
