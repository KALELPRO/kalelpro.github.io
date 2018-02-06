<?php
// Paging untuk semua berita
class paging_berita{
  // Fungsi untuk mencek halaman dan posisi data
  function cariPosisi($batas){
    if(empty($_GET['halberita'])){
	     $posisi=0;
	     $_GET['halberita']=1;
    }
    else{
	     $posisi = ($_GET['halberita']-1) * $batas;
    }
    return $posisi;
  }

  // Fungsi untuk menghitung total halaman
  function jumlahHalaman($jmldata, $batas){
    $jmlhalaman = ceil($jmldata/$batas);
    return $jmlhalaman;
  }

  // Fungsi untuk link halaman 1,2,3, dst 
  function navHalaman($halaman_aktif, $jmlhalaman){
    $link_halaman = "";

    // Link ke halaman pertama (first) dan sebelumnya (prev)
    if($halaman_aktif > 1){
	    $prev = $halaman_aktif-1;
	    $link_halaman .= "<a href=\"halberita-1.html\" class=\"page-numbers\">&laquo;</a>   
                        <a href=\"halberita-$prev.html\" class=\"page-numbers\">&lsaquo;</a> ";
    }

    // Link halaman 1,2,3, ...
    $angka = ($halaman_aktif > 3 ? " ... " : " "); 
    for ($i=$halaman_aktif-2; $i<$halaman_aktif; $i++){
      if ($i < 1) continue;
 	    $angka .= " <a href=\"halberita-$i.html\" class=\"page-numbers\">$i</a> ";
    }
	    $angka .= " <span class=\"page-numbers current\">$halaman_aktif</span> ";
	  
    for($i=$halaman_aktif+1; $i<($halaman_aktif+3); $i++){
      if($i > $jmlhalaman) break;
	    $angka .= " <a href=\"halberita-$i.html\" class=\"page-numbers\">$i</a> ";
    }
	    $angka .= ($halaman_aktif+2<$jmlhalaman ? " ... <a href=\"halberita-$jmlhalaman.html\" class=\"page-numbers\">$jmlhalaman</a> " : " ");

    $link_halaman .= "$angka";

    // Link ke halaman berikutnya (Next) dan terakhir (Last) 
    if($halaman_aktif < $jmlhalaman){
	    $next = $halaman_aktif+1;
	    $link_halaman .= " <a href=\"halberita-$next.html\" class=\"page-numbers\">&rsaquo;</a>  
                         <a href=\"halberita-$jmlhalaman.html\" class=\"page-numbers\">&raquo;</a> ";
    }
    return $link_halaman;
  }
}


// Paging untuk kategori (berita per kategori)
class paging_kategori{
  // Fungsi untuk mencek halaman dan posisi data
  function cariPosisi($batas){
    if(empty($_GET['halkategori'])){
	     $posisi=0;
	     $_GET['halkategori']=1;
    }
    else{
	     $posisi = ($_GET['halkategori']-1) * $batas;
    }
    return $posisi;
  }

  // Fungsi untuk menghitung total halaman
  function jumlahHalaman($jmldata, $batas){
    $jmlhalaman = ceil($jmldata/$batas);
    return $jmlhalaman;
  }

  // Fungsi untuk link halaman 1,2,3, dst 
  function navHalaman($halaman_aktif, $jmlhalaman){
    $link_halaman = "";

    // Link ke halaman pertama (first) dan sebelumnya (prev)
    if($halaman_aktif > 1){
	    $prev = $halaman_aktif-1;
	    $link_halaman .= "<a href=\"halkategori-$_GET[id]-1.html\" class=\"page-numbers\">&laquo;</a>   
                        <a href=\"halkategori-$_GET[id]-$prev.html\" class=\"page-numbers\">&lsaquo;</a> ";
    }

    // Link halaman 1,2,3, ...
    $angka = ($halaman_aktif > 3 ? " ... " : " "); 
    for ($i=$halaman_aktif-2; $i<$halaman_aktif; $i++){
      if ($i < 1) continue;
	    $angka .= " <a href=\"halkategori-$_GET[id]-$i.html\" class=\"page-numbers\">$i</a> ";
    }
	    $angka .= " <span class=\"page-numbers current\">$halaman_aktif</span> ";
	  
    for($i=$halaman_aktif+1; $i<($halaman_aktif+3); $i++){
      if($i > $jmlhalaman) break;
	    $angka .= " <a href=\"halkategori-$_GET[id]-$i.html\" class=\"page-numbers\">$i</a> ";
    }
	    $angka .= ($halaman_aktif+2<$jmlhalaman ? " ... <a href=\"halkategori-$_GET[id]-$jmlhalaman.html\" class=\"page-numbers\">$jmlhalaman</a> " : " ");

    $link_halaman .= "$angka";

    // Link ke halaman berikutnya (Next) dan terakhir (Last) 
    if($halaman_aktif < $jmlhalaman){
	    $next = $halaman_aktif+1;
	    $link_halaman .= " <a href=\"halkategori-$_GET[id]-$next.html\" class=\"page-numbers\">&rsaquo;</a>  
                         <a href=\"halkategori-$_GET[id]-$jmlhalaman.html\" class=\"page-numbers\">&raquo;</a> ";
    }
    return $link_halaman;
  }
}
?>