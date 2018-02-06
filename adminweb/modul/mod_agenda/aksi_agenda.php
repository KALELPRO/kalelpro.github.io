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
  include "../../../config/library.php";

  $module = $_GET['module'];
  $act    = $_GET['act'];

  // Hapus agenda
  if ($module=='agenda' AND $act=='hapus'){
    $query = "SELECT gambar FROM agenda WHERE id_agenda='$_GET[id]'";
    $hapus = mysqli_query($konek, $query);
    $r     = mysqli_fetch_array($hapus);
    
    if ($r['gambar']!=''){
      $namafile = $r['gambar'];
      
      // hapus file foto yang berhubungan dengan agenda tersebut
      unlink("../../../foto_banner/$namafile");   
      unlink("../../../foto_banner/small_$namafile");   

      // hapus data agenda di database 
      mysqli_query($konek, "DELETE FROM agenda WHERE id_agenda='$_GET[id]'");      
    }
    else{
      mysqli_query($konek, "DELETE FROM agenda WHERE id_agenda='$_GET[id]'");
    }
    header("location:../../media.php?module=".$module);
  }

  // Input agenda
  elseif ($module=='agenda' AND $act=='input'){
    $lokasi_file = $_FILES['fupload']['tmp_name'];
    $tipe_file   = $_FILES['fupload']['type'];
    $nama_file   = $_FILES['fupload']['name'];
    $acak        = rand(1,99);
    $nama_gambar = $acak.$nama_file; 

    $tema        = $_POST['tema'];
    $tema_seo    = seo_title($_POST['tema']);
    $isi_agenda  = $_POST['isi_agenda'];
    $tempat      = $_POST['tempat'];
    $tgl_mulai   = ubah_tgl($_POST['tgl_mulai']);
    $tgl_selesai = ubah_tgl($_POST['tgl_selesai']);
    $jam         = $_POST['jam'];
    $pengirim    = $_POST['pengirim'];
    
    // Apabila tidak ada gambar yang di upload
    if (empty($lokasi_file)){
      $input = "INSERT INTO agenda(tema, 
                                   tema_seo, 
                                   isi_agenda,
                                   tempat, 
                                   tgl_mulai,
                                   tgl_selesai,
                                   tgl_posting,
                                   jam,
                                   pengirim,
                                   username) 
                           VALUES('$tema', 
                                  '$tema_seo', 
                                  '$isi_agenda',
                                  '$tempat',
                                  '$tgl_mulai',
                                  '$tgl_selesai',
                                  '$tgl_sekarang',
                                  '$jam',
                                  '$pengirim',
                                  '$_SESSION[namauser]')";
      mysqli_query($konek, $input);
    }
    // Apabila ada gambar yang di upload
    else{
      if ($tipe_file != "image/jpeg" AND $tipe_file != "image/pjpeg"){
        echo "<script>window.alert('Upload Gagal! Pastikan file yang di upload bertipe *.JPG');
              window.location=('../../media.php?module=agenda')</script>";
      }
      else{
        $folder = "../../../foto_banner/"; // folder untuk gambar halaman statis
        $ukuran = 600;                     // gambar diperkecil jadi 600px (thumb)
        UploadFoto($nama_gambar, $folder, $ukuran);
        
        $input = "INSERT INTO agenda(tema, 
                                     tema_seo, 
                                     isi_agenda,
                                     tempat, 
                                     tgl_mulai,
                                     tgl_selesai,
                                     tgl_posting,
                                     jam,
                                     pengirim,
                                     username,
                                     gambar) 
                             VALUES('$tema', 
                                    '$tema_seo', 
                                    '$isi_agenda',
                                    '$tempat',
                                    '$tgl_mulai',
                                    '$tgl_selesai',
                                    '$tgl_sekarang',
                                    '$jam',
                                    '$pengirim',
                                    '$_SESSION[namauser]',
                                    '$nama_gambar')";
        mysqli_query($konek, $input);

        header("location:../../media.php?module=".$module);
      }
    }
  }

  // Update agenda
  elseif ($module=='agenda' AND $act=='update'){
    $lokasi_file = $_FILES['fupload']['tmp_name'];
    $tipe_file   = $_FILES['fupload']['type'];
    $nama_file   = $_FILES['fupload']['name'];
    $acak        = rand(1,99);
    $nama_gambar = $acak.$nama_file;

    $id          = $_POST['id'];
    $tema        = $_POST['tema'];
    $tema_seo    = seo_title($_POST['tema']);
    $isi_agenda  = $_POST['isi_agenda'];
    $tempat      = $_POST['tempat'];
    $tgl_mulai   = ubah_tgl($_POST['tgl_mulai']);
    $tgl_selesai = ubah_tgl($_POST['tgl_selesai']);
    $jam         = $_POST['jam'];
    $pengirim    = $_POST['pengirim'];


    // Apabila gambar tidak diganti
    if (empty($lokasi_file)){
      $update = "UPDATE agenda SET tema        = '$tema',
                                   tema_seo    = '$tema_seo',
                                   isi_agenda  = '$isi_agenda',
                                   tempat      = '$tempat',  
                                   tgl_mulai   = '$tgl_mulai',
                                   tgl_selesai = '$tgl_selesai',
                                   jam         = '$jam',  
                                   pengirim    = '$pengirim'  
                             WHERE id_agenda   = '$id'";
      mysqli_query($konek, $update);
      
      header("location:../../media.php?module=".$module);
    }
    else{
      if ($tipe_file != "image/jpeg" AND $tipe_file != "image/pjpeg"){
        echo "<script>window.alert('Upload Gagal! Pastikan file yang di upload bertipe *.JPG');
              window.location=('../../media.php?module=agenda')</script>";
      }
      else{
        $folder = "../../../foto_banner/"; // folder untuk gambar halaman statis
        $ukuran = 600;                    // gambar diperkecil jadi 600px (thumb)
        UploadFoto($nama_gambar, $folder, $ukuran);

        $update = "UPDATE agenda SET tema        = '$tema',
                                     tema_seo    = '$tema_seo',
                                     isi_agenda  = '$isi_agenda',
                                     tempat      = '$tempat',  
                                     tgl_mulai   = '$tgl_mulai',
                                     tgl_selesai = '$tgl_selesai',
                                     jam         = '$jam',  
                                     pengirim    = '$pengirim',
                                     gambar      = '$nama_gambar'  
                               WHERE id_agenda   = '$id'";
        mysqli_query($konek, $update);
      
        header("location:../../media.php?module=".$module);
      }
    }
  }
}
?>
