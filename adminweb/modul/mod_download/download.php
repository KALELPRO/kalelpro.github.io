<?php
// Apabila user belum login
if (empty($_SESSION['namauser']) AND empty($_SESSION['passuser'])){
  echo "<link href=\"../../css/style_login.css\" rel=\"stylesheet\" type=\"text/css\" />
        <div id=\"login\"><h1 class=\"fail\">Untuk mengakses modul, Anda harus login dulu.</h1>
        <p class=\"fail\"><a href=\"../../index.php\">LOGIN</a></p></div>";  
}
// Apabila user sudah login dengan benar, maka terbentuklah session
else{
  $aksi = "modul/mod_download/aksi_download.php";

  // mengatasi variabel yang belum di definisikan (notice undefined index)
  $act = isset($_GET['act']) ? $_GET['act'] : ''; 

  switch($act){
    // Tampil Download
    default:
      echo "<h2>Download</h2>
          <p><input type=\"button\" value=\"Tambah Download\" onclick=window.location.href=\"?module=download&act=tambahdownload\"></p>
          <table>
          <thead>
          <tr>
          <tr><th>No</th><th>Judul</th><th>Nama File</th><th>Tgl. Posting</th><th>Aksi</th></tr>
          </thead>
            <tbody>"; 

      $query  = "SELECT * FROM download ORDER BY id_download DESC";
      $tampil = mysqli_query($konek, $query);
 
      $no = 1;
      while ($r=mysqli_fetch_array($tampil)){
        $tgl_posting=tgl_indo($r['tanggal']);
        echo "<tr><td>$no</td>
                  <td width=\"300\">$r[judul]</td>
                  <td width=\"200\">$r[nama_file]</td>
                  <td>$tgl_posting</td>
                  <td><a href=\"?module=download&act=editdownload&id=$r[id_download]\">Edit</a> | 
	                    <a href=\"$aksi?module=download&act=hapus&id=$r[id_download]\">Hapus</a>
		          </tr>";
        $no++;
      }
      echo "</tbody>
        </table><br>";
    break;
  
    case "tambahdownload":
      echo "<h2>Tambah Download</h2>
          <form method=\"POST\" enctype=\"multipart/form-data\" action=\"$aksi?module=download&act=input\">
          <table>
          <tr><td>Judul</td><td> : <input type=\"text\" name=\"judul\"></td></tr>
          <tr><td>File</td> <td> : <input type=\"file\" name='fupload' size=\"50\"></td></tr>
          <tr><td colspan=\"2\"><input type=\"submit\" value=\"Simpan\">
                                <input type=\"button\" value=\"Batal\" onclick=\"self.history.back()\"></td></tr>
          </table>
          </form>";
     break;
    
    case "editdownload":
      $query = "SELECT * FROM download WHERE id_download='$_GET[id]'";
      $hasil = mysqli_query($konek, $query);
      $r     = mysqli_fetch_array($hasil);
      
      echo "<h2>Edit Download</h2>
          <form method=\"POST\" enctype=\"multipart/form-data\" action=\"$aksi?module=download&act=update\">
          <input type=\"hidden\" name=\"id\" value=\"$r[id_download]\">
          <table>
          <tr><td>Judul</td>     <td> : <input type=\"text\" name=\"judul\" value=\"$r[judul]\"></td></tr>
          <tr><td>Nama File</td> <td> : $r[nama_file]</td></tr>
          <tr><td>Ganti File</td><td> : <input type=\"file\" name=\"fupload\" size=\"50\"><br>
                                        - Apabila file tidak diganti, dikosongkan saja.</td></tr>
          <tr><td colspan=\"2\"><input type=\"submit\" value=\"Update\">
                                <input type=\"button\" value=\"Batal\" onclick=\"self.history.back()\"></td></tr>
          </table>
          </form>";
    break;  
  }
}
?>
