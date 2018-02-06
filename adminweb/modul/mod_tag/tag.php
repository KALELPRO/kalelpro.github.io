<?php
// Apabila user belum login
if (empty($_SESSION['namauser']) AND empty($_SESSION['passuser'])){
  echo "<link href=\"../../css/style_login.css\" rel=\"stylesheet\" type=\"text/css\" />
        <div id=\"login\"><h1 class=\"fail\">Untuk mengakses modul, Anda harus login dulu.</h1>
        <p class=\"fail\"><a href=\"../../index.php\">LOGIN</a></p></div>";  
}
// Apabila user sudah login dengan benar, maka terbentuklah session
else{
  $aksi = "modul/mod_tag/aksi_tag.php";

  // mengatasi variabel yang belum di definisikan (notice undefined index)
  $act = isset($_GET['act']) ? $_GET['act'] : ''; 

  switch($act){
    // Tampil Tag
    default:
      echo "<h2>Tag Berita</h2>
          <p><input type=\"button\" value=\"Tambah Tag\" onclick=window.location.href=\"?module=tag&act=tambahtag\"></p>
          <table>
          <thead>
          <tr><th>No</th><th>Nama Tag</th><th>Topik Pilihan</th><th>Aksi</th></tr>
          </thead>
            <tbody>";
            
      $query  = "SELECT * FROM tag ORDER BY id_tag DESC";
      $tampil = mysqli_query($konek, $query);
 
      $no = 1;
      while ($r=mysqli_fetch_array($tampil)){
        echo "<tr><td>$no</td>
                  <td>$r[nama_tag]</td>
                  <td align=\"center\">$r[pilihan]</td>
                  <td><a href=\"?module=tag&act=edittag&id=$r[id_tag]\">Edit</a> | 
	                    <a href=\"$aksi?module=tag&act=hapus&id=$r[id_tag]\">Hapus</a></td>
             </tr>";
        $no++;
      }
    echo "</tbody>
      </table>
        <p>*) Apabila Tag dijadikan Berita Pilihan (hot news), ubah Pilihan menjadi Y.</p><br>";
    break;
  
    // Form Tambah Tag
    case "tambahtag":
      echo "<h2>Tambah Tag Berita</h2>
          <form method=\"POST\" action=\"$aksi?module=tag&act=input\">
          <table>
          <tr><td>Nama Tag</td><td> : <input type=\"text\" name=\"nama_tag\"></td></tr>
          <tr><td colspan=\"2\"><input type=\"submit\" value=\"Simpan\">
                                <input type=\"button\" value=\"Batal\" onclick=\"self.history.back()\"></td></tr>                                
          </table>
          </form>";
     break;
  
    // Form Edit Tag  
    case "edittag":
      $query = "SELECT * FROM tag WHERE id_tag='$_GET[id]'";
      $hasil = mysqli_query($konek, $query);
      $r     = mysqli_fetch_array($hasil);

      echo "<h2>Edit Tag Berita</h2>
          <form method=\"POST\" action=\"$aksi?module=tag&act=update\">
          <input type=\"hidden\" name=\"id\" value=\"$r[id_tag]\">
          <table>
          <tr><td>Nama Tag</td><td> : <input type=\"text\" name=\"nama_tag\" value=\"$r[nama_tag]\"></td></tr>";
          
          if ($r['pilihan']=='Y'){
            echo "<tr><td>Topik Pilihan</td><td> : <input type=\"radio\" name=\"pilihan\" value=\"Y\" checked> Y  
                                                   <input type=\"radio\" name=\"pilihan\" value=\"N\"> N </td></tr>";
          }
          else{
            echo "<tr><td>Topik Pilihan</td><td> : <input type=\"radio\" name=\"pilihan\" value=\"Y\"> Y  
                                                   <input type=\"radio\" name=\"pilihan\" value=\"N\" checked> N </td></tr>";
          }

      echo "<tr><td colspan=\"2\"><input type=\"submit\" value=\"Update\">
                                  <input type=\"button\" value=\"Batal\" onclick=\"self.history.back()\"></td></tr>
          </table>
          </form>";
    break;  
  }
}
?>
