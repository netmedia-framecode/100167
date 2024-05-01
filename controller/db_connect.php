<?php
// $conn=mysqli_connect("localhost","zjxtorpv_client","Netmedia040700_","zjxtorpv_100167");
$conn = mysqli_connect("localhost", "root", "Netmedia040700_", "sig_kampung_adat_kabupaten_alor");
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
