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
  include "../../../config/fungsi_seo.php";

  $module = $_GET['module'];
  $act    = $_GET['act'];
  
  // Input kategori
  if ($module=='kategori' AND $act=='input'){
    $nama_kategori = $_POST['nama_kategori'];
    $kategori_seo  = seo_title($_POST['nama_kategori']);
    
    $input = "INSERT INTO kategori(nama_kategori, kategori_seo) VALUES('$nama_kategori', '$kategori_seo')";
    mysqli_query($konek, $input);
    
    header("location:../../media.php?module=".$module);
  }

  // Update kategori
  elseif ($module=='kategori' AND $act=='update'){
    $id            = $_POST['id'];
    $nama_kategori = $_POST['nama_kategori'];
    $kategori_seo  = seo_title($_POST['nama_kategori']);
    $aktif         = $_POST['aktif'];

    $update = "UPDATE kategori SET nama_kategori='$nama_kategori', kategori_seo='$kategori_seo', aktif='$aktif' WHERE id_kategori='$id'";
    mysqli_query($konek, $update);
    
    header("location:../../media.php?module=".$module);
  }
}
?>
