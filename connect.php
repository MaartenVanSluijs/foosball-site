<?php
  $user = 'root';
  $pass = '';
  $db = "foosball";

  $conn = new mysqli("localhost", $user, $pass, $db) or die("Unable to connect");
?>