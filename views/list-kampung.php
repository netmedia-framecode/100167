<?php require_once("../controller/script.php");
$_SESSION["project_sig_kampung_adat_kabupaten_alor"]["name_page"] = "List Kampung";
require_once("../templates/views_top.php"); ?>

<!-- Begin Page Content -->
<div class="container-fluid">

  <?php if (isset($_POST['edit'])) {
    $id = valid($conn, $_POST['id']);
    $take_data_kampung_adat = "SELECT * FROM kampung_adat WHERE id_kampung_adat='$id'";
    $views_data_kampung_adat = mysqli_query($conn, $take_data_kampung_adat);
    $data_ka = mysqli_fetch_assoc($views_data_kampung_adat);
  ?>
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
      <h1 class="h3 mb-0 text-gray-800">Ubah Kampung Adat <?= $data_ka['nama_kampung'] ?></h1>
    </div>

    <form action="" method="post" enctype="multipart/form-data">
      <input type="hidden" name="id_kampung_adat" value="<?= $data_ka['id_kampung_adat'] ?>">
      <input type="hidden" name="img_kampungOld" value="<?= $data_ka['img_kampung'] ?>">
      <input type="hidden" name="nama_kampungOld" value="<?= $data_ka['nama_kampung'] ?>">
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
                  center: [<?= $data_ka['longitude'] ?>, <?= $data_ka['latitude'] ?>],
                  zoom: 9,
                  attributionControl: false
                });

                var marker = new mapboxgl.Marker({
                    draggable: true
                  })
                  .setLngLat([<?= $data_ka['longitude'] ?>, <?= $data_ka['latitude'] ?>])
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
                <label for="img_kampung">Gambar Kampung</label>
                <div class="custom-file">
                  <input type="file" name="img_kampung" class="custom-file-input" id="img_kampung">
                  <label class="custom-file-label" for="img_kampung">Pilih Gambar</label>
                </div>
              </div>
              <div class="form-group">
                <label for="nama_kampung">Nama Kampung <small class="text-danger">*</small></label>
                <input type="text" name="nama_kampung" value="<?= $data_ka['nama_kampung'] ?>" class="form-control" id="nama_kampung" required>
              </div>
              <div class="form-group">
                <label for="deskripsi">Deskripsi <small class="text-danger">*</small></label>
                <textarea name="deskripsi" class="form-control" id="deskripsi" rows="3"><?= $data_ka['deskripsi'] ?></textarea>
              </div>
              <div class="form-group">
                <label for="latitude">Latitude <small class="text-danger">*</small></label>
                <input type="text" name="latitude" class="form-control" id="latitude" required>
              </div>
              <div class="form-group">
                <label for="longitude">Longitude <small class="text-danger">*</small></label>
                <input type="text" name="longitude" class="form-control" id="longitude" required>
              </div>
              <div class="form-group">
                <label for="lokasi">Lokasi</label>
                <input type="text" name="lokasi" class="form-control" id="lokasi" readonly required>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-12">
          <div class="form-group mt-3">
            <button type="button" class="btn btn-secondary btn-sm shadow" onclick="window.location.href='list-kampung'"><i class="bi bi-x-lg"></i> Batal</button>
            <button type="submit" name="edit_kampung_adat" class="btn btn-warning btn-sm shadow"><i class="bi bi-pencil-square"></i> Ubah</button>
          </div>
        </div>
      </div>
    </form>
    <hr>
  <?php } ?>

  <!-- Page Heading -->
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800"><?= $_SESSION["project_sig_kampung_adat_kabupaten_alor"]["name_page"] ?></h1>
    <a href="tambah-kampung" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="bi bi-plus-lg"></i> Tambah</a>
  </div>

  <div class="card shadow mb-4 border-0">
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered text-dark" id="dataTable" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th class="text-center">Gambar</th>
              <th class="text-center">Nama Kampung</th>
              <th class="text-center">Deskripsi</th>
              <th class="text-center">Lokasi</th>
              <th class="text-center">Latitude</th>
              <th class="text-center">Longitude</th>
              <th class="text-center">Tgl buat</th>
              <th class="text-center">Tgl ubah</th>
              <th class="text-center">Aksi</th>
            </tr>
          </thead>
          <tfoot>
            <tr>
              <th class="text-center">Gambar</th>
              <th class="text-center">Nama Kampung</th>
              <th class="text-center">Deskripsi</th>
              <th class="text-center">Lokasi</th>
              <th class="text-center">Latitude</th>
              <th class="text-center">Longitude</th>
              <th class="text-center">Tgl buat</th>
              <th class="text-center">Tgl ubah</th>
              <th class="text-center">Aksi</th>
            </tr>
          </tfoot>
          <tbody>
            <?php foreach ($views_kampung_adat as $data) { ?>
              <tr>
                <td><img src="../assets/img/kampung-adat/<?= $data['img_kampung'] ?>" style="width: 200px; height: 200px; object-fit: cover;" alt="Gambar kampung <?= $data['nama_kampung'] ?> tidak ditemukan!"></td>
                <td><?= $data['nama_kampung'] ?></td>
                <td><?php $num_char = 47;
                    $text = trim($data['deskripsi']);
                    $text = preg_replace('#</?strong.*?>#is', '', $text);
                    $lentext = strlen($text);
                    if ($lentext > $num_char) {
                      echo substr($text, 0, $num_char) . '...'; ?>
                    <button type="button" class="btn btn-link btn-sm" data-toggle="modal" data-target="#deskripsi<?= $data['id_kampung_adat'] ?>">
                      <i class="bi bi-eye"></i> lihat
                    </button>
                    <div class="modal fade" id="deskripsi<?= $data['id_kampung_adat'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header border-bottom-0 shadow">
                            <h5 class="modal-title" id="exampleModalLabel">Deskripsi <?= $data['nama_kampung'] ?></h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-body">
                            <?= $data['deskripsi'] ?>
                          </div>
                        </div>
                      </div>
                    </div>
                  <?php } else if ($lentext <= $num_char) {
                      echo substr($text, 0, $num_char);
                    } ?>
                </td>
                <td><?= $data['lokasi'] ?></td>
                <td><?= $data['latitude'] ?></td>
                <td><?= $data['longitude'] ?></td>
                <td>
                  <span class="badge badge-success">
                    <?php $created_at = date_create($data["created_at"]);
                    $dayNameEnglish = date_format($created_at, "l");
                    $dayNameIndonesian = $dayNames[$dayNameEnglish];

                    $monthNameEnglish = date_format($created_at, "F");
                    $monthNameIndonesian = $monthNames[$monthNameEnglish];

                    echo $dayNameIndonesian . ', ' . date_format($created_at, "d") . ' ' . $monthNameIndonesian . ' ' . date_format($created_at, "Y");  ?>
                  </span>
                </td>
                <td>
                  <span class="badge badge-warning">
                    <?php $updated_at = date_create($data["updated_at"]);
                    $dayNameEnglish = date_format($updated_at, "l");
                    $dayNameIndonesian = $dayNames[$dayNameEnglish];

                    $monthNameEnglish = date_format($updated_at, "F");
                    $monthNameIndonesian = $monthNames[$monthNameEnglish];

                    echo $dayNameIndonesian . ', ' . date_format($updated_at, "d") . ' ' . $monthNameIndonesian . ' ' . date_format($updated_at, "Y"); ?>
                  </span>
                </td>
                <td class="text-center">
                  <form action="" method="post">
                    <input type="hidden" name="id" value="<?= $data['id_kampung_adat'] ?>">
                    <button type="submit" name="edit" class="btn btn-warning btn-sm">
                      <i class="bi bi-pencil-square"></i> Ubah
                    </button>
                  </form>
                  <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#hapus<?= $data['id_kampung_adat'] ?>">
                    <i class="bi bi-trash3"></i> Hapus
                  </button>
                  <div class="modal fade" id="hapus<?= $data['id_kampung_adat'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header border-bottom-0 shadow">
                          <h5 class="modal-title" id="exampleModalLabel">Hapus <?= $data['nama_kampung'] ?></h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <form action="" method="post">
                          <input type="hidden" name="id_kampung_adat" value="<?= $data['id_kampung_adat'] ?>">
                          <input type="hidden" name="nama_kampungOld" value="<?= $data['nama_kampung'] ?>">
                          <div class="modal-body">
                            <p>Jika anda yakin ingin menghapus <?= $data['nama_kampung'] ?> klik Hapus!</p>
                          </div>
                          <div class="modal-footer justify-content-center border-top-0">
                            <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Batal</button>
                            <button type="submit" name="delete_kampung_adat" class="btn btn-danger btn-sm">hapus</button>
                          </div>
                        </form>
                      </div>
                    </div>
                  </div>
                </td>
              </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>

</div>
<!-- /.container-fluid -->

<?php require_once("../templates/views_bottom.php") ?>