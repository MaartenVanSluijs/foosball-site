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


  <form method="post">
    <fieldset>
      <legend>Singles game: </legend>
      <label for="winner">Winner:</label>
      <select name="winner" id="winner">
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
      <select name="loser" id="loser">

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
        <option value="" selected>-=+=-</option>
        <option value="yes">Yes</option>
        <option value="no">No</option>
      </select>

      <input type="submit" value="Submit" name="submit-single">
    </fieldset>
  </form>
</body>
</html>


<?php
  include "functions.php";
?>
