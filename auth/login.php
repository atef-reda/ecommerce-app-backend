<?php

include "../connect.php";
$password = filterRequest("password");
$email = filterRequest("email");


getData("users","users_email = ? AND users_password = ?",array($email,$password));

