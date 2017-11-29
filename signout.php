<?php
  session_start();
  session_destroy();
  echo "You have signed out successfully<br>";
  echo "<a href='login.php'>Click here to sign back in</a>";
?>