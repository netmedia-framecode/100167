<?php
if (!isset($_SESSION["project_sig_kampung_adat_kabupaten_alor"]["users"])) {
  header("Location: ../auth/");
  exit;
}
