<?php
session_start();
// Apabila user belum login
if (empty($_SESSION['namauser']) AND empty($_SESSION['passuser'])){
  echo "<link href=\"../../css/style_login.css\" rel=\"stylesheet\" type=\"text/css\" />
        <div id=\"login\"><h1 class=\"fail\">Untuk mengakses modul, Anda harus login dulu.</h1>
        <p class=\"fail\"><a href=\"../../index.php\">LOGIN</a></p></div>";  
}
// Apabila user sudah login dengan benar, maka terbentuklah session
else{
  include "../../../config/koneksi.php";

  $module = $_GET['module'];
  $act    = $_GET['act'];

  // Input user
  if ($module=='user' AND $act=='input'){
    $username     = $_POST['username'];
    $password     = md5($_POST['password']);
    $nama_lengkap = $_POST['nama_lengkap']; 
    $email        = $_POST['email'];
    
    $input = "INSERT INTO users(username, 
                                password, 
                                nama_lengkap, 
                                email) 
	                       VALUES('$username', 
                                '$password', 
                                '$nama_lengkap', 
                                '$email')";
    mysqli_query($konek, $input);
    header("location:../../media.php?module=".$module);
  }

  // Update user
  elseif ($module=='user' AND $act=='update'){
    $id           = $_POST['id'];
    $nama_lengkap = $_POST['nama_lengkap']; 
    $email        = $_POST['email'];
    $blokir       = $_POST['blokir'];
 
    // Apabila password tidak diubah (kosong)
    if (empty($_POST['password'])) {
      $update = "UPDATE users SET nama_lengkap = '$nama_lengkap',
                                         email = '$email',
                                        blokir = '$blokir'   
                              WHERE id_session = '$id'";
      mysqli_query($konek, $update);
    }
    // Apabila password diubah
    else{
      $password = md5($_POST['password']);
      $update = "UPDATE users SET nama_lengkap = '$nama_lengkap',
                                        email  = '$email',
                                        blokir = '$blokir',
                                      password = '$password'    
                              WHERE id_session = '$id'";
      mysqli_query($konek, $update);

    }
    header("location:../../media.php?module=".$module);
  }
}
?>
