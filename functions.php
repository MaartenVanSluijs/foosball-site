<?php

  include "connect.php";

  if (isset($_POST["register"]))
  {
    $userName = $_POST["username"];
    $fullName = $_POST["fullname"];

    if (strlen($userName) == 0) 
    {
      echo "Please enter a user name";
      exit();
    }
    if (strlen($fullName) == 0)
    {
      echo "Please enter your full name";
      exit();
    }

    $query = $conn -> prepare("SELECT * FROM players WHERE players.userName = ? OR players.fullName = ?");
    $query -> bind_param("ss", $userName, $fullName);
    $query -> execute();

    $result = $query -> get_result();
    
    if (mysqli_num_rows($result) == 0) 
    {
      $stmt = $conn -> prepare("INSERT INTO players(userName, fullName, elo, wins, losses, latenKruipen, gekropen) values(?, ?, 1000, 0, 0, 0, 0)");
      $stmt -> bind_param("ss", $userName, $fullName);
      $stmt -> execute();
      echo "Succesfully added user " . $fullName;
    } 
    else {
      echo 'This user already exists, please choose another user name';
    }
  }
?>