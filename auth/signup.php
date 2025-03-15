<?php

include "../connect.php";

$username = filterRequest("username");
$password = filterRequest("password");
$email = filterRequest("email");
$phone = filterRequest("phone");
$verfiycode = rand(10000,99999);

$stmt = $con->prepare("SELECT * FROM users WHERE users_email = ? OR users_phone = ?");
$stmt->execute(array($email, $phone));
$count = $stmt->rowCount();
if ($count > 0) {
    printFailure("Phone Or Email Are Exist");
}else{
    $data = array(
        "users_name" => $username,
        "users_password" => $password,
        "users_email" => $email,
        "users_phone" => $phone,
        "users_verfiycode" => $verfiycode,
    );
    // sendEmail($email,"Verify Code Ecommerce","Verify Code is $verifycode ");
    insertData("users", $data);
}