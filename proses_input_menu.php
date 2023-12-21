<?php
session_start();
require_once('koneksi.php');

if (isset($_POST['input_menu'])) {
    $gambar_menu_tmp = $_FILES['gambar_menu']['tmp_name'];
    $nama_menu = $_POST['nama_menu'];
    $keterangan = $_POST['keterangan'];
    $jenis_menu = $_POST['jenis_menu'];
    $harga = $_POST['harga'];


    // Cek apakah ada gambar yang diunggah
    if (!empty($gambar_menu_tmp) && is_uploaded_file($gambar_menu_tmp)) {
        $allowed_image_types = array("image/jpeg", "image/png", "image/gif");
        if (in_array($_FILES['gambar_menu']['type'], $allowed_image_types)) {
            $gambar_menu = date('Ymdhis') . '.jpg';
            move_uploaded_file($gambar_menu_tmp, 'img/' . $gambar_menu);
        } else {
            echo "Tipe gambar tidak valid. Hanya file JPEG, PNG, dan GIF yang diizinkan.";
            // Anda dapat menambahkan log atau pesan kesalahan lain sesuai kebutuhan.
            exit; // Keluar dari skrip jika tipe file tidak valid.
        }
    } else {
        $gambar_menu = '';
    }

    $query = "INSERT INTO tb_daftar_menu (gambar_menu, nama_menu, keterangan, jenis_menu, harga )
              VALUES ('$gambar_menu', '$nama_menu', '$keterangan', '$jenis_menu', '$harga' )";

    if (mysqli_query($conn, $query)) {
        header("Location: menu.php");
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}


if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $query = "SELECT gambar_menu FROM tb_daftar_menu WHERE id = '$id'";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    $gambar_hapus = $row['gambar_menu'];

    // Hapus gambar lama jika ada
    if (!empty($gambar_hapus) && file_exists('images/' . $gambar_hapus)) {
        unlink('img/' . $gambar_hapus);
    }

    // Hapus record dari database
    $query = "DELETE FROM tb_daftar_menu WHERE id = '$id'";
    if (mysqli_query($conn, $query)) {
        header("Location: menu.php");
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
if (isset($_POST['update_menu'])) {
    $id = $_POST['id'];
    $nama_menu = $_POST['nama_menu'];
    $keterangan = $_POST['keterangan'];
    $jenis_menu = $_POST['jenis_menu'];
    $harga = $_POST['harga'];


    // Cek apakah ada gambar yang diunggah
    if ($_FILES['gambar_menu']['error'] === UPLOAD_ERR_OK) {
        $gambar_menu = date('Ymdhis') . '.jpg';
        // Mengupload gambar baru
        move_uploaded_file($_FILES['gambar_menu']['tmp_name'], 'img/' . $gambar_menu);

        // Hapus gambar lama jika ada
        if (!empty($gambar_lama) && file_exists('img/' . $gambar_lama)) {
            unlink('img/' . $gambar_lama);
        }
    } else {
        // Jika tidak ada gambar baru, gunakan gambar lama
        $gambar_menu = $gambar_lama;
    }


    $query = "UPDATE tb_daftar_menu SET
                gambar_menu = '$gambar_menu',
                nama_menu = '$nama_menu',
                keterangan = '$keterangan',
                jenis_menu = '$jenis_menu',
                harga = '$harga'
                WHERE id = '$id'";

    if (mysqli_query($conn, $query)) {
        header("Location: menu.php");
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>