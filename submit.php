<?php
  include "connect.php";
  include "inputHandler.php";
  $loserScores = array(0, 0.5, 1, 1.5, 2, 2.5, 3, 3.5, 4, 4.5, 5, 5.5, 6, 6.5, 7, 7.5, 8, 8.5, 9);
?>

<!DOCTYPE html>
<html lang="nl">
<head>
<link rel="stylesheet" type="text/css" href="css.css">
<title>Foosball rankings website</title>
<link rel="shortcut icon" href="Intermate_roster.png">
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<html>

  <!-- Button for redicrecting to index.php -->
  <button onclick="location.href = '/foosball-site/index.php';" id="indexRedirect">Press this to return to the home page</button>

  <!-- Form for submitting a single game -->
  <form method="post">
      <h1>Singles game: </h1>
      <h2 for="winner">Winner:</h2>
      <select name="winner1" id="winner">
        <option value="" selected>-=+=-</option>
        <?php
          $query = $conn -> prepare("SELECT * FROM players");
          $query -> execute();
          $result = $query -> get_result();

          while ($row = mysqli_fetch_array($result)) 
          {
            ?>
            <option value="<?=$row['userName']?>"><?=$row['fullName']?></option>
            <?php
          }
        ?>


      </select>
      <h2 for="loser">Loser:</h2>
      <select name="loser1" id="loser">

        <option value="" selected>-=+=-</option>
          <?php
            $query = $conn -> prepare("SELECT * FROM players");
            $query -> execute();
            $result = $query -> get_result();

            while ($row = mysqli_fetch_array($result)) 
            {
              ?>
              <option value="<?=$row['userName']?>"><?=$row['fullName']?></option>
              <?php
            }
          ?>
      </select>

      <h2 for="score1">Score winner:</h2>
      <select name="score1" id="score1">
        <option name=10 disabled selected>10</option>
      </select>

      <h2 for="score2">Score loser:</h2>
      <select id="score2" name="score2">
        <option value="" selected>-=+=-</option>
          <?php
            foreach ($loserScores as $value) 
            {
              ?>
              <option value="<?=$value?>"><?=$value?></option>
              <?php
            }
          ?>
      </select>

      <h2 for="kruipen">Did the loser have to crawl? </h2>
      <select name="kruipen" id="kruipen">
        <option value="yes">Yes</option>
        <option value="no" selected>No</option>
      </select>

      <input type="submit" value="Submit" name="submit-single">
  </form>

  <!-- Form for submitting a doubles game -->
  <form method="post">
      <h2>Doubles game: </h2>
      <h2 for="winner1">Winner 1:</h2>
      <select name="winner1" id="winner1">
        <option value="" selected>-=+=-</option>
        <?php
          $query = $conn -> prepare("SELECT * FROM players");
          $query -> execute();
          $result = $query -> get_result();

          while ($row = mysqli_fetch_array($result)) 
          {
            ?>
            <option value="<?=$row['userName']?>"><?=$row['fullName']?></option>
            <?php
          }
        ?>
      </select>


      <h2 for="winner2">Winner 2:</h2>
      <select name="winner2" id="winner2">
        <option value="" selected>-=+=-</option>
        <?php
          $query = $conn -> prepare("SELECT * FROM players");
          $query -> execute();
          $result = $query -> get_result();

          while ($row = mysqli_fetch_array($result)) 
          {
            ?>
            <option value="<?=$row['userName']?>"><?=$row['fullName']?></option>
            <?php
          }
        ?>
      </select>


      <h2 for="loser1">Loser1:</h2>
      <select name="loser1" id="loser1">
        <option value="" selected>-=+=-</option>
          <?php
            $query = $conn -> prepare("SELECT * FROM players");
            $query -> execute();
            $result = $query -> get_result();

            while ($row = mysqli_fetch_array($result)) 
            {
              ?>
              <option value="<?=$row['userName']?>"><?=$row['fullName']?></option>
              <?php
            }
          ?>
      </select>


      <h2 for="loser2">Loser2:</h2>
      <select name="loser2" id="loser2">
        <option value="" selected>-=+=-</option>
          <?php
            $query = $conn -> prepare("SELECT * FROM players");
            $query -> execute();
            $result = $query -> get_result();

            while ($row = mysqli_fetch_array($result)) 
            {
              ?>
              <option value="<?=$row['userName']?>"><?=$row['fullName']?></option>
              <?php
            }
          ?>
      </select>


      <h2 for="score1">Score winner:</h2>
      <select name="score1" id="score1">
        <option name=10 disabled selected>10</option>
      </select>


      <h2 for="score2">Score loser:</h2>
      <select id="score2" name="score2">
        <option value="" selected>-=+=-</option>
          <?php
            foreach ($loserScores as $value) 
            {
              ?>
              <option value="<?=$value?>"><?=$value?></option>
              <?php
            }
          ?>
      </select>

      <h2 for="kruipen">Did the losers have to crawl?</h2>
      <select name="kruipen" id="kruipen">
        <option value="yes">Yes</option>
        <option value="no" selected>No</option>
      </select>

      <input type="submit" value="Submit" name="submit-double">
  </form>