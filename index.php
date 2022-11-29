<?php
  include "connect.php";
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
<!-- <head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="css2.css">
  <title>Foosball standings</title>

</head>

<body>

  <!-- Form for registering a user -->
  <form method="post">
      <h1>Register:</h1>
      <label for="username"><h1>Please enter a user name to register:</h1></label>
      <input type="text" size="20" id="username" name="username">
      <label for="fullname"><h1>Please enter your full name here:</h1></label>
      <input type="text" size="20" id="fullname" name="fullname"><br>
      <input type="submit" value="Register" name="register">
  </form>

  <!-- Form for submitting a single game -->
  <form method="post">
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

  <!-- Table for the singles leaderboard -->
	<table style="float: left">
		<caption>Single Elos:</caption>
		<tr>   
			<th> <a href="/foosball-site?orderSinglesBy=fullName&dir=<?php echo (!isset($_GET["dir"]) || $_GET["dir"] == "DESC") ? "ASC" : "DESC";?>"> Player </a> </th>
			<th> <a href="/foosball-site?orderSinglesBy=singleElo&dir=<?php echo (!isset($_GET["dir"]) || $_GET["dir"] == "ASC") ? "DESC" : "ASC";?>"> Singles Elo </a> </th>
			<th> <a href="/foosball-site?orderSinglesBy=wins&dir=<?php echo (!isset($_GET["dir"]) || $_GET["dir"] == "ASC") ? "DESC" : "ASC";?>"> Wins </a> </th>
			<th> <a href="/foosball-site?orderSinglesBy=losses&dir=<?php echo (!isset($_GET["dir"]) || $_GET["dir"] == "ASC") ? "DESC" : "ASC";?>"> Losses </a> </th>
			<th> <a href="/foosball-site?orderSinglesBy=total&dir=<?php echo (!isset($_GET["dir"]) || $_GET["dir"] == "ASC") ? "DESC" : "ASC";?>"> Total games played</a> </th>
		</tr>
		<?php
      $sortStringSingles = "ORDER BY singleElo DESC";

      $sortOptions = ["fullName", "singleElo", "wins", "losses", "total"];
      $sortDirections = ["ASC", "DESC"];
      if (isset($_GET["orderSinglesBy"]) && isset($_GET["dir"])) 
      {
        if (in_array($_GET["orderSinglesBy"], $sortOptions) && in_array($_GET["dir"], $sortDirections))
        {
          $sortStringSingles = "ORDER BY" . " " .  $_GET["orderSinglesBy"] . " " . $_GET["dir"];
        }
      }

  		$query = $conn -> prepare(" SELECT  players.userName, players.fullName, players.singleElo, 
																					COALESCE(winCount, 0) AS wins, COALESCE(lossCount, 0) AS losses,
                                          COALESCE(winCount, 0) + COALESCE(lossCount, 0) AS total 
																	FROM players
																	LEFT JOIN (
																			SELECT single_games.winner, COUNT(*) as winCount
																			FROM single_games
																			GROUP BY single_games.winner
																		) AS wins
																	ON players.userName = wins.winner
																	LEFT JOIN (
																			SELECT single_games.loser, COUNT(*) as lossCount
																			FROM single_games
																			GROUP BY single_games.loser
																		) AS losses
																	ON players.userName = losses.loser
																	WHERE COALESCE(winCount, 0) + COALESCE(lossCount, 0) != 0
																	$sortStringSingles");
			$query -> execute();
			$result = $query -> get_result();
			
			while ($row = mysqli_fetch_array($result))
			{
				?>
				<tr>
					<td><?=$row['fullName']?></td>
					<td><?=$row['singleElo']?></td>
					<td><?=$row['wins']?></td>
					<td><?=$row['losses']?></td>
					<td><?=$row["total"]?></td>
				</tr>
				<?php
			}
			?>
	</table>

	<!-- Table for the doubles leaderboard -->
	<table style="float: left">
		<caption>Double Elos:</caption>
		<tr>
    <th> <a href="/foosball-site?orderDoublesBy=fullName&dir=<?php echo (!isset($_GET["dir"]) || $_GET["dir"] == "DESC") ? "ASC" : "DESC";?>"> Player </a> </th>
			<th> <a href="/foosball-site?orderDoublesBy=doubleElo&dir=<?php echo (!isset($_GET["dir"]) || $_GET["dir"] == "ASC") ? "DESC" : "ASC";?>"> Double Elo </a> </th>
			<th> <a href="/foosball-site?orderDoublesBy=wins&dir=<?php echo (!isset($_GET["dir"]) || $_GET["dir"] == "ASC") ? "DESC" : "ASC";?>"> Wins </a> </th>
			<th> <a href="/foosball-site?orderDoublesBy=losses&dir=<?php echo (!isset($_GET["dir"]) || $_GET["dir"] == "ASC") ? "DESC" : "ASC";?>"> Losses </a> </th>
			<th> <a href="/foosball-site?orderDoublesBy=total&dir=<?php echo (!isset($_GET["dir"]) || $_GET["dir"] == "ASC") ? "DESC" : "ASC";?>"> Total games played</a> </th>
		</tr>
		<?php
      $sortStringDoubles = "ORDER BY DoubleElo DESC";

      $sortOptions = ["fullName", "doubleElo", "wins", "losses", "total"];
      $sortDirections = ["ASC", "DESC"];
      if (isset($_GET["orderDoublesBy"]) && isset($_GET["dir"])) 
      {
        if (in_array($_GET["orderDoublesBy"], $sortOptions) && in_array($_GET["dir"], $sortDirections))
        {
          $sortStringDoubles = "ORDER BY" . " " .  $_GET["orderDoublesBy"] . " " . $_GET["dir"];
        }
      }



			$query = $conn -> prepare(" SELECT players.userName, players.fullName, players.doubleElo, 
																	COALESCE(winCount1, 0) + COALESCE(winCount2, 0) AS wins, 
																	COALESCE(lossCount1, 0) + COALESCE(lossCount2, 0) AS losses,
                                  COALESCE(winCount1, 0) + COALESCE(winCount2, 0) + COALESCE(lossCount1, 0) + COALESCE(lossCount2, 0) AS total 
																	FROM players
																	LEFT JOIN (
																			SELECT double_games.winner1, COUNT(*) as winCount1
																			FROM double_games
																			GROUP BY double_games.winner1
																		) AS wins1
																	ON players.userName = wins1.winner1
																	LEFT JOIN (
																			SELECT double_games.winner2, COUNT(*) as winCount2
																			FROM double_games
																			GROUP BY double_games.winner2
																		) AS wins2
																	ON players.userName = wins2.winner2
																	LEFT JOIN (
																			SELECT double_games.loser1, COUNT(*) as lossCount1
																			FROM double_games
																			GROUP BY double_games.loser1
																		) AS losses1
																	ON players.userName = losses1.loser1
																	LEFT JOIN (
																			SELECT double_games.loser2, COUNT(*) as lossCount2
																			FROM double_games
																			GROUP BY double_games.loser2
																		) AS losses2
																	ON players.userName = losses2.loser2
																	WHERE COALESCE(winCount1, 0) + COALESCE(winCount2, 0) + COALESCE(lossCount1, 0) + COALESCE(lossCount2, 0) != 0
																	$sortStringDoubles");
			$query -> execute();
			$result = $query -> get_result();
			
			while ($row = mysqli_fetch_array($result))
			{
				?>
				<tr>
					<td><?=$row['fullName']?></td>
					<td><?=$row['doubleElo']?></td>
					<td><?=$row['wins']?></td>
					<td><?=$row['losses']?></td>
					<td><?=$row['wins'] + $row['losses']?></td>
				</tr>
				<?php
			}
			?>
	</table>

</body>
</html>


<?php
  include "inputHandler.php";
?>
