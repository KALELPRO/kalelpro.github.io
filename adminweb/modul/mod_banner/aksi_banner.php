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
  include "../../../config/fungsi_thumbnail.php";

  $module = $_GET['module'];
  $act    = $_GET['act'];

  // Hapus banner
  if ($module=='banner' AND $act=='hapus'){
    $query = "SELECT gambar FROM banner WHERE id_banner='$_GET[id]'";
    $hapus = mysqli_query($konek, $query);
    $r     = mysqli_fetch_array($hapus);
    
    if ($r['gambar']!=''){
      $namafile = $r['gambar'];
      
      // hapus filenya
      unlink("../../../foto_banner/$namafile");   
      unlink("../../../foto_banner/small_$namafile");   

      // hapus data banner di database 
      mysqli_query($konek, "DELETE FROM banner WHERE id_banner='$_GET[id]'");      
    }
    else{
      mysqli_query($konek, "DELETE FROM banner WHERE id_banner='$_GET[id]'");      
    }
    header("location:../../media.php?module=".$module);
  }

  // Input banner
  elseif ($module=='banner' AND $act=='input'){
    $lokasi_file = $_FILES['fupload']['tmp_name'];
    $tipe_file   = $_FILES['fupload']['type'];
    $nama_file   = $_FILES['fupload']['name'];
    $acak        = rand(1,99);
    $nama_gambar = $acak.$nama_file; 
    
    $judul = $_POST['judul'];
    $link  = $_POST['link'];

    // Apabila tidak ada gambar yang di upload
    if (empty($lokasi_file)){
      $input = "INSERT INTO banner(judul, link) VALUES('$judul', '$link')";
      mysqli_query($konek, $input);

      header("location:../../media.php?module=".$module);
    }
    // Apabila ada gambar yang di upload
    else{
      if ($tipe_file != "image/jpeg" AND $tipe_file != "image/pjpeg"){
        echo "<script>window.alert('Upload Gagal! Pastikan file yang di upload bertipe *.JPG');
              window.location=('../../media.php?module=banner')</script>";
      }
      else{
        $folder = "../../../foto_banner/"; // folder untuk gambar banner
        $ukuran = 200;                     // gambar diperkecil jadi 200px (thumb)
        UploadFoto($nama_gambar, $folder, $ukuran);
        
        $input = "INSERT INTO banner(judul, link, gambar) VALUES('$judul', '$link', '$nama_gambar')";
        mysqli_query($konek, $input);

        header("location:../../media.php?module=".$module);
      }
    }
  }

  // Update banner
  elseif ($module=='banner' AND $act=='update'){
    $lokasi_file = $_FILES['fupload']['tmp_name'];
    $tipe_file   = $_FILES['fupload']['type'];
    $nama_file   = $_FILES['fupload']['name'];
    $acak        = rand(1,99);
    $nama_gambar = $acak.$nama_file; 

    $id    = $_POST['id'];    
    $judul = $_POST['judul'];
    $link  = $_POST['link'];
    $aktif = $_POST['aktif'];

    // Apabila gambar tidak diganti
    if (empty($lokasi_file)){
      $update = "UPDATE banner SET judul     = '$judul',
                                   link      = '$link', 
                                   aktif     = '$aktif'
                             WHERE id_banner = '$id'";
      mysqli_query($konek, $update);
      
      header("location:../../media.php?module=".$module);
    }
    else{
      if ($tipe_file != "image/jpeg" AND $tipe_file != "image/pjpeg"){
        echo "<script>window.alert('Upload Gagal! Pastikan file yang di upload bertipe *.JPG');
              window.location=('../../media.php?module=banner')</script>";
      }
      else{
        $folder = "../../../foto_banner/"; // folder untuk gambar banner
        $ukuran = 200;                    // gambar diperkecil jadi 200px (thumb)
        UploadFoto($nama_gambar, $folder, $ukuran);

        $update = "UPDATE banner SET judul       = '$judul',
                                     link        = '$link', 
                                     aktif       = '$aktif',
                                     gambar      = '$nama_gambar' 
                               WHERE id_banner   = '$id'";
        mysqli_query($konek, $update);
      
        header("location:../../media.php?module=".$module);
      }
    }
  }
}
?>
