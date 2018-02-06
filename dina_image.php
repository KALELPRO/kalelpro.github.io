<?php
if (isset($_GET['id'])){
    $query = "SELECT gambar FROM berita WHERE id_berita='$_GET[id]'";
    $hasil = mysqli_query($konek, $query);
    $data  = mysqli_fetch_array($hasil);

		echo "foto_berita/$data[gambar]";
}
else{
		echo "default.jpg";
}
?>

