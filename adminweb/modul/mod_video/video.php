<?php
// Apabila user belum login
if (empty($_SESSION['namauser']) AND empty($_SESSION['passuser'])){
  echo "<link href=\"../../css/style_login.css\" rel=\"stylesheet\" type=\"text/css\" />
        <div id=\"login\"><h1 class=\"fail\">Untuk mengakses modul, Anda harus login dulu.</h1>
        <p class=\"fail\"><a href=\"../../index.php\">LOGIN</a></p></div>";  
}
// Apabila user sudah login dengan benar, maka terbentuklah session
else{
  $aksi = "modul/mod_video/aksi_video.php";

  // mengatasi variabel yang belum di definisikan (notice undefined index)
  $act = isset($_GET['act']) ? $_GET['act'] : ''; 

  switch($act){
    // Tampil Video
    default:
      echo "<h2>Video</h2>
            <p><input type=\"button\" value=\"Tambah Video\" onclick=window.location.href=\"?module=video&act=tambahvideo\"></p>
        
        <table>
          <thead>
          <tr><th>No</th><th>Judul Video</th><th>Link Youtube</th><th>Aksi</th></tr>
          </thead>
            <tbody>"; 
            
      $query  = "SELECT * FROM video ORDER BY id_video DESC";
      $tampil = mysqli_query($konek, $query);
                  
      $no = 1;
      while ($r=mysqli_fetch_array($tampil)){
        echo "<tr>
             <td>$no</td>         
             <td align=\"center\"><img src=\"../foto_video/small_$r[gambar]\" width=\"100\" height=\"75\"><br>$r[judul_video]</td>
             <td>http://www.youtube.com/watch?v=$r[link_youtube]</td>
             <td><a href=\"?module=video&act=editvideo&id=$r[id_video]\">Edit</a> | 
                 <a href=\"$aksi?module=video&act=hapus&id=$r[id_video]\">Hapus</a></td>
             </tr>";
        $no++;
      }
      echo "</tbody>
        </table><br>";
    break;
  
    case "tambahvideo":
      echo "<h2>Tambah Video</h2>
          <form method=\"POST\" enctype=\"multipart/form-data\" action=\"$aksi?module=video&act=input\">
          <table>
          <tr><td>Judul Video </td><td> : <input type=\"text\" name=\"judul_video\"></td></tr>
          <tr><td>Link Youtube</td><td> : <input type=\"text\" name=\"link_youtube\"><br>
                                          - Contoh: http://www.youtube.com/watch?v=B7pVjF8fLvA</td></tr>
          <tr><td>Deskripsi   </td><td>   <textarea name=\"deskripsi\" id=\"lokomedia\" name=\"deskripsi\" style=\"width: 800px; height: 350px;\">
                                          </textarea></td></tr>  
          <tr><td>Gambar    </td><td> : <input type=\"file\" name=\"fupload\" size=\"50\"></td></tr>
          <tr><td colspan=\"2\"><input type=\"submit\" value=\"Simpan\">
                                <input type=\"button\" value=\"Batal\" onclick=\"self.history.back()\"></td></tr>
          </table>
          </form>";
    break;
    
    case "editvideo":
      $query = "SELECT * FROM video WHERE id_video='$_GET[id]'";
      $hasil = mysqli_query($konek, $query);
      $r     = mysqli_fetch_array($hasil);

      echo "<h2>Edit Video</h2>
          <form method=\"POST\" enctype=\"multipart/form-data\" action=\"$aksi?module=video&act=update\">
          <input type=\"hidden\" name=\"id\" value=\"$r[id_video]\">
          <table>
          <tr><td>Judul Video </td><td> : <input type=\"text\" name=\"judul_video\" value=\"$r[judul_video]\"></td></tr>
          <tr><td>Link Youtube</td><td> : <input type=\"text\" name=\"link_youtube\" value=\"http://www.youtube.com/watch?v=$r[link_youtube]\"></td></tr>
          <tr><td>Deskripsi   </td><td>   <textarea name=\"deskripsi\" id=\"lokomedia\" name=\"deskripsi\" style=\"width: 800px; height: 350px;\">$r[deskripsi]
                                          </textarea></td></tr>";
      echo "<tr><td>Gambar</td><td> ";
          if ($r['gambar']!=''){
            echo "<img src=\"../foto_video/small_$r[gambar]\">";  
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
