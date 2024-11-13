<?php
$db = new PDO('mysql:host=localhost; dbname=categories_db; charset=utf8', 'username', 'password');

function listCategories($parentId = null, $level = 0) {
    global $db;
    $stmt = $db->prepare("SELECT * FROM Categories WHERE parent_id " . ($parentId ? "= :parent_id" : "IS NULL"));
    if ($parentId) {
        $stmt->bindParam(':parent_id', $parentId);
    }
    $stmt->execute();
    $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($categories as $index => $category) {
        $indentation = str_repeat(' ', $level * 2);
        echo "{$index}n{$indentation}{$category['name']}n";
        listCategories($category['id'], $level + 1);
    }
}

listCategories();
?>
