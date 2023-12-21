<?php
include('koneksi.php');
$query = "SELECT * from tb_order";
$hasil_order = mysqli_query($conn, $query);
$data_order = mysqli_fetch_all($hasil_order, MYSQLI_ASSOC);
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
    Data Pesanan
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

<!-- End Navbar -->
<div class="container-fluid py-4">
  <div class="row">
    <div class="col-12">
      <div class="card mb-4">

        <div class="card-header pb-0">
          <!-- Button trigger modal -->
          <button type="button" class="btn bg-gradient-primary" data-bs-toggle="modal" data-bs-target="#modalinput">
            Input Pesanan
          </button>
          <h3 class="text-center" >Data Pesanan</h3>
        </div>


        <!-- Modal input_order -->
        <div class="modal fade" id="modalinput" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Input Pesanan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <form action="proses_input_order.php" method="POST" enctype="multipart/form-data">
                  <div class="form-group">
                    <label>Kode Order</label>
                    <input type="text" class="form-control" name="kode_order" placeholder="Kode Order" value="<?php echo $randomOrderCode; ?>">
                  </div>
                  <div class="form-group">
                    <label>Meja</label>
                    <input type="number" class="form-control" name="meja" required>
                  </div>
                  <div class="form-group">
                    <label>Nama Pelanggan</label>
                    <input type="text" class="form-control" name="pelanggan" required>
                  </div>

                  <div class="modal-footer">
                    <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn bg-gradient-primary" name="input_order">Save changes</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
        <!-- end -->

          <?php foreach ($data_order as $order) : ?>
            <!-- Modal update_order -->
            <div class="modal fade" id="ModalUpdate<?= $order['id_order'] ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Input Pesanan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <form action="proses_input_order.php" method="POST" enctype="multipart/form-data">
                      <div class="form-group">
                        <label>Kode Order</label>
                        <input type="text" class="form-control" name="kode_order" placeholder="Kode Order" value="<?php echo $order['kode_order']; ?>">
                      </div>
                      <div class="form-group">
                        <label>Meja</label>
                        <input type="number" class="form-control" name="meja"oninput="this.value = this.value.replace(/[^0-9]/g, '');" value='<?= $order['meja'] ?>'>
                      </div>
                      <div class="form-group">
                        <label>Nama Pelanggan</label>
                        <input type="text" class="form-control" name="pelanggan" value="<?= $order['pelanggan'] ?>">
                      </div>

                      <div class="modal-footer">
                        <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn bg-gradient-primary" name="update_order">Save changes</button>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          <?php endforeach ?>
          <!-- end -->



        <div class="card-body px-0 pt-0 pb-2">
          <div class="table-responsive p-0">
            <table class="table align-items-center mb-0">
              <thead>
                <tr>
                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">No</th>
                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Kode Order</th>
                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Pelanggan</th>
                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Meja</th>
                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Total harga</th>
                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Pelayan</th>
                  
                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Waktu Order</th>
                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Aksi</th>
                </tr>
              </thead>
              <tbody>
                <?php $no = 1;
                foreach ($data_order as $order) {
                   ?>
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
                    
                    <td class="align-middle text-sm">
                      <p class="text-xs font-weight-bold mb-0"><?= $order['waktu_order']; ?></p>
                    </td>
                    <td class="align-middle">
                      <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#ModalUpdate<?= $order['id_order'] ?>">Edit</button>
                      <a href="order_item.php?code=<?php echo $order['kode_order'] ?>" class="btn btn-warning">View</a>
                      <a onclick="return confirm('Yakinn?')" class="btn btn-danger" href="proses_input_order.php?delete=<?= $order['id_order'] ?>">Hapus </a>
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