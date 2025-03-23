
<?php
include "../connect.php";
// getAllData("itemsview"," categories_id = $categoriesid ");

$userid = filterRequest("user_id");
$categoriesid=filterRequest("categories_id");

$stmt = $con->prepare(
"SELECT items1view.*, '1' AS favorite , (items_price - (items_price*items_discount/100)) as items_price_discount
FROM items1view 
INNER JOIN favorites 
ON favorites.favorites_itemsid = items1view.items_id 
AND favorites.favorites_usersid = $userid  -- Use placeholders for security
WHERE categories_id = $categoriesid

UNION ALL

SELECT items1view.*, '0' AS favorite , (items_price - (items_price*items_discount/100)) as items_price_discount
FROM items1view 
WHERE categories_id = $categoriesid 
AND items_id NOT IN (
    SELECT items1view.items_id 
    FROM items1view 
    INNER JOIN favorites 
    ON items1view.items_id = favorites.favorites_itemsid 
    AND favorites.favorites_usersid = $userid  -- Missing closing parenthesis added here
) 

LIMIT 25;

"
);

$stmt->execute();
$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
$count = $stmt->rowCount();

if ($count > 0) {
    echo json_encode(array("status" => "success", "data" => $data));
} else {
    echo json_encode(array("status" => "failure"));
}
?>
