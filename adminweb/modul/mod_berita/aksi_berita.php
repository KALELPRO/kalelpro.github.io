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
  include "../../../config/fungsi_seo.php";
  include "../../../config/fungsi_thumbnail.php";

  $module = $_GET['module'];
  $act    = $_GET['act'];

  // Hapus berita
  if ($module=='berita' AND $act=='hapus'){
    $query = "SELECT gambar FROM berita WHERE id_berita='$_GET[id]'";
    $hapus = mysqli_query($konek, $query);
    $r     = mysqli_fetch_array($hapus);
    
    if ($r['gambar']!=''){
      $namafile = $r['gambar'];
      // hapus file gambar yang berhubungan dengan berita tersebut
      unlink("../../../foto_berita/$namafile");   
      unlink("../../../foto_berita/small_$namafile");   
      
      // hapus data berita di database 
      mysqli_query($konek, "DELETE FROM berita WHERE id_berita='$_GET[id]'");      
    }
    else{
      mysqli_query($konek, "DELETE FROM berita WHERE id_berita='$_GET[id]'");
    }
    header("location:../../media.php?module=".$module);
  }

  // Input berita
  elseif ($module=='berita' AND $act=='input'){
    $lokasi_file = $_FILES['fupload']['tmp_name'];
    $tipe_file   = $_FILES['fupload']['type'];
    $nama_file   = $_FILES['fupload']['name'];
    $acak        = rand(1,99);
    $nama_gambar = $acak.$nama_file; 
  
    if (!empty($_POST['tag_seo'])){
      $tag_seo = $_POST['tag_seo'];
      $tag     = implode(',',$tag_seo);
    }
    
    $judul      = $_POST['judul'];            
    $judul_seo  = seo_title($_POST['judul']);
    $kategori   = $_POST['kategori'];
    $headline   = $_POST['headline'];
    $publish    = $_POST['publish'];
    $isi_berita = $_POST['isi_berita'];

    // Apabila tidak ada gambar yang di upload
    if (empty($lokasi_file)){
      $input = "INSERT INTO berita(judul,
                                   judul_seo,     
                                   id_kategori, 
                                   username,
                                   headline,
                                   publish,
                                   isi_berita,
                                   hari,
                                   tanggal,
                                   jam,
                                   tag) 
	                         VALUES('$judul',
                                  '$judul_seo', 
                                  '$kategori', 
                                  '$_SESSION[namauser]',
                                  '$headline',
                                  '$publish',
                                  '$isi_berita',
                                  '$hari_ini',
                                  '$tgl_sekarang',
                                  '$jam_sekarang',
                                  '$tag')";
      mysqli_query($konek, $input);

      header("location:../../media.php?module=".$module);
    } 
    
    // Apabila ada gambar yang di upload
    else{
      if ($tipe_file != "image/jpeg" AND $tipe_file != "image/pjpeg"){
        echo "<script>window.alert('Upload Gagal! Pastikan file yang di upload bertipe *.JPG');
              window.location=('../../media.php?module=berita')</script>";
      }
      else{
        $folder = "../../../foto_berita/"; // folder untuk foto berita
        $ukuran = 200;                     // foto diperkecil jadi 200px (thumb)
        UploadFoto($nama_gambar, $folder, $ukuran);
        $input = "INSERT INTO berita(judul,
                                   judul_seo,     
                                   id_kategori, 
                                   username,
                                   headline,
                                   publish,
                                   isi_berita,
                                   hari,
                                   tanggal,
                                   jam,
                                   tag,
                                   gambar) 
	                         VALUES('$judul',
                                  '$judul_seo', 
                                  '$kategori', 
                                  '$_SESSION[namauser]',
                                  '$headline',
                                  '$publish',
                                  '$isi_berita',
                                  '$hari_ini',
                                  '$tgl_sekarang',
                                  '$jam_sekarang',
                                  '$tag',
                                  '$nama_gambar')";
        mysqli_query($konek, $input);

        header("location:../../media.php?module=".$module);
      }
    }
  }

  // Update berita
  elseif ($module=='berita' AND $act=='update'){
    $lokasi_file = $_FILES['fupload']['tmp_name'];
    $tipe_file   = $_FILES['fupload']['type'];
    $nama_file   = $_FILES['fupload']['name'];
    $acak        = rand(1,99);
    $nama_gambar = $acak.$nama_file; 

    if (!empty($_POST['tag_seo'])){
      $tag_seo = $_POST['tag_seo'];
      $tag     = implode(',',$tag_seo);
    }

    $id         = $_POST['id'];
    $judul      = $_POST['judul'];            
    $judul_seo  = seo_title($_POST['judul']);
    $kategori   = $_POST['kategori'];
    $headline   = $_POST['headline'];
    $publish    = $_POST['publish'];
    $isi_berita = $_POST['isi_berita'];

    // Apabila gambar tidak diganti
    if (empty($lokasi_file)){
      $update = "UPDATE berita SET judul       = '$judul',
                                   judul_seo   = '$judul_seo', 
                                   id_kategori = '$kategori',
                                   headline    = '$headline',
                                   publish     = '$publish',
                                   isi_berita  = '$isi_berita',  
                                   tag         = '$tag' 
                             WHERE id_berita   = '$id'";
      mysqli_query($konek, $update);
      
      header("location:../../media.php?module=".$module);
    }
    else{
      if ($tipe_file != "image/jpeg" AND $tipe_file != "image/pjpeg"){
        echo "<script>window.alert('Upload Gagal! Pastikan file yang di upload bertipe *.JPG');
              window.location=('../../media.php?module=berita')</script>";
      }
      else{
        $folder = "../../../foto_berita/"; // folder untuk foto berita
        $ukuran = 200;                     // foto diperkecil jadi 200px (thumb)
        UploadFoto($nama_gambar, $folder, $ukuran);
        $update = "UPDATE berita SET judul       = '$judul',
                                     judul_seo   = '$judul_seo', 
                                     id_kategori = '$kategori',
                                     headline    = '$headline',
                                     publish     = '$publish',
                                     isi_berita  = '$isi_berita',  
                                     tag         = '$tag',
                                     gambar      = '$nama_gambar' 
                               WHERE id_berita   = '$id'";
        mysqli_query($konek, $update);

        header("location:../../media.php?module=".$module);
      }
    }
  }
}
?>
