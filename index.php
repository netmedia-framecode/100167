<?php require_once("controller/script.php"); ?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <title><?= $name_website ?></title>
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <meta content="" name="keywords">
  <meta content="" name="description">

  <!-- Favicon -->
  <link href="<?= $baseURL ?>assets/img/logo.png" rel="icon">

  <!-- Google Web Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500&family=Jost:wght@500;600;700&display=swap" rel="stylesheet">

  <!-- Icon Font Stylesheet -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

  <!-- Libraries Stylesheet -->
  <link href="<?= $baseURL ?>assets/lib/animate/animate.min.css" rel="stylesheet">
  <link href="<?= $baseURL ?>assets/lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">

  <!-- Customized Bootstrap Stylesheet -->
  <link href="<?= $baseURL ?>assets/css/bootstrap.min.css" rel="stylesheet">

  <!-- Template Stylesheet -->
  <link href="<?= $baseURL ?>assets/css/stylex.css" rel="stylesheet">
  <link href="<?= $baseURL ?>assets/css/scrollbar.css" rel="stylesheet">
  <script src="<?= $baseURL ?>assets/sweetalert/dist/sweetalert2.all.min.js"></script>
</head>

<body data-bs-spy="scroll" data-bs-target=".navbar" data-bs-offset="51">
  <?php foreach ($messageTypes as $type) {
    if (isset($_SESSION["project_sig_kampung_adat_kabupaten_alor"]["message_$type"])) {
      echo "<div class='message-$type' data-message-$type='{$_SESSION["project_sig_kampung_adat_kabupaten_alor"]["message_$type"]}'></div>";
    }
  } ?>
  <div class="container-xxl bg-white p-0">
    <!-- Spinner Start -->
    <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
      <div class="spinner-grow text-primary" style="width: 3rem; height: 3rem;" role="status">
        <span class="sr-only">Loading...</span>
      </div>
    </div>
    <!-- Spinner End -->

    <!-- Navbar & Hero Start -->
    <div class="container-xxl position-relative p-0" id="home">
      <nav class="navbar navbar-expand-lg navbar-light px-4 px-lg-5 py-3 py-lg-0">
        <a href="./" class="navbar-brand p-0">
          <!-- <h1 class="m-0">FitApp</h1> -->
          <img src="assets/img/logo.png" alt="Logo">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
          <span class="fa fa-bars"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
          <div class="navbar-nav mx-auto py-0">
            <a href="./" class="nav-item nav-link active">Beranda</a>
            <a href="#tentang" class="nav-item nav-link">Tentang</a>
            <a href="#kampung-adat" class="nav-item nav-link">Kampung Adat</a>
            <a href="#galeri" class="nav-item nav-link">Galeri</a>
            <a href="peta" target="_blank" class="nav-item nav-link">Peta</a>
            <a href="#contact" class="nav-item nav-link">Kontak</a>
          </div>
          <a href="auth/" class="btn btn-primary-gradient rounded-pill py-2 px-4 ms-3 d-none d-lg-block"><i class="bi bi-box-arrow-in-right"></i> Login</a>
        </div>
      </nav>

      <div class="container-xxl bg-primary hero-header">
        <div class="container px-lg-5">
          <div class="row g-5">
            <div class="col-lg-8 text-center text-lg-start">
              <h1 class="text-white mb-4 animated slideInDown">SISTEM INFORMASI GEOGRAFIS<br>KAMPUNG ADAT DI KABUPATEN ALOR</h1>
              <p class="text-white pb-3 animated slideInDown">dapat memberikan kontribusi positif dalam melestarikan budaya dan mempromosikan keberlanjutan wilayah ini, serta dapat menjaga kekayaan budaya dan alamiah yang ada di Kabupaten Alor sambil menjaga keseimbangan antara tradisi dan perkembangan modern.</p>
              <a href="#about" class="btn btn-primary-gradient py-sm-3 px-4 px-sm-5 rounded-pill me-3 animated slideInLeft">Lihat Lebih</a>
              <a href="maps" class="btn btn-secondary-gradient py-sm-3 px-4 px-sm-5 rounded-pill animated slideInRight">Maps</a>
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


    <!-- Footer Start -->
    <div class="container-fluid bg-primary text-light footer wow fadeIn" data-wow-delay="0.1s">
      <div class="container px-lg-5">
        <div class="copyright">
          <div class="row">
            <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
              Copyright &copy; <a href="https://wasd.netmedia-framecode.com" class="text-decoration-none">WASD Netmedia Framecode</a> <?= date('Y') ?> | Develop by Neang
            </div>
            <div class="col-md-6 text-center text-md-end">
              <div class="footer-menu">
                <a href="./">Home</a>
                <a href="./#tentang">Tentang</a>
                <a href="./#kampung-adat">Kampung Adat</a>
                <a href="./#galeri">Galeri</a>
                <a href="./#contact">Kontak</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Footer End -->


    <!-- Back to Top -->
    <a href="#" class="btn btn-lg btn-lg-square back-to-top pt-2"><i class="bi bi-arrow-up text-white"></i></a>
  </div>

  <!-- JavaScript Libraries -->
  <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="<?= $baseURL ?>assets/lib/wow/wow.min.js"></script>
  <script src="<?= $baseURL ?>assets/lib/easing/easing.min.js"></script>
  <script src="<?= $baseURL ?>assets/lib/waypoints/waypoints.min.js"></script>
  <script src="<?= $baseURL ?>assets/lib/counterup/counterup.min.js"></script>
  <script src="<?= $baseURL ?>assets/lib/owlcarousel/owl.carousel.min.js"></script>

  <!-- Template Javascript -->
  <script src="<?= $baseURL ?>assets/js/main.js"></script>

  <script>
    const showMessage = (type, title, message) => {
      if (message) {
        Swal.fire({
          icon: type,
          title: title,
          text: message,
        });
      }
    };

    showMessage("success", "Berhasil Terkirim", $(".message-success").data("message-success"));
    showMessage("info", "For your information", $(".message-info").data("message-info"));
    showMessage("warning", "Peringatan!!", $(".message-warning").data("message-warning"));
    showMessage("error", "Kesalahan", $(".message-danger").data("message-danger"));
  </script>
</body>

</html>