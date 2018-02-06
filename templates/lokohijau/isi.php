    <?php
    /*** BEGIN .Halaman Utama (Beranda atau Home) ***/
    if ($_GET['module']=='home'){
    ?>
								<div class="main-head">
									<a href="semua-berita.html" class="right">semua berita</a>
									<div class="main-title">
										<h1>Headline</h1>
										<div class="ribbon"><div class="inner"></div></div>
									</div>
								</div>

							<!-- BEGIN .blog-list-1 -->
							<div class="blog-list-1">								
              <?php
                // Tampilkan 5 headline berita terbaru
                $queryterbaru = "SELECT * FROM berita,kategori,users 
                                WHERE kategori.id_kategori=berita.id_kategori AND users.username=berita.username  
                                AND headline='Y' AND publish='Y' 
                                ORDER BY id_berita DESC LIMIT 5";
                $hasilterbaru = mysqli_query($konek, $queryterbaru);
                
              	while($t=mysqli_fetch_array($hasilterbaru)){                      
                  $isi_berita = strip_tags($t['isi_berita']); // membuat paragraf pada isi berita dan mengabaikan tag html
                  $isi = substr($isi_berita,0,170); // ambil sebanyak 170 karakter
                  $isi = substr($isi_berita,0,strrpos($isi," ")); // potong per spasi kalimat
       	    
	                $tanggal = tgl_indo($t['tanggal']); // konversi ke format tanggal indonesia
	                $tgl = explode(' ', $tanggal); // pisahkan penanggalan -> $tgl[0] = tanggal, $tgl[1] = bulan, $tgl[2] = tahun 
	                                          
						echo "<div class=\"item\">
                  <div class=\"date\">
										<p class=\"day\">$tgl[0]</p>
										<p class=\"month\">$tgl[1]</p>
										<p class=\"year\">$tgl[2]</p>
										<p class=\"comments\">Hari $t[hari]</p>
										<p class=\"section\"><a href=\"kategori-$t[id_kategori]-$t[kategori_seo].html\">$t[nama_kategori]</a></p>
										<p class=\"author\"><a href=\"#\">$t[nama_lengkap]</a></p>
									</div>
             
									<div class=\"image\">
											<img src=\"foto_berita/small_$t[gambar]\" width=\"110\" height=\"80\" />
									</div>
									<div class=\"text\">
										<h4><a href=\"berita-$t[id_berita]/$t[judul_seo].html\">$t[judul]</a></h4>
										<p>$isi</p>
										<p><a href=\"berita-$t[id_berita]/$t[judul_seo].html\" class=\"more-link\"><i>Selengkapnya</i></a></p>
									</div>
                </div>";
                } 
              ?>
															
							</div> <!-- END .blog-list-1 -->

								<div class="main-head">
									<a href="semua-album.html" class="right">semua album</a>
									<div class="main-title">
										<h1>Galeri Foto</h1>
										<div class="ribbon"><div class="inner"></div></div>
									</div>
								</div>

								<div class="menu-display-1-wrapper">
									<div class="menu-display-1">
								
              <?php
              // Tampilkan 6 galeri foto terbaru
              $querygaleri = "SELECT * FROM galeri ORDER BY id_galeri DESC LIMIT 6";
              $hasilgaleri = mysqli_query($konek, $querygaleri); 
              
              while ($g=mysqli_fetch_array($hasilgaleri)) {
								echo "<div class=\"item\">
											<h6 align=\"center\">$g[judul_galeri]</h6>
											<a href=\"foto_galeri/$g[foto]\" rel=\"prettyPhoto\" title=\"$g[keterangan]\" class=\"image\">
												<img src=\"foto_galeri/small_$g[foto]\" alt=\"$g[judul_galeri]\">
											</a>
										</div>";
              }
              ?>

										<div class="clear-float"></div>
									</div>
								</div>

								<div class="main-spacer"></div>

								<div class="main-head">
									<a href="semua-video.html" class="right">semua video</a>
									<div class="main-title">
										<h1>Video Favorit</h1>
										<div class="ribbon"><div class="inner"></div></div>
									</div>
								</div>

								<div class="menu-display-1-wrapper">
									<div class="menu-display-1">

              <?php
              // Tampilkan 2 video terbaru
              $queryvideo = "SELECT * FROM video ORDER BY id_video DESC LIMIT 2";
              $hasilvideo = mysqli_query($konek, $queryvideo); 
              
              while ($v=mysqli_fetch_array($hasilvideo)) {
								echo "<iframe src=\"http://www.youtube.com/embed/$v[link_youtube]\" frameborder=\"0\" width=\"300\" height=\"200\"></iframe> ";
              }
              ?>              
									</div>
								</div>
    <?php
    }     /*** END .Halaman Utama (Beranda atau Home) ***/

    
    /*** BEGIN .Detail Berita ***/
    elseif ($_GET['module']=='detailberita'){
    ?>

								<div class="main-head">
									<a href="<?php echo "$d[alamat_website]/semua-berita.html" ?>" class="right">tampilkan semua berita</a>
									<div class="main-title">
										<h1>Berita</h1>
										<div class="ribbon"><div class="inner"></div></div>
									</div>
								</div>

     <?php
	      $querydetail  = "SELECT * FROM berita,users,kategori    
                         WHERE users.username=berita.username  
                         AND kategori.id_kategori=berita.id_kategori 
                         AND id_berita = '$_GET[id]'";
                   
        $hasildetail  = mysqli_query($konek, $querydetail);
	      $r            = mysqli_fetch_array($hasildetail);
	      $tanggal      = tgl_indo($r['tanggal']);
	      $baca         = $r['dibaca']+1;
							
				echo "<!-- BEGIN .post -->
              <div class=\"post\">
								<h2>$r[judul]</h2>
								<div class=\"date\">
									<p class=\"day\">$r[hari], $tanggal</p>
									<p class=\"author\"><a href=\"#\">$r[nama_lengkap]</a></p>
									<p class=\"section\"><a href=\"$d[alamat_website]/kategori-$r[id_kategori]-$r[kategori_seo].html\">$r[nama_kategori]</a></p>
									<p class=\"comments\"><a href=\"#comments\">Dibaca: $baca kali</a></p>
								</div>";

        // Apabila ada gambar dalam berita, tampilkan.   
 	      if ($r['gambar']!=''){
		      echo "<p><img src=\"$d[alamat_website]/foto_berita/$r[gambar]\" class=\"post-image-1\" width=\"350\"></p>";
	      }
	      
				echo "<p class=\"caps\">$r[isi_berita]</p>

             <div class=\"main-spacer\"></div>
				
				     <h3>Berita Terkait</h3>
                <ul>";				
				// tampilkan 5 berita terkait berdasarkan tag
				$nama_tag = $r['tag'];
				$queryterkait = "SELECT * FROM berita WHERE tag LIKE '%$nama_tag%' AND id_berita!='$_GET[id]' ORDER BY id_berita DESC LIMIT 5";
				$hasilterkait = mysqli_query($konek, $queryterkait);
				
				while($h=mysqli_fetch_array($hasilterkait)){
          echo "<li><a href=\"$d[alamat_website]/berita-$h[id_berita]/$h[judul_seo].html\">$h[judul]</a></li>";
        }
								
				echo "</ul>
              <div class=\"main-spacer\"></div>
              
              <h3>Komentar via Facebook</h3>
              <div class=\"fb-comments\" data-href=\"$d[alamat_website]/berita-$r[judul_seo].html\" data-num-posts=\"5\" data-width=\"600\"></div>
              
              <div class=\"main-spacer\"></div>
							<p class=\"back-top\"><a href=\"#top\"><span>Kembali ke atas</span></a></p>
              							
						</div> <!-- END .post -->";

        // Apabila detail berita dilihat, maka tambahkan berapa kali dibacanya
        $dibaca = mysqli_query($konek, "UPDATE berita SET dibaca=$r[dibaca]+1 WHERE id_berita='$_GET[id]'"); 
    } /*** END .Detail Berita ***/
    
    
    /*** BEGIN .Semua Berita ***/
    elseif ($_GET['module']=='semuaberita'){
    ?>
								<div class="main-head">
									<div class="main-title">
										<h1>Semua Berita</h1>
										<div class="ribbon"><div class="inner"></div></div>
									</div>
								</div>

							<!-- BEGIN .blog-list-1 -->
							<div class="blog-list-1">								
              <?php
              // Gunakan fungsi/class paging
              $p = new paging_berita;
	            $batas  = 9;
	            $posisi = $p->cariPosisi($batas);

              // Tampilkan semua berita
              $queryberita = "SELECT * FROM berita,kategori,users  
                              WHERE kategori.id_kategori=berita.id_kategori 
                              AND users.username=berita.username  
                              AND publish='Y'  
                              ORDER BY id_berita DESC LIMIT $posisi,$batas";
              $hasilberita = mysqli_query($konek, $queryberita);

              while($m=mysqli_fetch_array($hasilberita)){
                  $isi_berita = strip_tags($m['isi_berita']); // membuat paragraf pada isi berita dan mengabaikan tag html
                  $isi = substr($isi_berita,0,170); // ambil sebanyak 170 karakter
                  $isi = substr($isi_berita,0,strrpos($isi," ")); // potong per spasi kalimat
       	    
	                $tanggal = tgl_indo($m['tanggal']); // konversi ke format tanggal indonesia
	                $tgl = explode(' ', $tanggal); // pisahkan penanggalan -> $tgl[0] = tanggal, $tgl[1] = bulan, $tgl[2] = tahun 
	                                          
						echo "<div class=\"item\">
                  <div class=\"date\">
										<p class=\"day\">$tgl[0]</p>
										<p class=\"month\">$tgl[1]</p>
										<p class=\"year\">$tgl[2]</p>
										<p class=\"comments\">Hari $m[hari]</p>
										<p class=\"section\"><a href=\"kategori-$m[id_kategori]-$m[kategori_seo].html\">$m[nama_kategori]</a></p>
										<p class=\"author\"><a href=\"#\">$m[nama_lengkap]</a></p>
									</div>
             
									<div class=\"image\">
											<img src=\"$d[alamat_website]/foto_berita/small_$m[gambar]\" width=\"110\" height=\"80\" />
									</div>
									<div class=\"text\">
										<h4><a href=\"$d[alamat_website]/berita-$m[id_berita]/$m[judul_seo].html\">$m[judul]</a></h4>
										<p>$isi</p>
										<p><a href=\"$d[alamat_website]/berita-$m[id_berita]/$m[judul_seo].html\" class=\"more-link\"><i>Selengkapnya</i></a></p>
									</div>
                </div>";          
              }
              // query untuk paging halaman berita per kategori
              $querydata   = mysqli_query($konek, "SELECT * FROM berita WHERE publish='Y'");
              $jmldata     = mysqli_num_rows($querydata);
              $jmlhalaman  = $p->jumlahHalaman($jmldata, $batas);
		          $linkHalaman = $p->navHalaman($_GET['halberita'], $jmlhalaman);                  

     					echo "<div class=\"pagination\">$linkHalaman</div>                    
				        </div> <!-- END .post -->";
    } /*** END .Semua Berita ***/

    /*** BEGIN .Berita per Kategori ***/
    elseif ($_GET['module']=='detailkategori'){
      // Tampilkan nama kategori
      $querynamakategori = "SELECT nama_kategori FROM kategori WHERE id_kategori='$_GET[id]'";
      $hasilnamakategori = mysqli_query($konek, $querynamakategori);
      $n = mysqli_fetch_array($hasilnamakategori);
    ?>
								<div class="main-head">
									<div class="main-title">
										<h1><?php echo "Kategori: $n[nama_kategori]" ?></h1>
										<div class="ribbon"><div class="inner"></div></div>
									</div>
								</div>

							<!-- BEGIN .blog-list-1 -->
							<div class="blog-list-1">								
              <?php
              // Gunakan fungsi/class paging
              $p = new paging_kategori;
	            $batas  = 8;
	            $posisi = $p->cariPosisi($batas);

              // Tampilkan daftar berita sesuai dengan kategori yang dipilih
 	            $querykategori = "SELECT * FROM berita WHERE id_kategori='$_GET[id]' ORDER BY id_berita DESC LIMIT $posisi,$batas";		 
              $hasilkategori = mysqli_query($konek, $querykategori);
	            $jumlahberita  = mysqli_num_rows($hasilkategori);
	            // Apabila ditemukan berita dalam kategori
	            if ($jumlahberita > 0){
                while($m=mysqli_fetch_array($hasilkategori)){
                  $isi_berita = strip_tags($m['isi_berita']); // membuat paragraf pada isi berita dan mengabaikan tag html
                  $isi = substr($isi_berita,0,170); // ambil sebanyak 170 karakter
                  $isi = substr($isi_berita,0,strrpos($isi," ")); // potong per spasi kalimat
       	    
	                $tanggal = tgl_indo($m['tanggal']); // konversi ke format tanggal indonesia
	                $tgl = explode(' ', $tanggal); // pisahkan penanggalan -> $tgl[0] = tanggal, $tgl[1] = bulan, $tgl[2] = tahun 
	                                          
						echo "<div class=\"item\">
                  <div class=\"date\">
										<p class=\"day\">$tgl[0]</p>
										<p class=\"month\">$tgl[1]</p>
										<p class=\"year\">$tgl[2]</p>
										<p class=\"comments\">Hari $m[hari]</p>
									</div>
             
									<div class=\"image\">
											<img src=\"$d[alamat_website]/foto_berita/small_$m[gambar]\" width=\"110\" height=\"80\" />
									</div>
									<div class=\"text\">
										<h4><a href=\"$d[alamat_website]/berita-$m[id_berita]/$m[judul_seo].html\">$m[judul]</a></h4>
										<p>$isi</p>
										<p><a href=\"$d[alamat_website]/berita-$m[id_berita]/$m[judul_seo].html\" class=\"more-link\"><i>Selengkapnya</i></a></p>
									</div>
                </div>";          
                }
                // query untuk paging halaman berita per kategori
                $querydata   = mysqli_query($konek, "SELECT * FROM berita WHERE id_kategori='$_GET[id]'");
                $jmldata     = mysqli_num_rows($querydata);
                $jmlhalaman  = $p->jumlahHalaman($jmldata, $batas);
		            $linkHalaman = $p->navHalaman($_GET['halkategori'], $jmlhalaman);                  

     					  echo "<div class=\"pagination\">$linkHalaman</div>";                
              }
              else{
                echo "<div><h5>Belum ada berita pada kategori ini.</h5></div>";
              }   
							echo "</div> <!-- END .blog-list-1 -->";
    } /*** END .Berita per Kategori ***/
     
    /*** BEGIN .Topik Berita (Terhangat) ***/
    elseif ($_GET['module']=='topikberita'){
      // Tampilkan nama topik
      $querynamatag = "SELECT nama_tag FROM tag WHERE tag_seo='$_GET[id]'";
      $hasilnamatag = mysqli_query($konek, $querynamatag);
      $n = mysqli_fetch_array($hasilnamatag);
    ?>
								<div class="main-head">
									<div class="main-title">
										<h1><?php echo "Topik: $n[nama_tag]" ?></h1>
										<div class="ribbon"><div class="inner"></div></div>
									</div>
								</div>

							<!-- BEGIN .blog-list-1 -->
							<div class="blog-list-1">								
              <?php
              // Tampilkan daftar berita sesuai dengan topik yang dipilih
 	            $querytag = "SELECT * FROM berita WHERE tag='$_GET[id]' ORDER BY id_berita DESC";		 
              $hasiltag = mysqli_query($konek, $querytag);
	            $jumlahberita  = mysqli_num_rows($hasiltag);
	            // Apabila ditemukan berita dalam kategori
	            if ($jumlahberita > 0){
                while($m=mysqli_fetch_array($hasiltag)){
                  $isi_berita = strip_tags($m['isi_berita']); // membuat paragraf pada isi berita dan mengabaikan tag html
                  $isi = substr($isi_berita,0,170); // ambil sebanyak 170 karakter
                  $isi = substr($isi_berita,0,strrpos($isi," ")); // potong per spasi kalimat
       	    
	                $tanggal = tgl_indo($m['tanggal']); // konversi ke format tanggal indonesia
	                $tgl = explode(' ', $tanggal); // pisahkan penanggalan -> $tgl[0] = tanggal, $tgl[1] = bulan, $tgl[2] = tahun 
	                                          
						echo "<div class=\"item\">
                  <div class=\"date\">
										<p class=\"day\">$tgl[0]</p>
										<p class=\"month\">$tgl[1]</p>
										<p class=\"year\">$tgl[2]</p>
										<p class=\"comments\">Hari $m[hari]</p>
									</div>
             
									<div class=\"image\">
											<img src=\"$d[alamat_website]/foto_berita/small_$m[gambar]\" width=\"110\" height=\"80\" />
									</div>
									<div class=\"text\">
										<h4><a href=\"$d[alamat_website]/berita-$m[id_berita]/$m[judul_seo].html\">$m[judul]</a></h4>
										<p>$isi</p>
										<p><a href=\"$d[alamat_website]/berita-$m[id_berita]/$m[judul_seo].html\" class=\"more-link\"><i>Selengkapnya</i></a></p>
									</div>
                </div>";          
                }
              }
              else{
                echo "<div><h5>Belum ada berita pada topik ini.</h5></div>";
              }   
							echo "</div> <!-- END .blog-list-1 -->";
    } /*** END .Topik Berita ***/

    /*** BEGIN .Semua Album ***/
    elseif ($_GET['module']=='semuaalbum'){
    ?>
								<div class="main-head">
									<div class="main-title">
										<h1>Album Foto</h1>
										<div class="ribbon"><div class="inner"></div></div>
									</div>
								</div>

								<div class="menu-display-1-wrapper">
									<div class="menu-display-1">
								
              <?php
              // Tampilkan semua album foto disertai berapa jumlah galeri foto didalamnya 
              $queryalbum = "SELECT album.id_album, nama_album, album_seo, gambar,     
                             COUNT(galeri.id_galeri) as jumlah 
                             FROM album LEFT JOIN galeri 
                             ON album.id_album=galeri.id_album 
                             WHERE album.aktif='Y'  
                             GROUP BY nama_album";            
              $hasilalbum = mysqli_query($konek, $queryalbum); 
              
              while ($w=mysqli_fetch_array($hasilalbum)) {
								echo "<div class=\"item\">
											<a href=\"album-$w[id_album]-$w[album_seo].html\" class=\"image\">
                        <h6 align=\"center\">$w[nama_album]</h6>
                      </a>
											<a href=\"album-$w[id_album]-$w[album_seo].html\" class=\"image\">
												<img src=\"$d[alamat_website]/foto_album/small_$w[gambar]\">
											</a>
											<p align=\"center\">($w[jumlah] Foto)</p>
										</div>";
              }
              ?>

										<div class="clear-float"></div>
									</div>
								</div>

								<div class="main-spacer"></div>
    <?php
    } /*** END .Semua Album ***/
     
    /*** BEGIN .Galeri Foto Berdasarkan Album ***/    
    elseif ($_GET['module']=='detailalbum'){
      // Tampilkan nama album
      $querynamaalbum = "SELECT nama_album FROM album WHERE id_album='$_GET[id]'";
      $hasilnamaalbum = mysqli_query($konek, $querynamaalbum);
      $n = mysqli_fetch_array($hasilnamaalbum);
    ?>

								<div class="main-head">
									<a href="semua-album.html" class="right">kembali ke Semua Album</a>
									<div class="main-title">
										<h1><?php echo "Album: $n[nama_album]" ?> </h1>
										<div class="ribbon"><div class="inner"></div></div>
									</div>
								</div>

								<div class="menu-display-1-wrapper">
									<div class="menu-display-1">
								
              <?php
              // Tampilkan semua foto berdasarkan album yang dipilih 
              $querygaleri = "SELECT * FROM galeri WHERE id_album='$_GET[id]' ORDER BY id_galeri DESC";            
              $hasilgaleri = mysqli_query($konek, $querygaleri); 
              
              while ($g=mysqli_fetch_array($hasilgaleri)) {
								echo "<div class=\"item\">
                      <h6 align=\"center\">$g[judul_galeri]</h6>
											<a href=\"$d[alamat_website]/foto_galeri/$g[foto]\" rel=\"prettyPhoto\" title=\"$g[keterangan]\" class=\"image\">
												<img src=\"$d[alamat_website]/foto_galeri/small_$g[foto]\" alt=\"$g[judul_galeri]\">
											</a>
										</div>";
              }
              ?>

										<div class="clear-float"></div>
									</div>
								</div>

								<div class="main-spacer"></div>
    <?php
    } /*** END .Galeri Foto Berdasarkan Album ***/
    
    /*** BEGIN .Semua Download ***/
    elseif ($_GET['module']=='semuadownload'){
    ?>

								<div class="main-head">
									<div class="main-title">
										<h1>Download</h1>
										<div class="ribbon"><div class="inner"></div></div>
									</div>
								</div>

     <?php
	    $querydownload = "SELECT * FROM download ORDER BY id_download DESC";
      $hasildownload = mysqli_query($konek, $querydownload);

      echo "<div class=\"post\">
              <ul>";
              
      while($r=mysqli_fetch_array($hasildownload)){
        echo "<li><a href=\"downlot.php?file=$r[nama_file]\">$r[judul]</a> (didownload: $r[diunduh] kali)</li>";      
      }							
				echo "</ul>              							
						</div>";
    } /*** END .Semua Download ***/    


    /*** BEGIN .Semua Agenda ***/
    elseif ($_GET['module']=='semuaagenda'){
    ?>

								<div class="main-head">
									<div class="main-title">
										<h1>Agenda</h1>
										<div class="ribbon"><div class="inner"></div></div>
									</div>
								</div>

     <?php
	    $queryagenda = "SELECT * FROM agenda ORDER BY id_agenda DESC";
      $hasilagenda = mysqli_query($konek, $queryagenda);

      echo "<div class=\"post\">
              <ul>";
              
      while($r=mysqli_fetch_array($hasilagenda)){
        $tanggal=tgl_indo($r['tgl_mulai']);
        echo "<li><a href=\"agenda-$r[id_agenda]/$r[tema_seo].html\">$r[tema]</a> [$tanggal]</li>";      
      }							
				echo "</ul>              							
						</div> <!-- END .post -->";
    } /*** END .Semua Agenda ***/    


    /*** BEGIN .Detail Agenda ***/
    elseif ($_GET['module']=='detailagenda'){
    ?>

								<div class="main-head">
									<a href="<?php echo "$d[alamat_website]/semua-agenda.html" ?>" class="right">tampilkan semua agenda</a>
									<div class="main-title">
										<h1>Agenda</h1>
										<div class="ribbon"><div class="inner"></div></div>
									</div>
								</div>

     <?php
	      $queryagenda  = "SELECT * FROM agenda WHERE id_agenda='$_GET[id]'";
        $detailagenda = mysqli_query($konek, $queryagenda);
	      $r            = mysqli_fetch_array($detailagenda);

	      $tgl_posting  = tgl_indo($r['tgl_posting']);
	      $tgl_mulai    = tgl_indo($r['tgl_mulai']);
	      $tgl_selesai  = tgl_indo($r['tgl_selesai']);
							
				echo "<!-- BEGIN .post -->
              <div class=\"post\">
								<h2>$r[tema]</h2>
								<div class=\"date\">
									<p class=\"section\"><a href=\"#\">Tgl. Posting: $tgl_posting</a></p>
									<p class=\"author\"><a href=\"#\">Pengirim: $r[pengirim]</a></p>
								</div>";

        // Apabila ada gambar dalam agenda, tampilkan.   
 	      if ($r['gambar']!=''){
		      echo "<p><img src=\"$d[alamat_website]/foto_banner/$r[gambar]\" class=\"post-image-1\" width=\"600\"></p>";
	      }
	      
				echo "<br><p><b>Tema</b> : <br>$r[isi_agenda]</p>";
				
        if ($tgl_mulai==$tgl_selesai){
            echo "<p><b>Tanggal</b> : $tgl_mulai</p>";        
        }
        else{
            echo "<p><b>Tanggal</b> : $tgl_mulai s/d $tgl_selesai</p>";                
        }  
				
        echo "<p><b>Tempat</b> : $r[tempat]</p> 
              <p><b>Pukul</b> : $r[jam]</p> 

              <div class=\"main-spacer\"></div>
							<p class=\"back-top\"><a href=\"#top\"><span>Kembali ke atas</span></a></p>
              							
						</div> <!-- END .post -->";

    } /*** END .Detail Agenda ***/
    

    /*** BEGIN .Semua Video ***/
    elseif ($_GET['module']=='semuavideo'){
    ?>

								<div class="main-head">
									<div class="main-title">
										<h1>Video</h1>
										<div class="ribbon"><div class="inner"></div></div>
									</div>
								</div>

								<div class="menu-display-1-wrapper">
									<div class="menu-display-1">
								
              <?php
              // Tampilkan semua video 
	            $queryvideo = "SELECT * FROM video ORDER BY id_video DESC";
              $hasilvideo = mysqli_query($konek, $queryvideo);
              
              while ($g=mysqli_fetch_array($hasilvideo)) {
								echo "<div class=\"item\">
											<a href=\"video-$g[id_video]/$g[video_seo].html\" class=\"image\">
                        <h6 align=\"center\">$g[judul_video]</h6>
											</a>
											<a href=\"video-$g[id_video]/$g[video_seo].html\" class=\"image\">
												<img src=\"$d[alamat_website]/foto_video/small_$g[gambar]\">
											</a>
										</div>";
              }
              ?>

										<div class="clear-float"></div>
									</div>
								</div>

								<div class="main-spacer"></div>
    <?php
    } /*** END .Semua Video ***/

    /*** BEGIN .Detail Video ***/
    elseif ($_GET['module']=='detailvideo'){
    ?>

								<div class="main-head">
									<a href="<?php echo "$d[alamat_website]/semua-video.html" ?>" class="right">tampilkan semua video</a>
									<div class="main-title">
										<h1>Video</h1>
										<div class="ribbon"><div class="inner"></div></div>
									</div>
								</div>

     <?php
	      $queryvideo  = "SELECT * FROM video WHERE id_video='$_GET[id]'";
        $detailvideo = mysqli_query($konek, $queryvideo);
	      $r            = mysqli_fetch_array($detailvideo);

							
				echo "<!-- BEGIN .post -->
              <div class=\"post\">
								<h2>$r[judul_video]</h2>
				        <iframe src=\"http://www.youtube.com/embed/$r[link_youtube]\" frameborder=\"0\" width=\"600\" height=\"320\"></iframe>
				        <p>$r[deskripsi]</p>
				        
              <div class=\"main-spacer\"></div>
							<p class=\"back-top\"><a href=\"#top\"><span>Kembali ke atas</span></a></p>
              							
						</div> <!-- END .post -->";

    } /*** END .Detail Video ***/


    /*** BEGIN .Halaman Statis (Profil, Visi Misi, Struktur Organisasi) ***/
    elseif ($_GET['module']=='halamanstatis'){
        $querystatis  = "SELECT * FROM halamanstatis WHERE id_halaman='$_GET[id]'";
        $detailstatis = mysqli_query($konek, $querystatis);
	      $r            = mysqli_fetch_array($detailstatis);

	      $tanggal      = tgl_indo($r['tanggal']);
     ?>
     
								<div class="main-head">
									<div class="main-title">
										<h1><?php echo "$r[judul]" ?></h1>
										<div class="ribbon"><div class="inner"></div></div>
									</div>
								</div>           
								
	   <?php							
				echo "<!-- BEGIN .post -->
              <div class=\"post\">";

        // Apabila ada gambar dalam agenda, tampilkan.   
 	      if ($r['gambar']!=''){
		      echo "<p><img src=\"$d[alamat_website]/foto_banner/$r[gambar]\" class=\"post-image-1\"></p>";
	      }
	      
				echo "<p>&nbsp</p>
              <p>$r[isi_halaman]</p>				
              <div class=\"main-spacer\"></div>
              							
						</div> <!-- END .post -->";

    } /*** END .Halaman Statis ***/


    /*** BEGIN .Hasil Pencarian Berita ***/
    elseif ($_GET['module']=='hasilcari'){
    ?>
    
    						<div class="main-head">
									<div class="main-title">
										<h1>Hasil Pencarian</h1>
										<div class="ribbon"><div class="inner"></div></div>
									</div>
								</div>

							<!-- BEGIN .blog-list-1 -->
							<div class="blog-list-1">								

    <?php
      // mencegah XSS
      $kata = htmlentities(htmlspecialchars($_POST['kata']), ENT_QUOTES);

      // pisahkan kata per kalimat lalu hitung jumlah kata
      $pisah_kata = explode(" ",$kata);
      $jml_katakan = (integer)count($pisah_kata);
      $jml_kata = $jml_katakan-1;

      $cari = "SELECT * FROM berita WHERE " ;
      for ($i=0; $i<=$jml_kata; $i++){
        $cari .= "judul OR isi_berita LIKE '%$pisah_kata[$i]%'";
        if ($i < $jml_kata ){
          $cari .= " OR ";
        }
      }
      $cari .= " ORDER BY id_berita DESC LIMIT 10";
      $hasil  = mysqli_query($konek, $cari);
      $ketemu = mysqli_num_rows($hasil);

      if ($ketemu > 0){
        echo "<p>Ditemukan <b>$ketemu</b> berita dengan kata <font style='background-color:#00FFFF'><b>$kata</b></font> : </p><br>";
         
        while($t=mysqli_fetch_array($hasil)){        
          $isi_berita = strip_tags($t['isi_berita']); // membuat paragraf pada isi berita dan mengabaikan tag html
          $isi = substr($isi_berita,0,170); // ambil sebanyak 170 karakter
          $isi = substr($isi_berita,0,strrpos($isi," ")); // potong per spasi kalimat
       	    
	        $tanggal = tgl_indo($t['tanggal']); // konversi ke format tanggal indonesia
	        $tgl = explode(' ', $tanggal); // pisahkan penanggalan -> $tgl[0] = tanggal, $tgl[1] = bulan, $tgl[2] = tahun 
	                                          
						echo "<div class=\"item\">
                  <div class=\"date\">
										<p class=\"day\">$tgl[0]</p>
										<p class=\"month\">$tgl[1]</p>
										<p class=\"year\">$tgl[2]</p>
										<p class=\"comments\">Hari $t[hari]</p>
									</div>
             
									<div class=\"image\">
											<img src=\"$d[alamat_website]/foto_berita/small_$t[gambar]\" width=\"110\" height=\"80\" />
									</div>
									<div class=\"text\">
										<h4><a href=\"$d[alamat_website]/berita-$t[id_berita]/$t[judul_seo].html\">$t[judul]</a></h4>
										<p>$isi</p>
										<p><a href=\"$d[alamat_website]/berita-$t[id_berita]/$t[judul_seo].html\" class=\"more-link\"><i>Selengkapnya</i></a></p>
									</div>
                </div>";          
        }                                                          
      }
      else{
        echo "<div><h5>Tidak ditemukan berita dengan kata <font style='background-color:#00FFFF'>$kata</font></h5></div>";
      }
		  echo "</div> <!-- END .blog-list-1 -->";
    } /*** END .Hasil Pencarian Berita ***/
    
    /*** BEGIN .Hubungi Kami ***/
    elseif ($_GET['module']=='hubungikami'){
    ?>

							<div class="main-head">
								<div class="main-title">
									<h1>Hubungi Kami</h1>
									<div class="ribbon"><div class="inner"></div></div>
									<div class="ribbon-tail"><div class="inner-top"></div><div class="inner-bottom"></div></div>
								</div>
							</div>

							<h4>Hubungi kami secara online dengan mengisi form di bawah ini : </h4>

							<!-- BEGIN .post -->
							<div class="post">
								
								<form class="add-comment" action="hubungi-aksi.html" method="post">
									<p>
										<label for="nama">Nama<span class="required">*</span></label>
										<input type="text" placeholder="Nama Anda" name="nama" id="nama" />
									</p>
									<p>
										<label for="email">E-mail<span class="required">*</span></label>
										<input type="text" placeholder="E-mail Anda" name="email" id="email" />
									</p>
									<p>
										<label for="subjek">Subjek<span class="required">*</span></label>
										<input type="text" placeholder="Subjek" name="subjek" id="subjek" />
									</p>
									<p>
										<label for="pesan">Pesan</label>
										<textarea name="pesan" placeholder="Pesan Anda..." id="pesan"></textarea>
									</p>
									<p><input type="submit" class="button" value="Kirim" /></p>
								</form>

								<div class="main-spacer"></div>

							</div> <!-- END .post -->    
    <?php
    } /*** END .Hubungi Kami ***/

    /*** BEGIN .Hubungi Aksi ***/
    elseif ($_GET['module']=='hubungiaksi'){
      $nama   = $_POST['nama'];
      $email  = $_POST['email'];
      $subjek = $_POST['subjek'];
      $pesan  = $_POST['pesan'];

      $queryhubungi = "INSERT INTO hubungi(nama_pengirim,
                                           email,
                                           subjek,
                                           pesan,
                                           tanggal) 
                                  VALUES('$nama',
                                         '$email',
                                         '$subjek',
                                         '$pesan',
                                         '$tgl_sekarang')";
      $hasilhubungi = mysqli_query($konek, $queryhubungi);
    ?>                                         

							<div class="main-head">
								<div class="main-title">
									<h1>Hubungi Kami</h1>
									<div class="ribbon"><div class="inner"></div></div>
									<div class="ribbon-tail"><div class="inner-top"></div><div class="inner-bottom"></div></div>
								</div>
							</div>

							<h4>Terimakasih telah menghubungi kami. Tunggu balasan Kami via Email. </h4>
							<div class="main-spacer"></div>
      
    <?php  
    } /*** END .Hubungi Aksi ***/

    /*** BEGIN .Hasil Polling ***/
    elseif ($_GET['module']=='hasilpolling'){
    ?>
    
						  <div class="main-head">
								<div class="main-title">
									<h1>Hasil Polling</h1>
									<div class="ribbon"><div class="inner"></div></div>
									<div class="ribbon-tail"><div class="inner-top"></div><div class="inner-bottom"></div></div>
								</div>
							</div>

    <?php
      // Mencegah pengunjung melakukan voting lebih dari 1 kali dalam sehari.
      if (isset($_COOKIE['polling'])) {
        echo "<h4>Sorry, Anda sudah pernah melakukan voting terhadap polling ini.</h4>
              <h4>Coba lagi besok ya.</h4>";
      }
      else{
        // membuat cookie dengan nama polling
        // cookie akan secara otomatis terhapus dalam waktu 24 jam
        setcookie("polling", "sudah polling", time() + 3600 * 24);

        $pilihan = $_POST['pilihan'];
        // tambahkan rating untuk polling yang dipilih pengunjung
        $querypolling = "UPDATE polling SET rating=rating+1 WHERE id_polling='$pilihan'";
        $updatepolling = mysqli_query($konek, $querypolling);

				echo "<!-- BEGIN .post -->
              <div class=\"post\">
              <h3>Terimakasih atas partisipasi Anda mengikuti polling kami.</h3><br>
              <h5>Hasil polling saat ini: </h5><br>";
  
        echo "<table width=\"100%\" cellpadding=\"20\" cellspacing=\"20\">";

        // hitung jumlah rating masing-masing polling
        $jumlahpolling = "SELECT SUM(rating) as jml_vote FROM polling WHERE aktif='Y' AND status='Jawaban'";
        $hasilpolling  = mysqli_query($konek, $jumlahpolling);
        $j             = mysqli_fetch_array($hasilpolling);
  
        $jml_vote=$j['jml_vote'];
  
        // tampilkan polling yang aktif
        $sql = "SELECT * FROM polling WHERE aktif='Y' AND status='Jawaban'";
        $hsl = mysqli_query($konek, $sql);
  
        while ($s=mysqli_fetch_array($hsl)){
          $rating = $s['rating'];
          // hitung prosentasi masing-masing polling 
  	      $prosentase = sprintf("%2.1f",(($rating/$jml_vote)*100));
  	      $gbr_vote   = $prosentase * 3;

          echo "<tr><td><br>$s[pilihan] ($s[rating]) <br></td>
                    <td><br><img src=\"$d[alamat_website]/$f[folder]/images/blue.png\" width=\"$gbr_vote\" height=\"30\" border=\"0\"> $prosentase % <br></td>
                </tr>";  
        }
        echo "</table>
              <br><br>
              <p>Jumlah Voting: <b>$jml_vote</b> Orang</p>
              
              <div class=\"main-spacer\"></div>              							
						</div> <!-- END .post -->";
      }
    } /*** END .Hasil Polling ***/

    /*** BEGIN .Lihat Polling ***/
    elseif ($_GET['module']=='lihatpolling'){
    ?>
					   <div class="main-head">
								<div class="main-title">
									<h1>Hasil Polling</h1>
									<div class="ribbon"><div class="inner"></div></div>
									<div class="ribbon-tail"><div class="inner-top"></div><div class="inner-bottom"></div></div>
								</div>
							</div>

    <?php
				echo "<!-- BEGIN .post -->
              <div class=\"post\">
              <h5>Hasil polling saat ini: </h5><br>";
  
        echo "<table width=\"100%\" cellpadding=\"20\" cellspacing=\"20\">";

        // hitung jumlah rating masing-masing polling
        $jumlahpolling = "SELECT SUM(rating) as jml_vote FROM polling WHERE aktif='Y' AND status='Jawaban'";
        $hasilpolling  = mysqli_query($konek, $jumlahpolling);
        $j             = mysqli_fetch_array($hasilpolling);
  
        $jml_vote=$j['jml_vote'];
  
        // tampilkan polling yang aktif
        $sql = "SELECT * FROM polling WHERE aktif='Y' AND status='Jawaban'";
        $hsl = mysqli_query($konek, $sql);
  
        while ($s=mysqli_fetch_array($hsl)){
          $rating = $s['rating'];
          // hitung prosentasi masing-masing polling 
  	      $prosentase = sprintf("%2.1f",(($rating/$jml_vote)*100));
  	      $gbr_vote   = $prosentase * 3;

          echo "<tr><td><br>$s[pilihan] ($s[rating]) <br></td>
                    <td><br><img src=\"$d[alamat_website]/$f[folder]/images/blue.png\" width=\"$gbr_vote\" height=\"30\" border=\"0\"> $prosentase % <br></td>
                </tr>";  
        }
        echo "</table>
              <br><br>
              <p>Jumlah Voting: <b>$jml_vote</b> Orang</p>
              
              <div class=\"main-spacer\"></div>              							
						</div> <!-- END .post -->";
    
    } /*** END .Lihat Polling ***/
    
    ?>

