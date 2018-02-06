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
    
  // Hapus hubungi
  if ($module=='hubungi' AND $act=='hapus'){
    $hapus = "DELETE FROM hubungi WHERE id_hubungi='$_GET[id]'";
    mysqli_query($konek, $hapus);
    
    header("location:../../media.php?module=".$module);
  }
}
?>
