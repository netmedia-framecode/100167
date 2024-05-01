<?php

require_once("controller/script.php");
require_once("sections/head.php");

?>

<div class="container-xxl bg-primary hero-header">
  <div class="container px-lg-5">
    <div class="row g-5">
      <div class="col-lg-8 text-center text-lg-start">
        <h1 class="text-white mb-4 animated slideInDown">SISTEM INFORMASI GEOGRAFIS<br>KAMPUNG ADAT DI KABUPATEN ALOR</h1>
        <p class="text-white pb-3 animated slideInDown">dapat memberikan kontribusi positif dalam melestarikan budaya dan mempromosikan keberlanjutan wilayah ini, serta dapat menjaga kekayaan budaya dan alamiah yang ada di Kabupaten Alor sambil menjaga keseimbangan antara tradisi dan perkembangan modern.</p>
        <a href="#tentang" class="btn btn-primary-gradient py-sm-3 px-4 px-sm-5 rounded-pill me-3 animated slideInLeft">Lihat Lebih</a>
        <a href="peta" class="btn btn-secondary-gradient py-sm-3 px-4 px-sm-5 rounded-pill animated slideInRight">Maps</a>
      </div>
      <div class="col-lg-4 d-flex justify-content-center justify-content-lg-end wow fadeInUp" data-wow-delay="0.3s">
        <div class="owl-carousel screenshot-carousel">
          <?php foreach ($views_galeri as $data_galeri) { ?>
            <img class="img-fluid" src="assets/img/<?= $data_galeri['image'] ?>" style="width: 100%;object-fit: cover;border-radius: 10px;" alt="">
          <?php } ?>
        </div>
      </div>
    </div>
  </div>
</div>
</div>
<!-- Navbar & Hero End -->

<!-- About Start -->
<div class="container-xxl py-5" id="tentang">
  <div class="container py-5 px-lg-5">
    <div class="row g-5 align-items-center">
      <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.1s">
        <h5 class="text-primary-gradient fw-medium">Tentang</h5>
        <h1 class="mb-4">KAMPUNG ADAT DI KABUPATEN ALOR</h1>
        <?php if (mysqli_num_rows($views_tentang) > 0) {
          while ($data_tentang = mysqli_fetch_assoc($views_tentang)) {
            echo $data_tentang['deskripsi'] ?>
        <?php }
        } ?>
        <div class="row g-4 mb-4">
          <div class="col-sm-6 wow fadeIn" data-wow-delay="0.5s">
            <div class="d-flex">
              <i class="fas fa-map-marked-alt fa-2x text-primary-gradient flex-shrink-0 mt-1"></i>
              <div class="ms-3">
                <h2 class="mb-0" data-toggle="counter-up"><?= mysqli_num_rows($views_kampung_adat) ?></h2>
                <p class="text-primary-gradient mb-0">Jumlah Kampung Adat</p>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-6">
        <img class="img-fluid wow fadeInUp" data-wow-delay="0.5s" src="assets/img/about.png">
      </div>
    </div>
  </div>
</div>
<!-- About End -->

<!-- Features Start -->
<div class="container-xxl py-5" id="kampung-adat">
  <div class="container py-5 px-lg-5">
    <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
      <h5 class="text-primary-gradient fw-medium">Daftar</h5>
      <h1 class="mb-5">Kampung Adat</h1>
    </div>
    <div class="row g-4">
      <?php foreach ($views_kampung_adat as $data_ka) {
        $num_char = 47;
        $text = trim($data_ka['deskripsi']);
        $text = strip_tags(preg_replace('#</?strong.*?>#is', '', $text));
        $lentext = strlen($text);
        if ($lentext > $num_char) {
          $deskripsi = substr($text, 0, $num_char) . '...';
        } else if ($lentext <= $num_char) {
          $deskripsi = substr($text, 0, $num_char);
        } ?>
        <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
          <div class="feature-item bg-light rounded p-4">
            <div class="d-inline-flex align-items-center justify-content-center bg-primary-gradient rounded-circle mb-4" style="width: 60px; height: 60px;">
              <i class="fas fa-map-marked-alt text-white fs-4"></i>
            </div>
            <h5 class="mb-3"><?= $data_ka['nama_kampung'] ?></h5>
            <p class="m-0"><?= $deskripsi ?></p>
          </div>
        </div>
      <?php } ?>
    </div>
  </div>
</div>
<!-- Features End -->

<!-- Testimonial Start -->
<div class="container-xxl py-5" id="galeri">
  <div class="container py-5 px-lg-5">
    <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
      <h1 class="mb-5">Galeri</h1>
    </div>
    <div class="owl-carousel testimonial-carousel wow fadeInUp" data-wow-delay="0.1s">
      <?php foreach ($views_galeri as $data_galeri) { ?>
        <div class="testimonial-item rounded p-4">
          <div class="d-flex align-items-center mb-4">
            <img class="img-fluid bg-white rounded flex-shrink-0 p-1" src="assets/img/<?= $data_galeri['image'] ?>" style="width: 100%; height: 200px; object-fit: cover;">
          </div>
          <?= $data_galeri['ket'] ?>
        </div>
      <?php } ?>
    </div>
  </div>
</div>
<!-- Testimonial End -->

<!-- Contact Start -->
<div class="container-xxl py-5" id="contact">
  <div class="container py-5 px-lg-5">
    <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
      <h1 class="mb-5">Kontak</h1>
    </div>
    <div class="row justify-content-center">
      <div class="col-lg-9">
        <div class="wow fadeInUp" data-wow-delay="0.3s">
          <p class="text-center mb-4">Kirimkan pesan kamu kepada kami untuk mendapatkan info lebih lengkap tentang kampung adat di Kabupaten Alor.</p>
          <form action="" method="post">
            <div class="row g-3">
              <div class="col-md-6">
                <div class="form-floating">
                  <input type="text" name="nama" class="form-control" id="nama" placeholder="Nama" required>
                  <label for="nama">Nama</label>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-floating">
                  <input type="email" name="email" class="form-control" id="email" placeholder="Email" required>
                  <label for="email">Email</label>
                </div>
              </div>
              <div class="col-12">
                <div class="form-floating">
                  <input type="number" name="phone" class="form-control" id="phone" placeholder="No. Handphone" required>
                  <label for="phone">No. Handphone</label>
                </div>
              </div>
              <div class="col-12">
                <div class="form-floating">
                  <textarea class="form-control" name="pesan" placeholder="Tinggalkan pesan di sini" id="pesan" style="height: 150px" required></textarea>
                  <label for="pesan">Pesan</label>
                </div>
              </div>
              <div class="col-12 text-center">
                <button class="btn btn-primary-gradient rounded-pill py-3 px-5" type="submit" name="add_kontak">Kirim Pesan</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- Contact End -->

<?php require_once("sections/footer.php") ?>