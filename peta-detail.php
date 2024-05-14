<?php

require_once("controller/script.php");
require_once("sections/head.php");

if (!isset($_GET['obj'])) {
  header("Location: peta");
  exit();
} else {
  $obj = valid($conn, $_GET['obj']);
  $check_data_maps = "SELECT * FROM kampung_adat WHERE id_kampung_adat=$obj";
  $views_data_maps = mysqli_query($conn, $check_data_maps);
  if (mysqli_num_rows($views_data_maps) == 0) {
    header("Location: peta");
    exit();
  } else {
    $data = mysqli_fetch_assoc($views_data_maps);
    $num_char = 27;
    $text = trim($data['deskripsi']);
    $text = strip_tags(preg_replace('#</?strong.*?>#is', '', $text));
    $lentext = strlen($text);
    if ($lentext > $num_char) {
      $deskripsi = substr($text, 0, $num_char) . '...';
    } else if ($lentext <= $num_char) {
      $deskripsi = substr($text, 0, $num_char);
    }
?>

    <div class="container-xxl hero-header" style="margin-bottom: -0px;">
      <div id='map' style="margin-top: -150px; width: 100%; height: 100vh;"></div>
      <div id='map-menu' class='map-overlay d-flex justify-content-start bg-white'>
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
          center: [<?= $data['longitude'] ?>, <?= $data['latitude'] ?>],
          zoom: 12,
          attributionControl: false
        });

        // Add the control to the map.
        map.addControl(
          new MapboxGeocoder({
            accessToken: mapboxgl.accessToken,
            mapboxgl: mapboxgl
          })
        );

        map.addControl(new mapboxgl.NavigationControl());

        // Add geolocate control to the map.
        map.addControl(
          new mapboxgl.GeolocateControl({
            positionOptions: {
              enableHighAccuracy: true
            },
            // When active the map will receive updates to the device's location as it changes.
            trackUserLocation: true,
            // Draw an arrow next to the location dot to indicate which direction the device is heading.
            showUserHeading: true
          })
        );

        var layerList = document.getElementById('map-menu');
        var inputs = layerList.getElementsByTagName('input');

        function switchLayer(layer) {
          var layerId = layer.target.id;
          map.setStyle('mapbox://styles/mapbox/' + layerId);
        }
        for (var i = 0; i < inputs.length; i++) {
          inputs[i].onclick = switchLayer;
        }

        var markers = [{
          lngLat: [<?= $data['longitude'] ?>, <?= $data['latitude'] ?>],
          popupContent: '<div class="popup-container"><img class="popup-image" src="assets/img/kampung-adat/<?= $data['img_kampung'] ?>" alt="Gambar kampung <?= $data['nama_kampung'] ?> tidak ditemukan!" style="width: 100%;height: 100px;"><h3 class="popup-title"><?= $data['nama_kampung'] ?></h3><p class="popup-description"><?= $deskripsi ?></p></div>'
        }, ];

        // Tambahkan setiap marker ke peta dan buka popup secara otomatis
        markers.forEach(function(markerInfo) {
          var marker = new mapboxgl.Marker()
            .setLngLat(markerInfo.lngLat)
            .addTo(map);

          var popup = new mapboxgl.Popup()
            .setLngLat(markerInfo.lngLat)
            .setHTML(markerInfo.popupContent)
            .addTo(map);

          marker.setPopup(popup);

          // Buka popup secara otomatis
          popup.addTo(map);
        });

        map.on('load', function() {
          map.resize();
        });
      </script>
    </div>
    <div class="container mt-5 mb-5">
      <div class="row">
        <div class="col-lg-8">
          <h1>Kampung Adat <?= $data['nama_kampung'] ?></h1>
          <p><?= $data['lokasi'] ?></p>
          <p class="mt-4"><?= $data['deskripsi'] ?></p>
        </div>
        <div class="col-lg-4">
          <img src="assets/img/kampung-adat/<?= $data['img_kampung'] ?>" style="width: 100%; height: 250px; object-fit: cover;" alt="">
          <h4 class="mt-3">Fasilitas</h4>
          <ul>
            <?php $check_data_fasilitas = "SELECT * FROM fasilitas_ka JOIN kategori_fasilitas ON fasilitas_ka.id_kf=kategori_fasilitas.id_kf WHERE fasilitas_ka.id_kampung_adat=$obj";
            $views_data_fasilitas = mysqli_query($conn, $check_data_fasilitas);
            if (mysqli_num_rows($views_data_fasilitas) > 0) {
              while ($data_f = mysqli_fetch_assoc($views_data_fasilitas)) { ?>
                <li>
                  <p><?= $data_f['nama_kf'] ?></p>
                </li>
            <?php }
            }
            ?>
          </ul>
        </div>
      </div>
    </div>
    </div>
    <!-- Navbar & Hero End -->

<?php require_once("sections/footer.php");
  }
} ?>