

<?php

include "../connect.php";
$password = filterRequest("password");
$email = filterRequest("email");

$data=array("users_password"=>$password);
updateData("users",$data,"users_email = '$email' ");