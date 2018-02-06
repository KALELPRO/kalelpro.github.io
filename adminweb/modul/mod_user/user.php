<?php
// Apabila user belum login
if (empty($_SESSION['namauser']) AND empty($_SESSION['passuser'])){
  echo "<link href=\"../../css/style_login.css\" rel=\"stylesheet\" type=\"text/css\" />
        <div id=\"login\"><h1 class=\"fail\">Untuk mengakses modul, Anda harus login dulu.</h1>
        <p class=\"fail\"><a href=\"../../index.php\">LOGIN</a></p></div>";  
}
// Apabila user sudah login dengan benar, maka terbentuklah session
else{
  $aksi = "modul/mod_user/aksi_user.php";

  // mengatasi variabel yang belum di definisikan (notice undefined index)
  $act = isset($_GET['act']) ? $_GET['act'] : ''; 

  switch($act){
    // Tampil User
    default:
      echo "<h2>Manajemen User</h2>";
    
      if ($_SESSION['leveluser']=='admin'){
        $query  = "SELECT * FROM users ORDER BY username";
        $tampil = mysqli_query($konek, $query);
        echo "<p><input type=\"button\" value=\"Tambah User\" onclick=window.location.href=\"?module=user&act=tambahuser\"></p>";
      }
      else{
        $query  = "SELECT * FROM users WHERE username='$_SESSION[namauser]'";
        $tampil = mysqli_query($konek, $query);
      }
    
      echo "<table>
          <thead>
          <tr><th>No</th><th>Username</th><th>Nama Lengkap</th><th>Email</th><th>Level</th><th>Blokir</th><th>Aksi</th></tr>
          </thead>
            <tbody>"; 
            
      $no = 1;
      while ($r=mysqli_fetch_array($tampil)){
        echo "<tr>
             <td>$no</td>
             <td>$r[username]</td>
             <td>$r[nama_lengkap]</td>
		         <td><a href=\"mailto:$r[email]\">$r[email]</a></td>
		         <td>$r[level]</td>
		         <td align=\"center\">$r[blokir]</td>
             <td><a href=\"?module=user&act=edituser&id=$r[id_session]\">Edit</a></td>
             </tr>";
        $no++;
      }
      echo "</tbody>
        </table>
        <p>*) Data pada User tidak bisa dihapus, tapi bisa di blokir melalui Edit User.</p><br>";
    break;
  
    case "tambahuser":
      if ($_SESSION['leveluser']=='admin'){
        echo "<h2>Tambah User</h2>
          <form method=\"POST\" action=\"$aksi?module=user&act=input\">
          <table>
          <tr><td>Username</td>     <td> : <input type=\"text\" name=\"username\"></td></tr>
          <tr><td>Password</td>     <td> : <input type=\"text\" name=\"password\"></td></tr>
          <tr><td>Nama Lengkap</td> <td> : <input type=\"text\" name=\"nama_lengkap\"></td></tr>  
          <tr><td>E-mail</td>       <td> : <input type=\"text\" name=\"email\"></td></tr>
          <tr><td colspan=\"2\"><input type=\"submit\" value=\"Simpan\">
                                <input type=\"button\" value=\"Batal\" onclick=\"self.history.back()\"></td></tr>
          </table>
          </form>";
      }
      else{
        echo "Anda tidak berhak mengakses halaman ini.";
      }
    break;
    
    case "edituser":
      $query = "SELECT * FROM users WHERE id_session='$_GET[id]'";
      $hasil = mysqli_query($konek, $query);
      $r     = mysqli_fetch_array($hasil);

      if ($_SESSION['leveluser']=='admin'){
        echo "<h2>Edit User</h2>
          <form method=\"POST\" action=\"$aksi?module=user&act=update\">
          <input type=\"hidden\" name=\"id\" value=\"$r[id_session]\">
          <table>
          <tr><td>Username</td>     <td> : <input type=\"text\" name=\"username\" value=\"$r[username]\" disabled> **)</td></tr>
          <tr><td>Password</td>     <td> : <input type=\"text\" name=\"password\"> *) </td></tr>
          <tr><td>Nama Lengkap</td> <td> : <input type=\"text\" name=\"nama_lengkap\" value=\"$r[nama_lengkap]\"></td></tr>
          <tr><td>E-mail</td>       <td> : <input type=\"text\" name=\"email\" value=\"$r[email]\"></td></tr>";

          if ($r['blokir']=='N'){
            echo "<tr><td>Blokir</td><td> : <input type=\"radio\" name=\"blokir\" value=\"Y\"> Y   
                                            <input type=\"radio\" name=\"blokir\" value=\"N\" checked> N </td></tr>";
          }
          else{
            echo "<tr><td>Blokir</td><td> : <input type=\"radio\" name=\"blokir\" value=\"Y\" checked> Y  
                                            <input type=\"radio\" name=\"blokir\" value=\"N\"> N </td></tr>";
          }
    
        echo "<tr><td colspan=\"2\">*) Apabila password tidak diubah, dikosongkan saja.<br />
                                **) Username tidak bisa diubah.</td></tr>
          <tr><td colspan=\"2\"><input type=\"submit\" value=\"Update\">
                                <input type=\"button\" value=\"Batal\" onclick=\"self.history.back()\"></td></tr>
          </table>
          </form>";     
      }
      else{
        echo "<h2>Edit User</h2>
          <form method=\"POST\" action=\"$aksi?module=user&act=update\">
          <input type=\"hidden\" name=\"id\" value=\"$r[id_session]\">
          <input type=\"hidden\" name=\"blokir\" value=\"$r[blokir]\">
          <table>
          <tr><td>Username</td>     <td> : <input type=\"text\" name=\"username\" value=\"$r[username]\" disabled> **)</td></tr>
          <tr><td>Password</td>     <td> : <input type=\"text\" name=\"password\"> *) </td></tr>
          <tr><td>Nama Lengkap</td> <td> : <input type=\"text\" name=\"nama_lengkap\" value=\"$r[nama_lengkap]\"></td></tr>
          <tr><td>E-mail</td>       <td> : <input type=\"text\" name=\"email\" value=\"$r[email]\"></td></tr>";
        echo "<tr><td colspan=\"2\">*) Apabila password tidak diubah, dikosongkan saja.<br />
                                **) Username tidak bisa diubah.</td></tr>
          <tr><td colspan=\"2\"><input type=\"submit\" value=\"Update\">
                                <input type=\"button\" value=\"Batal\" onclick=\"self.history.back()\"></td></tr>
          </table>
          </form>";     
      }
    break;  
  }
}    
?>
