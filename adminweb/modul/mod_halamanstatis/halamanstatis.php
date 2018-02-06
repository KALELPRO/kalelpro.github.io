<?php
// Apabila user belum login
if (empty($_SESSION['namauser']) AND empty($_SESSION['passuser'])){
  echo "<link href=\"../../css/style_login.css\" rel=\"stylesheet\" type=\"text/css\" />
        <div id=\"login\"><h1 class=\"fail\">Untuk mengakses modul, Anda harus login dulu.</h1>
        <p class=\"fail\"><a href=\"../../index.php\">LOGIN</a></p></div>";  
}
// Apabila user sudah login dengan benar, maka terbentuklah session
else{
  $aksi = "modul/mod_halamanstatis/aksi_halamanstatis.php";

  // mengatasi variabel yang belum di definisikan (notice undefined index)
  $act = isset($_GET['act']) ? $_GET['act'] : ''; 

  switch($act){
    // Tampil Halaman Statis
    default:
      echo "<h2>Halaman Statis</h2>
        <p><input type=\"button\" value=\"Tambah Halaman Statis\" onclick=window.location.href=\"?module=halamanstatis&act=tambahhalamanstatis\"></p>
        <table>
          <thead>
          <tr><th>No</th><th>Judul</th><th>Link</th><th>Tgl. Posting</th><th>Aksi</th></tr>
          </thead>
            <tbody>";
            
      $query  = "SELECT * FROM halamanstatis ORDER BY id_halaman DESC";
      $tampil = mysqli_query($konek, $query);
 
      $no = 1;
      while ($r=mysqli_fetch_array($tampil)){  
        $tanggal = tgl_indo($r['tanggal']);
        echo "<tr><td>$no</td>
                  <td>$r[judul]</td>
                  <td>statis-$r[id_halaman]/$r[judul_seo].html</td>
                  <td>$tanggal</td>
		              <td><a href=\"?module=halamanstatis&act=edithalamanstatis&id=$r[id_halaman]\">Edit</a> | 
		                  <a href=\"$aksi?module=halamanstatis&act=hapus&id=$r[id_halaman]\">Hapus</td>
		          </tr>";
        $no++;
      }
      echo "</tbody>
        </table>
        <p>*) Link akan terisi otomatis, nanti Link tersebut di-isikan pada saat membuat Menu Website untuk Halaman Statis.</p><br>";
    break;

    case "tambahhalamanstatis":
      echo "<h2>Tambah Halaman Statis</h2>
            <form method=\"POST\" enctype=\"multipart/form-data\" action=\"$aksi?module=halamanstatis&act=input\">
            <table>
            <tr><td>Judul</td>      <td> : <input type=\"text\" name=\"judul\"></td></tr>
            <tr><td>Isi Halaman</td><td>   <textarea name=\"isi_halaman\" id=\"lokomedia\" style=\"width: 800px; height: 350px;\"></textarea></td></tr>
            <tr><td>Gambar     </td><td> : <input type=\"file\" name=\"fupload\" size=\"50\"><br> 
                                           - Tipe gambar harus JPG (disarankan lebar gambar 600 pixel).</td></tr>
            <tr><td colspan=\"2\"><input type=\"submit\" value=\"Simpan\">
                                 <input type=\"button\" value=\"Batal\" onclick=\"self.history.back()\"></td></tr>
            </table>
            </form>";
     break;
    
    case "edithalamanstatis":
      $query = "SELECT * FROM halamanstatis WHERE id_halaman='$_GET[id]'";
      $hasil = mysqli_query($konek, $query);
      $r     = mysqli_fetch_array($hasil);

      echo "<h2>Edit Halaman Statis</h2>
            <form method=\"POST\" enctype=\"multipart/form-data\" action=\"$aksi?module=halamanstatis&act=update\">
            <input type=\"hidden\" name=\"id\" value=\"$r[id_halaman]\">
            <table>
            <tr><td>Judul      </td><td> : <input type=\"text\" name=\"judul\" value=\"$r[judul]\"></td></tr>
            <tr><td>Isi Halaman</td><td>   <textarea name=\"isi_halaman\" id=\"lokomedia\" style=\"width: 800px; height: 350px;\">$r[isi_halaman]</textarea>
            </td></tr>
            <tr><td>Gambar     </td><td> ";
            if ($r['gambar']!=''){
              echo "<img src=\"../foto_banner/$r[gambar]\">";  
            }
            else{
              echo "Tidak ada gambar";
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
