<?php
$host = "HOST";
$user = "USER";
$pass = "";
$db_name = "chats";
$con = mysqli_connect($host, $user, $pass, $db_name);

if (!$con) {
    echo "Error: Unable to connect to MySQL." . PHP_EOL;
    echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
    echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
    exit;
   }

?>
