<?php
require_once('koneksi.php');
session_start();
$query = "SELECT * FROM tb_user ";
$hasil = mysqli_query($conn, $query);
if (!isset($_SESSION["username"])) {
  header("Location: login.php");
}
// $query = mysqli_query ($conn,"SELECT FROM tb_user WHERE username = '$_SESSION [username]'");
// $hasil = mysqli_fetch_array($query);
$page = "dashboard";
// menampikan jumlah penjualan
$query = "SELECT COUNT(*) as total_penjualan FROM tb_order";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $total_penjualan = $row["total_penjualan"];
} else {
    $total_penjualan = 0;
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
    Dashboard
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
    
    <div class="container-fluid py-4">
      <div class="row">
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
          <div class="card">
            <div class="card-body p-3">
              <div class="row">
                <div class="col-8">
                  <div class="numbers">
                    <p class="text-sm mb-0 text-uppercase font-weight-bold">Total Penjualan</p>
                    <h5 class="font-weight-bolder">
                      <?php echo $total_penjualan; ?>
                    </h5>
                  </div>
                </div>
                <div class="col-4 text-end">
                  <div class="icon icon-shape bg-gradient-primary shadow-primary text-center rounded-circle">
                    <i class="ni ni-money-coins text-lg opacity-10" aria-hidden="true"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
  </div>
  <!--   Core JS Files   -->
 <?php
  include_once('js.php'); 
  ?>
</body>

</html>