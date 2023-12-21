<?php
include('koneksi.php');
$page = "user";
$query = "SELECT * from tb_user";
$hasil_user = mysqli_query($conn, $query);
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="./assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="argon_dashboard/assets/img/favicon.png">
  <title>
User
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
            Input User
          </button>
          <h3 class="text-center" >Data User</h3>
        </div>


        <!-- Modal input_user -->
        <div class="modal fade" id="modalinput" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Input User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <form action="proses_input_user.php" method="POST" enctype="multipart/form-data">
                  <div class="form-group">
                    <label>Username</label>
                    <input type="text" class="form-control" placeholder="Masukkan Username" name="username" required>
                  </div>
                  <div class="form-group">
                    <label>Level User</label>
                    <select class="form-control" name="level">
                      <option value="1">Admin</option>
                      <option value="2">Kasir</option>
                      <option value="3">Pelayan</option>
                      
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="">Password</label>
                    <input type="password" class="form-control" placeholder="Masukkan Password" name="password" required>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn bg-gradient-primary" name="input_user1">Save changes</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
        <!-- end -->

        <!-- Modal view_user -->
        <?php
        foreach ($hasil_user as $user) { ?>
          <div class="modal fade" id="ModalView<?= $user['id_user'] ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">View User</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <form action="proses_input_user.php" method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                      <label for="exampleFormControlInput1">Username</label>
                      <input disabled type="text" class="form-control" id="username" placeholder="Masukkan Username" name="username" value="<?php echo $user['username'] ?>">

                    </div>
                    <div class="form-group">
                      <label for="exampleFormControlSelect1">Level User</label>
                      <input disabled type="text" class="form-control" name="level" value="
                    <?php
                    if ($user['level'] == 1) {
                      echo "Admin";
                    } elseif ($user['level'] == 2) {
                      echo "Kasir";
                    } elseif ($user['level'] == 3) {
                      echo "Pelayan";
                    } 
                    ?>">

                    </div>

                </div>
                <div class="modal-footer">
                  <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Close</button>

                </div>
              </div>
            </div>
          </div>
        <?php } ?>
        <!-- end -->
        <!-- Modal update_user -->
        <?php foreach ($hasil_user as $user) : ?>
          <div class="modal fade" id="ModalUpdate<?= $user['id_user'] ?>" tabindex="-1" role="dialog" aria-labelledby="ModalUpdate" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Update User</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <form action="proses_input_user.php" method="POST" enctype="multipart/form-data">
                    <input hidden type="text" name="id_user" value="<?php echo $user['id_user'] ?>">
                    <div class="form-group">
                      <label for="exampleFormControlInput1">Username</label>
                      <input  type="text" class="form-control" placeholder="Masukkan Username" name="username" value="<?php echo $user['username'] ?>">
                    </div>
                    <div class="form-group">
                      <label for="exampleFormControlSelect1">Level User</label>
                      <select class="form-select" aria-label="Default select example" required name="level" id="">
                        <?php

                        $data = array("Admin", "Kasir", "Pelayan");
                        foreach ($data as $key => $value) {
                          if ($user["level"] == $key + 1) {
                            $key++;
                            echo "<option selected value='$key'>$value</option>";
                          } else {
                            $key++;
                            echo "<option value='$key'>$value</option>";
                          }
                        }
                        ?>
                      </select>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Close</button>
                      <button type="submit" class="btn bg-gradient-primary" name="update_user">Save changes</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        <?php endforeach ?>
        <!-- end -->
        <!-- modal reset password -->
        <?php foreach ($hasil_user as $user) : ?>
    <div class="modal fade" id="ModalResetPassword<?= $user['id_user'] ?>" tabindex="-1" role="dialog" aria-labelledby="ModalReset" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Reset Password</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form novalidate action="proses_reset_password.php" method="POST">
                        <input type="hidden" name="id_user" value="<?php echo $user['id_user'] ?>">
                        <div class="form-group">
                            <?php
                            if ($user['username'] == $_SESSION['username']) {
                                echo "<div class='alert alert-danger'>Anda tidak dapat mereset password sendiri</div>";
                            } else {
                                echo "Apakah anda ingin mereset password user <b>{$user['username']}</b> menjadi password bawaan sistem yaitu <b>password</b>?";
                            }
                            ?>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn bg-gradient-primary" value="1234"
                            <?php echo ($user['id_user'] == $_SESSION['username']) ? 'disabled' : ''; ?>name="reset_password_user">Reset Password</button>
                        
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
                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-3">No</th>
                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-0">Username</th>
                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Level</th>
                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Aksi</th>

                </tr>
              </thead>
              <tbody>
                <?php $no = 1;
                foreach ($hasil_user as $user) { ?>
                  <tr>
                    <td>
                      <div class="d-flex px-2 py-1">
                        <div class="d-flex flex-column justify-content-center">
                          <h3 class="mb-1 text-sm"><?= $no; ?></h3>
                        </div>
                      </div>
                    </td>
                    <td>
                      <p class="text-xs font-weight-bold mb-0"><?= $user['username']; ?></p>
                    </td>
                    <td class="align-middle text-sm">
                      <p class="text-xs font-weight-bold mb-0">
                        <?php
                        if ($user['level'] == 1) {
                          echo "Admin";
                        } elseif ($user['level'] == 2) {
                          echo "Kasir";
                        } elseif ($user['level'] == 3) {
                          echo "Pelayan";
                        } 
                        ?></p>
                    </td>
                    <td class="align-middle">
                      <button type="button" class="btn btn-info " data-bs-toggle="modal" data-bs-target="#ModalView<?= $user['id_user'] ?>">View</button>
                      <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#ModalUpdate<?= $user['id_user'] ?>">Edit</button>
                      <button type="button" class="btn btn-warning " data-bs-toggle="modal" data-bs-target="#ModalResetPassword<?= $user['id_user'] ?>">Reset</button>
                      <a onclick="return confirm('Yakinn?')" class="btn btn-danger" href="proses_input_user.php?delete=<?= $user['id_user'] ?>">Hapus </a>
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