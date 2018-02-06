<?php
// Apabila user belum login
if (empty($_SESSION['namauser']) AND empty($_SESSION['passuser'])){
  echo "<link href=\"../../css/style_login.css\" rel=\"stylesheet\" type=\"text/css\" />
        <div id=\"login\"><h1 class=\"fail\">Untuk mengakses modul, Anda harus login dulu.</h1>
        <p class=\"fail\"><a href=\"../../index.php\">LOGIN</a></p></div>";  
}
// Apabila user sudah login dengan benar, maka terbentuklah session
else{
  $aksi = "modul/mod_hubungi/aksi_hubungi.php";

  // mengatasi variabel yang belum di definisikan (notice undefined index)
  $act = isset($_GET['act']) ? $_GET['act'] : ''; 

  switch($act){
    // Tampil Hubungi Kami
    default:
      echo "<h2>Hubungi Kami</h2>
          <p>Untuk menjawab/membalas email, klik pada alamat email yang ada di kolom Email.</p>
          <table>
          <thead>
          <tr><th>No</th><th>Nama Pengirim</th><th>Email</th><th>Subjek</th><th>Tanggal</th><th>Aksi</th></tr>
          </thead>
            <tbody>";

      $query  = "SELECT * FROM hubungi ORDER BY id_hubungi DESC";
      $tampil = mysqli_query($konek, $query);
 
      $no = 1;
      while ($r=mysqli_fetch_array($tampil)){  
        $tanggal=tgl_indo($r['tanggal']);
        echo "<tr><td>$no</td>
                  <td>$r[nama_pengirim]</td>
                  <td><a href=\"?module=hubungi&act=balasemail&id=$r[id_hubungi]\">$r[email]</a></td>
                  <td>$r[subjek]</td>
                  <td>$tanggal</a></td>
                  <td><a href=\"$aksi?module=hubungi&act=hapus&id=$r[id_hubungi]\">Hapus</a></td>
              </tr>";
        $no++;
      }
      echo "</tbody>
        </table><br>";
    break;

    case "balasemail":
      $query = "SELECT * FROM hubungi WHERE id_hubungi='$_GET[id]'";
      $hasil = mysqli_query($konek, $query);
      $r     = mysqli_fetch_array($hasil);
      
      echo "<h2>Balas Email</h2>
          <form method=\"POST\" action=\"?module=hubungi&act=kirimemail\">
          <table>
          <tr><td>Kepada</td><td> : <input type=\"text\" name=\"email\" value=\"$r[email]\"></td></tr>
          <tr><td>Subjek</td><td> : <input type=\"text\" name=\"subjek\" value=\"Re: $r[subjek]\"></td></tr>
          <tr><td>Pesan</td> <td>   <textarea name=\"pesan\" id=\"lokomedia\" style=\"width: 800px; height: 180px;\"><br><br>    
          -----------------------------------------------------------------------------------------------------------------------------------------------<br>
          $r[pesan]</textarea></td></tr>
          <tr><td colspan=\"2\"><input type=\"submit\" value=\"Kirim\">
                                <input type=\"button\" value=\"Batal\" onclick=\"self.history.back()\"></td></tr>
          </table>
          </form>";
    break;
    
    case "kirimemail":
      $query = "SELECT nama_pemilik,email FROM identitas LIMIT 1";
      $hasil = mysqli_query($konek, $query);
      $r     = mysqli_fetch_array($hasil);
      
      $kepada = $_POST['email']; 
      $subjek = $_POST['subjek'];
      $pesan  = $_POST['pesan'];
       
      $dari  = "from: $r[nama_pemilik] <$r[email]> \r\n";
      $dari .= "Content-type: text/html \r\n"; // isi email support html

      mail($email,$subjek,$pesan,$dari);
      
      echo "<h2>Status Email</h2>
            <p>Email telah terkirim.</p>";	 		  
    break;  
  }
}
?>
