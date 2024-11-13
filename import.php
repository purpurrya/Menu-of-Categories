<?php
$db = new PDO('pgsql:host=127.0.0.1;dbname=categories_db;user=postgres;password=password');

$jsonData = file_get_contents('categories.json');
$categories = json_decode($jsonData, true);

function importCategory($category, $parentId = null) {
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
            importCategory($child, $category['id']);
        }
    }
}

foreach ($categories as $category) {
    importCategory($category);
}
?>
