<?php
include "../connect.php";
$verfiycode = rand(10000,99999);
$email = filterRequest("email");

$data=array("users_verfiycode" => $verfiycode);
updateData("users",$data,"users_email = '$email' ");

// sendEmail($email,"Verify Code Ecommerce","Verify Code is $verifycode ");

?>