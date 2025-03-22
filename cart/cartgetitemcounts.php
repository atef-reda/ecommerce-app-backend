<?php
include "../connect.php";
$userid = filterRequest("user_id");
$itemsid = filterRequest("item_id");

$count= getData("cart","cart_usersid = ? AND cart_itemsid = ? ",array($userid,$itemsid),false);
echo json_encode(array("status"=>"success","data"=> $count));

?>