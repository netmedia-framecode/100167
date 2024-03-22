<?php require_once("../controller/script.php");
$_SESSION["project_sig_kampung_adat_kabupaten_alor"]["name_page"] = "Tambah Kampung";
require_once("../templates/views_top.php"); ?>

<!-- Begin Page Content -->
<div class="container-fluid">

  <!-- Page Heading -->
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800"><?= $_SESSION["project_sig_kampung_adat_kabupaten_alor"]["name_page"] ?></h1>
  </div>

  <form action="" method="post" enctype="multipart/form-data">
    <div class="row flex-row-reverse">
      <div class="col-lg-8">
        <div class="card shadow border-0 mb-3">
          <div class="card-header shadow">
            Lokasi Kampung
          </div>
          <div class="card-body">
            <div id='map' style="width: 100%; height: 600px;"></div>
            <script>
              mapboxgl.accessToken = '<?= $accessToken ?>';
              var map = new mapboxgl.Map({
                container: 'map',
                style: 'mapbox://styles/mapbox/streets-v11',
                center: [123.8156423, -8.3315012],
                zoom: 9,
                attributionControl: false
              });

              var marker = new mapboxgl.Marker({
                  draggable: true
                })
                .setLngLat([123.8156423, -8.3315012])
                .addTo(map);

              function updateInputValues(lngLat) {
                document.getElementById('latitude').value = lngLat.lat.toFixed(6);
                document.getElementById('longitude').value = lngLat.lng.toFixed(6);
              }

              function reverseGeocode(lngLat) {
                fetch('https://api.mapbox.com/geocoding/v5/mapbox.places/' + lngLat.lng + ',' + lngLat.lat + '.json?access_token=' + mapboxgl.accessToken)
                  .then(response => response.json())
                  .then(data => {
                    if (data.features && data.features.length > 0) {
                      var placeName = data.features[0].place_name;
                      document.getElementById('lokasi').value = placeName;
                    }
                  })
                  .catch(error => console.error('Error:', error));
              }

              marker.on('dragend', function() {
                var lngLat = marker.getLngLat();
                updateInputValues(lngLat);
                reverseGeocode(lngLat);
              });

              map.on('load', function() {
                map.resize();
                updateInputValues(marker.getLngLat());
                reverseGeocode(marker.getLngLat());
              });
            </script>
          </div>
        </div>
      </div>
      <div class="col-lg-4">
        <div class="card shadow border-0">
          <div class="card-header shadow">
            Input Data
          </div>
          <div class="card-body">
            <div class="form-group">
              <label for="img_kampung">Gambar Kampung <small class="text-danger">*</small></label>
              <div class="custom-file">
                <input type="file" name="img_kampung" class="custom-file-input" id="img_kampung" required>
                <label class="custom-file-label" for="img_kampung">Pilih Gambar</label>
              </div>
            </div>
            <div class="form-group">
              <label for="nama_kampung">Nama Kampung <small class="text-danger">*</small></label>
              <input type="text" name="nama_kampung" value="" class="form-control" id="nama_kampung" required>
            </div>
            <div class="form-group">
              <label for="deskripsi">Deskripsi <small class="text-danger">*</small></label>
              <textarea name="deskripsi" class="form-control" id="deskripsi" rows="3"></textarea>
            </div>
            <div class="form-group">
              <label for="latitude">Latitude <small class="text-danger">*</small></label>
              <input type="text" name="latitude" value="" class="form-control" id="latitude" required>
            </div>
            <div class="form-group">
              <label for="longitude">Longitude <small class="text-danger">*</small></label>
              <input type="text" name="longitude" value="" class="form-control" id="longitude" required>
            </div>
            <div class="form-group">
              <label for="lokasi">Lokasi</label>
              <input type="text" name="lokasi" value="" class="form-control" id="lokasi" readonly required>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-12">
        <div class="form-group mt-3">
          <button type="submit" name="add_kampung_adat" class="btn btn-primary btn-sm shadow"><i class="bi bi-plus-lg"></i> Tambah</button>
        </div>
      </div>
    </div>
  </form>

</div>
<!-- /.container-fluid -->

<?php require_once("../templates/views_bottom.php") ?>