<?php
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
$query = "SELECT * from tb_order WHERE kode_order = '$kodeOrder'";
$hasil_order = mysqli_query($conn, $query);
$data_order = mysqli_fetch_assoc($hasil_order);

$queryMenu = "SELECT * FROM tb_daftar_menu";
$hasil_menu = mysqli_query($conn, $queryMenu);
$data_menu = mysqli_fetch_assoc($hasil_menu);

$id_order = $data_order['id_order'];
// var_dump($id_order);
// die;
$querylist = "SELECT * FROM tb_list_order AS tlo JOIN tb_daftar_menu AS tm ON tlo.menu = tm.id join tb_order AS tor ON tlo.order = tor.id_order WHERE tlo.order = '$id_order';";
$hasil_list = mysqli_query($conn, $querylist);
$list_order = mysqli_fetch_all($hasil_list, MYSQLI_ASSOC);
// var_dump($list_order);
// die;
// Menghasilkan kode order acak
$randomOrderCode = generateRandomOrderCode(8);


function Total($idMenu, $id)
{

    include('koneksi.php');
    $queryMenu = "SELECT * from tb_daftar_menu WHERE id = '$idMenu'";
    $hasil_Menu = mysqli_query($conn, $queryMenu);
    $data_menu = mysqli_fetch_assoc($hasil_Menu);
    $queryList = "SELECT * FROM tb_list_order AS tlo WHERE tlo.id_list_order = '$id'";
    $execList = mysqli_query($conn, $queryList);
    $dataList = mysqli_fetch_assoc($execList);
    $harga = 0;

    if (mysqli_num_rows($execList) != 0) {

        // foreach ($dataList as $list) {
        //     $total = $list['jumlah'] * $data_menu['harga'];
        //     $harga += $total;
        // }
        $harga =  $dataList['jumlah'] * $data_menu['harga'];
        $_SESSION['totalHarga'] = $harga;
    }

    return $harga;
    if (isset($_POST['pembayaran'])) {
        $inputPembayaran = intval($_POST['pembayaran']);

        // Hitung kembalian
        $kembalian = $inputPembayaran - $_SESSION['totalHarga'];

        // Simpan nilai pembayaran dan kembalian ke dalam sesi
        $_SESSION['pembayaran'] = $inputPembayaran;
        $_SESSION['kembalian'] = $kembalian;
        // var_dump($_SESSION);
        // die;
    }

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
    Halaman Order Item 
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
    <div class="col-lg-9 mt-2">
        <div class="card">
            <div class="card-header">
                Halaman Order Item
            </div>
            <div class="card-body mb-3">
                <a href="order.php" class="btn btn-info mb-3">Kembali</a>
                <div class="row">
                    <div class="col-lg-3 ">
                        <div class="form-floating mb-3">
                            <input disabled="" type="text" class="form-control" id="kodeorder" value="<?= $data_order['kode_order'] ?>">
                            <label for="uploadFoto">Kode Order</label>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="form-floating mb-3">
                            <input disabled="" type="text" class="form-control" id="meja" value="<?= $data_order['meja'] ?>">
                            <label for="uploadFoto">Meja</label>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-floating mb-3">
                            <input disabled="" type="text" class="form-control" id="pelanggan" value="<?= $data_order['pelanggan'] ?>">
                            <label for="uploadFoto">Pelanggan</label>
                        </div>
                    </div>
                </div>
                <!-- Modal Tambah Item Baru-->
                <div class="modal fade" id="tambahItem" tabindex="-1" aria-labelledby="exampleModalLabel" style="display: none;" aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-fullscreen-md-down">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah Menu Makanan dan Minuman</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form class="needs-validation" novalidate="" action="proses_input_orderitem.php" method="POST">
                                    <input type="hidden" name="id_order" value="<?= $data_order['id_order'] ?>">
                                    <input type="hidden" name="kode_order" value="<?= $data_order['kode_order'] ?>">
                                    <div class="row">
                                        <div class="col-lg-8">
                                            <div class="form-floating mb-3">
                                                <select class="form-select" name="menu" id="">
                                                    <?php foreach ($hasil_menu as $menu) : ?>
                                                        <option value="<?= $menu['id'] ?>"><?= $menu['nama_menu'] ?></option>
                                                    <?php endforeach ?>
                                                </select>
                                                <label for="menu">Menu Makanan/Minuman</label>
                                                <div class="invalid-feedback">
                                                    Pilih Menu
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-floating mb-3">
                                                <input type="number" class="form-control" id="floatingInput" placeholder="Jumlah Porsi" name="jumlah" oninput="this.value = this.value.replace(/[^0-9]/g, '');" required>
                                                <label for="floatingInput">Jumlah Porsi</label>
                                                <div class="invalid-feedback">
                                                    Masukkan Jumlah Porsi.
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="form-floating mb-3">
                                                <input type="text" class="form-control" id="floatingInput" placeholder="Catatan" name="catatan">
                                                <label for="floatingPassword">Catatan</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary" name="input_orderitem" value="1234">Save changes</button>
                                    </div>
                                </form>
                            </div>

                        </div>
                    </div>
                </div>
                <!-- Akhir Modal Tambah Item Baru-->
                <!-- modal bayar -->
                <div class="modal fade" id="bayarItem" tabindex="-1" aria-labelledby="exampleModalLabel" style="display: none;" aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-fullscreen-md-down">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalLabel">Kasir</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form class="needs-validation" novalidate="" action="proses_input_orderitem.php" method="POST">
                                    <input type="hidden" name="id_order" value="<?= $data_order['id_order'] ?>">
                                    <input type="hidden" name="kode_order" value="<?= $data_order['kode_order'] ?>">
                                    <div class="table-responsive">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr class="text-nowrap">
                                                    <th scope="col">Menu</th>
                                                    <th scope="col">Harga</th>
                                                    <th scope="col">Qty</th>
                                                    <th scope="col">Catatan</th>
                                                    <th scope="col">Total </th>

                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $totalHarga = 0; ?>
                                                <?php foreach ($list_order as $list) : ?>
                                                    <?php $total = Total($list['menu'], $list['id_list_order']);
                                                    ?>
                                                    <tr>
                                                        <td>
                                                            <p class="text-xs font-weight-bold mb-0"><?= $list['nama_menu']; ?></p>
                                                        </td>
                                                        <td>
                                                            <p class="text-xs font-weight-bold mb-0"><?= $list['harga']; ?></p>
                                                        </td>
                                                        <td>
                                                            <p class="text-xs font-weight-bold mb-0"><?= $list['jumlah']; ?></p>
                                                        </td>

                                                        <td>
                                                            <p class="text-xs font-weight-bold mb-0"><?= $list['catatan']; ?></p>
                                                        </td>
                                                        <td>
                                                            <p class="text-xs font-weight-bold mb-0"><?= number_format($total); ?></p>
                                                        </td>
                                                    
                                                    </tr>
                                                <?php
                                                    $totalHarga += $total;
                                                endforeach; ?>
                                                <tr>
                                                    <td>Total Harga : </td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td><?= number_format($totalHarga) ?></td>
                                                </tr>
                                                <tr>
                                                    
                                                    <td>
                                                        <input type="number" name="pembayaran" id="pembayaran" required placeholder="nominal pembayaran" >
                                                        
                                                    </td>
                                                    
                                                </tr>
                                                <tr>
                                                    
                                                   
                                                    
                                                    <td>
                                                    <button type="button" onclick="kembali()" class="btn btn-success" >Hitung Kembalian</button>
                                                        <input readonly type="text" name="" id="kembalian" value="">
                                                        <input type="hidden" name="kembalian" id="kembalian1">
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary" name="bayar" value="1234" href="struk.php">Bayar</button>
                                    </div>
                                </form>
                            </div>

                        </div>
                    </div>
                </div>
                <!-- end bayar -->

                <!-- modal update -->
                <?php foreach ($list_order as $list) : ?>
                    <div class="modal fade" id="updateItem<?= $list['id_list_order'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" style="display: none;" aria-hidden="true">
                        <div class="modal-dialog modal-lg modal-fullscreen-md-down">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Update Menu Makanan dan Minuman</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="proses_input_orderitem.php" method="POST" enctype="multipart/form-data">
                                        <input type="hidden" name="id_order" value="<?= $data_order['id_order'] ?>">
                                        <input type="hidden" name="kode_order" value="<?= $data_order['kode_order'] ?>">
                                        <input type="hidden" name="id_item_to_update" id="id_item_to_update" value=<?= $list['id_list_order'] ?>>
                                        <div class="row">
                                            <div class="col-lg-8">
                                                <div class="form-floating mb-3">
                                                    <select class="form-select" name="menu" id="">
                                                        <?php foreach ($hasil_menu as $menu) : ?>
                                                            <option value="<?= $menu['id'] ?>"><?= $menu['nama_menu'] ?></option>
                                                        <?php endforeach ?>
                                                    </select>
                                                    <label for="menu">Menu Makanan/Minuman</label>
                                                    <div class="invalid-feedback">
                                                        Pilih Menu
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-floating mb-3">
                                                    <input type="number" class="form-control" id="floatingInput" value="<?= $list['jumlah'] ?>" name="jumlah" oninput="this.value = this.value.replace(/[^0-9]/g, '');">
                                                    <label for="floatingInput">Jumlah Porsi</label>
                                                    <div class="invalid-feedback">
                                                        Masukkan Jumlah Porsi.
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="form-floating mb-3">
                                                    <input type="text" class="form-control" id="floatingPassword" value="<?= $list['catatan'] ?>" name="catatan">
                                                    <label for="floatingPassword">Catatan</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary" name="update_orderitem">Update Item</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach ?>
                <div>
                    <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#tambahItem"><i class="bi bi-plus-circle-fill"></i> Item</button>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#bayarItem"><i class="bi bi-cash-coin"></i> Bayar</button>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr class="text-nowrap">
                                <th scope="col">Menu</th>
                                <th scope="col">Harga</th>
                                <th scope="col">Qty</th>

                                <th scope="col">Catatan</th>
                                <th scope="col">Total </th>
                                <th scope="col">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $totalHargaBawah = 0; ?>
                            <?php foreach ($list_order as $list) : ?>
                                <?php $total =  Total($list['menu'], $list['id_list_order']); 
                                // echo $list['id_list_order'];
                                ?>
                                <tr>
                                    <td>
                                        <p class="text-xs font-weight-bold mb-0"><?= $list['nama_menu']; ?></p>
                                    </td>
                                    <td>
                                        <p class="text-xs font-weight-bold mb-0"><?= $list['harga']; ?></p>
                                    </td>
                                    <td>
                                        <p class="text-xs font-weight-bold mb-0"><?= $list['jumlah']; ?></p>
                                    </td>   

                                    <td>
                                        <p class="text-xs font-weight-bold mb-0"><?= $list['catatan']; ?></p>
                                    </td>
                                    <td>
                                        <p class="text-xs font-weight-bold mb-0"><?= $total ?></p>
                                    </td>

                                    </td>
                                    <td>
                                        <div class="d-flex">
                                            <button class="btn btn-warning btn-sm me-1" data-bs-toggle="modal" data-bs-target="#updateItem<?= $list['id_list_order'] ?>"></i>Edit</button>
                                            <a onclick="return confirm('Yakinn?')" class="btn btn-danger" href="proses_input_orderitem.php?delete=<?= $list['id_list_order'] ?>&code=<?= $kodeOrder ?>">Hapus </a>
                                        </div>
                                    </td>
                                </tr>

                            <?php
                                $totalHargaBawah += $total;
                            endforeach ?>
                            <tr>
                                <td>Total Harga : </td>
                                <td></td>
                                <td></td>
                                <td></td>


                                <td><?= number_format($totalHargaBawah) ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>
</main>
<!-- scrip buat nominal kembalian -->
<script>
    function kembali() {
        var total = <?php echo $totalHarga ?>;
        var input = parseInt(document.getElementById('pembayaran').value);
        var kembalian = input - total;
        if(input < total){
            alert('Total Bayar Kurang')
        }
        document.getElementById('kembalian').value = kembalian;
        document.getElementById('kembalian1').value = kembalian;
    }
</script>
<!-- end -->



<!--   Core JS Files   -->
<?php
include_once('js.php');
?>

</body>

</html>