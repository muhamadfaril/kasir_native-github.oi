<?php
include('koneksi.php');
$query = "SELECT * from tb_order";
$hasil_order = mysqli_query($conn, $query);
$data_order = mysqli_fetch_all($hasil_order, MYSQLI_ASSOC);

$page = "report";
// filter laporan pertanggal
if (isset($_POST['filter_tgl'])) {
  $tgl_mulai = $_POST['tgl_mulai'];
  $tgl_selesai = $_POST['tgl_selesai'];
  $query = "SELECT * FROM tb_order WHERE waktu_order BETWEEN '$tgl_mulai' AND '$tgl_selesai'";
  $hasil_order = mysqli_query($conn, $query);
  $data_order = mysqli_fetch_all($hasil_order, MYSQLI_ASSOC);
} else {
  $query = "SELECT * FROM tb_order";
  $hasil_order = mysqli_query($conn, $query);
  $data_order = mysqli_fetch_all($hasil_order, MYSQLI_ASSOC);
}

// Fungsi untuk menghasilkan kode order acak

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

?>
<!DOCTYPE html>
<html lang="en">


<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="./assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="argon_dashboard/assets/img/favicon.png">
  <title>
    Report
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
</head>

</html>
<?php
include_once('sidebar.php');
?>

<?php
include_once('navbar.php');
?>
  <!-- <nav aria-label="breadcrumb">
      <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
        <li class="breadcrumb-item text-sm"><a class="opacity-5 text-white" href="javascript:;">Pages</a></li>
        <li class="breadcrumb-item text-sm text-white active" aria-current="page">Report</li>
      </ol>
      <h6 class="font-weight-bolder text-white mb-0">Report</h6>
    </nav> -->
<!-- End Navbar -->
<div class="container-fluid py-4">
  <form class="row g-3" method="POST">
    <div class="col-md-6">
      <label for="tgl_mulai" class="form-label">Tgl mulai</label>
      <input type="date" class="form-control" id="tgl_mulai" name="tgl_mulai" value="<?php echo isset($_POST['tgl_mulai']) ? $_POST['tgl_mulai'] : ''; ?>">
    </div>
    <div class="col-md-3">
      <label for="tgl_selesai" class="form-label">Tgl selesai</label>
      <input type="date" class="form-control" id="tgl_selesai" name="tgl_selesai" value="<?php echo isset($_POST['tgl_selesai']) ? $_POST['tgl_selesai'] : ''; ?>">
      <button type="submit" class="btn btn-warning" name="filter_tgl">Filter</button>
      <a href="print_detail.php?tgl_mulai=<?= isset($_POST['tgl_mulai']) ? $_POST['tgl_mulai'] : ''; ?>&tgl_akhir=<?= isset($_POST['tgl_selesai']) ? $_POST['tgl_selesai'] : ''; ?>" class="btn btn-success">Print</a>

    </div>
  </form>
  <div class="row">
    <div class="col-12">
      <div class="card mb-4">

        <div class="card-header pb-0">
          <!-- Button trigger modal -->

          <h6>Laporan</h6>
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
                    <td class="align-middle">
                      
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
<div>
  
</div>
</main>

<!--   Core JS Files   -->
<?php
include_once('js.php');
?>

</body>

</html>