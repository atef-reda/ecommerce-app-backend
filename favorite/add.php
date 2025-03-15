
<?php
include "../connect.php";

$userid = filterRequest("user_id");
$itemsid = filterRequest("item_id");
$data=array("favorites_usersid"=>$userid,"favorites_itemsid"=>$itemsid);

insertData("favorites", $data);


