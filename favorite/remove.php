
<?php
include "../connect.php";

$userid = filterRequest("user_id");
$itemsid = filterRequest("item_id");

deleteData("favorites", "favorites_usersid = $userid AND favorites_itemsid = $itemsid ");