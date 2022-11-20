<?php
  include "connect.php";
  include "functions.php";


  // Runs if the register form is submitted
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
      $stmt = $conn -> prepare("INSERT INTO players(userName, fullName, singleElo, doubleElo) values(?, ?, 1000, 1000)");
      $stmt -> bind_param("ss", $userName, $fullName);
      $stmt -> execute();
      echo "Succesfully added user " . $fullName;
    } 
    else {
      echo 'This user already exists, please choose another user name';
    }
  }

  // Runs if a singles game is submitted
  if (isset($_POST["submit-single"]))
  {
    $winner = $_POST["winner1"];
    $loser = $_POST["loser1"];
    $score1 = 10;
    $score2 = $_POST["score2"];
    $kruipen = $_POST["kruipen"];

    validateGame();
    
    // Add the game to the record
    $stmt = $conn -> prepare("INSERT INTO single_games(winner, loser, winnerScore, loserScore, kruipen) VALUES(?, ?, ?, ?, ?)");
    $stmt -> bind_param("ssids", $winner, $loser, $score1, $score2, $kruipen);
    $stmt -> execute();

    echo "Successfully submitted game!";

    updateSinglesELO($winner, $loser);
  }

  // Runs if a doubles game is submitted
  if (isset($_POST["submit-double"]))
  {
    $winner1 = $_POST["winner1"];
    $winner2 = $_POST["winner2"];
    $loser1 = $_POST["loser1"];
    $loser2 = $_POST["loser2"];
    $score1 = 10;
    $score2 = $_POST["score2"];
    $kruipen = $_POST["kruipen"];
    
    validateGame();

    // Add the game to the record
    $stmt = $conn -> prepare("INSERT INTO double_games(winner1, winner2, loser1, loser2, winnerScore, loserScore, kruipen) VALUES(?, ?, ?, ?, ?, ?, ?)");
    $stmt -> bind_param("ssssids", $winner1, $winner2, $loser1, $loser2, $score1, $score2, $kruipen);
    $stmt -> execute();

    echo "Successfully submitted game!";

    updateDoublesELO($winner1, $winner2, $loser1, $loser2);
  }

  // Runs if singleELOs are to be recalculated
  if (isset($_POST["recalc_single"]))
  {
    if ($_POST["passcode"] != 1234)
    {
      echo "This is not the correct passcode, please try again";
      exit();
    }

    // Reinitializes the ELOs back to 1000
    initializeELOs("single");

    // Loop through the games and update ELOs
    $query = $conn -> prepare("SELECT * FROM single_games");
    $query -> execute();
    $result = $query -> get_result();

    while ($row = mysqli_fetch_array($result)) 
    {
      updateSinglesELO($row["winner"], $row["loser"]);
    }
    echo "Successfully recalculated single ELOs";
  }

  // Runs if doubleELOs are to be recalculated
  if (isset($_POST["recalc_double"]))
  {
    if ($_POST["passcode"] != 1234)
    {
      echo "This is not the correct passcode, please try again";
      exit();
    }

    // Reinitializes the ELOs back to 1000
    initializeELOs("double");

    // Loop through the games and update ELOs
    $query = $conn -> prepare("SELECT * FROM double_games");
    $query -> execute();
    $result = $query -> get_result();

    while ($row = mysqli_fetch_array($result))
    {
      updateDoublesELO($row["winner1"], $row["winner2"], $row["loser1"], $row["loser2"]);
    }
    echo "Successfully recalculated double ELOs";
  }
?>