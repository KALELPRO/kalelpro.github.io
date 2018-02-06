    <!-- jQuery Visualize Plugin (Grafik berbentuk Bar) -->
    <link href="css/visualize.css" rel="stylesheet" type="text/css" />
	
    <script src="js/jquery.min.js"></script>		
	  <script src="js/visualize.jQuery.js"></script>		
	  <script type="text/javascript">
	  $(function(){
	     $('#grafik').visualize({type: 'bar', width: '450px'});
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
  $tgl=date("Y-m-d");
  $tanggal=tgl_indo($tgl);
  echo "<h2>Selamat Datang di Halaman Administrator</h2>
        <p>Hai, <b>$_SESSION[namalengkap]</b> Anda login saat ini pada tanggal <b>$tanggal</b>.</p> 
        <table id=\"grafik\" width=\"400\" align=\"center\">
          <caption>Statistik Pengunjung Website (Seminggu Terakhir)</caption>
            <thead>	
              <tr><td></td><th>Pengunjung</th><th>Hits</th></tr>
            </thead>
              <tbody>";

  // $tgl_skrg = date("Ymd"); // dapatkan tanggal sekarang saat online
  $tgl_skrg = date("20140117"); // untuk simulasi saja sesuai dengan di database  17 Januari 2014

  // dapatkan 6 hari sblm tgl sekarang 
  $seminggu = strtotime("-1 week +1 day",strtotime($tgl_skrg));
  $hasilnya = date("Y-m-d", $seminggu);

  // lakukan looping sebanyak 6 kali   
  for ($i=0; $i<=6; $i++){
    $urutan_tgl   = strtotime("+$i day",strtotime($hasilnya));
    $hasil_urutan = date("d-M-Y", $urutan_tgl);
    
    $tgl_pengujung   = strtotime("+$i day",strtotime($hasilnya));
    $hasil_pengujung = date("Y-m-d", $tgl_pengujung);
    $query_pengujung = mysqli_num_rows(mysqli_query($konek, "SELECT * FROM statistik WHERE tanggal='$hasil_pengujung' GROUP BY ip"));
   
    $tgl_hits   = strtotime("+$i day",strtotime($hasilnya));
    $hasil_hits = date("Y-m-d", $tgl_hits);
    $query_hits = mysqli_fetch_array(mysqli_query($konek, "SELECT SUM(hits) as hitstoday FROM statistik WHERE tanggal='$hasil_hits' GROUP BY tanggal"));
    
    $hits_today = $query_hits['hitstoday'];
    
    if ($hits_today==""){ 
      $hits_today="0"; 
    }
      
    echo "<tr><th>$hasil_urutan</th><td align=\"center\">$query_pengujung</td><td align=\"center\">$hits_today</td></tr>";    
  }
  echo "</tbody>
     </table><br>";
}
?>
