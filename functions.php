<?php
  include "connect.php";



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
?>