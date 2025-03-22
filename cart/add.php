
<?php
include "../connect.php";

$userid = filterRequest("user_id");
$itemsid = filterRequest("item_id");

$data=array("cart_usersid"=>$userid,"cart_itemsid"=>$itemsid);
insertData("cart", $data);

$count= getData("cart","cart_usersid = ? AND cart_itemsid = ? ",array($userid,$itemsid),false);


