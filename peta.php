<?php require_once("controller/script.php"); ?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <title><?= $name_website ?></title>
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <meta content="" name="keywords">
  <meta content="" name="description">

  <!-- Favicon -->
  <link href="<?= $baseURL ?>assets/img/logo.png" rel="icon">

  <!-- Google Web Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500&family=Jost:wght@500;600;700&display=swap" rel="stylesheet">

  <!-- Icon Font Stylesheet -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

  <!-- Libraries Stylesheet -->
  <link href="<?= $baseURL ?>assets/lib/animate/animate.min.css" rel="stylesheet">
  <link href="<?= $baseURL ?>assets/lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">

  <!-- Customized Bootstrap Stylesheet -->
  <link href="<?= $baseURL ?>assets/css/bootstrap.min.css" rel="stylesheet">

  <!-- Template Stylesheet -->
  <link href="<?= $baseURL ?>assets/css/stylex.css" rel="stylesheet">
  <link href="<?= $baseURL ?>assets/css/scrollbar.css" rel="stylesheet">
  <script src="<?= $baseURL ?>assets/sweetalert/dist/sweetalert2.all.min.js"></script>

  <script src='https://api.mapbox.com/mapbox-gl-js/v2.6.1/mapbox-gl.js'></script>
  <link href='https://api.mapbox.com/mapbox-gl-js/v2.6.1/mapbox-gl.css' rel='stylesheet' />

  <style>
    /* Gaya untuk popup */
    .popup-container {
      max-width: 300px;
      padding: 20px;
      background-color: #fff;
      border-radius: 5px;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
    }

    .popup-title {
      font-size: 18px;
      font-weight: bold;
      margin-bottom: 10px;
    }

    .popup-image {
      width: 100%;
      height: 200px;
      object-fit: cover;
      margin-bottom: 10px;
    }

    .popup-description {
      font-size: 14px;
      line-height: 1.5;
    }

    .form-group {
      padding: 10px;
    }

    .form-group input[type="checkbox"] {
      transform: scale(1.5);
      margin-right: 5px;
    }
  </style>
</head>

<body data-bs-offset="51" style="overflow-x: hidden;">

  <div class="container-xxl bg-white p-0">
    <!-- Spinner Start -->
    <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
      <div class="spinner-grow text-primary" style="width: 3rem; height: 3rem;" role="status">
        <span class="sr-only">Loading...</span>
      </div>
    </div>
    <!-- Spinner End -->

    <!-- Navbar & Hero Start -->
    <div class="container-xxl position-relative p-0" id="home">
      <nav class="navbar navbar-expand-lg navbar-light px-4 px-lg-5 py-3 py-lg-0">
        <a href="./" class="navbar-brand p-0">
          <!-- <h1 class="m-0">FitApp</h1> -->
          <img src="assets/img/logo.png" alt="Logo">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
          <span class="fa fa-bars"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
          <div class="navbar-nav mx-auto py-0">
            <a href="./" class="nav-item nav-link">Beranda</a>
            <a href="#tentang" class="nav-item nav-link">Tentang</a>
            <a href="#kampung-adat" class="nav-item nav-link">Kampung Adat</a>
            <a href="#galeri" class="nav-item nav-link">Galeri</a>
            <a href="peta" target="_blank" class="nav-item nav-link active">Peta</a>
            <a href="#contact" class="nav-item nav-link">Kontak</a>
          </div>
          <a href="auth/" class="btn btn-primary-gradient rounded-pill py-2 px-4 ms-3 d-none d-lg-block"><i class="bi bi-box-arrow-in-right"></i> Login</a>
        </div>
      </nav>

      <div class="container-xxl bg-primary hero-header">
        <div class="row" style="margin-top: -120px;">
          <div class="col-lg-3 p-0" style="height: 794px; overflow-y: auto;">
            <div class="card shadow border-0 mb-3 rounded-0">
              <?php foreach ($views_kampung_adat as $data) {
                $num_char = 47;
                $text = trim($data['deskripsi']);
                $text = strip_tags(preg_replace('#</?strong.*?>#is', '', $text));
                $lentext = strlen($text);
                if ($lentext > $num_char) {
                  $deskripsi = substr($text, 0, $num_char) . '...';
                } else if ($lentext <= $num_char) {
                  $deskripsi = substr($text, 0, $num_char);
                } ?>
                <img src="assets/img/kampung-adat/<?= $data['img_kampung'] ?>" class="card-img-top rounded-0" style="width: 100%; height: 150px; object-fit: cover;" alt="Gambar kampung <?= $data['nama_kampung'] ?> tidak ditemukan!">
                <div class="card-body" style="padding: 30px;">
                  <h5 class="card-title"><?= $data['nama_kampung'] ?></h5>
                  <p class="card-text"><?= $deskripsi ?></p>
                  <a href="#" class="btn btn-primary btn-sm btn-map-view" data-latitude="<?= $data['latitude'] ?>" data-longitude="<?= $data['longitude'] ?>" data-img="<?= $data['img_kampung'] ?>" data-nama="<?= $data['nama_kampung'] ?>" data-deskripsi="<?= $deskripsi ?>"><i class="bi bi-map"></i> Lihat</a>
                </div>
              <?php } ?>
            </div>
          </div>
          <div class="col-lg-9 p-0">
            <div class="card shadow border-0 rounded-0">
              <div class="card-body p-0">
                <div id='map' style="width: 100%; height: 750px;"></div>
                <div id='map-menu' class='map-overlay d-flex justify-content-start'>
                  <div class="form-group">
                    <input id='streets-v11' type='checkbox' name='rtoggle' value='streets' checked='checked'>
                    <label for='streets'>Jalan</label>
                  </div>
                  <div class="form-group">
                    <input id='satellite-v9' type='checkbox' name='rtoggle' value='satellite'>
                    <label for='satellite'>Satelit</label>
                  </div>
                  <div class="form-group">
                    <input id='outdoors-v11' type='checkbox' name='rtoggle' value='outdoors'>
                    <label for='outdoors'>Outdoor</label>
                  </div>
                  <div class="form-group">
                    <input id='light-v10' type='checkbox' name='rtoggle' value='light'>
                    <label for='light'>Cahaya</label>
                  </div>
                  <div class="form-group">
                    <input id='dark-v10' type='checkbox' name='rtoggle' value='dark'>
                    <label for='dark'>Gelap</label>
                  </div>
                </div>
                <script>
                  var checkboxes = document.querySelectorAll('input[type="checkbox"]');

                  checkboxes.forEach(function(checkbox) {
                    checkbox.addEventListener('change', function() {
                      if (this.checked) {
                        checkboxes.forEach(function(otherCheckbox) {
                          if (otherCheckbox !== checkbox) {
                            otherCheckbox.checked = false;
                          }
                        });
                      }
                    });
                  });
                </script>
                <script>
                  mapboxgl.accessToken = '<?= $accessToken ?>';
                  var map = new mapboxgl.Map({
                    container: 'map',
                    style: 'mapbox://styles/mapbox/streets-v11',
                    center: [123.8156423, -8.3315012],
                    zoom: 9,
                    attributionControl: false
                  });

                  map.addControl(new mapboxgl.NavigationControl());

                  var layerList = document.getElementById('map-menu');
                  console.log(layerList);
                  var inputs = layerList.getElementsByTagName('input');

                  function switchLayer(layer) {
                    var layerId = layer.target.id;
                    map.setStyle('mapbox://styles/mapbox/' + layerId);
                  }
                  for (var i = 0; i < inputs.length; i++) {
                    inputs[i].onclick = switchLayer;
                  }

                  var markers = [
                    <?php foreach ($views_kampung_adat as $data) {
                      $num_char = 147;
                      $text = trim($data['deskripsi']);
                      $text = strip_tags(preg_replace('#</?strong.*?>#is', '', $text));
                      $lentext = strlen($text);
                      if ($lentext > $num_char) {
                        $deskripsi = substr($text, 0, $num_char) . '...';
                      } else if ($lentext <= $num_char) {
                        $deskripsi = substr($text, 0, $num_char);
                      } ?> {
                        lngLat: [<?= $data['longitude'] ?>, <?= $data['latitude'] ?>],
                        popupContent: '<div class="popup-container"><img class="popup-image" src="../assets/img/kampung-adat/<?= $data['img_kampung'] ?>" alt="Gambar kampung <?= $data['nama_kampung'] ?> tidak ditemukan!"><h3 class="popup-title"><?= $data['nama_kampung'] ?></h3><p class="popup-description"><?= $deskripsi ?></p></div>'
                      },
                    <?php } ?>
                  ];

                  // Tambahkan setiap marker ke peta
                  markers.forEach(function(markerInfo) {
                    var marker = new mapboxgl.Marker()
                      .setLngLat(markerInfo.lngLat)
                      .addTo(map)
                      .setPopup(new mapboxgl.Popup().setHTML(markerInfo.popupContent));
                  });

                  map.on('load', function() {
                    map.resize();
                  });
                </script>
                <script>
                  document.addEventListener('DOMContentLoaded', function() {
                    var viewButtons = document.querySelectorAll('.btn-map-view');
                    var currentPopup = null;

                    viewButtons.forEach(function(button) {
                      button.addEventListener('click', function(event) {
                        event.preventDefault();

                        var latitude = parseFloat(button.getAttribute('data-latitude'));
                        var longitude = parseFloat(button.getAttribute('data-longitude'));
                        var img_kampung = button.getAttribute('data-img');
                        var nama_kampung = button.getAttribute('data-nama');
                        var deskripsi = button.getAttribute('data-deskripsi');

                        // Tutup popup sebelumnya jika ada
                        if (currentPopup) {
                          currentPopup.remove();
                        }

                        currentPopup = new mapboxgl.Popup()
                          .setLngLat([longitude, latitude])
                          .setHTML('<div class="popup-container"><img class="popup-image" src="../assets/img/kampung-adat/' + img_kampung + '" alt="Gambar kampung ' + nama_kampung + ' tidak ditemukan!"><h3 class="popup-title">' + nama_kampung + '</h3><p class="popup-description">' + deskripsi + '</p></div>')
                          .addTo(map);

                        map.flyTo({
                          center: [longitude, latitude],
                          zoom: 16,
                          essential: true
                        });
                      });
                    });
                  });
                </script>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Navbar & Hero End -->

    <!-- Footer Start -->
    <div class="container-fluid bg-primary text-light footer wow fadeIn" style="margin-top: -96px;" data-wow-delay="0.1s">
      <div class="container px-lg-5">
        <div class="copyright">
          <div class="row">
            <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
              Copyright &copy; <a href="https://wasd.netmedia-framecode.com" class="text-decoration-none">WASD Netmedia Framecode</a> <?= date('Y') ?> | Develop by Neang
            </div>
            <div class="col-md-6 text-center text-md-end">
              <div class="footer-menu">
                <a href="./">Home</a>
                <a href="./#tentang">Tentang</a>
                <a href="./#kampung-adat">Kampung Adat</a>
                <a href="./#galeri">Galeri</a>
                <a href="./#contact">Kontak</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Footer End -->


    <!-- Back to Top -->
    <a href="#" class="btn btn-lg btn-lg-square back-to-top pt-2"><i class="bi bi-arrow-up text-white"></i></a>
  </div>

  <!-- JavaScript Libraries -->
  <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="<?= $baseURL ?>assets/lib/wow/wow.min.js"></script>
  <script src="<?= $baseURL ?>assets/lib/easing/easing.min.js"></script>
  <script src="<?= $baseURL ?>assets/lib/waypoints/waypoints.min.js"></script>
  <script src="<?= $baseURL ?>assets/lib/counterup/counterup.min.js"></script>
  <script src="<?= $baseURL ?>assets/lib/owlcarousel/owl.carousel.min.js"></script>

  <!-- Template Javascript -->
  <script src="<?= $baseURL ?>assets/js/main.js"></script>
</body>

</html>