<?php require_once("../controller/script.php");
$_SESSION["project_sig_kampung_adat_kabupaten_alor"]["name_page"] = "Fasilitas Kampung Adat";
require_once("../templates/views_top.php"); ?>

<!-- Begin Page Content -->
<div class="container-fluid">

  <!-- Page Heading -->
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800"><?= $_SESSION["project_sig_kampung_adat_kabupaten_alor"]["name_page"] ?></h1>
  </div>

  <div class="card shadow mb-4 border-0">
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered text-dark" id="dataTable" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th class="text-center">Nama kampung</th>
              <th class="text-center">Fasilitas</th>
              <th class="text-center">Aksi</th>
            </tr>
          </thead>
          <tfoot>
            <tr>
              <th class="text-center">Nama kampung</th>
              <th class="text-center">Fasilitas</th>
              <th class="text-center">Aksi</th>
            </tr>
          </tfoot>
          <tbody>
            <?php foreach ($views_kampung_adat as $data) { ?>
              <tr>
                <td><?= $data['nama_kampung'] ?></td>
                <td>
                  <?php $id_ka = $data['id_kampung_adat'];
                  $check_ka = "SELECT * FROM fasilitas_ka JOIN kategori_fasilitas ON fasilitas_ka.id_kf=kategori_fasilitas.id_kf WHERE fasilitas_ka.id_kampung_adat='$id_ka'";
                  $take_ka = mysqli_query($conn, $check_ka);
                  foreach ($take_ka as $data_ka) {
                    echo $data_ka['nama_kf'] . "<br>";
                  }
                  ?>
                </td>
                <td class="text-center">
                  <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#ubah<?= $data['id_kampung_adat'] ?>">
                    <i class="bi bi-pencil-square"></i> Ubah
                  </button>
                  <div class="modal fade" id="ubah<?= $data['id_kampung_adat'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header border-bottom-0 shadow">
                          <h5 class="modal-title" id="exampleModalLabel">Ubah Fasilitas <?= $data['nama_kampung'] ?></h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <form action="" method="post">
                          <input type="hidden" name="id_kampung_adat" value="<?= $data['id_kampung_adat'] ?>">
                          <input type="hidden" name="nama_kampung" value="<?= $data['nama_kampung'] ?>">
                          <div class="modal-body text-left">
                            <p>Pilih Fasilitas Kampung</p>
                            <?php foreach ($views_kategori_fasilitas as $data_kf) : ?>
                              <div class="form-group">
                                <div class="custom-control custom-checkbox">
                                  <input type="checkbox" name="id_kf[]" value="<?= $data_kf['id_kf'] ?>" class="custom-control-input" id="id_kf<?= $data['id_kampung_adat'] . $data_kf['id_kf'] ?>">
                                  <label class="custom-control-label" for="id_kf<?= $data['id_kampung_adat'] . $data_kf['id_kf'] ?>"><?= $data_kf['nama_kf'] ?></label>
                                </div>
                              </div>
                            <?php endforeach; ?>
                          </div>
                          <div class="modal-footer justify-content-center border-top-0">
                            <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Batal</button>
                            <button type="submit" name="edit_fasilitas_ka" class="btn btn-warning btn-sm">Ubah</button>
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