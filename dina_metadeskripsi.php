<?php    
if (isset($_GET['id'])){
    $query = "SELECT isi_berita FROM berita WHERE id_berita='$_GET[id]'";
    $hasil = mysqli_query($konek, $query);
    $data  = mysqli_fetch_array($hasil);

    // Tampilkan hanya sebagian isi berita
    $isi_berita = htmlentities(strip_tags($data['isi_berita'])); // membuat paragraf pada isi berita dan mengabaikan tag html
    $isi = substr($isi_berita,0,180); // ambil sebanyak 180 karakter
    $isi = substr($isi_berita,0,strrpos($isi," ")); // potong per spasi kalimat
		echo "$isi";
}
else{
    $query2 = "SELECT meta_deskripsi FROM identitas";
    $hasil2 = mysqli_query($konek, $query2);
    $data2  = mysqli_fetch_array($hasil2);
	  echo "$data2[meta_deskripsi]";
}
?>
