<?php
include "../connect.php";
$user_id=filterRequest("user_id");
getAllData("myfavorite","users_id = ? ",array($user_id));
?>