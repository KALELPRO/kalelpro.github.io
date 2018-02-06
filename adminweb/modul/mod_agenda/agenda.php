    <!-- Date Picker jQuery UI-->
    <link type="text/css" href="development-bundle/themes/base/ui.all.css" rel="stylesheet" />   

    <script type="text/javascript" src="development-bundle/jquery-1.8.0.min.js"></script>
    <script type="text/javascript" src="development-bundle/ui/ui.core.js"></script>
    <script type="text/javascript" src="development-bundle/ui/ui.datepicker.js"></script>
    
    <script type="text/javascript" src="development-bundle/ui/i18n/ui.datepicker-id.js"></script>

    <script type="text/javascript"> 
      $(document).ready(function(){
        $("#tgl_mulai").datepicker({
					dateFormat  : "dd/mm/yy",        
          changeMonth : true,
          changeYear  : true					
        });      
        $("#tgl_selesai").datepicker({
					dateFormat  : "dd/mm/yy",        
          changeMonth : true,
          changeYear  : true					
        });      
      });
    </script>

<?php
// Apabila user belum login
if (empty($_SESSION['namauser']) AND empty($_SESSION['passuser'])){
  echo "<link href=\"../../css/style_login.css\" rel=\"stylesheet\" type=\"text/css\" />
        <div id=\"login\"><h1 class=\"fail\">Untuk mengakses modul, Anda harus login dulu.</h1>
        <p class=\"fail\"><a href=\"../../index.php\">LOGIN</a></p></div>";  
}
// Apabila user sudah login dengan benar, maka terbentuklah session
else{
  $aksi = "modul/mod_agenda/aksi_agenda.php";

  // mengatasi variabel yang belum di definisikan (notice undefined index)
  $act = isset($_GET['act']) ? $_GET['act'] : ''; 

  switch($act){
    // Tampil Agenda
    default:
      echo "<h2>Agenda</h2>
        <p><input type=\"button\" value=\"Tambah Agenda\" onclick=window.location.href=\"?module=agenda&act=tambahagenda\"></p>
        <table>
          <thead>
          <tr><th>No</th><th>Tema Acara</th><th>Tgl. Acara</th><th>Tgl. Posting</th><th>Aksi</th></tr>
          </thead>
            <tbody>";
            
      if ($_SESSION['leveluser']=='admin'){
        $query  = "SELECT * FROM agenda ORDER BY id_agenda DESC";
        $tampil = mysqli_query($konek, $query);
      }
      else{
        $query  = "SELECT * FROM agenda WHERE username='$_SESSION[namauser]' ORDER BY id_agenda DESC";
        $tampil = mysqli_query($konek, $query);
      }
  
      $no = 1;
      while($r=mysqli_fetch_array($tampil)){
        $tgl_mulai   = tgl_indo($r['tgl_mulai']);
        $tgl_selesai = tgl_indo($r['tgl_selesai']);
        $tgl_posting = tgl_indo($r['tgl_posting']);
        
        echo "<tr><td>$no</td>
                  <td width=\"300\">$r[tema]</td>";
        
        if ($tgl_mulai==$tgl_selesai){
            echo "<td>$tgl_mulai</td>";        
        }
        else{
            echo "<td>$tgl_mulai s/d $tgl_selesai</td>";                
        }  
            echo "<td>$tgl_posting</td>
                  <td><a href=\"?module=agenda&act=editagenda&id=$r[id_agenda]\">Edit</a> | 
	                    <a href=\"$aksi?module=agenda&act=hapus&id=$r[id_agenda]\">Hapus</a>
		          </tr>";
        $no++;
      }
      echo "</tbody>
        </table><br>";
    break;

    case "tambahagenda":
      echo "<h2>Tambah Agenda</h2>
            <form method=\"POST\" enctype=\"multipart/form-data\" action=\"$aksi?module=agenda&act=input\">
            <table>
            <tr><td>Tema Acara  </td><td> : <input type=\"text\" name=\"tema\"></td></tr>
            <tr><td>Isi Agenda  </td><td>   <textarea name=\"isi_agenda\" id=\"lokomedia\" style=\"width: 800px; height: 150px;\"></textarea></td></tr>
            <tr><td>Tempat      </td><td> : <input type=\"text\" name=\"tempat\"></td></tr>
            <tr><td>Tgl. Mulai  </td><td> : <input type=\"text\" name=\"tgl_mulai\" id=\"tgl_mulai\"></td></tr>        
            <tr><td>Tgl. Selesai</td><td> : <input type=\"text\" name=\"tgl_selesai\" id=\"tgl_selesai\"><br>
                                            - Apabila acara hanya sehari, isikan tanggal yang sama dengan Tgl. Mulai.</td></tr>        
            <tr><td>Pukul       </td><td> : <input type=\"text\" name=\"jam\"></td></tr>
            <tr><td>Pengirim    </td><td> : <input type=\"text\" name=\"pengirim\"></td></tr>
            <tr><td>Gambar      </td><td> : <input type=\"file\" name=\"fupload\" size=\"50\"><br> 
                                           - Tipe gambar harus JPG (disarankan lebar gambar 600 pixel).</td></tr>
            <tr><td colspan=\"2\"><input type=\"submit\" value=\"Simpan\">
                                 <input type=button value=\"Batal\" onclick=\"self.history.back()\"></td></tr>
            </table>
            </form>";
    break;
  

    case "editagenda":
      if ($_SESSION['leveluser']=='admin'){
        $query = "SELECT * FROM agenda WHERE id_agenda='$_GET[id]'";
        $hasil = mysqli_query($konek, $query);
      }
      else{
        $query = "SELECT * FROM agenda WHERE id_agenda='$_GET[id] AND username='$_SESSION[namauser]''";
        $hasil = mysqli_query($konek, $query);
      }
    
        $r     = mysqli_fetch_array($hasil);
           
        $tgl_mulai   = ubah_tgl2($r['tgl_mulai']);
        $tgl_selesai = ubah_tgl2($r['tgl_selesai']);

      echo "<h2>Edit Agenda</h2>
            <form method=\"POST\" enctype=\"multipart/form-data\"  action=\"$aksi?module=agenda&act=update\">
            <input type=\"hidden\" name=\"id\" value=\"$r[id_agenda]\">
            <table>
            <tr><td>Tema Acara  </td><td> : <input type=\"text\" name=\"tema\" value=\"$r[tema]\"></td></tr>
            <tr><td>Isi Agenda  </td><td>   <textarea name=\"isi_agenda\" id=\"lokomedia\" style=\"width: 800px; height: 150px;\">$r[isi_agenda]
                                            </textarea></td></tr>
            <tr><td>Tempat      </td><td> : <input type=\"text\" name=\"tempat\" value=\"$r[tempat]\"></td></tr>
            <tr><td>Tgl. Mulai  </td><td> : <input type=\"text\" name=\"tgl_mulai\" id=\"tgl_mulai\" value=\"$tgl_mulai\"></td></tr>        
            <tr><td>Tgl. Selesai</td><td> : <input type=\"text\" name=\"tgl_selesai\" id=\"tgl_selesai\" value=\"$tgl_selesai\"><br>
                                            - Apabila acara hanya sehari, isikan tanggal yang sama dengan Tgl. Mulai.</td></tr>        
            <tr><td>Pukul       </td><td> : <input type=\"text\" name=\"jam\" value=\"$r[jam]\"></td></tr>
            <tr><td>Pengirim    </td><td> : <input type=\"text\" name=\"pengirim\" value=\"$r[pengirim]\"></td></tr>";
      echo "<tr><td>Gambar</td><td> ";
          if ($r['gambar']!=''){
            echo "<img src=\"../foto_banner/small_$r[gambar]\">";  
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
