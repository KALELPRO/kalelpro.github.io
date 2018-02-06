<?php
// Apabila user belum login
if (empty($_SESSION['namauser']) AND empty($_SESSION['passuser'])){
  echo "<link href=\"../../css/style_login.css\" rel=\"stylesheet\" type=\"text/css\" />
        <div id=\"login\"><h1 class=\"fail\">Untuk mengakses modul, Anda harus login dulu.</h1>
        <p class=\"fail\"><a href=\"../../index.php\">LOGIN</a></p></div>";  
}
// Apabila user sudah login dengan benar, maka terbentuklah session
else{
  $aksi = "modul/mod_polling/aksi_polling.php";

  // mengatasi variabel yang belum di definisikan (notice undefined index)
  $act = isset($_GET['act']) ? $_GET['act'] : ''; 

  switch($act){
    // Tampil Polling
    default:
      echo "<h2>Polling</h2>
          <p><input type=\"button\" value=\"Tambah Polling\" onclick=window.location.href=\"?module=polling&act=tambahpolling\"></p>
          <table>
          <thead>
          <tr><th>No</th><th>Pilihan</th><th>Status</th><th>Aktif</th><th>Rating</th><th>Aksi</th></tr>
          </thead>
            <tbody>";
            
      $query  = "SELECT * FROM polling ORDER BY id_polling DESC";
      $tampil = mysqli_query($konek, $query);
 
      $no = 1;
      while ($r=mysqli_fetch_array($tampil)){  
        echo "<tr><td>$no</td>
                  <td>$r[pilihan]</td>
                  <td>$r[status]</td>
                  <td align=\"center\">$r[aktif]</td>
                  <td align=\"center\">$r[rating]</td>
                  <td><a href=\"?module=polling&act=editpolling&id=$r[id_polling]\">Edit</a> | 
	                    <a href=\"$aksi?module=polling&act=hapus&id=$r[id_polling]\">Hapus</a></td>
              </tr>";
        $no++;
      }
      echo "</tbody>
        </table><br>";
    break;

    case "tambahpolling":
      echo "<h2>Tambah Polling</h2>
          <form method=\"POST\" action=\"$aksi?module=polling&act=input\">
          <table>
          <tr><td>Pilihan</td><td> : <input type=\"text\" name=\"pilihan\"></td></tr>
          <tr><td>Status </td><td> : <input type=\"radio\" name=\"status\" value=\"Jawaban\" checked> Jawaban  
                                     <input type=\"radio\" name=\"status\" value=\"Pertanyaan\"> Pertanyaan </td></tr>
          <tr><td colspan=\"2\"><input type=\"submit\" value=\"Simpan\">
                                <input type=\"button\" value=\"Batal\" onclick=\"self.history.back()\"></td></tr>
          </table>
          </form>";
    break;
 
    case "editpolling":
      $query = "SELECT * FROM polling WHERE id_polling='$_GET[id]'";
      $hasil = mysqli_query($konek, $query);
      $r     = mysqli_fetch_array($hasil);

      echo "<h2>Edit Polling</h2>
          <form method=\"POST\" action=\"$aksi?module=polling&act=update\">
          <input type=\"hidden\" name=\"id\" value=\"$r[id_polling]\">
          <table>
          <tr><td>Pilihan</td><td> : <input type=\"text\" name=\"pilihan\" value=\"$r[pilihan]\"></td></tr>";
          
      if ($r['status']=='Jawaban'){
        echo "<tr><td>Status</td><td> : <input type=\"radio\" name=\"status\" value=\"Jawaban\" checked> Jawaban   
                                        <input type=\"radio\" name=\"status\" value=\"Pertanyaan\"> Pertanyaan </td></tr>";
      }
      else{
        echo "<tr><td>Status</td><td> : <input type=\"radio\" name=\"status\" value=\"Jawaban\"> Jawaban   
                                        <input type=\"radio\" name=\"status\" value=\"Pertanyaan\" checked> Pertanyaan </td></tr>";
      }
      if ($r['aktif']=='Y'){
        echo "<tr><td>Aktif</td><td> : <input type=\"radio\" name=\"aktif\" value=\"Y\" checked> Y   
                                       <input type=\"radio\" name=\"aktif\" value=\"N\"> N </td></tr>";
      }
      else{
        echo "<tr><td>Aktif</td><td> : <input type=\"radio\" name=\"aktif\" value=\"Y\"> Y   
                                       <input type=\"radio\" name=\"aktif\" value=\"N\" checked> N </td></tr>";
      }
      echo "<tr><td colspan=\"2\"><input type=\"submit\" value=\"Update\">
                                  <input type=\"button\" value=\"Batal\" onclick=\"self.history.back()\"></td></tr>
            </table>
            </form>";
    break;  
  }
}
?>
