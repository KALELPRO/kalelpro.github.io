<?php
    $query = "SELECT meta_keyword FROM identitas";
    $hasil = mysqli_query($konek, $query);
    $data  = mysqli_fetch_array($hasil);
    
    echo "$data[meta_keyword]";
?>
