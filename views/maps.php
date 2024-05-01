<?php require_once("../controller/script.php");
$_SESSION["project_sig_kampung_adat_kabupaten_alor"]["name_page"] = "Maps";
require_once("../templates/views_top.php"); ?>

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

<!-- Begin Page Content -->
<div class="container-fluid">

  <!-- Page Heading -->
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800"><?= $_SESSION["project_sig_kampung_adat_kabupaten_alor"]["name_page"] ?></h1>
  </div>

  <div class="row">
    <div class="col-lg-3" style="height: 820px; overflow-y: auto;">
      <div class="card shadow border-0 mb-3">
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
          <img src="../assets/img/kampung-adat/<?= $data['img_kampung'] ?>" class="card-img-top" style="width: 100%; height: 150px; object-fit: cover;" alt="Gambar kampung <?= $data['nama_kampung'] ?> tidak ditemukan!">
          <div class="card-body">
            <h5 class="card-title"><?= $data['nama_kampung'] ?></h5>
            <p class="card-text"><?= $deskripsi ?></p>
            <a href="#" class="btn btn-primary btn-sm btn-map-view" data-latitude="<?= $data['latitude'] ?>" data-longitude="<?= $data['longitude'] ?>" data-img="<?= $data['img_kampung'] ?>" data-nama="<?= $data['nama_kampung'] ?>" data-deskripsi="<?= $deskripsi ?>"><i class="bi bi-map"></i> Lihat</a>
          </div>
        <?php } ?>
      </div>
    </div>
    <div class="col-lg-9">
      <div class="card shadow border-0">
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
<!-- /.container-fluid -->

<?php require_once("../templates/views_bottom.php") ?>