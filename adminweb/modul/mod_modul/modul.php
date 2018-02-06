<?php
// Apabila user belum login
if (empty($_SESSION['namauser']) AND empty($_SESSION['passuser'])){
  echo "<link href=\"../../css/style_login.css\" rel=\"stylesheet\" type=\"text/css\" />
        <div id=\"login\"><h1 class=\"fail\">Untuk mengakses modul, Anda harus login dulu.</h1>
        <p class=\"fail\"><a href=\"../../index.php\">LOGIN</a></p></div>";  
}
// Apabila user sudah login dengan benar, maka terbentuklah session
else{
  $aksi = "modul/mod_modul/aksi_modul.php";

  // mengatasi variabel yang belum di definisikan (notice undefined index)
  $act = isset($_GET['act']) ? $_GET['act'] : ''; 

  switch($act){
    // Tampil Modul
    default:
      echo "<h2>Manajemen Modul</h2>
          <p><input type=\"button\" value=\"Tambah Modul\" onclick=window.location.href=\"?module=modul&act=tambahmodul\"></p>
          <table>
          <thead>
          <tr><th>Urutan Modul</th><th>Nama Modul</th><th>Link</th><th>Status</th><th>Aktif</th><th>Aksi</th></tr>
          </thead>
            <tbody>";
            
      $query  = "SELECT * FROM modul ORDER BY urutan";
      $tampil = mysqli_query($konek, $query);
 
      while ($r=mysqli_fetch_array($tampil)){  
        echo "<tr><td align=\"center\">$r[urutan]</td>
                  <td>$r[nama_modul]</td>
                  <td>$r[link]</td>
                  <td>$r[status]</td>
                  <td align=\"center\">$r[aktif]</td>
                  <td><a href=\"?module=modul&act=editmodul&id=$r[id_modul]\">Edit</a></td>
              </tr>";
      }
      echo "</tbody>
        </table>
        <p>Data pada Modul tidak bisa dihapus, tapi bisa di non-aktifkan melalui Edit Modul.</p>";
    break;

    case "tambahmodul":
      echo "<h2>Tambah Modul</h2>
          <form method=\"POST\" action=\"$aksi?module=modul&act=input\">
          <table>
          <tr><td>Nama Modul</td><td> : <input type=\"text\" name=\"nama_modul\"></td></tr>
          <tr><td>Link      </td><td> : <input type=\"text\" name=\"link\"></td></tr>
          <tr><td colspan=\"2\"><input type=\"submit\" value=\"Simpan\">
                                <input type=\"button\" value=\"Batal\" onclick=\"self.history.back()\"></td></tr>
          </table>
          </form>";
    break;
 
    case "editmodul":
      $query = "SELECT * FROM modul WHERE id_modul='$_GET[id]'";
      $hasil = mysqli_query($konek, $query);
      $r     = mysqli_fetch_array($hasil);

      echo "<h2>Edit Modul</h2>
          <form method=\"POST\" action=\"$aksi?module=modul&act=update\">
          <input type=\"hidden\" name=\"id\" value=\"$r[id_modul]\">
          <table>
          <tr><td>Urutan Menu</td><td> : <input type=\"text\" name=\"urutan\" value=\"$r[urutan]\"></td></tr>
          <tr><td>Nama Modul </td><td> : <input type=\"text\" name=\"nama_modul\" value=\"$r[nama_modul]\"></td></tr>
          <tr><td>Link       </td><td> : <input type=\"text\" name=\"link\" value=\"$r[link]\"></td></tr>";
          
      if ($r['status']=='admin'){
        echo "<tr><td>Status</td><td> : <input type=\"radio\" name=\"status\" value=\"admin\" checked> admin   
                                        <input type=\"radio\" name=\"status\" value=\"user\"> user </td></tr>";
      }
      else{
        echo "<tr><td>Status</td><td> : <input type=\"radio\" name=\"status\" value=\"admin\"> admin   
                                        <input type=\"radio\" name=\"status\" value=\"user\" checked> user </td></tr>";
      }
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
