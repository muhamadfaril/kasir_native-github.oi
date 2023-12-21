<?php 
session_start();
require_once('koneksi.php');
if(isset($_POST['register'])) {
   $id_admin = $_POST['id_admin'];
   $username = $_POST['username'];
   $password = md5($_POST['password']);
   $query = "INSERT INTO tb_user VALUES(
        '',
        '$username',
        '$password',
    )";
   
   mysqli_query($conn,$query);
   header('Location: login.php');
}
if(isset($_POST['login'])){
    $username = $_POST['username'];
    $password = md5($_POST['password']);
    $query = "SELECT * FROM tb_user where username='$username'";
        $hasil = mysqli_query($conn, $query);
        $tess= mysqli_fetch_array($hasil);
        if($tess==NULL){
          echo"<script> alert('Username tidak ditemukan');
          window.location.replace('login.php');
          </script>";
        } else if($password <> $tess['password']){
          echo"<script> alert('password salah');
          window.location.replace('login.php');
          </script>"; 
         
        } else{
         session_start();
         $_SESSION['username'] = $tess['username'];
         echo "<script> window.location.href = 'index.php'; </script>";
         header('Location: index.php');
   }
 }
 ?>