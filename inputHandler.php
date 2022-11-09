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
    $stmt -> bind_param("ssiis", $winner, $loser, $score1, $score2, $kruipen);
    $stmt -> execute();

    echo "Successfully submitted game!";

    //Updates ELOs
    //Retrieves rows of players
    $stmt = $conn -> prepare("SELECT * FROM players WHERE players.userName = ? OR players.userName = ?");
    $stmt -> bind_param("ss", $winner, $loser);
    $stmt -> execute();
    $result = $stmt -> get_result();

    //Assign old winner and loser ELO
    while ($row = mysqli_fetch_array($result)) 
    {
      switch($row["userName"])
      {
        case $winner:
          $winnerELO = $row["singleElo"];
          break;
        case $loser:
          $loserELO = $row["singleElo"];
          break;
      }
    }

    //Compute new ELOs
    $winnerNew = $winnerELO + intval(64 * (1 - getExpectation($winnerELO, $loserELO, 400)));
    $loserNew = $loserELO + intval(64 * (0 - getExpectation($loserELO, $winnerELO, 400)));

    //Update ELOs in DB
    $stmt = $conn -> prepare("UPDATE players SET singleElo = CASE WHEN userName = ? THEN ? WHEN userName = ? THEN ? ELSE singleElo END");
    $stmt -> bind_param("sisi", $winner, $winnerNew, $loser, $loserNew);
    $stmt -> execute();
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
    $stmt -> bind_param("ssssiis", $winner1, $winner2, $loser1, $loser2, $score1, $score2, $kruipen);
    $stmt -> execute();

    echo "Successfully submitted game!";

    // Retrieve current ELOs from players table
    $stmt = $conn -> prepare("SELECT * FROM players WHERE players.userName = ? OR players.userName = ? OR players.userName = ? OR players.userName = ?");
    $stmt -> bind_param("ssss", $winner1, $winner2, $loser1, $loser2);
    $stmt -> execute();
    $result = $stmt -> get_result();

    //Assign current winners and losers ELOs
    while ($row = mysqli_fetch_array($result)) 
    {
      switch($row["userName"])
      {
        case $winner1:
          $winner1ELO = $row["doubleElo"];
          break;
        case $winner2:
          $winner2ELO = $row["doubleElo"];
          break;
        case $loser1:
          $loser1ELO = $row["doubleElo"];
          break;
        case $loser2:
          $loser2ELO = $row["doubleElo"];
          break;
      }
    }

    // Compute average ELO scores per team
    $winnersELO = ($winner1ELO + $winner2ELO) / 2;
    $losersELO = ($loser1ELO + $loser2ELO) / 2;

    // Compute new ELO scores per person
    $winner1New = $winner1ELO + intval(64 * (1 - getExpectation($winnersELO, $losersELO, 400)));
    $winner2New = $winner2ELO + intval(64 * (1 - getExpectation($winnersELO, $losersELO, 400)));
    $loser1New = $loser1ELO + intval(64 * (0 - getExpectation($losersELO, $winnersELO, 400)));
    $loser2New = $loser2ELO + intval(64 * (0 - getExpectation($losersELO, $winnersELO, 400)));

    // Update ELOs in the DB
    $stmt = $conn -> prepare("UPDATE players SET doubleElo = CASE 
                              WHEN userName = ? THEN ? 
                              WHEN userName = ? THEN ? 
                              WHEN userName = ? THEN ? 
                              WHEN userName = ? THEN ? 
                              ELSE doubleElo END");
    $stmt -> bind_param("sisisisi", $winner1, $winner1New, 
                                    $winner2, $winner2New,
                                    $loser1, $loser1New,
                                    $loser2, $loser2New);
    $stmt -> execute();
  }

  // Runs if singleELOs are to be recalculated
  if (isset($_POST["recalc_single"]))
  {
    if ($_POST["passcode"] != 1234)
    {
      echo "This is not the correct passcode, please try again";
      exit();
    }

    
  }
?>