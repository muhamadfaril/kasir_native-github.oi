<?php
include('koneksi.php');
$page = "user";
$query = "SELECT * from tb_daftar_menu";
$hasil_menu = mysqli_query($conn, $query);
$data_menu = mysqli_fetch_all($hasil_menu, MYSQLI_ASSOC);

$page = "daftar menu";
?>
<!DOCTYPE html>
<html lang="en">


<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="./assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="argon_dashboard/assets/img/favicon.png">
  <title>
    Daftar Menu
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
            Input Menu
          </button>
          <h3 class="text-center">Daftar Menu</h3>
        </div>


        <!-- Modal input_menu -->
        <div class="modal fade" id="modalinput" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Input Menu</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <form action="proses_input_menu.php" method="POST" enctype="multipart/form-data">
                  <div class="form-group">
                    <label>Masukkan Foto</label>
                    <input type="file" class="form-control" name="gambar_menu" required>
                  </div>
                  <div class="form-group">
                    <label>Nama Menu</label>
                    <input type="text" class="form-control" name="nama_menu" required>
                  </div>
                  <div class="form-group">
                    <label>Keterangan</label>
                    <input type="text" class="form-control" name="keterangan" >
                  </div>
                  
                  <select class="form-select form-select-sm" aria-label=".form-select-sm example" name="jenis_menu" >
                    <option selected>Pilih Kategori Menu</option>
                    <option value="makanan">Makanan</option>
                    <option value="minuman">Minuman</option>
                    <option value="snack">Snack</option>
                  </select>
                  <div class="form-group">
                    <label>Harga</label>
                    <input type="text" class="form-control" name="harga" required>
                  </div>
                  

                  <div class="modal-footer">
                    <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn bg-gradient-primary" name="input_menu">Save changes</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
        <!-- end -->

        <?php foreach ($data_menu as $menu) : ?>
        <!-- Modal update_menu -->
        <div class="modal fade" id="ModalUpdate<?= $menu['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="ModalUpdate" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Update Menu</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <form action="proses_input_menu.php" method="POST" enctype="multipart/form-data">
                <input hidden type="text" name="id" value="<?php echo $menu['id'] ?>">
                  <div class="form-group">
                    <label>Masukkan Foto</label>
                    <input type="file" class="form-control" name="gambar_menu">
                  </div>
                  <div class="form-group">
                    <label>Nama Menu</label>
                    <input type="text" class="form-control" name="nama_menu" value="<?php echo $menu['nama_menu'] ?>">
                  </div>
                  <div class="form-group">
                    <label>Keterangan</label>
                    <input type="text" class="form-control" name="keterangan" value="<?php echo $menu['keterangan'] ?>">
                  </div>
                  <label>Keterangan</label>
                  <select class="form-select form-select-sm" aria-label=".form-select-sm example" name="jenis_menu"value="<?php echo $menu['jenis_menu'] ?>" >
                    <option selected>Pilih Kategori Menu</option>
                    <option value="makanan">Makanan</option>
                    <option value="minuman">Minuman</option>
                    <option value="snack">Snack</option>
                  </select>
                  <div class="form-group">
                    <label>Harga</label>
                    <input type="text" class="form-control" name="harga" value="<?php echo $menu['harga'] ?>">
                  </div>
                  

                  <div class="modal-footer">
                    <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn bg-gradient-primary" name="update_menu">Update</button>
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
                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Foto Menu</th>
                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Nama Menu</th>
                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Keterangan</th>
                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Jenis menu</th>
                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Harga</th>
                
                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Aksi</th>

                </tr>
              </thead>
              <tbody>
                <?php $no = 1;
                foreach ($data_menu as $menu) { ?>
                  <tr>
                    <td>
                      <div class="d-flex px-2 py-1">
                        <div class="d-flex flex-column justify-content-center">
                          <h3 class="mb-1 text-sm"><?= $no; ?></h3>
                        </div>
                      </div>
                    </td>
                    <td>
                      <img src="img/<?= $menu['gambar_menu']; ?>" class="rounded" width="100px">
                    </td>
                    <td class="align-middle text-sm">
                      <p class="text-xs font-weight-bold mb-0"><?= $menu['nama_menu']; ?></p>
                    </td>
                    <td class="align-middle text-sm">
                      <p class="text-xs font-weight-bold mb-0"><?= $menu['keterangan']; ?></p>
                    </td>
                    <td class="align-middle text-sm">
                      <p class="text-xs font-weight-bold mb-0"><?= $menu['jenis_menu']; ?></p>
                    </td>
                    <td class="align-middle text-sm">
                      <p class="text-xs font-weight-bold mb-0"><?= $menu['harga']; ?></p>
                    </td>
                   
                    <td class="align-middle">
                      <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#ModalUpdate<?= $menu['id'] ?>">Edit</button>
                      <a onclick="return confirm('Yakinn?')" class="btn btn-danger" href="proses_input_menu.php?delete=<?= $menu['id'] ?>">Hapus </a> 
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

 
</div>
</main>

<!--   Core JS Files   -->
<?php
include_once('js.php');
?>

</body>

</html>