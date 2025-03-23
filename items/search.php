<?php
include "../connect.php";

$search=filterRequest("search");
$table=filterRequest("table");

getAllData($table,"items_name LIKE '%$search%' OR items_name_ar LIKE '%$search%'");
?>