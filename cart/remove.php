
<?php
include "../connect.php";

$userid = filterRequest("user_id");
$itemsid = filterRequest("item_id");

deleteData("cart", " cart_id = ( SELECT cart_id from cart WHERE cart_usersid = $userid AND cart_itemsid = $itemsid LIMIT 1 )");
