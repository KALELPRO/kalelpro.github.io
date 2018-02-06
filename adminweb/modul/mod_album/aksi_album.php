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
  include "../../../config/fungsi_thumbnail.php";

  $module = $_GET['module'];
  $act    = $_GET['act'];

  // Input album
  if ($module=='album' AND $act=='input'){
    $lokasi_file = $_FILES['fupload']['tmp_name'];
    $nama_file   = $_FILES['fupload']['name'];
    $tipe_file   = $_FILES['fupload']['type'];
    $acak        = rand(1,99);
    $nama_gambar = $acak.$nama_file; 

    $nama_album = $_POST['nama_album'];
    $album_seo  = seo_title($_POST['nama_album']);
    
    // Apabila tidak ada gambar yang di upload
    if (empty($lokasi_file)){
      $input = "INSERT INTO album(nama_album, album_seo) VALUES('$nama_album', '$album_seo')";
      mysqli_query($konek, $input);

      header("location:../../media.php?module=".$module);
    }
    // Apabila ada gambar yang di upload
    else{
      if ($tipe_file != "image/jpeg" AND $tipe_file != "image/pjpeg"){
        echo "<script>window.alert('Upload Gagal! Pastikan file yang di upload bertipe *.JPG');
              window.location=('../../media.php?module=album')</script>";
      }
      else{
        $folder = "../../../foto_album/"; // folder untuk gambar album
        $ukuran = 180;                    // gambar diperkecil jadi 180px (thumb)
        UploadFoto($nama_gambar, $folder, $ukuran);
        
        $input = "INSERT INTO album(nama_album, album_seo, gambar) VALUES('$nama_album', '$album_seo', '$nama_gambar')";
        mysqli_query($konek, $input);

        header("location:../../media.php?module=".$module);
      }
    }
  }

  // Update album
  elseif ($module=='album' AND $act=='update'){
    $lokasi_file = $_FILES['fupload']['tmp_name'];
    $nama_file   = $_FILES['fupload']['name'];
    $tipe_file   = $_FILES['fupload']['type'];
    $acak        = rand(1,99);
    $nama_gambar = $acak.$nama_file; 

    $id         = $_POST['id'];
    $nama_album = $_POST['nama_album'];
    $album_seo  = seo_title($_POST['nama_album']);
    $aktif      = $_POST['aktif'];

    // Apabila gambar tidak diganti
    if (empty($lokasi_file)){
      $update = "UPDATE album SET nama_album = '$nama_album',
                                  album_seo  = '$album_seo', 
                                  aktif      = '$aktif'
                            WHERE id_album   = '$id'";
      mysqli_query($konek, $update);
      
      header("location:../../media.php?module=".$module);
    }
    else{
      if ($tipe_file != "image/jpeg" AND $tipe_file != "image/pjpeg"){
        echo "<script>window.alert('Upload Gagal! Pastikan file yang di upload bertipe *.JPG');
              window.location=('../../media.php?module=album)</script>";
      }
      else{
        $folder = "../../../foto_album/"; // folder untuk gambar album
        $ukuran = 180;                    // gambar diperkecil jadi 180px (thumb)
        UploadFoto($nama_gambar, $folder, $ukuran);

        $update = "UPDATE album SET nama_album = '$nama_album',
                                    album_seo  = '$album_seo', 
                                    aktif      = '$aktif',
                                    gambar     = '$nama_gambar' 
                              WHERE id_album   = '$id'";
        mysqli_query($konek, $update);
      
        header("location:../../media.php?module=".$module);
      }
    } 
  }
}
?>
