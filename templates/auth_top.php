<?php require_once("redirect.php"); ?>
<!DOCTYPE html>
<html lang="en">

<head>

  <?php require_once("../sections/auth_head.php") ?>

</head>

<body class="bg-gradient-primary">
  <?php foreach ($messageTypes as $type) {
    if (isset($_SESSION["project_sig_kampung_adat_kabupaten_alor"]["message_$type"])) {
      echo "<div class='message-$type' data-message-$type='{$_SESSION["project_sig_kampung_adat_kabupaten_alor"]["message_$type"]}'></div>";
    }
  } ?>

  <div class="container">
