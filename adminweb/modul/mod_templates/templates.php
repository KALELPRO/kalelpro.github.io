<?php
// Apabila user belum login
if (empty($_SESSION['namauser']) AND empty($_SESSION['passuser'])){
  echo "<link href=\"../../css/style_login.css\" rel=\"stylesheet\" type=\"text/css\" />
        <div id=\"login\"><h1 class=\"fail\">Untuk mengakses modul, Anda harus login dulu.</h1>
        <p class=\"fail\"><a href=\"../../index.php\">LOGIN</a></p></div>";  
}
// Apabila user sudah login dengan benar, maka terbentuklah session
else{
  $aksi = "modul/mod_templates/aksi_templates.php";

  // mengatasi variabel yang belum di definisikan (notice undefined index)
  $act = isset($_GET['act']) ? $_GET['act'] : ''; 

  switch($act){
    // Tampil Templates
    default:
      echo "<h2>Templates</h2>
          <p><input type=\"button\" value=\"Tambah Templates\" onclick=window.location.href=\"?module=templates&act=tambahtemplates\"></p>
          <table>
          <thead>
          <tr><th>No</th><th>Nama Templates</th><th>Pembuat</th><th>Folder</th><th>Aktif</th><th>Aksi</th></tr>
          </thead>
            <tbody>";

      $query  = "SELECT * FROM templates ORDER BY id_templates DESC";
      $tampil = mysqli_query($konek, $query);
 
      $no = 1;
      while ($r=mysqli_fetch_array($tampil)){  
        echo "<tr><td>$no</td>
                  <td>$r[nama_templates]</td>
                  <td>$r[pembuat]</td>
                  <td>$r[folder]</td>
                  <td align=\"center\">$r[aktif]</td>
                  <td><a href=\"?module=templates&act=edittemplates&id=$r[id_templates]\">Edit</a> | 
                      <a href=\"$aksi?module=templates&act=hapus&id=$r[id_templates]\">Hapus</a> | 
	                    <a href=\"$aksi?module=templates&act=aktifkan&id=$r[id_templates]\">Aktifkan</a></td>
		          </tr>";
        $no++;
      }
      echo "</tbody>
        </table><br>";
    break;  
  
    // Form Tambah Templates
    case "tambahtemplates":
      echo "<h2>Tambah Templates</h2>
          <form method=\"POST\" action=\"$aksi?module=templates&act=input\">
          <table>
          <tr><td>Nama Templates</td><td> : <input type=\"text\" name=\"nama_templates\"></td></tr>
          <tr><td>Pembuat       </td><td> : <input type=\"text\" name=\"pembuat\"></td></tr>
          <tr><td>Folder        </td><td> : <input type=\"text\" name=\"folder\"></td></tr>
          <tr><td colspan=\"2\"><input type=\"submit\" value=\"Simpan\">
                                <input type=\"button\" value=\"Batal\" onclick=\"self.history.back()\"></td></tr>
          </table>
          </form>";
     break;
  
    // Form Edit Templates 
    case "edittemplates":
      $query = "SELECT * FROM templates WHERE id_templates='$_GET[id]'";
      $hasil = mysqli_query($konek, $query);
      $r     = mysqli_fetch_array($hasil);

      echo "<h2>Edit Templates</h2>
          <form method=\"POST\" action=\"$aksi?module=templates&act=update\">
          <input type=\"hidden\" name=\"id\" value=\"$r[id_templates]\">
          <table>
          <tr><td>Nama Templates</td><td> : <input type=\"text\" name=\"nama_templates\" value=\"$r[nama_templates]\"></td></tr>
          <tr><td>Pembuat       </td><td> : <input type=\"text\" name=\"pembuat\" value=\"$r[pembuat]\"></td></tr>
          <tr><td>Folder        </td><td> : <input type=\"text\" name=\"folder\" value=\"$r[folder]\"></td></tr>
          <tr><td colspan=\"2\"><input type=\"submit\" value=\"Update\">
                                <input type=\"button\" value=\"Batal\" onclick=\"self.history.back()\"></td></tr>
          </table>
          </form>";
    break;  
  }
}
?>
