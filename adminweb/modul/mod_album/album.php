<?php
// Apabila user belum login
if (empty($_SESSION['namauser']) AND empty($_SESSION['passuser'])){
  echo "<link href=\"../../css/style_login.css\" rel=\"stylesheet\" type=\"text/css\" />
        <div id=\"login\"><h1 class=\"fail\">Untuk mengakses modul, Anda harus login dulu.</h1>
        <p class=\"fail\"><a href=\"../../index.php\">LOGIN</a></p></div>";  
}
// Apabila user sudah login dengan benar, maka terbentuklah session
else{
  $aksi = "modul/mod_album/aksi_album.php";

  // mengatasi variabel yang belum di definisikan (notice undefined index)
  $act = isset($_GET['act']) ? $_GET['act'] : ''; 

  switch($act){
    // Tampil Album
    default:
      echo "<h2>Album</h2>
          <p><input type=\"button\" value=\"Tambah Album\" onclick=window.location.href=\"?module=album&act=tambahalbum\"></p>
          <table>
          <thead>
          <tr>
          <tr><th>No</th><th>Gambar</th><th>Nama Album</th><th>Aktif</th><th>Aksi</th></tr>
          </thead>
            <tbody>"; 
            
      $query  = "SELECT * FROM album ORDER BY id_album DESC";
      $tampil = mysqli_query($konek, $query);
 
      $no = 1;
      while ($r=mysqli_fetch_array($tampil)){
        echo "<tr><td>$no</td>             
                  <td><img src=\"../foto_album/small_$r[gambar]\" width=\"100\" height=\"75\"></td>
                  <td>$r[nama_album]</td>
                  <td align=\"center\">$r[aktif]</td>
                  <td><a href=\"?module=album&act=editalbum&id=$r[id_album]\">Edit</a></td>
              </tr>";
        $no++;
      }
      echo "</tbody>
        </table>
        <p>*) Data pada Album tidak bisa dihapus, tapi bisa di non-aktifkan melalui Edit Album.</p><br>";
    break;
  
    // Form Tambah Album
    case "tambahalbum":
      echo "<h2>Tambah Album</h2>
          <form method=\"POST\" enctype=\"multipart/form-data\" action=\"$aksi?module=album&act=input\">
          <table>
          <tr><td>Nama Album</td><td> : <input type=\"text\" name=\"nama_album\"></td></tr>
          <tr><td>Gambar    </td><td> : <input type=\"file\" name=\"fupload\" size=\"50\"></td></tr>
          <tr><td colspan=\"2\"><input type=\"submit\" value=\"Simpan\">
                                <input type=\"button\" value=\"Batal\" onclick=\"self.history.back()\"></td></tr>
          </table>
          </form>";
    break;
  
    // Form Edit Album  
    case "editalbum":
      $query = "SELECT * FROM album WHERE id_album='$_GET[id]'";
      $hasil = mysqli_query($konek, $query);
      $r     = mysqli_fetch_array($hasil);

      echo "<h2>Edit Album</h2>
          <form method=\"POST\" enctype=\"multipart/form-data\" action=\"$aksi?module=album&act=update\">
          <input type=\"hidden\" name=\"id\" value=\"$r[id_album]\">
          <table>
          <tr><td>Nama Album</td><td> : <input type=\"text\" name=\"nama_album\" value=\"$r[nama_album]\"></td></tr>";
          
      if ($r['aktif']=='Y'){
        echo "<tr><td>Aktif</td><td> : <input type=\"radio\" name=\"aktif\" value=\"Y\" checked> Y  
                                       <input type=\"radio\" name=\"aktif\" value=\"N\"> N </td></tr>";
      }
      else{
        echo "<tr><td>Aktif</td><td> : <input type=\"radio\" name=\"aktif\" value=\"Y\"> Y  
                                       <input type=\"radio\" name=\"aktif\" value=\"N\" checked> N </td></tr>";
      }         

      echo "<tr><td>Gambar</td><td> ";
          if ($r['gambar']!=''){
            echo "<img src=\"../foto_album/small_$r[gambar]\">";  
          }
          else{
            echo "Belum ada gambar";
          }
      echo "</td></tr>
            <tr><td>Ganti Gambar</td><td> : <input type=\"file\" name=\"fupload\" size=\"50\"><br>
                                            - Apabila gambar tidak diganti, dikosongkan saja.</td></tr>
            <tr><td colspan=\"2\"><input type=\"submit\" value=\"Update\">
                                  <input type=\"button\" value=\"Batal\" onclick=\"self.history.back()\"></td></tr>
            </table>
            </form>";
    break;  
  }
}
?>
