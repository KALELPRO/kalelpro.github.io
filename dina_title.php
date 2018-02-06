<?php
if (isset($_GET['id'])){
    $query = "SELECT judul FROM berita WHERE id_berita='$_GET[id]'";
    $hasil = mysqli_query($konek, $query);
    $data  = mysqli_fetch_array($hasil);
    
    if(isset($data)) {
      echo "$data[judul]";
    } 
    else{
      $query2 = "SELECT judul_website FROM identitas";
      $hasil2 = mysqli_query($konek, $query2);
      $data2  = mysqli_fetch_array($hasil2);
		  echo "$data2[judul_website]";
    }
}
else{
    $query2 = "SELECT judul_website FROM identitas";
    $hasil2 = mysqli_query($konek, $query2);
    $data2  = mysqli_fetch_array($hasil2);
	  echo "$data2[judul_website]";
}
?>
