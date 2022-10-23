<?php
  include "connect.php";
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
      <input type="text" size="20" id="fullname" name="fullname">
      <input type="submit" value="Register" name="register">
    </fieldset>
  </form>


  <form method="post">
    <fieldset>
      <legend>Singles game: </legend>
      <label for="winner">Winner:</label>
      <select name="winner" id="winner">
        <option value="-1">-=+=-</option>
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

        <option value="">-=+=-</option>
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
      <input type="text" id="score1" size="4">
      <label for="score2">Score loser:</label>
      <input type="text" id="score2" size="4">
      <label for="kruipen">Is er gekropen: </label>
      <input type="checkbox" id="kruipen" name="kruipen">
      <input type="submit" value="Submit" name="submit-single">
    </fieldset>
  </form>
</body>
</html>


<?php
  include "functions.php";
?>
