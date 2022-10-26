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

  if (isset($_POST["submit-single"]))
  {
    $winner = $_POST["winner"];
    $loser = $_POST["loser"];
    $score1 = 10;
    $score2 = ($_POST["score2"]);
    $kruipen = $_POST["kruipen"];

    if ($winner == "")
    {
      echo "Please enter a winner";
      exit();
    }
    if ($loser == "")
    {
      echo "Please enter a loser";
      exit();
    }
    if ($winner == $loser) 
    {
      echo "You played against yourself? Impressive! Please choose two different players";
      exit();
    }
    if ($score2 == "")
    {
      echo "Please enter a loser score";
      exit();
    }
    if ($kruipen == "")
    {
      echo "Please enter if someone has gekropen";
      exit();
    }
    
    // Add the game to the record
    $stmt = $conn -> prepare("INSERT INTO single_games(winner, loser, winnerScore, loserScore, kruipen) VALUES(?, ?, ?, ?, ?)");
    $stmt -> bind_param("ssiis", $winner, $loser, $score1, $score2, $kruipen);
    $stmt -> execute();

    // Add the wins/losses to the users
    $stmt = $conn -> prepare("UPDATE players SET wins = wins + 1 WHERE userName = ?");
    $stmt -> bind_param("s", $winner);
    $stmt -> execute();

    $stmt = $conn -> prepare("UPDATE players set losses = losses + 1 WHERE username = ?");
    $stmt -> bind_param("s", $loser);
    $stmt -> execute();

    // Increments kruipen stats if there is gekropen
    if ($kruipen == "yes")
    {
      $stmt = $conn -> prepare("UPDATE players SET gekropen = gekropen + 1 WHERE userName = ?");
      $stmt -> bind_param("s", $loser);
      $stmt -> execute();

      $stmt = $conn -> prepare("UPDATE players SET latenKruipen = latenKruipen + 1 WHERE userName = ?");
      $stmt -> bind_param("s", $winner);
      $stmt -> execute();
    }

    //Updates ELOs
    //Retrieves rows of players
    $stmt = $conn -> prepare("SELECT * FROM players WHERE players.userName = ? OR players.userName = ?");
    $stmt -> bind_param("ss", $winner, $loser);
    $stmt -> execute();
    $result = $stmt -> get_result();

    //Assign old winner and loser ELO
    while ($row = mysqli_fetch_array($result)) 
    {
      if ($row["userName"] == $winner)
      {
        $winnerELO = $row["elo"];
      }
      if ($row["userName"] == $loser)
      {
        $loserELO = $row["elo"];
      }
    }

    //Compute new ELOs
    $winnerNew = $winnerELO + intval(64 * (1 - getExpectation($winnerELO, $loserELO, 400)));
    $loserNew = $loserELO + intval(64 * (0 - getExpectation($loserELO, $winnerELO, 400)));

    //Update ELOs in DB
    //Update winner
    $stmt = $conn -> prepare("UPDATE players SET elo = ? WHERE userName = ?");
    $stmt -> bind_param("is", $winnerNew, $winner);
    $stmt -> execute();

    //Update loser
    $stmt = $conn -> prepare("UPDATE players SET elo = ? WHERE userName = ?");
    $stmt -> bind_param("is", $loserNew, $loser);
    $stmt -> execute();
  }

  function getExpectation($self, $other, $scaling)
  {
    return 1 / (1 + (10 ** ( ($other - $self) / $scaling)) );
  }
?>