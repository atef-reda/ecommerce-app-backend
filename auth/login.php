<?php

include "../connect.php";
$password = filterRequest("password");
$email = filterRequest("email");


getData("users","users_email = ? AND users_password = ? AND users_approve = 1",array($email,$password));