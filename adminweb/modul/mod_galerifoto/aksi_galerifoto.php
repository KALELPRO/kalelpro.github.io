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

  // Hapus galeri foto
  if ($module=='galerifoto' AND $act=='hapus'){
    // cari informasi nama file foto yang ada di tabel galeri
    $query = "SELECT foto FROM galeri WHERE id_galeri='$_GET[id]'";
    $hapus = mysqli_query($konek, $query);
    $r     = mysqli_fetch_array($hapus);
    
    // kalau ada file fotonya
    if ($r['foto']!=''){
      $namafile = $r['foto'];
      
      // hapus file foto yang berhubungan dengan galeri tersebut
      unlink("../../../foto_galeri/$namafile");   
      unlink("../../../foto_galeri/small_$namafile");   

      // kemudian baru hapus data galeri di database 
      mysqli_query($konek, "DELETE FROM galeri WHERE id_galeri='$_GET[id]'");      
    }
    // kalau tidak ada file fotonya
    else{
      mysqli_query($konek, "DELETE FROM galeri WHERE id_galeri='$_GET[id]'");
    }
    header("location:../../media.php?module=".$module);
  }


  // Input galeri foto
  elseif ($module=='galerifoto' AND $act=='input'){
    $lokasi_file = $_FILES['fupload']['tmp_name'];
    $tipe_file   = $_FILES['fupload']['type'];
    $nama_file   = $_FILES['fupload']['name'];
    $acak        = rand(1,99);
    $nama_foto   = $acak.$nama_file; 
  
    $judul_galeri = $_POST['judul_galeri'];
    $galeri_seo   = seo_title($_POST['judul_galeri']);
    $album        = $_POST['album'];
    $keterangan   = $_POST['keterangan'];

    // Apabila tidak ada foto yang di upload
    if (empty($lokasi_file)){
      $input = "INSERT INTO galeri(judul_galeri, 
                                   galeri_seo,
                                   id_album, 
                                   keterangan) 
                            VALUES('$judul_galeri', 
                                   '$galeri_seo',
                                   '$album',
                                   '$keterangan')";
      mysqli_query($konek, $input);

      header("location:../../media.php?module=".$module);
    }
    // Apabila ada foto yang di upload
    else{
      if ($tipe_file != "image/jpeg" AND $tipe_file != "image/pjpeg"){
        echo "<script>window.alert('Upload Gagal! Pastikan file yang di upload bertipe *.JPG');
              window.location=('../../media.php?module=galerifoto')</script>";
      }
      else{
        $folder = "../../../foto_galeri/"; // folder untuk foto galeri
        $ukuran = 180;                     // foto diperkecil jadi 180px (thumb)
        UploadFoto($nama_foto, $folder, $ukuran);
        
        $input = "INSERT INTO galeri(judul_galeri, 
                                     galeri_seo,
                                     id_album, 
                                     keterangan,
                                     foto) 
                              VALUES('$judul_galeri', 
                                     '$galeri_seo',
                                     '$album',
                                     '$keterangan',
                                     '$nama_foto')";
        mysqli_query($konek, $input);

        header("location:../../media.php?module=".$module);
      }
    }
  }

  // Update galeri foto
  elseif ($module=='galerifoto' AND $act=='update'){
    $lokasi_file    = $_FILES['fupload']['tmp_name'];
    $tipe_file      = $_FILES['fupload']['type'];
    $nama_file      = $_FILES['fupload']['name'];
    $acak           = rand(1,99);
    $nama_foto      = $acak.$nama_file; 

    $id           = $_POST['id'];
    $judul_galeri = $_POST['judul_galeri'];
    $galeri_seo   = seo_title($_POST['judul_galeri']);
    $album        = $_POST['album'];
    $keterangan   = $_POST['keterangan'];

    // Apabila foto tidak diganti
    if (empty($lokasi_file)){
      $update = "UPDATE galeri SET judul_galeri = '$judul_galeri',
                                   galeri_seo   = '$galeri_seo', 
                                   id_album     = '$album',
                                   keterangan   = '$keterangan' 
                             WHERE id_galeri    = '$id'";
      mysqli_query($konek, $update);
      
      header("location:../../media.php?module=".$module);
    }
    else{
      if ($tipe_file != "image/jpeg" AND $tipe_file != "image/pjpeg"){
        echo "<script>window.alert('Upload Gagal! Pastikan file yang di upload bertipe *.JPG');
              window.location=('../../media.php?module=galerifoto)</script>";
      }
      else{
        $folder = "../../../foto_galeri/"; // folder untuk foto galeri
        $ukuran = 180;                     // foto diperkecil jadi 180px (thumb)
        UploadFoto($nama_foto, $folder, $ukuran);

        $update = "UPDATE galeri SET judul_galeri = '$judul_galeri',
                                     galeri_seo   = '$galeri_seo', 
                                     id_album     = '$album',
                                     keterangan   = '$keterangan', 
                                     foto         = '$nama_foto' 
                               WHERE id_galeri    = '$id'";
        mysqli_query($konek, $update);
      
        header("location:../../media.php?module=".$module);
      }
    }
  }
}
?>
