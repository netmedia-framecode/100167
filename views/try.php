<?php require_once("../controller/script.php"); ?>

<script src='https://api.mapbox.com/mapbox-gl-js/v2.6.1/mapbox-gl.js'></script>
<link href='https://api.mapbox.com/mapbox-gl-js/v2.6.1/mapbox-gl.css' rel='stylesheet' />

<div class="card shadow border-0 mb-3">
  <div class="card-body p-0">
    <div id='map' style="width: 100%; height: 550px;"></div>
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
        height: auto;
        margin-bottom: 10px;
      }

      .popup-description {
        font-size: 14px;
        line-height: 1.5;
      }
    </style>
    <!-- Kontrol untuk mengubah model peta -->
    <div id='map-menu' class='map-overlay'>
      <input id='streets-v11' type='radio' name='rtoggle' value='streets' checked='checked'>
      <label for='streets'>Jalan</label>
      <input id='satellite-v9' type='radio' name='rtoggle' value='satellite'>
      <label for='satellite'>Satelit</label>
      <input id='outdoors-v11' type='radio' name='rtoggle' value='outdoors'>
      <label for='outdoors'>Outdoor</label>
      <input id='light-v10' type='radio' name='rtoggle' value='light'>
      <label for='light'>Cahaya</label>
      <input id='dark-v10' type='radio' name='rtoggle' value='dark'>
      <label for='dark'>Gelap</label>
    </div>
    <script>
      mapboxgl.accessToken = '<?= $accessToken ?>';
      var map = new mapboxgl.Map({
        container: 'map',
        style: 'mapbox://styles/mapbox/streets-v11', // Model peta awal (jalan)
        center: [123.8156423, -8.3315012],
        zoom: 9,
        attributionControl: false
      });

      // Tambahkan kontrol zoom
      map.addControl(new mapboxgl.NavigationControl());

      // Tambahkan kontrol untuk mengubah model peta
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
            popupContent: '<div class="popup-container"><img class="popup-image" src="../assets/img/kampung-adat/<?= $data['img_kampung'] ?>"><h3 class="popup-title"><?= $data['nama_kampung'] ?></h3><p class="popup-description"><?= $deskripsi ?></p></div>'
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
  </div>
</div>