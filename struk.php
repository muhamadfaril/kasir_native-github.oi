<?php
session_start(); // Tambahkan session_start() di awal file

include('koneksi.php');

$page = "order";

// Fungsi untuk menghasilkan kode order acak
function generateRandomOrderCode($length = 8)
{
    $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $code = '';

    for ($i = 0; $i < $length; $i++) {
        $randomIndex = rand(0, strlen($characters) - 1);
        $code .= $characters[$randomIndex];
    }

    return $code;
}


$kodeOrder = $_GET['code'];
$query = "SELECT * FROM tb_order WHERE kode_order = '$kodeOrder'";
$hasil_order = mysqli_query($conn, $query);
$data_order = mysqli_fetch_assoc($hasil_order);

$queryMenu = "SELECT * FROM tb_daftar_menu";
$hasil_menu = mysqli_query($conn, $queryMenu);

$id_order = $data_order['id_order'];
$querylist = "SELECT * FROM tb_list_order AS tlo JOIN tb_daftar_menu AS tm ON tlo.menu = tm.id JOIN tb_order AS tor ON tlo.order = tor.id_order WHERE tlo.order = '$id_order'";
$hasil_list = mysqli_query($conn, $querylist);
$list_order = mysqli_fetch_all($hasil_list, MYSQLI_ASSOC);

// Menghasilkan kode order acak
$randomOrderCode = generateRandomOrderCode(8);

function Total($idMenu, $id)
{
    include('koneksi.php');
    $queryMenu = "SELECT * FROM tb_daftar_menu WHERE id = '$idMenu'";
    $hasil_Menu = mysqli_query($conn, $queryMenu);
    $data_menu = mysqli_fetch_assoc($hasil_Menu);
    $queryList = "SELECT * FROM tb_list_order AS tlo WHERE id_list_order = '$id' AND menu = '$idMenu'";
    $execList = mysqli_query($conn, $queryList);
    $dataList = mysqli_fetch_all($execList, MYSQLI_ASSOC);
    $harga = 0;

    if (mysqli_num_rows($execList) != 0) {
        foreach ($dataList as $list) {
            $total = $list['jumlah'] * $data_menu['harga'];
            $harga += $total;
            $_SESSION['totalHarga'] ; // Perbarui nilai totalHarga
        }
    } else {
        // $_SESSION['totalHarga'] = 0; // Setel totalHarga ke nol jika tidak ada item pesanan
    }

    return $harga;
}

// Handle pembayaran dan kembalian
if (isset($_POST['pembayaran'])) {
    $inputPembayaran = intval($_POST['pembayaran']);

    // Hitung kembalian
    $kembalian = $inputPembayaran - $_SESSION['totalHarga'];

    // Simpan nilai pembayaran dan kembalian ke dalam sesi
    $_SESSION['pembayaran'] = $inputPembayaran;
    $_SESSION['kembalian'] = $kembalian;
}
?>
<html>
<head>
<title>Faktur Pembayaran</title>
<style>
 
#tabel
{
font-size:15px;
border-collapse:collapse;
}
#tabel  td
{
padding-left:5px;
border: 1px solid black;
}
</style>
</head>
<body style='font-family:tahoma; font-size:8pt;'  onload="window.print();">
<center><table style='width:350px; font-size:16pt; font-family:calibri; border-collapse: collapse;' border = '0'>
<td width='70%' align='CENTER' vertical-align:top'><span style='color:black;'>
<b>RM.AYAM GEPREK TIGA DARA</b></br>Jl.Karangpandan-Ngargoyoso</span></br>
 
 
<span style='font-size:12pt'>No : <?= $data_order['kode_order'] ?> | Meja : <?= $data_order['meja'] ?> | Pelanggan: <?= $data_order['pelanggan'] ?> </span></br>
<span style='font-size:12pt'> </span></br>

</td>
</table>
<style>
hr { 
    display: block;
    margin-top: 0.5em;
    margin-bottom: 0.5em;
    margin-left: auto;
    margin-right: auto;
    border-style: inset;
    border-width: 1px;
} 
</style>
<table cellspacing='0' cellpadding='0' style='width:350px; font-size:12pt; font-family:calibri;  border-collapse: collapse;' border='0'>
<style>
    @media print {
      @page {
        size: landscape;
      }
    }
  </style>
<tr align='center'>
<td width='10%'>Menu</td>
<td width='13%'>Harga</td>
<td width='4%'>Qty</td>
<td width='7%'>Catatan</td>
<td width='13%'>Total</td><tr>
<td colspan='5'><hr></td></tr>
</tr>

<?php $totalSemua = 0 ?>
<?php foreach ($list_order as $list) : ?>
    <?php $total =  Total($list['menu'], $list['id_list_order']); 
    $totalSemua += $total;
    ?>
    
    <?php $_SESSION['totalHarga'] += $total; ?> <!-- Perbaru$i nilai totalHarga -->
    <tr>
        <td style='vertical-align:top'><?= $list['nama_menu']; ?></td>
        <td style='vertical-align:top; text-align:right; padding-right:10px'><?= $list['harga']; ?></td>
        <td style='vertical-align:top; text-align:right; padding-right:10px'><?= $list['jumlah']; ?></td>
        <td style='vertical-align:top; text-align:right; padding-right:10px'><?= $list['catatan']; ?></td>
        <td style='text-align:right; vertical-align:top'><?= number_format($total); ?></td>
    </tr>

    <tr>
        <td colspan='5'><hr></td>
    </tr>
   
                                                
<?php endforeach; ?>
  </tr>
                                                

<tr>
    
<td colspan = '4'><div style='text-align:right; color:black'>Total : </div></td>
<td style='text-align:right; font-size:16pt; color:black'><?= number_format($totalSemua) ?></td>
</tr>

<tr>
    <td colspan='4'><div style='text-align:right; color:black'>Pembayaran : </div></td>
    <td style='text-align:right; font-size:16pt; color:black'><?= isset($_SESSION['pembayaran']) ? number_format($_SESSION['pembayaran']) : '' ?></td>
</tr>
<tr>
    <td colspan='4'><div style='text-align:right; color:black'>Kembalian : </div></td>
    <td style='text-align:right; font-size:16pt; color:black'><?= isset($_SESSION['kembalian']) ? number_format($_SESSION['kembalian']) : '' ?></td>
</tr>
</table>
<table style='width:350; font-size:12pt;' cellspacing='2'><tr></br><td align='center'>****** TERIMAKASIH ******</br></
