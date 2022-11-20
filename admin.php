<?php
  include "connect.php";
  include "inputHandler.php";
?>

<html>
<body>
  
  <!-- Form for recalculating all single ELOs -->
  <form method="post">
  <fieldset>
    <legend>Recalculate Singles</legend>
    <label for="passcode">Enter the passcode</label>
    <input type="text" size="4" id="passcode" name="passcode">
    <input type="submit" name="recalc_single" value="Click me to recalculate single ELOs">
  </fieldset>
  </form>

  <!-- Form for recalculating all double ELOs -->
  <form method="post">
  <fieldset>
    <legend>Recalculate Doubles</legend>
    <label for="passcode">Enter the passcode</label>
    <input type="text" size="4" id="passcode" name="passcode">
    <input type="submit" name="recalc_double" value="Click me to recalculate double ELOs">
  </fieldset>
  </form>



</body>
</html>