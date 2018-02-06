<?php
include "../config/koneksi.php";

if ($_SESSION['leveluser']=='admin'){
  $query = "SELECT * FROM modul WHERE aktif='Y' ORDER BY urutan";
  $hasil = mysqli_query($konek, $query);
  while ($m=mysqli_fetch_array($hasil)){  
    echo "<li><a href=\"$m[link]\">&#187; $m[nama_modul]</a></li>";
  }
}
elseif ($_SESSION['leveluser']=='user'){
  $query = "SELECT * FROM modul WHERE status='user' and aktif='Y' ORDER BY urutan";
  $hasil = mysqli_query($konek, $query);
  while ($m=mysqli_fetch_array($hasil)){  
    echo "<li><a href=\"$m[link]\">&#187; $m[nama_modul]</a></li>";
  }
} 
?>
