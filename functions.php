<?php

  // Checks if the entries of the form are all in order before processing
  function validateGame()
  {
    $winner = $_POST["winner1"];
    $loser = $_POST["loser1"];
    $score2 = $_POST["score2"];
    $players = array();

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

    $players[] = $winner;
    $players[] = $loser;

    if ($score2 == "")
    {
      echo "Please enter a loser score";
      exit();
    }

    if (isset($_POST["submit-double"]))
    {
      $winner2 = $_POST["winner2"];
      $loser2 = $_POST["loser2"];

      if ($winner2 == "")
      {
        echo "Please enter a second winner";
        exit();
      }
      if ($loser2 == "")
      {
        echo "Please enter a second loser";
        exit();
      }

      $players[] = $winner2;
      $players[] = $loser2;
    }

    if (count($players) != count(array_unique($players)))
    {
      echo "A person can only appear in a game once, please try again";
      exit();
    }
  }

  // Returns the expected outcome of a game
  function getExpectation($self, $other, $scaling)
  {
    return 1 / (1 + (10 ** ( ($other - $self) / $scaling)) );
  }

  // Updates singles ELO given winner and loser
  function updateSinglesELO($winner, $loser)
  {
    include "connect.php";

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

  // Updates doubles ELO given winners and losers
  function updateDoublesELO($winner1, $winner2, $loser1, $loser2)
  {
    include "connect.php";

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

  // Initializes the ELO's back to 1000, $type can take values either "single" or "double"
  function initializeELOs($type)
  {
    include "connect.php";

    switch($type)
    {
      case "single":
        $column = "singleElo";
        break;
      case "double":
        $column = "doubleElo";
        break;
    }

    // TODO: FIX DIT 
    $stmt = $conn -> prepare("UPDATE players SET {$column} = 1000");
    $stmt -> execute();
  }
?>