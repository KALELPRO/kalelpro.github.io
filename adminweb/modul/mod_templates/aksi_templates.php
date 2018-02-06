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

  // Hapus templates
  if ($module=='templates' AND $act=='hapus'){
    $hapus = "DELETE FROM templates WHERE id_templates='$_GET[id]'";
    mysqli_query($konek, $hapus);
    
    header("location:../../media.php?module=".$module);
  }

  // Input templates
  if ($module=='templates' AND $act=='input'){
    $nama_templates = $_POST['nama_templates'];
    $pembuat        = $_POST['pembuat'];;
    $folder         = $_POST['folder'];;
    
    $input = "INSERT INTO templates(nama_templates, pembuat, folder) VALUES('$nama_templates', '$pembuat', '$folder')";
    mysqli_query($konek, $input);
    
    header("location:../../media.php?module=".$module);
  }

  // Update templates
  elseif ($module=='templates' AND $act=='update'){
    $id             = $_POST['id'];
    $nama_templates = $_POST['nama_templates'];
    $pembuat        = $_POST['pembuat'];;
    $folder         = $_POST['folder'];;
    
    $update = "UPDATE templates SET nama_templates='$nama_templates', pembuat='$pembuat', folder='$folder' WHERE id_templates='$id'";
    mysqli_query($konek, $update);

    header("location:../../media.php?module=".$module);
  }

  // Aktifkan templates
  elseif ($module=='templates' AND $act=='aktifkan'){
    $query1 = mysqli_query($konek, "UPDATE templates SET aktif='Y' WHERE id_templates='$_GET[id]'");
    $query2 = mysqli_query($konek, "UPDATE templates SET aktif='N' WHERE id_templates!='$_GET[id]'");

    header("location:../../media.php?module=".$module);
  }
}
?>
