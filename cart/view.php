<?php
include "../connect.php";
$userid = filterRequest("user_id");

$data=getAllData('cartview',"cart_usersid='$userid'",null,false);

$stmt = $con->prepare("SELECT SUM(itemsprice) as totalprice ,count(itemscount) as totalcount from cartview
WHERE cart_usersid=$userid
GROUP BY cart_usersid ");

$stmt->execute();
$countprice = $stmt->fetch(PDO::FETCH_ASSOC);

echo json_encode(
    array(
        "data"=>$data,
        "countprice"=>$countprice,
    ));
?> 