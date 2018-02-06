<?php
// Apabila user belum login
if (empty($_SESSION['namauser']) AND empty($_SESSION['passuser'])){
  echo "<link href=\"../../css/style_login.css\" rel=\"stylesheet\" type=\"text/css\" />
        <div id=\"login\"><h1 class=\"fail\">Untuk mengakses modul, Anda harus login dulu.</h1>
        <p class=\"fail\"><a href=\"../../index.php\">LOGIN</a></p></div>";  
}
// Apabila user sudah login dengan benar, maka terbentuklah session
else{
  $aksi = "modul/mod_menu/aksi_menu.php";

  // mengatasi variabel yang belum di definisikan (notice undefined index)
  $act = isset($_GET['act']) ? $_GET['act'] : ''; 

  switch($act){  
    // Tampil Menu 
    default:
      echo "<h2>Menu Website</h2>
          <p><input type=\"button\" value=\"Tambah Menu\" onclick=window.location.href=\"?module=menu&act=tambahmenu\"></p>
          <table>
          <thead>
          <tr>
          <tr><th>No</th><th>Nama Menu</th><th>Link</th><th>Level Menu</th><th>Aktif</th><th>Aksi</th></tr>
          </thead>
            <tbody>"; 
            
      $query  = "SELECT * FROM menu";
      $tampil = mysqli_query($konek, $query);
 
      $no = 1;
      while ($r=mysqli_fetch_array($tampil)){
        echo "<tr><td>$no</td>             
                  <td>$r[nama_menu]</td><td>$r[link]</td>";
  		  
      $query2 = "SELECT * FROM menu WHERE id_menu=$r[id_parent]";
      $hasil  = mysqli_query($konek, $query2);
      $jumlah = mysqli_num_rows($hasil); 	
            
      if ($jumlah > 0){
        while($s=mysqli_fetch_array($hasil)){
          echo "<td>$s[nama_menu]</td>"; 
        }
      }            
      else{
        echo "<td>Menu Utama</td>";
      }
  
        echo "<td align=\"center\">$r[aktif]</td>            
              <td><a href=\"?module=menu&act=editmenu&id=$r[id_menu]\">Edit</a> | 
                  <a href=\"$aksi?module=menu&act=hapus&id=$r[id_menu]\">Hapus</a></td></tr>";
        $no++;
      }
 
      echo "</tbody>
        </table>";
    break;

    // Form Tambah Menu
    case "tambahmenu":  
      echo "<h2>Tambah Menu</h1>
            <form method=\"POST\" action=\"$aksi?module=menu&act=input\">   
            <table>
            <tr><td>Nama Menu  </td><td> : <input type=\"text\" name=\"nama_menu\"></td></tr>
            <tr><td>Link       </td><td> : <input type=\"text\" name=\"link\"></td></tr>
            <tr><td>Level Menu </td><td> : <select name=\"id_parent\">
                <option value=\"0\" selected>Menu Utama</option>";
              
                $query  = "SELECT * FROM menu ORDER BY id_menu";
                $tampil = mysqli_query($konek, $query);
              
                while($r=mysqli_fetch_array($tampil)){
                  echo "<option value=\"$r[id_menu]\">$r[nama_menu]</option>";
                }
      echo "</select></td></tr>  		
            <tr><td colspan=\"2\"><input type=\"submit\" value=\"Simpan\">
                                  <input type=\"button\" value=\"Batal\" onclick=\"self.history.back()\"></td></tr>
            </table>
            </form>";   		     	 
    break;

    // Form Edit Menu
    case "editmenu":
      $query = "SELECT * FROM menu WHERE id_menu='$_GET[id]'";
      $hasil = mysqli_query($konek, $query);
      $r     = mysqlI_fetch_array($hasil);
		  
      echo "<h2>Edit Menu Website</h1>
            <form method=\"POST\" action=\"$aksi?module=menu&act=update\">
            <input type=\"hidden\" name=\"id\" value=\"$r[id_menu]\">
            <table>
		        <tr><td>Nama Menu </td><td> : <input type=\"text\" name=\"nama_menu\" value=\"$r[nama_menu]\"></td></tr>
		        <tr><td>Link      </td><td> : <input type=\"text\" name=\"link\" value=\"$r[link]\"></td></tr>
            <tr><td>Level Menu</td><td> : <select name=\"id_parent\">";
            
            $query  = "SELECT * FROM menu ORDER BY id_menu";
            $tampil = mysqli_query($konek, $query);
            if ($r['parent_id']==0){
              echo "<option value=\"0\" selected>Menu Utama</option>";}
            else{
              echo "<option value=\"0\">Menu Utama</option>";
            }     

            while($w=mysqli_fetch_array($tampil)){
              if ($r['id_parent']==$w['id_menu']){
                echo "<option value=\"$w[id_menu]\" selected>$w[nama_menu]</option>";}
              else{
                if ($w['id_menu']==$r['id_menu']){
                  echo "<option value=\"0\">Tanpa Level</option>";
                }
                else{
                  echo "<option value=\"$w[id_menu]\">$w[nama_menu]</option>";
                }
              }
            }
                      
      echo "</select></td></tr>";
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
