<?php
// Apabila user belum login
if (empty($_SESSION['namauser']) AND empty($_SESSION['passuser'])){
  echo "<link href=\"../../css/style_login.css\" rel=\"stylesheet\" type=\"text/css\" />
        <div id=\"login\"><h1 class=\"fail\">Untuk mengakses modul, Anda harus login dulu.</h1>
        <p class=\"fail\"><a href=\"../../index.php\">LOGIN</a></p></div>";  
}
// Apabila user sudah login dengan benar, maka terbentuklah session
else{
  $aksi = "modul/mod_kategori/aksi_kategori.php";

  // mengatasi variabel yang belum di definisikan (notice undefined index)
  $act = isset($_GET['act']) ? $_GET['act'] : ''; 

  switch($act){
    // Tampil Kategori
    default:
      echo "<h2>Kategori</h2>
          <p><input type=\"button\" value=\"Tambah Kategori\" onclick=window.location.href=\"?module=kategori&act=tambahkategori\"></p>
          <table>
          <thead>
          <tr><th>No</th><th>Nama Kategori</th><th>Aktif</th><th>Aksi</th></tr>
          </thead>
            <tbody>";
            
      $query  = "SELECT * FROM kategori ORDER BY id_kategori DESC";
      $tampil = mysqli_query($konek, $query);
 
      $no = 1;
      while ($r=mysqli_fetch_array($tampil)){
        echo "<tr><td>$no</td>
                  <td>$r[nama_kategori]</td>
                  <td align=\"center\">$r[aktif]</td>
                  <td><a href=\"?module=kategori&act=editkategori&id=$r[id_kategori]\">Edit</a></td>
              </tr>";
        $no++;
      }
      echo "</tbody>
        </table>
        <p>*) Data pada Kategori tidak bisa dihapus, tapi bisa di non-aktifkan melalui Edit Kategori.</p><br>";
    break;
  
    // Form Tambah Kategori
    case "tambahkategori":
      echo "<h2>Tambah Kategori</h2>
          <form method=\"POST\" action=\"$aksi?module=kategori&act=input\">
          <table>
          <tr><td>Nama Kategori</td><td> : <input type=\"text\" name=\"nama_kategori\"></td></tr>
          <tr><td colspan=\"2\"><input type=\"submit\" value=\"Simpan\">
                                <input type=\"button\" value=\"Batal\" onclick=\"self.history.back()\"></td></tr>
          </table>
          </form>";
    break;
  
    // Form Edit Kategori  
    case "editkategori":
      $query = "SELECT * FROM kategori WHERE id_kategori='$_GET[id]'";
      $hasil = mysqli_query($konek, $query);
      $r     = mysqli_fetch_array($hasil);

      echo "<h2>Edit Kategori</h2>
          <form method=\"POST\" action=\"$aksi?module=kategori&act=update\">
          <input type=\"hidden\" name=\"id\" value=\"$r[id_kategori]\">
          <table>
          <tr><td>Nama Kategori</td><td> : <input type=\"text\" name=\"nama_kategori\" value=\"$r[nama_kategori]\"></td></tr>";
          
          if ($r['aktif']=='Y'){
            echo "<tr><td>Aktif</td><td> : <input type=\"radio\" name=\"aktif\" value=\"Y\" checked> Y  
                                           <input type=\"radio\" name=\"aktif\" value=\"N\"> N </td></tr>";
          }
          else{
            echo "<tr><td>Aktif</td><td> : <input type=\"radio\" name=\"aktif\" value=\"Y\"> Y  
                                           <input type=\"radio\" name=\"aktif\" value=\"N\" checked> N </td></tr>";
          }

      echo "<tr><td colspan=\"2\"><input type=\"submit\" value=\"Update\">
                                <input type=\"button\" value=\"Batal\" onclick=\"self.history.back()\"></td></tr>
          </table>
          </form>";
    break;  
  }
}
?>
