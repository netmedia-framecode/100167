<?php

require_once("controller/script.php");
require_once("sections/head.php");

?>


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

  #mode-selector {
    position: absolute;
    top: 10px;
    left: 10px;
    z-index: 1000;
    /* Pastikan z-index lebih tinggi dari peta untuk menempatkan di atas peta */
  }
</style>

<div class="container-xxl bg-primary hero-header" style="margin-bottom: -0px;">
  <div class="row" style="margin-top: -120px;">
    <div class="col-lg-3 bg-white" style="height: 794px; overflow-y: auto;padding-right: 0;">
      <div class="card shadow border-0 mb-3 rounded-0">
        <?php foreach ($views_kampung_adat as $data) {
          $num_char = 100;
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
            <div class="d-flex gap-3">
              <button href="#" class="btn btn-primary btn-sm btn-map-view" data-latitude="<?= $data['latitude'] ?>" data-longitude="<?= $data['longitude'] ?>" data-img="<?= $data['img_kampung'] ?>" data-nama="<?= $data['nama_kampung'] ?>" data-deskripsi="<?= $deskripsi ?>"><i class="bi bi-map"></i> Lihat</button>
              <a href="peta-detail?obj=<?= $data['id_kampung_adat'] ?>" class="btn btn-primary btn-sm"><i class="bi bi-eye"></i> Detail</a>
            </div>
          </div>
        <?php } ?>
      </div>
    </div>
    <div class="col-lg-9" style="padding-left: 0;">
      <div class="card shadow border-0 rounded-0">
        <div class="card-body p-0">
          <select id="mode-selector">
            <option value="driving">Driving</option>
            <option value="walking">Walking</option>
            <option value="cycling">Cycling</option>
            <option value="transit">Transit</option>
          </select>
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
              center: [124.5098773, -8.2033862],
              zoom: 10,
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

            var markers = [
              <?php foreach ($views_kampung_adat as $data) {
                $num_char = 22;
                $text = trim($data['deskripsi']);
                // Menghapus karakter non-breaking space
                $text = str_replace('&nbsp;', ' ', $text);
                // Menghapus semua tag HTML
                $text = strip_tags($text);
                $lentext = strlen($text);
                if ($lentext > $num_char) {
                  $deskripsi = substr($text, 0, $num_char) . '...';
                } else {
                  $deskripsi = substr($text, 0, $num_char);
                }
                // Encode deskripsi untuk mencegah karakter khusus menyebabkan kesalahan JavaScript
                $deskripsi_encoded = htmlspecialchars($deskripsi, ENT_QUOTES, 'UTF-8');
              ?> {
                  lngLat: [<?= $data['longitude'] ?>, <?= $data['latitude'] ?>],
                  popupContent: '<div class="popup-container"><img class="popup-image" src="../assets/img/kampung-adat/<?= $data['img_kampung'] ?>" alt="Gambar kampung <?= $data['nama_kampung'] ?> tidak ditemukan!"><h3 class="popup-title"><?= $data['nama_kampung'] ?></h3><p class="popup-description"><?= $deskripsi_encoded ?></p></div>'
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
              var modeSelector = document.getElementById('mode-selector');
              var currentPopup = null;

              // Fungsi untuk mendapatkan mode transportasi yang dipilih
              function getSelectedMode() {
                return modeSelector.value;
              }

              // Fungsi untuk mendapatkan rute dari lokasi saat ini ke lokasi tujuan
              function getRouteToDestination(currentLocation, destination, mode) {
                var url = 'https://api.mapbox.com/directions/v5/mapbox/' + mode + '/' + currentLocation[0] + ',' + currentLocation[1] + ';' + destination[0] + ',' + destination[1] + '?steps=true&geometries=geojson&access_token=' + mapboxgl.accessToken;

                fetch(url)
                  .then(function(response) {
                    return response.json();
                  })
                  .then(function(data) {
                    var route = data.routes[0].geometry;
                    var routeCoordinates = route.coordinates;

                    // Buat rute pada peta
                    map.addLayer({
                      'id': 'route',
                      'type': 'line',
                      'source': {
                        'type': 'geojson',
                        'data': {
                          'type': 'Feature',
                          'properties': {},
                          'geometry': {
                            'type': 'LineString',
                            'coordinates': routeCoordinates
                          }
                        }
                      },
                      'layout': {
                        'line-join': 'round',
                        'line-cap': 'round'
                      },
                      'paint': {
                        'line-color': '#3887be',
                        'line-width': 8
                      }
                    });
                  });
              }

              viewButtons.forEach(function(button) {
                button.addEventListener('click', function(event) {
                  event.preventDefault();

                  // Dapatkan koordinat lokasi saat ini
                  navigator.geolocation.getCurrentPosition(function(position) {
                    var currentLocation = [position.coords.longitude, position.coords.latitude];
                    var destination = [parseFloat(button.getAttribute('data-longitude')), parseFloat(button.getAttribute('data-latitude'))];
                    var selectedMode = getSelectedMode();

                    // Tambahkan rute dari lokasi saat ini ke lokasi tujuan
                    getRouteToDestination(currentLocation, destination, selectedMode);

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
                      .setHTML('<div class="popup-container"><img class="popup-image" src="assets/img/kampung-adat/' + img_kampung + '" alt="Gambar kampung ' + nama_kampung + ' tidak ditemukan!" style="width: 100%;height: 100px;"><h3 class="popup-title">' + nama_kampung + '</h3><p class="popup-description">' + deskripsi + '</p></div>')
                      .addTo(map);

                    map.flyTo({
                      center: [longitude, latitude],
                      zoom: 7,
                      essential: true
                    });
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

<?php require_once("sections/footer.php") ?>