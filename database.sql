CREATE VIEW items1view AS
SELECT items.* ,categories.* FROM items
INNER JOIN categories ON items.items_catogries = categories.categories_id


SELECT items1view.* , 1 AS favorite FROM items1view
INNER JOIN favorites ON favorites.favorites_itemsid = items1view.items_id AND favorites.favorites_usersid = 18
UNION ALL
SELECT items1view.* , 0 AS favorite FROM items1view WHERE items_id != (SELECT items1view.items_id FROM items1view INNER JOIN favorites ON items1view.items_id = favorites.favorites_itemsid AND favorites.favorites_usersid = 18 );


CREATE VIEW itemsview  AS
SELECT items1view.* , 1 AS favorite FROM items1view INNER JOIN favorites ON favorites.favorites_itemsid = items1view.items_id 
UNION ALL
SELECT items1view.* , 0 AS favorite FROM items1view WHERE items_id != (SELECT items1view.items_id FROM items1view INNER JOIN favorites ON items1view.items_id = favorites.favorites_itemsid  );


SELECT items1view.*, 1 AS favorite 
FROM items1view 
INNER JOIN favorites 
ON favorites.favorites_itemsid = items1view.items_id 
AND favorites.favorites_usersid = $userid  -- Use placeholders for security
WHERE categories_id = $categoriesid

UNION ALL

SELECT items1view.*, 0 AS favorite 
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


**************** MyFavorite ****************
