<?php
$conn = mysqli_connect("localhost", "root", "", "sig_kampung_adat_kabupaten_alor");
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
