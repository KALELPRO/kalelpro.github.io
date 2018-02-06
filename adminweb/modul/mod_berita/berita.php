
<?php    
// Apabila user belum login
if (empty($_SESSION['namauser']) AND empty($_SESSION['passuser'])){
  echo "<link href=\"../../css/style_login.css\" rel=\"stylesheet\" type=\"text/css\" />
        <div id=\"login\"><h1 class=\"fail\">Untuk mengakses modul, Anda harus login dulu.</h1>
        <p class=\"fail\"><a href=\"../../index.php\">LOGIN</a></p></div>";  
}
// Apabila user sudah login dengan benar, maka terbentuklah session
else{
  // fungsi untuk check box Tag (Berita Terkait) di form input dan edit berita 
  function GetCheckBox($table, $key, $Label, $Nilai='') {
    include "../config/koneksi.php";
    $s = "SELECT * FROM $table ORDER BY $Label";
    $u = mysqli_query($konek, $s);
    $_arrNilai = explode(',', $Nilai);
    $str = '';
    while ($t = mysqli_fetch_array($u)) {
      $_ck = (array_search($t[$key], $_arrNilai) === false)? '' : 'checked';
      $str .= "<input type=\"checkbox\" name='".$key."[]' value=\"$t[$key]\" $_ck>$t[$Label] ";
    }
    return $str;
  }

  $aksi = "modul/mod_berita/aksi_berita.php";

  // mengatasi variabel yang belum di definisikan (notice undefined index)
  $act = isset($_GET['act']) ? $_GET['act'] : ''; 

  switch($act){
    // Tampil Berita
    default:
      echo "<h2>Berita</h2>
          <p><input type=\"button\" value=\"Tambah Berita\" onclick=window.location.href=\"?module=berita&act=tambahberita\"></p>
          <table id=\"tabelku\">
          <thead>
          <tr><th>No</th><th>Judul</th><th>Tgl. Posting</th><th>Publish</th><th>Aksi</th></tr>
          </thead>
            <tbody>"; 
      
      if ($_SESSION['leveluser']=='admin'){
        $query  = "SELECT * FROM berita ORDER BY id_berita DESC";
        $tampil = mysqli_query($konek, $query);
      }
      else{
        $query  = "SELECT * FROM berita WHERE username='$_SESSION[namauser]' ORDER BY id_berita DESC";
        $tampil = mysqli_query($konek, $query);
      }
  
      $no = 1;
      while($r=mysqli_fetch_array($tampil)){
        $tgl_posting=tgl_indo($r['tanggal']);
        echo "<tr><td>$no</td>
                  <td width=\"350\">$r[judul]</td>
                  <td>$tgl_posting</td>
                  <td align=\"center\">$r[publish]</td>
		              <td><a href=\"?module=berita&act=editberita&id=$r[id_berita]\">Edit</a> | 
		                  <a href=\"$aksi?module=berita&act=hapus&id=$r[id_berita]\">Hapus</a></td>
		          </tr>";
        $no++;
      }
      echo "</tbody>
        </table>";
    break;    
  
    case "tambahberita":
      echo "<h2>Tambah Berita</h2>
          <form method=\"POST\" enctype=\"multipart/form-data\" action=\"$aksi?module=berita&act=input\">
          <table>
          <tr><td>Judul   </td><td> : <input type=\"text\" name=\"judul\"></td></tr>
          <tr><td>Kategori</td><td> : 
          <select name=\"kategori\">
            <option value=\"0\" selected>- Pilih Kategori -</option>";
            $query  = "SELECT * FROM kategori ORDER BY nama_kategori";
            $tampil = mysqli_query($konek, $query);
            while($r=mysqli_fetch_array($tampil)){
              echo "<option value=\"$r[id_kategori]\">$r[nama_kategori]</option>";
            }
      echo "</select></td></tr>
           <tr><td>Headline  </td><td> : <input type=\"radio\" name=\"headline\" value=\"Y\" checked> Y  
                                         <input type=\"radio\" name=\"headline\" value=\"N\"> N 
                                         <br> - Apabila berita akan dijadikan Headline, pilih <b>Y</b> (disarankan berita headline disertai gambar)</td></tr>
           <tr><td>Publish   </td><td> : <input type=\"radio\" name=\"publish\" value=\"Y\" checked> Y  
                                         <input type=\"radio\" name=\"publish\" value=\"N\"> N </td></tr>
           <tr><td>Isi Berita</td><td>   <textarea name=\"isi_berita\" id=\"lokomedia\" style=\"width: 800px; height: 250px;\"></textarea></td></tr>
           <tr><td>Gambar    </td><td> : <input type=\"file\" name=\"fupload\" size=\"50\"> 
                                         <br> - Tipe gambar harus JPG (disarankan lebar gambar 350 px).</td></tr>";

      $tag = mysqli_query($konek, "SELECT * FROM tag ORDER BY tag_seo");
      echo "<tr><td>Tag Berita</td><td> ";
      while ($t=mysqli_fetch_array($tag)){
        echo "<input type=\"checkbox\" value=\"$t[tag_seo]\" name=\"tag_seo[]\">$t[nama_tag] ";
      }
    
      echo "</td></tr>
            <tr><td colspan=\"2\"><input type=\"submit\" value=\"Simpan\">
                                  <input type=\"button\" value=\"Batal\" onclick=\"self.history.back()\"></td></tr>
            </table>
            </form><br>";
    break;
       
    case "editberita":
      if ($_SESSION['leveluser']=='admin'){
        $query = "SELECT * FROM berita WHERE id_berita='$_GET[id]'";
        $hasil = mysqli_query($konek, $query);
      }
      else{
        $query = "SELECT * FROM berita WHERE id_berita='$_GET[id]' AND username='$_SESSION[namauser]'";
        $hasil = mysqli_query($konek, $query);
      }

      $r = mysqli_fetch_array($hasil);

      echo "<h2>Edit Berita</h2>
          <form method=\"POST\" enctype=\"multipart/form-data\" action=\"$aksi?module=berita&act=update\">
          <input type=\"hidden\" name=\"id\" value=\"$r[id_berita]\">
          <table>
          <tr><td>Judul   </td><td> : <input type=\"text\" name=\"judul\" value=\"$r[judul]\"></td></tr>
          <tr><td>Kategori</td><td> : <select name=\"kategori\">";
           
          if ($r['id_kategori']==0){
            echo "<option value=\"0\" selected>- Pilih Kategori -</option>";
          }   

          $query2 = "SELECT * FROM kategori ORDER BY nama_kategori";
          $tampil = mysqli_query($konek, $query2);

          while($w=mysqli_fetch_array($tampil)){
            if ($r['id_kategori']==$w['id_kategori']){
              echo "<option value=\"$w[id_kategori]\" selected>$w[nama_kategori]</option>";
            }
            else{
              echo "<option value=\"$w[id_kategori]\">$w[nama_kategori]</option>";
            }
          }

      echo "</select></td></tr>";

      if ($r['headline']=='Y'){
        echo "<tr><td>Headline</td><td> : <input type=\"radio\" name=\"headline\" value=\"Y\" checked> Y  
                                          <input type=\"radio\" name=\"headline\" value=\"N\"> N </td></tr>";
      }
      else{
        echo "<tr><td>Headline</td><td> : <input type=\"radio\" name=\"headline\" value=\"Y\"> Y  
                                          <input type=\"radio\" name=\"headline\" value=\"N\" checked> N </td></tr>";
      }
      
      if ($r['publish']=='Y'){
        echo "<tr><td>Publish </td><td> : <input type=\"radio\" name=\"publish\" value=\"Y\" checked> Y  
                                          <input type=\"radio\" name=\"publish\" value=\"N\"> N </td></tr>";
      }
      else{
        echo "<tr><td>Publish </td><td> : <input type=\"radio\" name=\"publish\" value=\"Y\"> Y  
                                          <input type=\"radio\" name=\"publish\" value=\"N\" checked> N </td></tr>";
      }

      echo "<tr><td>Isi Berita</td><td> 
            <textarea id=\"lokomedia\" name=\"isi_berita\" style=\"width: 800px; height: 350px;\">$r[isi_berita]</textarea></td></tr>
            
            <tr><td>Gambar</td><td> ";
            if ($r['gambar']!=''){
              echo "<img src=\"../foto_berita/small_$r[gambar]\">";  
            }
            else{
              echo "Berita tidak ada gambarnya";
            }
      echo "</td></tr>
            <tr><td>Ganti Gambar</td><td> : <input type=\"file\" name=\"fupload\" size=\"50\"><br>
                    - Apabila gambar tidak diganti, dikosongkan saja.</td></tr>";
      
      // cocokkan tag di tabel berita dengan tag di tabel tag, kalau cocok berikan tanda cek              
      $d = GetCheckBox('tag', 'tag_seo', 'nama_tag', $r['tag']);

      echo "<tr><td>Tag Berita</td><td> $d </td></tr>
            <tr><td colspan=\"2\"><input type=\"submit\" value=\"Update\">
                                  <input type=\"button\" value=\"Batal\" onclick=\"self.history.back()\"></td></tr>
            </table>
            </form><br>";
    break;  
  }
}
?>
