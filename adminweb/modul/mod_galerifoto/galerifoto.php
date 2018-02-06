<?php
// Apabila user belum login
if (empty($_SESSION['namauser']) AND empty($_SESSION['passuser'])){
  echo "<link href=\"../../css/style_login.css\" rel=\"stylesheet\" type=\"text/css\" />
        <div id=\"login\"><h1 class=\"fail\">Untuk mengakses modul, Anda harus login dulu.</h1>
        <p class=\"fail\"><a href=\"../../index.php\">LOGIN</a></p></div>";  
}
// Apabila user sudah login dengan benar, maka terbentuklah session
else{
  $aksi = "modul/mod_galerifoto/aksi_galerifoto.php";

  // mengatasi variabel yang belum di definisikan (notice undefined index)
  $act = isset($_GET['act']) ? $_GET['act'] : ''; 

  switch($act){
    // Tampil Galeri Foto
    default:
      echo "<h2>Galeri Foto</h2>
          <p><input type=\"button\" value=\"Tambah Galeri Foto\" onclick=window.location.href=\"?module=galerifoto&act=tambahgalerifoto\"></p>
          <table>
          <thead>
          <tr>
          <tr><th>No</th><th>Foto</th><th>Judul Foto</th><th>Album</th><th>Aksi</th></tr>
          </thead>
            <tbody>"; 

      $query  = "SELECT * FROM galeri,album 
                WHERE galeri.id_album = album.id_album ORDER BY id_galeri DESC";
      $tampil = mysqli_query($konek, $query);
 
      $no = 1;
      while ($r=mysqli_fetch_array($tampil)){
        echo "<tr><td>$no</td>
				          <td><img src=\"../foto_galeri/small_$r[foto]\" width=\"100\" height=\"75\"></td>
                  <td>$r[judul_galeri]</td>
                  <td>$r[nama_album]</td>
		              <td><a href=\"?module=galerifoto&act=editgalerifoto&id=$r[id_galeri]\">Edit</a> | 
		                  <a href=\"$aksi?module=galerifoto&act=hapus&id=$r[id_galeri]\">Hapus</a></td>
		          </tr>";
        $no++;
      }
      echo "</tbody>
        </table><br>";
    break;
  
    case "tambahgalerifoto":
      echo "<h2>Tambah Galeri Foto</h2>
          <form method=\"POST\" enctype=\"multipart/form-data\" action=\"$aksi?module=galerifoto&act=input\">
          <table>
          <tr><td>Judul Foto</td><td> : <input type=\"text\" name=\"judul_galeri\"></td></tr>
          <tr><td>Album     </td><td> : 
          <select name=\"album\">
            <option value=\"0\" selected>- Pilih Album -</option>";
            $query  = "SELECT * FROM album ORDER BY nama_album";
            $tampil = mysqli_query($konek, $query);
            while($r=mysqli_fetch_array($tampil)){
              echo "<option value=\"$r[id_album]\">$r[nama_album]</option>";
            }
      echo "</select></td></tr>
          <tr><td>Keterangan</td><td> : <input type=\"text\" name=\"keterangan\"></td></tr>
          <tr><td>Foto      </td><td> : <input type=\"file\" name=\"fupload\" size=\"50\"><br> 
                                        - Tipe foto harus JPG/JPEG</td></tr>
          <tr><td colspan=\"2\"><input type=\"submit\" value=\"Simpan\">
                                <input type=\"button\" value=\"Batal\" onclick=\"self.history.back()\"></td></tr>
          </table>
          </form>";
     break;
    
    case "editgalerifoto":
      $query = "SELECT * FROM galeri WHERE id_galeri='$_GET[id]'";
      $hasil = mysqli_query($konek, $query);
      $r    = mysqli_fetch_array($hasil);

      echo "<h2>Edit Galeri Foto</h2>
          <form method=\"POST\" action=\"$aksi?module=galerifoto&act=update\" enctype=\"multipart/form-data\">
          <input type=\"hidden\" name=\"id\" value=\"$r[id_galeri]\">
          <table>
          <tr><td>Judul Foto</td><td> : <input type=\"text\" name=\"judul_galeri\" value=\"$r[judul_galeri]\"></td></tr>
          <tr><td>Album     </td><td> : <select name=\"album\">";
 
          if ($r['id_album']==0){
            echo "<option value=\"0\" selected>- Pilih Album -</option>";
          }   

          $query2 = "SELECT * FROM album ORDER BY nama_album";
          $tampil = mysqli_query($konek, $query2);

          while($w=mysqli_fetch_array($tampil)){
            if ($r['id_album']==$w['id_album']){
              echo "<option value=\"$w[id_album]\" selected>$w[nama_album]</option>";
            }
            else{
              echo "<option value=\"$w[id_album]\">$w[nama_album]</option>";
            }
          }
      echo "</select></td></tr>
          <tr><td>Keterangan</td><td> : <input type=\"text\" name=\"keterangan\" value=\"$r[keterangan]\"></td></tr>
          <tr><td>Foto</td><td> ";
          if ($r['foto']!=''){
            echo "<img src=\"../foto_galeri/small_$r[foto]\">";  
          }
          else{
            echo "Belum ada foto";
          }
      echo "</td></tr>
          <tr><td>Ganti Foto</td><td> : <input type=\"file\" name=\"fupload\" size=\"50\"><br>
                                        - Apabila foto tidak diganti, dikosongkan saja.</td></tr>
          <tr><td colspan=\"2\"><input type=\"submit\" value=\"Update\">
                                <input type=\"button\" value=\"Batal\" onclick=\"self.history.back()\"></td></tr>
          </table>
          </form>";
    break;  
  }
}
?>
