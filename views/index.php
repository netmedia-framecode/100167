<?php require_once("../controller/script.php");
$_SESSION["project_sig_kampung_adat_kabupaten_alor"]["name_page"] = "";
require_once("../templates/views_top.php");
ini_set('display_errors', 0); ?>

<!-- Begin Page Content -->
<div class="container-fluid">

  <!-- Page Heading -->
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
  </div>

  <?php if ($id_role == 1) { ?>
    <div class="row">

      <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2" onclick="window.location.href='users'" style="cursor: pointer;">
          <div class="card-body">
            <div class="row no-gutters align-items-center">
              <div class="col mr-2">
                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                  Users</div>
                <div class="h5 mb-0 font-weight-bold text-gray-800"><?= mysqli_num_rows($views_users) ?></div>
              </div>
              <div class="col-auto">
                <i class="bi bi-people fa-2x"></i>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2" onclick="window.location.href='list-kampung'" style="cursor: pointer;">
          <div class="card-body">
            <div class="row no-gutters align-items-center">
              <div class="col mr-2">
                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                  Kampung Adat</div>
                <div class="h5 mb-0 font-weight-bold text-gray-800"><?= mysqli_num_rows($views_kampung_adat) ?></div>
              </div>
              <div class="col-auto">
                <i class="bi bi-geo fa-2x"></i>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2" onclick="window.location.href='kunjungan'" style="cursor: pointer;">
          <div class="card-body">
            <div class="row no-gutters align-items-center">
              <div class="col mr-2">
                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                  Kunjungan</div>
                <div class="h5 mb-0 font-weight-bold text-gray-800"><?= mysqli_num_rows($views_kunjungan) ?></div>
              </div>
              <div class="col-auto">
                <i class="bi bi-pin-map fa-2x"></i>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2" onclick="window.location.href='kontak'" style="cursor: pointer;">
          <div class="card-body">
            <div class="row no-gutters align-items-center">
              <div class="col mr-2">
                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                  Kontak</div>
                <div class="h5 mb-0 font-weight-bold text-gray-800"><?= mysqli_num_rows($views_kontak) ?></div>
              </div>
              <div class="col-auto">
                <i class="bi bi-chat-left-dots fa-2x"></i>
              </div>
            </div>
          </div>
        </div>
      </div>

    </div>
  <?php } ?>

  <div class="row">

    <div class="col-xl-8 col-lg-7">
      <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
          <h6 class="m-0 font-weight-bold text-primary">Grafik Kunjungan Kampung Adat</h6>
        </div>
        <div class="card-body">
          <div class="chart-area">
            <canvas id="myAreaChart"></canvas>
            <?php
            $currentYear = date('Y');
            $sql = "SELECT kampung_adat.nama_kampung as category, MONTH(kunjungan.tgl) as month, SUM(kunjungan.jumlah_kunjungan) as total FROM kunjungan JOIN kampung_adat ON kunjungan.id_kampung_adat=kampung_adat.id_kampung_adat WHERE YEAR(kunjungan.tgl) = $currentYear AND MONTH(kunjungan.tgl) BETWEEN 1 AND 12 GROUP BY category, month";
            $result = $conn->query($sql);
            $dataGrafik = [];
            if ($result->num_rows > 0) {
              while ($row = $result->fetch_assoc()) {
                $namaBulan = DateTime::createFromFormat('!m', $row['month'])->format('F');
                $dataGrafik[] = [
                  'category' => $row['category'],
                  'total' => $row['total'],
                  'month' => $namaBulan,
                ];
              }
            }
            ?>
            <script>
              var dataGrafik = <?php echo json_encode($dataGrafik); ?>;
            </script>
          </div>
        </div>
      </div>
    </div>

    <div class="col-xl-4 col-lg-5">
      <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
          <h6 class="m-0 font-weight-bold text-primary">List Fasilitas Kampung</h6>
        </div>
        <div class="card-body">
          <div class="chart-pie pt-4 pb-2">
            <canvas id="myPieChart"></canvas>
            <?php
            $currentYearPie = date('Y');
            $sqlPie = "SELECT kampung_adat.nama_kampung as category, COUNT(fk.id_kampung_adat) as total FROM kampung_adat 
           JOIN fasilitas_ka as fk ON kampung_adat.id_kampung_adat=fk.id_kampung_adat 
           GROUP BY kampung_adat.nama_kampung";
            $resultPie = $conn->query($sqlPie);
            $dataGrafikPie = [];
            if ($resultPie->num_rows > 0) {
              while ($rowPie = $resultPie->fetch_assoc()) {
                $dataGrafikPie[] = [
                  'category' => $rowPie['category'],
                  'total' => $rowPie['total'],
                ];
              }
            }
            ?>
            <div id="dataGrafik" style="display: none;">
              <?php echo json_encode($dataGrafikPie); ?>
            </div>
          </div>
          <div class="mt-4 text-center small">
            <?php
            $chartColors = array_column($dataGrafikPie, 'color');
            $index = 0;
            foreach ($resultPie as $rowPie) {
              $color = $chartColors[$index];
            ?>
              <span class="mr-2">
                <i class="fas fa-circle" style="color: <?= $color ?>"></i> <?= $rowPie['category'] ?>
              </span>
            <?php
              $index++;
            }
            ?>
          </div>
        </div>
      </div>
    </div>

  </div>

</div>
<!-- /.container-fluid -->

<?php require_once("../templates/views_bottom.php") ?>