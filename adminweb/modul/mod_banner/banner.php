<?php
// Apabila user belum login
if (empty($_SESSION['namauser']) AND empty($_SESSION['passuser'])){
  echo "<link href=\"../../css/style_login.css\" rel=\"stylesheet\" type=\"text/css\" />
        <div id=\"login\"><h1 class=\"fail\">Untuk mengakses modul, Anda harus login dulu.</h1>
        <p class=\"fail\"><a href=\"../../index.php\">LOGIN</a></p></div>";  
}
// Apabila user sudah login dengan benar, maka terbentuklah session
else{
  $aksi = "modul/mod_banner/aksi_banner.php";

  // mengatasi variabel yang belum di definisikan (notice undefined index)
  $act = isset($_GET['act']) ? $_GET['act'] : ''; 

  switch($act){
    // Tampil Banner
    default:
      echo "<h2>Banner</h2>
          <p><input type=\"button\" value=\"Tambah Banner\" onclick=window.location.href=\"?module=banner&act=tambahbanner\"></p>
          <table>
          <thead>
          <tr>
          <tr><th>No</th><th>Gambar</th><th>Judul</th><th>Link</th><th>Aktif</th><th>Aksi</th></tr>
          </thead>
            <tbody>"; 
            
      $query  = "SELECT * FROM banner ORDER BY id_banner DESC";
      $tampil = mysqli_query($konek, $query);
 
      $no = 1;
      while ($r=mysqli_fetch_array($tampil)){
        echo "<tr><td>$no</td>
                  <td><img src=\"../foto_banner/small_$r[gambar]\"></td>
                  <td>$r[judul]</td>
                  <td><a href=\"$r[link]\" target=\"_blank\">$r[link]</a></td>
                  <td align=\"center\">$r[aktif]</td>
                  <td><a href=\"?module=banner&act=editbanner&id=$r[id_banner]\">Edit</a> | 
	                    <a href=\"$aksi?module=banner&act=hapus&id=$r[id_banner]\">Hapus</a>
		          </tr>";
        $no++;
      }
      echo "</tbody>
        </table><br>";
    break;
  
    case "tambahbanner":
      echo "<h2>Tambah Banner</h2>
          <form method=\"POST\" enctype=\"multipart/form-data\" action=\"$aksi?module=banner&act=input\">
          <table>
          <tr><td>Judul</td> <td> : <input type=\"text\" name=\"judul\"></td></tr>
          <tr><td>Link</td>  <td> : <input type=\"text\" name=\"link\" value=\"http://\"></td></tr>
          <tr><td>Gambar</td><td> : <input type=\"file\" name=\"fupload\" size=\"50\"></td></tr>
          <tr><td colspan=\"2\"><input type=\"submit\" value=\"Simpan\">
                                <input type=\"button\" value=\"Batal\" onclick=\"self.history.back()\"></td></tr>
          </table>
          </form>";
     break;
    
    case "editbanner":
      $query = "SELECT * FROM banner WHERE id_banner='$_GET[id]'";
      $hasil = mysqli_query($konek, $query);
      $r     = mysqli_fetch_array($hasil);

      echo "<h2>Edit Banner</h2>
          <form method=\"POST\" enctype=\"multipart/form-data\" action=\"$aksi?module=banner&act=update\">
          <input type=\"hidden\" name=\"id\" value=\"$r[id_banner]\">
          <table>
          <tr><td>Judul</td><td> : <input type=\"text\" name=\"judul\" value=\"$r[judul]\"></td></tr>
          <tr><td>Link</td> <td> : <input type=\"text\" name=\"link\" value=\"$r[link]\"></td></tr>";
          
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
            echo "<img src=\"../foto_banner/small_$r[gambar]\">";  
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
