<?php
$db = new PDO('pgsql:host=127.0.0.1;dbname=categories_db;user=username;password=password;charset=utf8');

$jsonData = file_get_contents('categories.json');
$categories = json_decode($jsonData, true);

function insertCategory($category, $parentId = null) {
    global $db;
    $stmt = $db->prepare("INSERT INTO categories (id, name, alias, parent_id) VALUES (:id, :name, :alias, :parent_id)");
    $stmt->execute([
        ':id' => $category['id'],
        ':name' => $category['name'],
        ':alias' => $category['alias'],
        ':parent_id' => $parentId
    ]);

    if (isset($category['childrens'])) {
        foreach ($category['childrens'] as $child) {
            insertCategory($child, $category['id']);
        }
    }
}

foreach ($categories as $category) {
    insertCategory($category);
}
?>
