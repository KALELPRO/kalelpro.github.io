<?php
// Apabila user belum login
if (empty($_SESSION['namauser']) AND empty($_SESSION['passuser'])){
  echo "<link href=\"css/style_login.css\" rel=\"stylesheet\" type=\"text/css\" />
        <div id=\"login\"><h1 class=\"fail\">Untuk mengakses modul, Anda harus login dulu.</h1>
        <p class=\"fail\"><a href=\"index.php\">LOGIN</a></p></div>";  
}
// Apabila user sudah login dengan benar, maka terbentuklah session

else{
  include "../config/koneksi.php";
  include "../config/library.php";

  // Home (Beranda)
  if ($_GET['module']=='beranda'){               
    if ($_SESSION['leveluser']=='admin' OR $_SESSION['leveluser']=='user'){
      include "modul/mod_beranda/beranda.php";
    }  
  }

  // Identitas Website
  elseif ($_GET['module']=='identitas'){
    if ($_SESSION['leveluser']=='admin'){
      include "modul/mod_identitas/identitas.php";
    }
  }

  // Manajemen User
  elseif ($_GET['module']=='user'){
    if ($_SESSION['leveluser']=='admin' OR $_SESSION['leveluser']=='user'){
      include "modul/mod_user/user.php";
    }
  }

  // Manajemen Modul
  elseif ($_GET['module']=='modul'){
    if ($_SESSION['leveluser']=='admin'){
      include "modul/mod_modul/modul.php";
    }
  }

  // Kategori
  elseif ($_GET['module']=='kategori'){
    if ($_SESSION['leveluser']=='admin'){
      include "modul/mod_kategori/kategori.php";
    }
  }

  // Bagian Berita
  elseif ($_GET['module']=='berita'){
    if ($_SESSION['leveluser']=='admin' OR $_SESSION['leveluser']=='user'){
      include "modul/mod_berita/berita.php";                            
    }
  }

  // Tag (Berita Terkait)
  elseif ($_GET['module']=='tag'){
    if ($_SESSION['leveluser']=='admin'){
      include "modul/mod_tag/tag.php";
    }
  }

  // Agenda
  elseif ($_GET['module']=='agenda'){
    if ($_SESSION['leveluser']=='admin' OR $_SESSION['leveluser']=='user'){
      include "modul/mod_agenda/agenda.php";
    }
  }

  // Banner
  elseif ($_GET['module']=='banner'){
    if ($_SESSION['leveluser']=='admin'){
      include "modul/mod_banner/banner.php";
    }
  }

  // Polling
  elseif ($_GET['module']=='polling'){
    if ($_SESSION['leveluser']=='admin'){
      include "modul/mod_polling/polling.php";
    }
  }

  // Download
  elseif ($_GET['module']=='download'){
    if ($_SESSION['leveluser']=='admin'){
      include "modul/mod_download/download.php";
    }
  }

  // Hubungi Kami
  elseif ($_GET['module']=='hubungi'){
    if ($_SESSION['leveluser']=='admin'){
      include "modul/mod_hubungi/hubungi.php";
    }
  }

  // Templates
  elseif ($_GET['module']=='templates'){
    if ($_SESSION['leveluser']=='admin'){
      include "modul/mod_templates/templates.php";
    }
  }

  // Album
  elseif ($_GET['module']=='album'){
    if ($_SESSION['leveluser']=='admin'){
      include "modul/mod_album/album.php";
    }
  }

  // Galeri Foto
  elseif ($_GET['module']=='galerifoto'){
    if ($_SESSION['leveluser']=='admin'){
      include "modul/mod_galerifoto/galerifoto.php";
    }
  }

  // Menu Website
  elseif ($_GET['module']=='menu'){
    if ($_SESSION['leveluser']=='admin'){
      include "modul/mod_menu/menu.php";
    }
  }

  // Halaman Statis
  elseif ($_GET['module']=='halamanstatis'){
    if ($_SESSION['leveluser']=='admin'){
      include "modul/mod_halamanstatis/halamanstatis.php";
    }
  }

  // Video
  elseif ($_GET['module']=='video'){
    if ($_SESSION['leveluser']=='admin'){
      include "modul/mod_video/video.php";
    }
  }

  // Apabila modul tidak ditemukan
  else{
    echo "<p>Modul tidak ada.</p>";
  }
}
?>
