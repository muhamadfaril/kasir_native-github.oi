<?php
include('koneksi.php');
$query = "SELECT * from tb_order";
$hasil_order = mysqli_query($conn, $query);
$data_order = mysqli_fetch_all($hasil_order, MYSQLI_ASSOC);

$page = "report";

if(!empty($_GET['tgl_mulai']) && !empty($_GET['tgl_akhir'])){
  $tgl_mulai = $_GET['tgl_mulai'];
  $tgl_selesai = $_GET['tgl_akhir'];
  $query = "SELECT * FROM tb_order WHERE waktu_order BETWEEN '$tgl_mulai' AND '$tgl_selesai'";
  $hasil_order = mysqli_query($conn, $query);
  $data_order = mysqli_fetch_all($hasil_order, MYSQLI_ASSOC);
} else{
  $query = "SELECT * from tb_order";
$hasil_order = mysqli_query($conn, $query);
$data_order = mysqli_fetch_all($hasil_order, MYSQLI_ASSOC);
}

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
function cekList($idOrder)
{
  $id = $idOrder;
  include('koneksi.php');
  $queryMenu = "SELECT * from tb_daftar_menu";
  $hasil_Menu = mysqli_query($conn, $queryMenu);
  $data_menu = mysqli_fetch_all($hasil_Menu, MYSQLI_ASSOC);
  $queryList = "SELECT * FROM tb_list_order AS tlo WHERE tlo.order = '$id'";
  $execList = mysqli_query($conn, $queryList);
  $dataList = mysqli_fetch_all($execList, MYSQLI_ASSOC);
  $harga = 0;

  if (mysqli_num_rows($execList) != 0) {

    foreach ($dataList as $list) {
      foreach ($data_menu as $menu) {
        if ($list['menu'] == $menu['id']) {
          $total = $menu['harga'] * $list['jumlah'];
          $harga += $total;
        }
      }
    }
  }

  return $harga;
}

// Menghasilkan kode order acak
$randomOrderCode = generateRandomOrderCode(8);
?>
<!DOCTYPE html>
<html lang="en">


<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="./assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="argon_dashboard/assets/img/favicon.png">
  <title>
    Print Detail
  </title>
  <!--     Fonts and icons     -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
  <!-- Nucleo Icons -->
  <link href="argon-dashboard/assets/css/nucleo-icons.css" rel="stylesheet" />
  <link href="argon-dashboard/assets/css/nucleo-svg.css" rel="stylesheet" />
  <!-- Font Awesome Icons -->
  <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
  <link href="argon-dashboard/assets/css/nucleo-svg.css" rel="stylesheet" />
  <!-- CSS Files -->
  <link id="pagestyle" href="argon-dashboard/assets/css/argon-dashboard.css?v=2.0.4" rel="stylesheet" />
  <style>
    @media print {
      @page {
        size: landscape;
      }
    }
  </style>
</head>



<body onload="window.print();">

<div class="container-fluid py-4">
    <div class="row">
      <div class="col-12">
        <div class="card mb-4">

          <div class="card-header pb-0">
            <!-- Button trigger modal -->
            <div class="row">
              <div class="col-sm-3 float-left">
                <img src="argon-dashboard/assets/img/logo ayam geprek.png" alt="" width="200px">
              </div>
              <div class="col-sm-9 float-left">
                <h3>Ayam Geprek Tiga Dara</h3>
                <h6>Gadungan, Girimulyo, Kec. Ngargoyoso, Kabupaten Karanganyar, Jawa Tengah 57793</h6>
                <h6>@ayamgeprektigadara</h6>
              </div>
            </div>
            <h6>Print Detail</h6>
          </div>

          <div class="card-body px-0 pt-0 pb-2">
            <div class="table-responsive p-0">
              <table class="table align-items-center mb-0">
                <thead>
                  <tr>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">No</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Kode Order</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Waktu Order</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Waktu Bayar</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Pelanggan</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Meja</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Total Harga</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Pelayan</th>

                  </tr>
                </thead>
                <tbody>
                  <?php $no = 1;
                  foreach ($data_order as $order) { ?>


                    <tr>
                      <td>
                        <div class="d-flex px-2 py-1">
                          <div class="d-flex flex-column justify-content-center">
                            <h3 class="mb-1 text-sm"><?= $no; ?></h3>
                          </div>
                        </div>
                      </td>
                      <td class="align-middle text-sm">
                        <p class="text-xs font-weight-bold mb-0"><?= $order['kode_order']; ?></p>
                      </td>
                      <td class="align-middle text-sm">
                        <p class="text-xs font-weight-bold mb-0"><?= $order['waktu_order']; ?></p>
                      </td>
                      <td class="align-middle text-sm">
                        <p class="text-xs font-weight-bold mb-0"><?= $order['waktu_bayar']; ?></p>
                      </td>
                      <td class="align-middle text-sm">
                        <p class="text-xs font-weight-bold mb-0"><?= $order['pelanggan']; ?></p>
                      </td>
                      <td class="align-middle text-sm">
                        <p class="text-xs font-weight-bold mb-0"><?= $order['meja']; ?></p>
                      </td>
                      <td class="align-middle text-sm">
                        <p class="text-xs font-weight-bold mb-0"><?= cekList($order['id_order']) ?></p>
                      </td>
                      <td class="align-middle text-sm">
                        <p class="text-xs font-weight-bold mb-0"><?= $order['pelayan']; ?></p>
                      </td>

                    </tr>

                  <?php $no++;
                  } ?>

                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>

  </main>

  <!--   Core JS Files   -->
  <?php
  include_once('js.php');
  ?>


</body>

</html>