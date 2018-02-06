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

  $id             = $_POST['id'];
  $nama_pemilik   = $_POST['nama_pemilik'];
  $judul_website  = $_POST['judul_website'];
  $alamat_website = $_POST['alamat_website']; 
  $meta_deskripsi = $_POST['meta_deskripsi'];
  $meta_keyword   = $_POST['meta_keyword'];
  $email          = $_POST['email'];
  $facebook       = $_POST['facebook'];
  $twitter        = $_POST['twitter'];
  $twitter_widget = addslashes($_POST['twitter_widget']);
  $googleplus     = $_POST['googleplus'];
  $googlemap      = $_POST['googlemap'];

  $lokasi_file    = $_FILES['fupload']['tmp_name'];
  $nama_file      = $_FILES['fupload']['name'];

  // Apabila gambar favicon tidak diganti (atau tidak ada gambar yang di upload)
  if (empty($lokasi_file)){
    $edit = "UPDATE identitas SET nama_pemilik   = '$nama_pemilik',
                                  judul_website  = '$judul_website',
                                  alamat_website = '$alamat_website',
                                  meta_deskripsi = '$meta_deskripsi',
                                  meta_keyword   = '$meta_keyword',
                                  email          = '$email',
                                  twitter        = '$twitter',
                                  twitter_widget = '$twitter_widget',
                                  googleplus     = '$googleplus',
                                  googlemap      = '$googlemap',
                                  facebook       = '$facebook'
                            WHERE id_identitas   = '$id'";
    mysqli_query($konek, $edit);
    header("location:../../media.php?module=".$module);
  }
  else{
    // folder untuk gambar favicon ada di root
    $folder = "../../../";
    $file_upload = $folder . $nama_file;
    // upload gambar favicon
    move_uploaded_file($_FILES["fupload"]["tmp_name"], $file_upload);

    $edit = "UPDATE identitas SET nama_pemilik   = '$nama_pemilik',
                                  judul_website  = '$judul_website',
                                  alamat_website = '$alamat_website',
                                  meta_deskripsi = '$meta_deskripsi',
                                  meta_keyword   = '$meta_keyword',
                                  email          = '$email',
                                  twitter        = '$twitter',
                                  twitter_widget = '$twitter_widget',
                                  googleplus     = '$googleplus',
                                  googlemap      = '$googlemap',
                                  facebook       = '$facebook'
                            WHERE id_identitas   = '$id'";
    mysqli_query($konek, $edit);
    header("location:../../media.php?module=".$module);
  }
}
?>
