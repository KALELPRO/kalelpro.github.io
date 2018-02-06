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
  include "../../../config/library.php";

  $module = $_GET['module'];
  $act    = $_GET['act'];

  // Hapus download
  if ($module=='download' AND $act=='hapus'){
    $query = "SELECT nama_file FROM download WHERE id_download='$_GET[id]'";
    $hapus = mysqli_query($konek, $query);
    $r     = mysqli_fetch_array($hapus);
    
    if ($r['nama_file']!=''){
      $namafile = $r['nama_file'];
      
      // hapus filenya
      unlink("../../../files/$namafile");   
      unlink("../../../files/small_$namafile");   

      // hapus data download di database 
      mysqli_query($konek, "DELETE FROM download WHERE id_download='$_GET[id]'");      
    }
    else{
      mysqli_query($konek, "DELETE FROM download WHERE id_download='$_GET[id]'");      
    }
    header("location:../../media.php?module=".$module);
  }

  // Input download
  elseif ($module=='download' AND $act=='input'){
    $lokasi_file    = $_FILES['fupload']['tmp_name'];
    $nama_file      = $_FILES['fupload']['name'];    
    $acak           = rand(1,99);
    $nama_file_unik = $acak.$nama_file; 

    $judul = $_POST['judul'];
    
    // Apabila tidak ada file yang diupload
    if (empty($lokasi_file)){
      $input = "INSERT INTO download(judul, tanggal) VALUES('$judul', '$tgl_sekarang')";
      mysqli_query($konek, $input);

      header("location:../../media.php?module=".$module);
    }
    else{
      // folder untuk menyimpan file yang di upload
      $folder = "../../../files/";
      $file_upload = $folder . $nama_file_unik;
      // upload file
      move_uploaded_file($_FILES["fupload"]["tmp_name"], $file_upload);
    
      $input = "INSERT INTO download(judul, nama_file, tanggal) VALUES('$judul', '$nama_file_unik', '$tgl_sekarang')";
      mysqli_query($konek, $input);

      header("location:../../media.php?module=".$module);
    }
  }

  // Update donwload
  elseif ($module=='download' AND $act=='update'){
    $lokasi_file    = $_FILES['fupload']['tmp_name'];
    $nama_file      = $_FILES['fupload']['name'];
    $acak           = rand(1,99);
    $nama_file_unik = $acak.$nama_file; 

    $id    = $_POST['id'];
    $judul = $_POST['judul'];

    // Apabila file tidak diganti
    if (empty($lokasi_file)){
      $update = "UPDATE download SET judul='$judul' WHERE id_download='$id'";
      mysqli_query($konek, $update);
      
      header("location:../../media.php?module=".$module);
    }
    else{
      // folder untuk menyimpan file yang di upload
      $folder = "../../../files/";
      $file_upload = $folder . $nama_file_unik;
      // upload file
      move_uploaded_file($_FILES["fupload"]["tmp_name"], $file_upload);
      
      $update = "UPDATE download SET judul='$judul', nama_file='$nama_file_unik' WHERE id_download='$id'";
      mysqli_query($konek, $update);
      
      header("location:../../media.php?module=".$module);
    }
  }
}
?>
