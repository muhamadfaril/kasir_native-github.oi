<?php
// modal input item
include("koneksi.php");
session_start();
if(isset($_POST['input_orderitem'])){
    $id_order = $_POST['id_order'];
    $kodeOrder = $_POST['kode_order'];
    $menu = $_POST['menu'];
    $jumlah = $_POST['jumlah'];
    $catatan = $_POST['catatan'];
    $query = "INSERT INTO `tb_list_order` (`id_list_order`, `menu`, `order`, `jumlah`,`catatan`) VALUES (NULL, '$menu', '$id_order', '$jumlah', '$catatan') ";
    $result = mysqli_query($conn,$query);
    header("Location: order_item.php?code=".$kodeOrder);
}
// modal bayaritem
if(isset($_POST['bayar'])){
    $id_order = $_POST['id_order'];
    $kodeOrder = $_POST['kode_order'];
    $menu = $_POST['menu'];
    $jumlah = $_POST['jumlah'];
    $catatan = $_POST['catatan'];
    $waktu_bayar = date('Y-m-d');
    $pembayaran = $_POST['pembayaran'];
    $kembalian = $_POST['kembalian'];
    // var_dump($pembayaran, $kembalian);
    // die;
    $query = "UPDATE `tb_order` SET `waktu_bayar` = CURRENT_TIMESTAMP WHERE `tb_order`.`id_order` = '$id_order' ";
    $result = mysqli_query($conn,$query);
    $_SESSION['pembayaran'] = $pembayaran;
    $_SESSION['kembalian'] = $kembalian;
    header("Location: struk.php?code=".$kodeOrder);
}

// update item
if (isset($_POST['update_orderitem'])) {
    $id_order = $_POST['id_order'];
    $kodeOrder = $_POST['kode_order'];
    $id_item_to_update = $_POST['id_item_to_update'];
    $menu = $_POST['menu'];
    $jumlah = $_POST['jumlah'];
    $catatan = $_POST['catatan'];

    // Update the item in the database using the provided ID
    $query = "UPDATE `tb_list_order` SET `menu` = '$menu', `jumlah` = '$jumlah', `catatan` = '$catatan' WHERE `id_list_order` = '$id_item_to_update'";
    $result = mysqli_query($conn, $query);
    var_dump($id_order,$kodeOrder,$id_item_to_update,$menu,$jumlah,$catatan);
   var_dump($result);
    // die;
   
    // Redirect back to the order_item.php page with the code parameter
    header("Location: order_item.php?code=" . $kodeOrder);
}
if (isset($_GET["delete"])) {
  
    $id_order = $_GET['delete'];
    $kode = $_GET['code'];
    $query = "DELETE FROM tb_list_order WHERE id_list_order ='$id_order'";
    // die;
    if(mysqli_query($conn, $query)) {
        header("Location: order_item.php?code=$kode");
    } else {

    // Tutup koneksi
    mysqli_close($conn);
}
}


?>