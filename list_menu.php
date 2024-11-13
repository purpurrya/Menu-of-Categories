<?php
$db = new PDO('pgsql:host=127.0.0.1;dbname=categories_db;user=postgres;password=password');

function list_menu($parentId = null, $level = 0) {
    global $db;
    $stmt = $db->prepare("SELECT * FROM categories WHERE parent_id " . ($parentId ? "= :parent_id" : "IS NULL"));
    if ($parentId) {
        $stmt->bindParam(':parent_id', $parentId);
    }
    $stmt->execute();
    $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($categories as $category) {
        $indentation = str_repeat(' ', $level * 2); 
        echo "{$indentation}{$category['name']}\n"; 
        list_menu($category['id'], $level + 1); 
    }
}

list_menu();
?>
