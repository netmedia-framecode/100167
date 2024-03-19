<?php if (!isset($_SESSION)) {
  session_start();
}
require_once("../controller/script.php");
if (isset($_SESSION["project_sig_kampung_adat_kabupaten_alor"])) {
  unset($_SESSION["project_sig_kampung_adat_kabupaten_alor"]);
  header("Location: ./");
  exit();
}
