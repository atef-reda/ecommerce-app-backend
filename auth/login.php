<?php

include "../connect.php";
$password = trim($_POST["password"]);
$email = filterRequest("email");

$stmt = $con->prepare("SELECT * FROM users WHERE users_email = ? AND users_password = ? AND users_approve = 1");
$stmt->execute(array($email, $password));
$count = $stmt->rowCount();
// echo "Hashed Password: " . $password . "<br>";
// echo "Email: " . $email . "<br>";
result($count);