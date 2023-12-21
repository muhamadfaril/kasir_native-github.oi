<?php
include('koneksi.php');
$query = "SELECT * from tb_user";
$hasil_user = mysqli_query($conn, $query);
?>

<!-- Navbar -->
<nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl " id="navbarBlur" data-scroll="false">
  <div class="container-fluid py-1 px-3">
  
    <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
      <div class="ms-md-auto pe-md-3 d-flex align-items-center">
       
      </div>
      <ul class="navbar-nav px-5 justify-content-end">
        <li class="nav-item d-flex align-items-center">
          <a href="logout.php" class="nav-link text-white font-weight-bold px-0">
            <button type="button" class="btn btn-secondary"><span class="d-sm-inline d-none">LogOut</span></button>
          </a>
        </li>

        <li class="nav-item d-xl-none ps-3 d-flex align-items-center">
          <a href="javascript:;" class="nav-link text-white p-0" id="iconNavbarSidenav">
            <div class="sidenav-toggler-inner">
              <i class="sidenav-toggler-line bg-white"></i>
              <i class="sidenav-toggler-line bg-white"></i>
              <i class="sidenav-toggler-line bg-white"></i>
            </div>
          </a>
        </li>
        <li class="nav-item px-3 d-flex align-items-center">
          
        </li>
        <div class="collapse navbar-collapse" id="navbarNavDarkDropdown">
          <ul class="navbar-nav">
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fa fa-user me-sm-1"></i>
                <span class="d-sm-inline d-none"><?= $_SESSION['username']; ?></span>
              </a>
              <ul class="dropdown-menu ">
                <li><a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#ModalUbahPassword"></i>Ubah Password</a></li>
                
              </ul>
            </li>
          </ul>
        </div>
      </ul>
    </div>
  </div>
</nav>

<!-- modal ubah password -->
<?php foreach ($hasil_user as $user) : ?>
  <div class="modal fade" id="ModalUbahPassword" tabindex="-1" role="dialog" aria-labelledby="ModalUbahPassoword" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Ubah Password</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form novalidate action="proses_ubah_password.php" method="POST">
            <div class="form-group">
              <label for="exampleFormControlInput1">Username</label>
              <input disabled type="text" class="form-control" placeholder="Masukkan Username" name="username" value="<?php echo $user['username']; ?>">
            </div>
            <div class="form-group">
              <label>Password Lama</label>
              <input type="password" class="form-control" name="passwordlama" value="">
            </div>

            <div class="form-group">
              <label>Password Baru</label>
              <input type="password" class="form-control" name="passwordbaru">
            </div>

            <div class="form-group">
              <label>Ulangi Password</label>
              <input type="password" class="form-control" name="repasswordbaru">
            </div>

            <div class="modal-footer">
              <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Close</button>
              <button type="submit" class="btn bg-gradient-primary" name="ubah_password_validate">Ubah</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
<?php endforeach ?>
<!-- end -->


<!-- end -->
