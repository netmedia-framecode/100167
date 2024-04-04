<?php require_once("../controller/script.php");
$_SESSION["project_sig_kampung_adat_kabupaten_alor"]["name_page"] = "Kunjungan";
require_once("../templates/views_top.php"); ?>

<!-- Begin Page Content -->
<div class="container-fluid">

  <!-- Page Heading -->
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800"><?= $_SESSION["project_sig_kampung_adat_kabupaten_alor"]["name_page"] ?></h1>
    <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" data-toggle="modal" data-target="#tambah"><i class="bi bi-plus-lg"></i> Tambah</a>
  </div>

  <div class="card shadow mb-4 border-0">
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered text-dark" id="dataTable" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th class="text-center">Kampung</th>
              <th class="text-center">Jumlah Kunjungan</th>
              <th class="text-center">Tanggal</th>
              <th class="text-center">Aksi</th>
            </tr>
          </thead>
          <tfoot>
            <tr>
              <th class="text-center">Kampung</th>
              <th class="text-center">Jumlah Kunjungan</th>
              <th class="text-center">Tanggal</th>
              <th class="text-center">Aksi</th>
            </tr>
          </tfoot>
          <tbody>
            <?php foreach ($views_kunjungan as $data) { ?>
              <tr>
                <td><?= $data['nama_kampung'] ?></td>
                <td><?= $data['jumlah_kunjungan'] ?></td>
                <td><?php $tgl = date_create($data["tgl"]);
                    echo date_format($tgl, "d M Y"); ?></td>
                <td class="text-center">
                  <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#ubah<?= $data['id_kunjungan'] ?>">
                    <i class="bi bi-pencil-square"></i> Ubah
                  </button>
                  <div class="modal fade" id="ubah<?= $data['id_kunjungan'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header border-bottom-0 shadow">
                          <h5 class="modal-title" id="exampleModalLabel">Ubah <?= $data['nama_kampung'] ?></h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <form action="" method="post">
                          <input type="hidden" name="id_kunjungan" value="<?= $data['id_kunjungan'] ?>">
                          <input type="hidden" name="nama_kampung" value="<?= $data['nama_kampung'] ?>">
                          <div class="modal-body">
                            <div class="form-group">
                              <label for="id_kampung_adat">Kampung Adat</label>
                              <select name="id_kampung_adat" class="form-control" id="id_kampung_adat" required>
                                <?php $id_kampung_adat = $data['id_kampung_adat'];
                                foreach ($views_kampung_adat as $data_ka) {
                                  $selected = ($data_ka['id_kampung_adat'] == $id_kampung_adat) ? 'selected' : ''; ?>
                                  <option value="<?= $data_ka['id_kampung_adat'] ?>" <?= $selected ?>><?= $data_ka['nama_kampung'] ?></option>
                                <?php } ?>
                              </select>
                            </div>
                            <div class="form-group">
                              <label for="jumlah_kunjungan">Jumlah Kunjungan <small class="text-danger">*</small></label>
                              <input type="number" name="jumlah_kunjungan" value="<?= $data['jumlah_kunjungan'] ?>" class="form-control" id="jumlah_kunjungan" required>
                            </div>
                          </div>
                          <div class="modal-footer justify-content-center border-top-0">
                            <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Batal</button>
                            <button type="submit" name="edit_kunjungan" class="btn btn-warning btn-sm">Ubah</button>
                          </div>
                        </form>
                      </div>
                    </div>
                  </div>
                  <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#hapus<?= $data['id_kunjungan'] ?>">
                    <i class="bi bi-trash3"></i> Hapus
                  </button>
                  <div class="modal fade" id="hapus<?= $data['id_kunjungan'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header border-bottom-0 shadow">
                          <h5 class="modal-title" id="exampleModalLabel">Hapus <?= $data['nama_kampung'] ?></h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <form action="" method="post">
                          <input type="hidden" name="id_kunjungan" value="<?= $data['id_kunjungan'] ?>">
                          <input type="hidden" name="nama_kampung" value="<?= $data['nama_kampung'] ?>">
                          <div class="modal-body">
                            <p>Jika anda yakin ingin menghapus data kunjungan kampung <?= $data['nama_kampung'] ?> klik Hapus!</p>
                          </div>
                          <div class="modal-footer justify-content-center border-top-0">
                            <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Batal</button>
                            <button type="submit" name="delete_kunjungan" class="btn btn-danger btn-sm">hapus</button>
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

  <div class="modal fade" id="tambah" tabindex="-1" aria-labelledby="tambahLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header border-bottom-0 shadow">
          <h5 class="modal-title" id="tambahLabel">Tambah Kunjungan</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="" method="post">
          <div class="modal-body">
            <div class="form-group">
              <label for="id_kampung_adat">Kampung Adat</label>
              <select name="id_kampung_adat" class="form-control" id="id_kampung_adat" required>
                <option value="" selected>Pilih Kampung Adat</option>
                <?php foreach ($views_kampung_adat as $data_ka) { ?>
                  <option value="<?= $data_ka['id_kampung_adat'] ?>"><?= $data_ka['nama_kampung'] ?></option>
                <?php } ?>
              </select>
            </div>
            <div class="form-group">
              <label for="jumlah_kunjungan">Jumlah Kunjungan <small class="text-danger">*</small></label>
              <input type="number" name="jumlah_kunjungan" class="form-control" id="jumlah_kunjungan" required>
            </div>
          </div>
          <div class="modal-footer justify-content-center border-top-0">
            <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Batal</button>
            <button type="submit" name="add_kunjungan" class="btn btn-primary btn-sm">Tambah</button>
          </div>
        </form>
      </div>
    </div>
  </div>

</div>
<!-- /.container-fluid -->

<?php require_once("../templates/views_bottom.php") ?>