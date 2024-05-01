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