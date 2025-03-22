<?php
include "../connect.php";
$favorite_id=filterRequest("favorite_id");
// Delete the favorite item from the database
deleteData("favorites","favorites_id = $favorite_id ");
?>