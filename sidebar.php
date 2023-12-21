<?php 
  if(!isset($_SESSION))
{
 session_start();
}
 require_once('koneksi.php');
  $query = "SELECT * FROM tb_user where username= '$_SESSION[username]'";
  $hasil = mysqli_query($conn, $query);
  $row = mysqli_fetch_assoc($hasil);

  if($page =="dashboard"){
   $menu1 = 'active';
  }
  if($page =="order"){
    $menu2 = 'active';
   }
   if($page =="dapur"){
    $menu3 = 'active';
   }
   if($page =="user"){
    $menu4 = 'active';
   }
   if($page =="report"){
    $menu5 = 'active';
   }
   if($page =="daftar menu"){
    $menu6 = 'active';
   }
   if($page =="kategori menu"){
    $menu7 = 'active';
   }
  
 
  ?>


<body class="g-sidenav-show   bg-gray-100">
  <div class="min-height-300 bg-primary position-absolute w-100"></div>
  <aside class="sidenav bg-white navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-4 " id="sidenav-main">
    <div class="sidenav-header">
      <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
      <a class="navbar-brand m-0" href=" https://demos.creative-tim.com/argon-dashboard/pages/dashboard.html " target="_blank">
       
        <span class="ms-1 font-weight-bold">RM. Tiga Dara</span>
      </a>
    </div>
    <hr class="horizontal dark mt-0">
    <div class="collapse navbar-collapse  w-auto " id="sidenav-collapse-main">
      <ul class="navbar-nav">
        <!-- level admin -->
         <?php if($row['level']== 1){?>
        <li class="nav-item">
          <a class="nav-link <?= @$menu1 ?>" href="index.php">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="ni ni-tv-2 text-primary text-sm opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">Dashboard</span>
          </a>
        </li>
       
        <li class="nav-item">
          <a class="nav-link <?= @$menu6 ?>" href="menu.php">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="ni ni-calendar-grid-58 text-warning text-sm opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">Daftar Menu</span>
          </a>
        </li>
       
        <li class="nav-item">
          <a class="nav-link <?= @$menu4 ?>" href="user.php">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="ni ni-app text-info text-sm opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">User</span>
          </a>
        </li>
       <li class="nav-item ">
          <a class="nav-link <?= @$menu5 ?> " href="report.php">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="ni ni-world-2 text-danger text-sm opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">Laporan</span>
          </a>
        </li>
        
       <?php  } ?>
       
      <!-- level pelayan -->
       <?php if($row['level']== 2){?>
       
        </li>
        <li class="nav-item">
            <a class="nav-link <?= @$menu2 ?>" href="order.php">
              <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                <i class="ni ni-calendar-grid-58 text-warning text-sm opacity-10"></i>
              </div>
              <span class="nav-link-text ms-1">Data Pesanan</span>
            </a>
          </li>

        <?php }?>
        <!-- level kasir -->
       <?php if($row['level']== 3){?>
        <li class="nav-item">
            <a class="nav-link <?= @$menu2 ?>" href="order.php">
              <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                <i class="ni ni-calendar-grid-58 text-warning text-sm opacity-10"></i>
              </div>
              <span class="nav-link-text ms-1">Data Pesanan</span>
            </a>
          </li>
          <a class="nav-link <?= @$menu6 ?>" href="menu.php">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="ni ni-calendar-grid-58 text-warning text-sm opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">Daftar Menu</span>
          </a>

        <?php }?>
        
       
  </aside>
  <main class="main-content position-relative border-radius-lg ">