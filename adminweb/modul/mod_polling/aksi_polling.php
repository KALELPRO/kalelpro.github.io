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

  // Hapus polling
  if ($module=='polling' AND $act=='hapus'){
    $hapus = "DELETE FROM polling WHERE id_polling='$_GET[id]'";
    mysqli_query($konek, $hapus);
    
    header("location:../../media.php?module=".$module);
  }

  // Input polling
  elseif ($module=='polling' AND $act=='input'){
    $pilihan = $_POST['pilihan'];
    $status  = $_POST['status'];
    
    $input = "INSERT INTO polling(pilihan, status) VALUES('$pilihan', '$status')";
    mysqli_query($konek, $input);
    
    header("location:../../media.php?module=".$module);
  }

  // Update polling
  elseif ($module=='polling' AND $act=='update'){
    $id      = $_POST['id'];
    $pilihan = $_POST['pilihan'];
    $status  = $_POST['status'];
    $aktif   = $_POST['aktif'];
    
    $update = "UPDATE polling SET pilihan='$pilihan', status='$status', aktif='$aktif' WHERE id_polling='$id'";
    mysqli_query($konek, $update);
    
    header("location:../../media.php?module=".$module);
  }
}
?>
