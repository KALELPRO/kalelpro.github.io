<?php 
  // Panggil atau sertakan (include) semua fungsi yang dibutuhkan
  include "config/koneksi.php";
	include "config/library.php";
	include "config/class_paging.php";

  // Mengambil data identitas website
  $query = "SELECT * FROM identitas"; 
  $hasil = mysqli_query($konek, $query);  
  $d     = mysqli_fetch_array($hasil);
  
  // Memilih template yang aktif saat ini
  $querytemplate = "SELECT folder FROM templates WHERE aktif='Y'"; 
  $pilihtemplate = mysqli_query($konek, $querytemplate);  
  $f              = mysqli_fetch_array($pilihtemplate);
  
  include "$f[folder]/template.php"; 
?>
