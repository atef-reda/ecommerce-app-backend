<?php

include "../connect.php";

$email=filterRequest("email");
$verifycode=filterRequest("verifycode");

$stmt=$con->prepare("SELECT * FROM users WHERE users_email = '$email' AND users_verfiycode = '$verifycode'");
$stmt->execute();
$count=$stmt->rowCount();

result($count);
