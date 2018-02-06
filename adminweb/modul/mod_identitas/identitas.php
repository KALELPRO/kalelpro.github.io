<?php
// Apabila user belum login
if (empty($_SESSION['namauser']) AND empty($_SESSION['passuser'])){
  echo "<link href=\"../../css/style_login.css\" rel=\"stylesheet\" type=\"text/css\" />
        <div id=\"login\"><h1 class=\"fail\">Untuk mengakses modul, Anda harus login dulu.</h1>
        <p class=\"fail\"><a href=\"../../index.php\">LOGIN</a></p></div>";  
}
// Apabila user sudah login dengan benar, maka terbentuklah session
else{
  $aksi = "modul/mod_identitas/aksi_identitas.php";

  // mengatasi variabel yang belum di definisikan (notice undefined index)
  $act = isset($_GET['act']) ? $_GET['act'] : ''; 

  switch($act){
    // Tampil identitas
    default:
      $query = "SELECT * FROM identitas LIMIT 1";
      $hasil = mysqli_query($konek, $query);
      $r     = mysqli_fetch_array($hasil);
      
      $twitter_widget = htmlspecialchars($r['twitter_widget']);
      $googlemap      = htmlspecialchars($r['googlemap']);
                                                                     
      echo "<h2>Identitas Web</h2>
          <table>
          <tr><td width=\"120\"><b>Nama Pemilik</b></td><td> : $r[nama_pemilik]</td></tr>
          <tr><td><b>Judul Website</b></td>    <td> : $r[judul_website]</td></tr>
          <tr><td><b>Alamat Website</b></td>   <td> : $r[alamat_website]</td></tr>
          <tr><td><b>Meta Deskripsi</b></td>   <td> : $r[meta_deskripsi]</td></tr>
          <tr><td><b>Meta Keyword</b></td>     <td> : $r[meta_keyword]</td></tr>
          <tr><td><b>Email</b></td>            <td> : $r[email]</td></tr>
          <tr><td><b>Facebook Fan Page</b></td><td> : $r[facebook]</td></tr>
          <tr><td><b>Twitter</b></td>          <td> : $r[twitter]</td></tr>
          <tr><td><b>Twitter Widget</b></td>   <td> $twitter_widget</td></tr>
          <tr><td><b>Google Plus</b></td>      <td> : $r[googleplus]</td></tr>
          <tr><td><b>Google Map</b>       </td><td> : kontennya tidak ditampilkan karena kodenya agak panjang, tapi kodenya bisa dilihat saat Edit Identitas.</td></tr>
          <tr><td><b>Gambar Favicon</b></td>   <td> <img src=\"../$r[favicon]\"></td></tr>
          </table>
          <p><input type=\"button\" value=\"Edit Identitas\" onclick=location.href=\"?module=identitas&act=editidentitas&id=$r[id_identitas]\"></p>";
    break;
  
    case "editidentitas":
      $query = "SELECT * FROM identitas WHERE id_identitas='$_GET[id]'";
      $hasil = mysqli_query($konek, $query);
      $r     = mysqli_fetch_array($hasil);

      echo "<h2>Edit Identitas Web</h2>
          <form method=\"POST\" enctype=\"multipart/form-data\" action=\"$aksi?module=identitas\">
          <input type=\"hidden\" name=\"id\" value=\"$r[id_identitas]\">
          <table>
          <tr><td>Nama Pemilik</td>     <td> : <input type=\"text\" name=\"nama_pemilik\" value=\"$r[nama_pemilik]\"></td></tr>
          <tr><td>Judul Website</td>    <td> : <input type=\"text\" name=\"judul_website\" value=\"$r[judul_website]\"></td></tr>
          <tr><td>Alamat Website</td>   <td> : <input type=\"text\" name=\"alamat_website\" value=\"$r[alamat_website]\"><br>
                                               - Apabila website sudah di online-kan, ganti dengan nama domain website Anda<br>
                                               - Contoh: http://bukulokomedia.com</td></tr>
          <tr><td>Meta Deskripsi</td>   <td> : <input type=\"text\" name=\"meta_deskripsi\" value=\"$r[meta_deskripsi]\"></td></tr>
          <tr><td>Meta Keyword</td>     <td> : <input type=\"text\" name=\"meta_keyword\" value=\"$r[meta_keyword]\"></td></tr>
          <tr><td>Email</td>            <td> : <input type=\"text\" name=\"email\" value=\"$r[email]\"></td></tr>
          <tr><td>Facebook Fan Page</td><td> : <input type=\"text\" name=\"facebook\" value=\"$r[facebook]\"></td></tr>
          <tr><td>Twitter</td>          <td> : <input type=\"text\" name=\"twitter\" value=\"$r[twitter]\"></td></tr>
          <tr><td>Twitter Widget</td>   <td>   <textarea name=\"twitter_widget\" cols=\"90\" rows=\"5\">$r[twitter_widget]</textarea></td></tr>
          <tr><td>Google Plus</td>      <td> : <input type=\"text\" name=\"googleplus\" value=\"$r[googleplus]\"></td></tr>
          <tr><td>Google MAP</td>       <td>   <textarea name=\"googlemap\" cols=\"90\" rows=\"5\">$r[googlemap]</textarea></td></tr>
          <tr><td>Gambar Favicon</td>   <td>   <img src=\"../$r[favicon]\"></td></tr>
          <tr><td>Ganti Favicon</td>    <td> : <input type=\"file\" name=\"fupload\" size=\"50\"> *)</td></tr>
          <tr><td colspan=\"2\">*) Apabila gambar favicon tidak diganti, dikosongkan saja.<br>
                                *) Apabila gambar favicon diganti, nama filenya harus <b>favicon.png</b> dengan ukuran <b>50 x 50 pixel</b>.</td></tr>
          <tr><td colspan=\"2\"><input type=\"submit\" value=\"Update\">
                                <input type=\"button\" value=\"Batal\" onclick=\"self.history.back()\"></td></tr>
          </table><br>";
    break;        
  }
}
?>
