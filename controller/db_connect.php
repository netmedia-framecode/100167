<?php
$conn = mysqli_connect("localhost", "root", "Netmedia040700_", "sig_kampung_adat_kabupaten_alor");
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
