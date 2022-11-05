<?php
  include "connect.php";
  $loserScores = array(0, 0.5, 1, 1.5, 2, 2.5, 3, 3.5, 4, 4.5, 5, 5.5, 6, 6.5, 7, 7.5, 8, 8.5, 9);
?>

<html>
<!-- <head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="css.css">
  <title>Foosball standings</title>

</head> -->

<body>

  <form method="post">
    <fieldset>
      <legend>Register:</legend>
      <label for="username"><h1>Please enter a user name to register:</h1></label>
      <input type="text" size="20" id="username" name="username">
      <label for="fullname"><h1>Please enter your full name here:</h1></label>
      <input type="text" size="20" id="fullname" name="fullname"><br>
      <input type="submit" value="Register" name="register">
    </fieldset>
  </form>

  <!-- Form for submitting a single game -->
  <form method="post">
    <fieldset>
      <legend>Singles game: </legend>
      <label for="winner">Winner:</label>
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
      <label for="loser">Loser:</label>
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

      <label for="score1">Score winner:</label>
      <select name="score1" id="score1">
        <option name=10 disabled selected>10</option>
      </select>

      <label for="score2">Score loser:</label>
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

      <label for="kruipen">Is er gekropen: </label>
      <select name="kruipen" id="kruipen">
        <option value="yes">Yes</option>
        <option value="no" selected>No</option>
      </select>

      <input type="submit" value="Submit" name="submit-single">
    </fieldset>
  </form>

  <!-- Form for submitting a doubles game -->
  <form method="post">
    <fieldset>
      <legend>Doubles game: </legend>
      <label for="winner1">Winner 1:</label>
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


      <label for="winner2">Winner 2:</label>
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


      <label for="loser1">Loser1:</label>
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


      <label for="loser2">Loser2:</label>
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


      <label for="score1">Score winner:</label>
      <select name="score1" id="score1">
        <option name=10 disabled selected>10</option>
      </select>


      <label for="score2">Score loser:</label>
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

      <label for="kruipen">Is er gekropen: </label>
      <select name="kruipen" id="kruipen">
        <option value="yes">Yes</option>
        <option value="no" selected>No</option>
      </select>

      <input type="submit" value="Submit" name="submit-double">
    </fieldset>
  </form>

  <!-- Drop-down menu for the singles leaderboard -->
  <label for="singleLeaderboard">Singles Leaderboard:</label>
  <select name="singlesLeaderboard" id="singlesLeaderboard">
    <option value="placeholder">Click me to see the singles Leaderboard!</option>
    <?php
      $query = $conn -> prepare("SELECT * FROM players ORDER BY singleElo DESC");
      $query -> execute();
      $result = $query -> get_result();

      while ($row = mysqli_fetch_array($result)) 
      {
        ?>
        <option value="<?=$row['userName']?>" disabled><?=$row['fullName'] . " - " . $row["singleElo"] . " [won: " . $row["wins"] . " | losses: " . $row["losses"] . " | total: " . $row["wins"] + $row["losses"] . "]"?></option>
        <?php
      }
    ?>
  </select>
</body>
</html>


<?php
  include "functions.php";
?>
